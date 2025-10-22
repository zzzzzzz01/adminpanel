<?php

namespace App\Http\Controllers;

use App\Models\MidtermGrade;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;

class MidtermGradeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'assignment_submission_id' => 'required|exists:assignment_submissions,id',
            'grade' => 'required|numeric|min:0|max:100',
        ]);
    
        // submissionni topib olish
        $submission = AssignmentSubmission::findOrFail($request->assignment_submission_id);

        // dd($submission->id);
        
        $assignment = $submission->assignment;

        // dd($submission->id);

        // dd($assignment->midtermInterval->group_subject_id);
    
        // create orqali group_subject_id ni ham qo‘shib yuboramiz
        MidtermGrade::create([
            'student_id' => $request->student_id,
            'assignment_submission_id' => $submission->id,
            'grade' => $request->grade,
            'group_subject_id' => $assignment->midtermInterval->group_subject_id,
        ]);
    
        return redirect()->route('assignments.submissions', $assignment->id)
                     ->with('success', 'Midterm baho saqlandi!');
    }
    

    public function update(Request $request, MidtermGrade $midtermGrade)
    {
        $request->validate([
            'grade' => 'required|numeric|min:0|max:100',
        ]);

        $midtermGrade->update([
            'grade' => $request->grade,
        ]);

        return back()->with('success', 'Midterm baho yangilandi!');
    }

    //Admin uchun 
    public function adminSubmissionStore(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'assignment_submission_id' => 'required|exists:assignment_submissions,id',
            'grade' => 'required|numeric|min:0',
        ]);

        // dd($request->all());
    
        // submissionni topib olish
        $submission = AssignmentSubmission::findOrFail($request->assignment_submission_id);
        $assignment = $submission->assignment;

        // dd($assignment->id);
    
        // Dinamik validatsiya: agar grade > max_score bo‘lsa, xato
        if ($request->grade > $assignment->max_score) {
            return redirect()->back()
                ->withErrors(['grade' => 'Baho maksimal ball (' . $assignment->max_score . ') dan oshmasligi kerak!'])
                ->withInput();
        }
    
        // Bahoni saqlash
        MidtermGrade::create([
            'student_id' => $request->student_id,
            'assignment_submission_id' => $submission->id,
            'grade' => $request->grade,
            'group_subject_id' => $assignment->midtermInterval->group_subject_id,
        ]);
    
        return redirect()->route('admin.assignments.submissions', [
            'group' => $assignment->midtermInterval->groupSubject->group_id,
            'midterm' => $assignment->midtermInterval->id,
            'assignment' => $assignment->id,
        ])->with('success', 'Midterm baho saqlandi!');
    }
    
}
