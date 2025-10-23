<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Student;
use App\Models\Grade;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\Group;
use App\Models\GradeJournal;
use App\Models\Journal;
use Illuminate\Http\Request; 

class GradeJournalController extends Controller
{

    public function index()
    {
        $teacherId = auth()->id(); 
        $today = now()->toDateString(); 

        $journals = Journal::with(['groupSubject.subject', 'groupSubject.group'])
            ->whereHas('groupSubject', function($query) use ($teacherId, $today) {
                $query->where('teacher_id', $teacherId)
                ->whereHas('semester', function ($semester) use ($today) {
                    $semester->where('start_date', '<=', $today)
                             ->where('end_date', '>=', $today);
                });
            })
            ->get();

        return view('teachers.journals.index', compact('journals'));
    }

    public function alljournals()
    {
        $teacherId = auth()->id(); 

        $journals = Journal::with(['groupSubject.subject', 'groupSubject.group'])
            ->whereHas('groupSubject', function($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            })
            ->get();

        return view('teachers.journals.all-journals', compact('journals'));
    }

    public function show(Group $group, Subject $subject)
    {
        $teacherId = auth()->id();
    
        $schedules = $group->schedules()
            ->whereHas('groupSubject', function($query) use ($subject, $teacherId) {
                $query->where('subject_id', $subject->id)
                      ->where('teacher_id', $teacherId);
            })
            ->with(['groupSubject.subject'])
            ->paginate(10);
    
        $students = $group->students;
    
        return view('teachers.journals.show', compact('group', 'subject', 'schedules', 'students'));
    }
    

    public function showGrades(Schedule $schedule)
    {
        $students = $schedule->groupSubject->group->students->map(function($student) use ($schedule) {
            $totalCurrent = Grade::where('student_id', $student->id)
                ->where('type', 'current')
                ->whereHas('schedule', function($q) use ($schedule) {
                    $q->where('group_subject_id', $schedule->group_subject_id);
                })->sum('score');
    
            $student->total_current_score = $totalCurrent;
            return $student;
        });
    
        $grades = Grade::where('schedule_id', $schedule->id)->get()->keyBy('student_id');
    
        return view('teachers.journals.gradesShow', compact('schedule', 'students', 'grades'));
    }
    
    

    public function storeGrades(Request $request, Schedule $schedule)
    {
        $request->validate([
            'grades' => 'required|array',
            'journal_id' => 'required|exists:journals,id',
        ]);
    
        $maxCurrent = $schedule->groupSubject->max_current_score;
    
        foreach ($request->grades as $studentId => $score) {
            $currentTotal = Grade::where('student_id', $studentId)
                ->where('type', 'current')
                ->whereHas('schedule', function($q) use ($schedule) {
                    $q->where('group_subject_id', $schedule->group_subject_id);
                })->sum('score');
    
            // Agar yangi baho bilan maksimaldan oshsa → oldini olish
            if (($currentTotal + $score) > $maxCurrent) {
                return redirect()->back()->withErrors([
                    "Student {$studentId} umumiy joriy balli {$currentTotal} maksimal {$maxCurrent} dan oshmoqda!"
                ]);
            }
    
            Grade::updateOrCreate(
                [
                    'journal_id'  => $request->journal_id,
                    'schedule_id' => $schedule->id,
                    'student_id'  => $studentId,
                ],
                [
                    'score' => $score,
                    'type'  => 'current',
                ]
            );
        }
    
        return redirect()->back()->with('success', 'Baholar saqlandi!');
    }
    
        

    // Baholash sahifasini ochish
    public function create(Group $group, Schedule $schedule)
    {
        $students = $group->students;
    
        // O‘sha dars jadvaliga tegishli mavjud baholar (agar bo‘lsa)
        $grades = GradeJournal::where('schedule_id', $schedule->id)
            ->get()
            ->keyBy('student_id');
    
        return view('teachers.journals.create', compact('group', 'schedule', 'students', 'grades'));
    }
    
    

    // Bahoni saqlash
    public function store(Request $request, Group $group, $date)
    {
        foreach ($request->grades as $student_id => $grade) {
            GradeJournal::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'group_id'   => $group->id,
                    'date'       => $date,
                ],
                ['grade' => $grade]
            );
        }

        return redirect()->route('teachers.journals.create', [$group->id, $date])
                         ->with('success', 'Baholar saqlandi!');
    }



    public function studentGrades()
    {
        return view('students.grades');
    }

    

    public function teacherGrades()
    {
        $teacherId = auth()->id(); 

        // dd($teacherId);
    
        $groups = Group::whereHas('schedules', function ($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            })
            ->with([
                'schedules' => function ($q) use ($teacherId) {
                    $q->where('teacher_id', $teacherId)
                      ->with(['subject', 'semester', 'gradeJournals.student']);
                }
            ])
            ->get();
    
        return view('teachers.grades', compact('groups'));
    }



    public function groupGrades(Group $group)
    {
        $teacherId = auth()->id();
    
        $schedules = $group->schedules()
            ->where('teacher_id', $teacherId)
            ->with(['subject', 'gradeJournals.student'])
            ->orderBy('date', 'asc')
            ->get();
    
        $students = $group->students;
    
        $dates = $schedules->pluck('date')->unique();
    
        return view('teachers.group-grades', compact('group', 'schedules', 'students', 'dates'));
    }

    public function journalsSearch(Request $request)
    {
        $search = trim($request->input('search'));
        $teacherId = auth()->id();
    
        if (empty($search)) {
            return redirect()->route('all.journals');
        }
    
        $journals = Journal::with(['groupSubject.subject', 'groupSubject.group'])
            ->whereHas('groupSubject', function ($query) use ($teacherId, $search) {
                $query->where('teacher_id', $teacherId)
                      ->whereHas('group', function ($q) use ($search) {
                          $q->where('group_name', 'like', "%{$search}%");
                      });
            })
            ->get();
    
        return view('teachers.journals.all-journals', compact('journals', 'search'));
    }
    
    
    
    
    
    
}
