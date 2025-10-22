<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Test; 
use App\Models\Question;  
use App\Models\ExamSession; 
use App\Models\ExamSessionAnswer;  
use App\Models\Option;  
use App\Models\GroupSubject; 
use App\Models\ExamSessionStudentAccess; 
use App\Models\Result; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Schema;

class ExamSessionController extends Controller
{
    public function allSessions()
    {
        $user = auth()->user();

        $sessions = ExamSession::with([
            'tests.groupSubject.group',
            'tests.groupSubject.subject'
        ])
        ->orderBy('start_time')
        ->get()
        ->groupBy(function($session) {
            return \Carbon\Carbon::parse($session->start_time)->format('Y-m-d');
        });
    
        return view('examSession.all-sessions', compact('sessions', 'user'));
    }

    public function index()
    {
        $user = auth()->user();
        $now = \Carbon\Carbon::now();


        $sessions = ExamSession::with(['tests.groupSubject.group', 'tests.groupSubject.subject'])
            ->where('end_time', '>=', $now) // faqat tugamagan sessiyalar
            ->orderBy('start_time', 'asc')
            ->get()
            ->groupBy(fn($session) => \Carbon\Carbon::parse($session->start_time)->toDateString());
    
        return view('examSession.index', compact('sessions', 'user'));
    }
    

    public function create()
    {
        // Hali model yo‘q, lekin biz pluck uchun DB kerak emas:
        $usedTestIds = collect(\DB::table('exam_session_test')->pluck('test_id'));
    
        $tests = \App\Models\Test::where('is_active', 1)
            ->whereNotIn('id', $usedTestIds)
            ->get();
    
        return view('examSession.create', compact('tests'));
    }
    

    public function store(Request $request)
    {
        $data = $request->validate([
            'test_id'   => 'required|array|min:1',   // massiv bo‘lishi shart
            'test_id.*' => 'integer|exists:tests,id',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
            'room'       => 'nullable|string|max:255',
        ]);
    
        // 1. Avval exam_session yaratamiz
        $examSession = ExamSession::create([
            'start_time' => $data['start_time'],
            'end_time'   => $data['end_time'],
            'room'       => $data['room'] ?? null,
        ]);
    
        // 2. Pivot jadvalga testlarni biriktiramiz
        $testIds = array_map('intval', array_unique($data['test_id']));
        $examSession->tests()->attach($testIds);
    
        return redirect()->route('examSession.index')
                         ->with('success', 'Imtihon sessiyasi muvaffaqiyatli qo‘shildi!');
    }

    public function startTest(Test $test)
    {
        // Studentni olish
        $student = auth()->user();
    
        // Testni olish (savollar va variantlari bilan)
        $test->load('questions.options');
    
        // Tasodifiy 25 ta savolni olish
        $questions = $test->questions->shuffle()->take(25);

        // dd($questions->toArray());
        // dd($questions->all());
    
        // Testni boshlash sahifasiga yuborish
        return view('finaltest', compact('student', 'test', 'questions'));
    }



    public function answerStore(Request $request)
    {
        // dd($request->all()); // Qanday ma'lumot kelayotganini ko'ramiz
    
        $request->validate([
            'test_id' => 'required|exists:tests,id',
            'question_id' => 'required|array',
            'question_id.*' => 'exists:questions,id',
            'option_id' => 'nullable|array',
            'option_id.*' => 'exists:options,id',
        ]);
    
        $studentId = Auth::id();
        $testId = $request->test_id;

        // dd($studentId);
    
        // Har bir savol uchun javobni saqlaymiz
        foreach ($request->question_id as $index => $questionId) {
            // Ushbu savolga tanlangan optionni olamiz
            $optionId = $request->option_id[$questionId] ?? null;
    
            // Agar variant tanlangan bo'lsa
            if ($optionId) {
                // To'g'riligini tekshiramiz
                $isCorrect = Option::where('id', $optionId)
                    ->where('question_id', $questionId)
                    ->value('is_correct') ?? false;
    
                // Boolean ga o'tkazamiz
                $isCorrect = filter_var($isCorrect, FILTER_VALIDATE_BOOLEAN);
    
                ExamSessionAnswer::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'test_id' => $testId,
                        'question_id' => $questionId,
                    ],
                    [
                        'option_id' => $optionId,
                        'is_correct' => $isCorrect,
                    ]
                );
            }
        }
    
        
        $test = Test::with('groupSubject')->find($testId);
        $totalQuestions = Question::where('test_id', $testId)->count();
        $correctAnswers = ExamSessionAnswer::where('student_id', $studentId)
            ->where('test_id', $testId)
            ->where('is_correct', true)
            ->count();
        
        // Ballarni hisoblash
        $maxScore = $test->groupSubject->max_final_score ?? 50; // default 50
        $earnedScore = 0;
        
        if ($totalQuestions > 0) {
            $earnedScore = round(($correctAnswers / $totalQuestions) * $maxScore, 1);
        }

        // ⏱ vaqtni olish
        $timeSpent = $request->input('time_spent', 0);

        // results jadvaliga yozish (faqat 1 marta)
        $result = Result::updateOrCreate(
            [
                'test_id'    => $testId,
                'student_id' => $studentId,
            ],
            [
                'score'      => $earnedScore,
                'time_spent' => $timeSpent,
            ]
        );

        // Sessionga ham yozib qo‘yamiz (xohlasa natijani tez olish uchun)
        session([
            'test_score_' . $testId     => $earnedScore,
            'correct_answers_' . $testId=> $correctAnswers,
            'total_questions_' . $testId=> $totalQuestions,
            'max_score_' . $testId      => $maxScore
        ]);

        // ✅ Natija sahifasiga yo‘naltiramiz
        return redirect()->route('results.show', $result->id)
            ->with('success', 'Test yakunlandi!');
    }

    // Natijani sessionga saqlash
//     session([
//         'test_score_' . $testId => $earnedScore,
//         'correct_answers_' . $testId => $correctAnswers,
//         'total_questions_' . $testId => $totalQuestions,
//         'max_score_' . $testId => $maxScore
//     ]);

//     return back()->with([
//         'success' => 'Javoblar saqlandi!',
//         'earned_score' => $earnedScore,
//         'correct_answers' => $correctAnswers,
//         'total_questions' => $totalQuestions,
//         'max_score' => $maxScore
//     ]);
// }

    // Test yakunlash va natija ko‘rish
    public function finish($testId)
    {
        $answers = ExamSessionAnswer::where('user_id', Auth::id())
            ->where('test_id', $testId)
            ->with(['question', 'option'])
            ->get();

        $totalQuestions = $answers->count();
        $correctAnswers = $answers->where('is_correct', true)->count();

        return view('tests.result', compact('answers', 'totalQuestions', 'correctAnswers'));
    }

    public function giveAccess(Request $request, $sessionId, $testId, $studentId)
    {
        // dd($sessionId, $testId, $studentId);

        $request->validate([
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'integer|exists:users,id',
        ]);

        // dd($request);
        

        if ($request->has('student_ids')) {
            foreach ($request->student_ids as $studentId) {
                ExamSessionStudentAccess::updateOrCreate(
                    [
                        'exam_session_id' => $sessionId,
                        'test_id' => $testId,
                        'student_id' => $studentId,
                    ],
                    [
                        'is_allowed' => true,
                    ]
                );
            }
        }

        // dd(ExamSessionStudentAccess::all());


        return back()->with('success', 'Talabaga testga ruxsat berildi!');
    }

    public function revokeAccess($sessionId, $testId, $studentId)
    {
        ExamSessionStudentAccess::where([
            'exam_session_id' => $sessionId,
            'test_id' => $testId,
            'student_id' => $studentId,
        ])->update(['is_allowed' => false]);

        return back()->with('success', 'Talabaning ruxsati olib tashlandi!');
    }

    public function showGroupSubjectStudents($sessionId, $testId, GroupSubject $groupSubject)
    {
        // dd($sessionId, $testId, $groupSubject->group->students);

        $students = $groupSubject->group->students; // groupSubject → group → students

        // dd($students);

        $accessList = ExamSessionStudentAccess::where('exam_session_id', $sessionId)
        ->where('test_id', $testId)
        ->pluck('is_allowed', 'student_id')
        ->toArray(); 

        // dd($accessList);

        return view('examSession.group_subject_students', compact('students', 'sessionId', 'testId', 'groupSubject', 'accessList'));
    }
    
    public function search(Request $request)
    {
        // Obyektni tayyorlash (yozilgan relationship'larni moslang)
        $query = ExamSession::with(['tests.groupSubject.group', 'tests.groupSubject.subject']);

        // Agar from/to to'ldirilgan bo'lsa, Carbon bilan bosh/oxir vaqtlarini aniqlaymiz
        if ($request->filled('from_date') && $request->filled('to_date')) {
            // from va to maydonlari faqat sana bo'lishi mumkin (date) yoki datetime bo'lsa moslashtiring
            $from = \Carbon\Carbon::parse($request->from_date)->startOfDay();
            $to   = \Carbon\Carbon::parse($request->to_date)->endOfDay();

            // Biz shu oraliq bilan **kesishuvchi** sessiyalarni olamiz:
            // 1) start_time oraliqqa tushadi
            // 2) yoki end_time oraliqqa tushadi
            // 3) yoki sessiya butunlay oraliqni qamrab oladi
            $query->where(function ($q) use ($from, $to) {
                $q->whereBetween('start_time', [$from, $to])
                  ->orWhereBetween('end_time', [$from, $to])
                  ->orWhere(function($q2) use ($from, $to) {
                      $q2->where('start_time', '<', $from)
                         ->where('end_time', '>', $to);
                  });
            });
        }

        // Saralab olib, guruhlab view ga yuboramiz (sana bo'yicha guruhlash)
        $sessions = $query->orderBy('start_time', 'asc')->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->start_time)->toDateString();
            });

        // Viewga sessions uzatamiz — shu nom bilan view-da ishlating
        return view('examSession.all-sessions', compact('sessions'));
    }
    
    
    
}
