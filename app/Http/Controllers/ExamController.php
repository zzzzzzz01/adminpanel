<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Group; 
use App\Models\Test; 
use App\Models\Semester;
use App\Models\ExamSessionStudentAccess; 
use App\Models\GroupSubject; 
use App\Models\ExamSession;
use App\Models\Result;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $student = auth()->user();
        $group = $student->group;
    
        // Guruhdagi semestrlar
        $semesters = $group->semesters;
    
        // Hozirgi semestrni aniqlash (bugungi sana qaysi oralikda)
        $today = now();
        $currentSemester = $semesters->first(function ($semester) use ($today) {
            return $today->between($semester->start_date, $semester->end_date);
        });
    
        // Agar request orqali semestr tanlanmagan bo‘lsa, avtomatik hozirgi semestr tanlanadi
        $semesterId = $request->get('semester_id') 
            ?? ($currentSemester->id ?? $semesters->first()->id ?? null);
    
        // Shu semestrdagi group_subjectlar
        $groupSubjects = GroupSubject::where('group_id', $group->id)
            ->where('semester_id', $semesterId)
            ->with('subject')
            ->get();
    
        // Shu semestrga tegishli testlar — exam_session orqali
        $tests = Test::whereIn('group_subject_id', $groupSubjects->pluck('id'))
            ->whereHas('examSessions')
            ->with(['groupSubject.subject', 'examSessions'])
            ->get();
    
        // Talabaning natijalari
        $results = Result::where('student_id', $student->id)
            ->pluck('id', 'test_id');
    
        // Testga kirish ruxsatlari
        $accessList = [];
        foreach ($tests as $test) {
            $accessList[$test->id] = ExamSessionStudentAccess::where('test_id', $test->id)
                ->where('student_id', $student->id)
                ->where('is_allowed', true)
                ->exists();
        }
    
        return view('exams.index', [
            'semesters' => $semesters,
            'semesterId' => $semesterId,
            'groupSubjects' => $groupSubjects,
            'tests' => $tests,
            'results' => $results,
            'accessList' => $accessList,
            'user' => $student,
        ]);
    }
    
    
    

    public function getExamsByGroupAndSemester(Request $request)
    {
        $request->validate([
            'semester_id' => 'required|integer|between:1,8',
            'group_id' => 'required|integer|exists:groups,id',
        ]);
    
        $exams = Exam::with('teacher')
            ->whereHas('groups', function ($query) use ($request) {
                $query->where('group_id', $request->group_id)
                      ->where('exam_group.semester_id', $request->semester_id);
            })
            ->orderBy('exam_date')
            ->get();
    
        return response()->json($exams);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $semesters = Semester::all();
        $groups = Group::all();

        return view('exams.create', compact('groups', 'semesters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validated = $request->validate([
            'subject' => 'required',
            'exam_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'room' => 'required',
            'teacher_id' => 'required|exists:teachers,id',
            'groups' => 'nullable|array',
            'groups.*' => 'exists:groups,id',
        ]);

        // dd($validated);
    
        // Imtihon yaratish
        $exam = Exam::create($validated);
    
        // Guruhlarni biriktirish (agar mavjud bo‘lsa)
        foreach ($validated['groups'] as $groupId) {
            $group = Group::find($groupId);
    
            if ($group) {
                $exam->groups()->attach($groupId, [
                    'semester_id' => $group->semester_id,
                ]);
            }
        }
    
        return redirect()->route('exams.index')->with('success', 'Imtihon muvaffaqiyatli qo\'shildi!');
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        $subjects = Subject::all();

        $users = User::whereHas('roles', function ($query) {
            $query->where('roles.id', 3);
        })->get();

        $groups = Group::all();
    
        return view('exams.edit', compact('exam', 'subjects', 'users', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        // Validation
        $validated = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'subject_id' => 'sometimes|required|exists:subjects,id',
            'date' => 'sometimes|required|date',
            'time' => 'sometimes|required',
            'room' => 'sometimes|required|string',
            'groups' => 'sometimes|nullable|array',
            'groups.*' => 'sometimes|exists:groups,id',
        ]);

        $exam->fill($validated)->save();
    
        // Guruhlarni yangilash (agar groups kiritilgan bo'lsa)
        if ($request->has('groups')) {
            $exam->groups()->sync($request->input('groups', []));
        }
    
        return redirect()->route('exams.index')->with('success', __('words.exam.update.success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('exams.index')->with('examDelete', __('words.exam.delete'));
    }
}
