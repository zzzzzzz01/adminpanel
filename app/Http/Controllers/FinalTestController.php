<?php

namespace App\Http\Controllers;

use App\Models\GroupSubject; 
use App\Models\Test; 
use App\Models\Question; 
use App\Models\Option; 
use Illuminate\Http\Request;

class FinalTestController extends Controller
{
    public function allTests()
    {
        $tests = Test::with('groupSubject')->latest()->get();

        return view('test.all-tests', compact('tests'));
    }

    public function index()
    {
        $today = now()->toDateString();
    
        $tests = Test::with(['groupSubject.group', 'groupSubject.subject', 'groupSubject.semester'])
            ->whereHas('groupSubject.semester', function ($q) use ($today) {
                $q->whereDate('start_date', '<=', $today)
                  ->whereDate('end_date', '>=', $today);
            })
            ->latest()
            ->get();
    
        return view('test.index', compact('tests'));
    }

    public function testsSearch(Request $request)
    {
        $search = $request->input('search');

        if (empty($search)) {
            return redirect()->route('all.tests');
        }

        $teacherId = auth()->id();

        $tests = Test::with(['groupSubject.group', 'groupSubject.subject', 'groupSubject.semester'])
            ->whereHas('groupSubject', function ($q) use ($search, $teacherId) {
                $q->where('teacher_id', $teacherId)
                ->whereHas('group', function ($groupQuery) use ($search) {
                    $groupQuery->where('group_name', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('test.all-tests', compact('tests', 'search'));
    }

    public function finalTestCreate()
    {
        $teacherId = auth()->id();
        $today = now()->toDateString();
    
        $groupSubjects = GroupSubject::with(['group', 'subject', 'semester'])
            ->where('teacher_id', $teacherId)
            ->whereHas('semester', function ($q) use ($today) {
                $q->whereDate('start_date', '<=', $today)
                  ->whereDate('end_date', '>=', $today);
            })
            ->whereDoesntHave('tests') // faqat test yaratilmaganlar
            ->get();
    
        return view('test.create', compact('groupSubjects'));
    }

    public function toggleTestStatus(Test $test)
    {

        // dd($midterm->id);

        if ($test->is_active == 1) {
            return redirect()->back()->with('error', 'Bu oraliq allaqachon faollashgan va endi o‘chirib bo‘lmaydi.');
        }

        $test->update(['is_active' => 1]);

        return redirect()->back()->with('success', 'Oraliq muvaffaqiyatli faollashtirildi!');
    }
    

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required|string',
            'group_subject_id' => 'required',
            'time_limit' => 'nullable|integer'
        ]);

        // dd($request->all());
    
        $test = Test::create([
            'name' => $request->name,
            'group_subject_id' => $request->group_subject_id,
            'time_limit' => $request->time_limit ?? 45,
        ]);
    
        return redirect()->route('test.index')
            ->with('success', 'Test yaratildi, endi savollar qo‘shing!');
    }

    public function show(Test $test)
    {
        // Test bilan birga savollar va variantlarni yuklash
        $test->load('questions.options');
    
        
        $questions = $test->questions;
    
        $questionsCount = $questions->count();
        $timeLimit = $test->time_limit;
        $status = $test->is_active ? 'Faol' : 'Nofaol';
    
        return view('test.show', compact(
            'test',
            'questions',
            'questionsCount',
            'timeLimit',
            'status'
        ));
    }
    

    public function addQuestions(Test $test)
    {
        // Agar preview sahifasidan qaytilgan bo‘lsa, sessiondagi matnni olish
        $testContent = session('test_content', '');
    
        return view('test.questions', compact('test', 'testContent'));
    }
    
    public function preview(Request $request, Test $test)
    {
        $test_content = $request->input('test_content');
        $test_name = $request->input('test_name');
    
        // Test matnini sessionga yozish — keyingi qaytishda formda qoladi
        session(['test_content' => $test_content]);
    
        // Savollarni ajratib olish
        $questions = collect(explode("++++++", $test_content))
            ->map(function ($block) {
                $lines = array_values(array_filter(array_map('trim', explode("\n", $block))));
                if (count($lines) < 2) return null;
    
                $question = $lines[0];
                $options = [];
                foreach ($lines as $line) {
                    if ($line === "======") continue;
                    if ($line === $question) continue;
    
                    $isCorrect = false;
                    if (str_starts_with($line, '#')) {
                        $isCorrect = true;
                        $line = ltrim($line, '#');
                    }
                    $options[] = [
                        'text' => $line,
                        'correct' => $isCorrect,
                    ];
                }
    
                return [
                    'question' => $question,
                    'options' => $options,
                ];
            })
            ->filter()
            ->values();
    
        $questionsCount = $questions->count();
        $timeLimit = $test->time_limit;
        $status = $test->is_active ? 'Faol' : 'Nofaol';
    
        return view('test.preview', compact(
            'test',
            'test_content',
            'test_name',
            'questions',
            'questionsCount',
            'timeLimit',
            'status'
        ));
    }

    public function searchQuestions(Request $request, Test $test)
    {
        $search = trim($request->input('search'));
    
        if (empty($search)) {
            return redirect()->route('questions.show', $test);
        }
    
        $questions = $test->questions()
            ->where('question', 'like', "%{$search}%")
            ->with('options')
            ->get();

            // dd($questions);
    
        return view('test.show', compact('test', 'questions'));
    }
    
    
    

    



    public function storeQuestions(Request $request, Test $test)
    {

        // dd($request);

        $questions = $request->input('questions', []);

        // dd($questions);
    
        foreach ($questions as $q) {
            $question = Question::create([
                'test_id'  => $test->id,
                'question' => $q['question'],
            ]);
    
            foreach ($q['options'] as $opt) {
                Option::create([
                    'question_id' => $question->id,
                    'text'        => $opt['text'],
                    'is_correct'  => $opt['correct'] ?? 0,
                ]);
            }
        }
    
        return redirect()->route('test.index')
            ->with('success', 'Savollar va variantlar muvaffaqiyatli yaratildi!');
    }

    public function edit(Test $test, Question $question)
    {
        $question->load('options');
    
        $formatted = $question->question . "\n";
        foreach ($question->options as $opt) {
            $formatted .= "======\n";
            $formatted .= ($opt->is_correct ? '#' : '') . $opt->text . "\n";
        }
        $formatted .= "++++++";
    
        return view('test.edit', compact('test', 'question', 'formatted'));
    }

    public function update(Request $request, Test $test, Question $question)
    {
        // dd($request->all());

        // dd([
        //     'all_request' => $request->all(),
        //     'test_id'     => $test?->id,
        //     'question_id' => $question?->id,
        //     'question'    => $question?->question,
        // ]);

        // dd($request->all(), $test->id, $question->question);

        $content = $request->input('question_content');

        // dd(['content' => $content]);
    
        // Matnni satrlarga bo‘lish
        $lines = array_values(array_filter(array_map('trim', explode("\n", $content))));

        // dd(['lines' => $lines]);
    
        if (count($lines) < 2) {
            return back()->with('error', 'Savol va variantlar to‘liq kiritilmagan!');
        }
    
        // 1-satr – savol matni
        $questionText = $lines[0];
        // dd(['question_text' => $questionText]);
    
        $question->update([
            'question' => $questionText,
        ]);
        // dd(['updated_question' => $question]);

    
        $question->options()->delete();
        // dd(['after_delete_options' => $question->options()->get()]);
    
        foreach ($lines as $line) {
            if ($line === "======" || $line === $questionText || $line === "++++++") {
                continue;
            }
    
            $isCorrect = false;
            if (str_starts_with($line, '#')) {
                $isCorrect = true;
                $line = ltrim($line, '#'); // # belgini olib tashlaymiz
            }
    
            $question->options()->create([
                'text'       => $line,
                'is_correct' => $isCorrect,
            ]);
        }
    
        return redirect()
            ->route('questions.show', $test->id)
            ->with('success', 'Savol va variantlar muvaffaqiyatli yangilandi!');
    }

    public function destroy(Test $test, Question $question)
    {
        $question->options()->delete();

        $question->delete();

        return redirect()
            ->route('questions.show', $test->id)
            ->with('success', 'Savol va uning variantlari muvaffaqiyatli o‘chirildi!');
    }
}
