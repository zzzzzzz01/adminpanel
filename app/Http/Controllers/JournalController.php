<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Group; 
use App\Models\GroupSubject;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function createJournal(Request $request)
    {

        // dd($request);
        // Checkbox orqali keladigan group_subject id larini olamiz
        $request->validate([
            'group_subject_id' => 'required|exists:group_subjects,id',
        ]);

        $gsId = $request->group_subject_id;

        // dd($gsId);

        // Agar shu group_subject uchun journal bo‘lmasa, yaratamiz
        $exists = Journal::where('group_subject_id', $gsId)->exists();

        if (! $exists) {
            Journal::create([
                'group_subject_id' => $gsId,
                'created_by' => auth()->id(),
            ]);
        }

        return redirect()->back()->with('success', 'Jurnallar yaratildi!');
    }

    public function adminJournalIndex()
    {
        $groups = Group::all();

        return view('admins.journal.index', compact('groups'));
    }

    public function adminJournalGroupSubject(Group $group)
    {
        // Guruhga tegishli group_subject lar
        $groupSubjects = GroupSubject::with('subject', 'teacher')
            ->where('group_id', $group->id)
            ->get();

        return view('admins.journal.groupSubjects', compact('group', 'groupSubjects'));
    }

    public function adminGroupJurnalsIndex(Group $group, GroupSubject $groupSubject)
    {
        // groupSubject dan semester_id ni olamiz (agar mavjud bo‘lsa)
        $semesterId = $groupSubject->semester_id ?? null;
    
        // Faqat shu groupSubject va shu semestrga tegishli schedulelarni olish
        $schedules = Schedule::where('group_subject_id', $groupSubject->id)
            ->when($semesterId, function ($query, $semesterId) {
                $query->where('semester_id', $semesterId);
            })
            ->orderBy('date')
            ->get();
    
        // Shu guruhdagi talabalar
        $students = $group->students;
    
        return view('admins.journal.groupJurnals', compact('group', 'groupSubject', 'schedules', 'students'));
    }
    

    public function showJournalGroupGrades(Schedule $schedule)
    {
        $students = $schedule->groupSubject->group->students->map(function($student) use ($schedule) {
            // Shu fan va guruhdagi barcha darslar bo‘yicha joriy baholarni yig‘ish
            $totalCurrent = Grade::where('student_id', $student->id)
                ->where('type', 'current')
                ->whereHas('schedule', function($q) use ($schedule) {
                    $q->where('group_subject_id', $schedule->group_subject_id);
                })->sum('score');
    
            $student->total_current_score = $totalCurrent;
            return $student;
        });
    
        $grades = Grade::where('schedule_id', $schedule->id)->get()->keyBy('student_id');

        $group = $schedule->groupSubject->group; 
        $groupSubject = $schedule->groupSubject; 
    
        return view('admins.journal.journalGrades', compact('schedule', 'students', 'grades', 'group', 'groupSubject'));
    }

    public function storeJournalGroupGrades(Request $request, Schedule $schedule)
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

                // Studentni olib kelish
                $student = User::find($studentId);
    
            // Agar yangi baho bilan maksimaldan oshsa → oldini olish
            if (($currentTotal + $score) > $maxCurrent) {
                return redirect()->back()->with('storeError', 
                    "Talaba {$student->name}ning umumiy joriy balli  maksimal ({$maxCurrent}) ball dan oshmoqda!"
                );
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

    public function journalSearch(Request $request)
    {
        $search = $request->input('search');
    
        // Agar qidiruv maydoni bo‘sh bo‘lsa — guruh fanlar sahifasiga qaytadi
        if (empty($search)) {
            return redirect()->route('adminJournal.index');
        }

        $groups = Group::where('group_name', 'like', "%{$search}%")
            ->orderBy('group_name')
            ->get();

        return view('admins.journal.index', compact('groups', 'search'));
    } 
    

    public function groupJournalsSearch(Request $request, Group $group)
    {
        $search = $request->input('search');

        // Guruhga tegishli groupSubjectlarni subject nomi bo‘yicha qidirish
        $groupSubjects = $group->groupSubjects()
            ->whereHas('subject', function ($query) use ($search) {
                if (!empty($search)) {
                    $query->where('name_uz', 'like', "%{$search}%");
                }
            })
            ->with('subject') // subject ma'lumotlarini birga yuklash
            ->get();

        return view('admins.journal.groupSubjects', compact('group', 'groupSubjects', 'search'));

    }

}
