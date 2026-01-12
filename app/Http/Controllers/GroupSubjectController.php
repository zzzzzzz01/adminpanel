<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\Group;
use App\Models\GroupSubject;
use App\Models\Semester;
use Illuminate\Http\Request;

class GroupSubjectController extends Controller
{
    public function index(Group $group)
    {
        $groupSubjects = GroupSubject::with([
            'subject',
            'teacher',
            'semester'
        ])
        ->where('group_id', $group->id)
        ->get();

        return view('groups.groupSubject.index', [
            'group'            => $group,
            'groupSubjects'    => $groupSubjects,
            'subjects'         => Subject::all(),
            'teachers'         => User::whereHas('roles', fn ($q) => $q->where('roles.id', 3))->get(),

            // 🔴 view xatoga tushmasligi uchun
            'semesters'        => Semester::all(),
            'assignedSubjects' => collect(),
            'editingSubject'   => null,
            'isSearch'         => false,
        ]);
    }

    public function store(Request $request, Group $group)
    {
        $request->validate([
            'subject_id'          => 'required|exists:subjects,id',
            'teacher_id'          => 'required|exists:users,id',
            'semester_id'         => 'required|exists:semesters,id',
            'audit_hours'         => 'required|integer|min:1',
            'max_current_score'   => 'required|integer|min:0',
            'max_midterm_score'   => 'required|integer|min:0',
            'max_final_score'     => 'required|integer|min:0',
        ]);

        $total = $request->max_current_score
               + $request->max_midterm_score
               + $request->max_final_score;

        if ($total > 100) {
            return back()->withErrors([
                'max_total' => 'Joriy + Oraliq + Yakuniy baholar yig‘indisi 100 dan oshmasligi kerak.'
            ]);
        }

        $group->subjects()->syncWithoutDetaching([
            $request->subject_id => [
                'teacher_id'        => $request->teacher_id,
                'semester_id'       => $request->semester_id,
                'audit_hours'       => $request->audit_hours,
                'max_current_score' => $request->max_current_score,
                'max_midterm_score' => $request->max_midterm_score,
                'max_final_score'   => $request->max_final_score,
            ]
        ]);

        return back()->with('success', 'Fan muvaffaqiyatli biriktirildi.');
    }

    public function update(Request $request, Group $group)
    {
        $request->validate([
            'subjects'    => 'required|array',
            'semester_id' => 'required|exists:semesters,id',
            'teacher_id'  => 'required|exists:users,id',
            'audit_hours' => 'required|integer|min:1',
        ]);

        $syncData = [];

        foreach ($request->subjects as $subjectId) {
            $syncData[$subjectId] = [
                'semester_id' => $request->semester_id,
                'teacher_id'  => $request->teacher_id,
                'audit_hours' => $request->audit_hours,
            ];
        }

        $group->subjects()->sync($syncData);

        return back()->with('success', 'Fanlar muvaffaqiyatli yangilandi.');
    }

    public function edit(Group $group, Subject $subject)
    {
        $teachers = User::whereHas('roles', fn ($q) => $q->where('roles.id', 3))->get();

        $assignedSubjects = $group->subjects->mapWithKeys(function ($subj) {
            return [
                $subj->id => [
                    'semester_id' => $subj->pivot->semester_id,
                    'teacher_id'  => $subj->pivot->teacher_id,
                ]
            ];
        });

        $editingSubject = $group->subjects()->findOrFail($subject->id);

        return view('groups.groupSubject.index', [
            'group'            => $group,
            'groupSubjects'    => GroupSubject::with(['subject','teacher','semester'])
                                    ->where('group_id', $group->id)->get(),
            'subjects'         => Subject::all(),
            'teachers'         => $teachers,
            'semesters'        => Semester::all(),
            'assignedSubjects' => $assignedSubjects,
            'editingSubject'   => $editingSubject,
            'isSearch'         => false,
        ]);
    }

    public function destroy(Group $group, Subject $subject)
    {
        $group->subjects()->detach($subject->id);

        return redirect()
            ->route('groupSubject.index', $group->id)
            ->with('success', 'Fan guruhdan muvaffaqiyatli o‘chirildi.');
    }

    public function groupSubjectSearch(Request $request, Group $group)
    {
        $search = trim($request->input('search'));

        if ($search === '') {
            return redirect()->route('groupSubject.index', $group->id);
        }

        $subjects = $group->subjects()
            ->where(function ($query) use ($search) {
                $query->where('subjects.name_uz', 'like', "%{$search}%")
                      ->orWhere('subjects.name_ru', 'like', "%{$search}%")
                      ->orWhere('subjects.name_en', 'like', "%{$search}%");
            })
            ->select('subjects.*') // 🔴 ambiguous id ni yo‘q qiladi
            ->get();

        return view('groups.groupSubject.index', [
            'group'            => $group,
            'subjects'         => $subjects,
            'teachers'         => User::whereHas('roles', fn ($q) => $q->where('roles.id', 3))->get(),
            'groupSubjects'    => collect(),
            'semesters'        => Semester::all(),
            'assignedSubjects' => collect(),
            'editingSubject'   => null,
            'search'           => $search,
            'isSearch'         => true,
        ]);
    }
}
