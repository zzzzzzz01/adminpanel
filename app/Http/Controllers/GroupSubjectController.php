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
        $subjects  = Subject::all();
        // $teachers  = User::whereHas('roles', function ($query) {
        //     $query->where('roles.id', 3);
        // })->get();
        $semesters = $group->semesters;

        // dd($semesters);
    
        return view('groups.groupSubject.index', compact('group', 'subjects',  'semesters'));
    }

    public function store(Request $request, Group $group)
    {

        // dd($request);

        $request->validate([
            'subject_id'   => 'required|exists:subjects,id',
            'teacher_id'   => 'required|exists:users,id',
            'semester_id'  => 'required|exists:semesters,id',
            'audit_hours'  => 'required',
            'max_current_score' => 'required|integer',
            'max_midterm_score' => 'required|integer',
            'max_final_score'   => 'required|integer',
        ]);

        // dd($request);

        $total = $request->max_current_score + $request->max_midterm_score + $request->max_final_score;

        if ($total > 100) {
            return redirect()->back()->withErrors(['max_total' => 'Joriy + Oraliq + Yakuniy baho jami 100 dan oshmasligi kerak.']);
        }

        // Agar shu fan shu semestrda mavjud bo‘lsa update qilamiz
        $group->subjects()->syncWithoutDetaching([
            $request->subject_id => [
                'teacher_id'  => $request->teacher_id,
                'semester_id' => $request->semester_id,
                'audit_hours' => $request->audit_hours,
                'max_current_score' => $request->max_current_score,
                'max_midterm_score' => $request->max_midterm_score,
                'max_final_score'   => $request->max_final_score,
            ]
        ]);

        return back()->with('success', 'Fan biriktirish bekor qilindi');
    }

    public function update(Request $request, Group $group)
    {
        $request->validate([
            'subjects'    => 'required|array',
            'semester_id' => 'required|exists:semesters,id',
            'teacher_id'  => 'required|exists:users,id',
            'audit_hours'  => 'required|integer|min:1',
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
    
        return back()->with('success', 'Fanlar yangilandi.');
    }

    public function edit(Group $group, Subject $subject)
    {
        $semesters = Semester::all();
        $subjects  = Subject::all();
        $teachers  = User::whereHas('roles', function ($query) {
            $query->where('roles.id', 3);
        })->get();
    
        // Guruhga oldin biriktirilgan fanlarni olish
        $assignedSubjects = $group->subjects->mapWithKeys(function ($subj) {
            return [$subj->id => [
                'semester_id' => $subj->pivot->semester_id,
                'teacher_id'  => $subj->pivot->teacher_id,
            ]];
        });
    
        // Bu yerda aynan ozgartirilayotkan subjectni alohida o‘zgartiramiz
        $editingSubject = $group->subjects()->findOrFail($subject->id);
    
        return view('groups.groupSubject.index', compact(
            'group', 
            'semesters',
            'subjects',
            'teachers', 
            'assignedSubjects',
            'editingSubject'  
        ));
    }

    public function destroy(Group $group, Subject $subject)
    {

        // dd($subject->all(), $group->all());
        // Guruh va fan o‘rtasidagi pivot (biriktirish)ni o‘chirish
        $group->subjects()->detach($subject->id);
    
        return redirect()->route('groupSubject.index', $group->id)
                     ->with('success', 'Fan guruhdan muvaffaqiyatli o‘chirildi.');
    }

    public function groupSubjectSearch(Request $request, Group $group)
    {
        $search = $request->input('search');
    
        if (empty($search)) {
            return redirect()->route('groupSubject.index', $group->id);
        }
    
        $subjects = $group->subjects()
            ->where(function ($query) use ($search) {
                $query->where('name_uz', 'like', "%{$search}%")
                      ->orWhere('name_ru', 'like', "%{$search}%")
                      ->orWhere('name_en', 'like', "%{$search}%");
            })
            ->get();
    
        $teachers = User::whereHas('roles', function ($query) {
            $query->where('roles.id', 3); // 3 — o‘qituvchi roli
        })->get();
    
        return view('groups.groupSubject.index', [
            'group' => $group,
            'subjects' => $subjects,
            'teachers' => $teachers,
            'search' => $search,
            'isSearch' => true, // qidiruv rejimi ekanligini belgilaymiz
        ]);
    }
    
    
    
}
