<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Group;
use App\Models\MidtermInterval;
use App\Models\AssignmentSubmission; 
use Illuminate\Http\Request;

class AssignmentSubmissionController extends Controller
{
    public function create(Assignment $assignment)
    {
        $user = auth()->user();
    
        // Agar bog‘lanish bo‘lmasa xatolik chiqmasin
        if (
            !$assignment->midtermInterval || 
            !$assignment->midtermInterval->groupSubject || 
            $assignment->midtermInterval->groupSubject->group_id !== $user->group_id
        ) {
            abort(403, "Sizning guruhingiz uchun emas!");
        }
    
        return view('students.submissions.create', compact('assignment'));
    }
    
    public function store(Request $request, Assignment $assignment)
    {
        // dd($request);

        $user = auth()->user();
    
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'student_id'    => 'required|exists:users,id',
            'file'          => 'required|file|mimes:pdf,doc,docx,zip,png,jpg|max:10240',
            'comment'       => 'nullable|string|max:500',
        ]);

        // dd($request->all());
    
        // Talabaning mavjud submissionini olish
        $existing = AssignmentSubmission::where('assignment_id', $assignment->id)
                        ->where('student_id', $user->id)
                        ->first();
    
        // Agar mavjud bo‘lsa, eski faylni o‘chirib tashlash
        // if ($existing) {
        //     if ($existing->file_path && \Storage::disk('public')->exists($existing->file_path)) {
        //         \Storage::disk('public')->delete($existing->file_path);
        //     }
        //     $existing->delete();
        // }
    
        // Original fayl nomi bilan saqlash
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $path = $file->storeAs('submissions', $originalName, 'public');
    
        // Yangi submission yaratish
        AssignmentSubmission::create([
            'assignment_id' => $assignment->id,
            'student_id'    => $user->id,
            'file_path'     => $path,
            'comment'       => $request->comment,
        ]);
    
        // Guruhni olish
        $groupSubject = $assignment->midtermInterval->groupSubject ?? null;
    
        return redirect()->route('student.assignments', $groupSubject->id)
                         ->with('success', 'Vazifa muvaffaqiyatli yuklandi!');
    }
    

    public function show(AssignmentSubmission $submission)
    {
        $user = auth()->user();

        // Xavfsizlik: faqat talaba yoki o'qituvchi ko‘ra oladi

        $submissions = AssignmentSubmission::all();


        return view('students.assignments.submission_show', compact('submission', 'submissions'));
    }

    public function edit(AssignmentSubmission $submission)
    {
        $submissions = AssignmentSubmission::all();

        return view('students.assignments.submission_show', compact('submission', 'submissions'));
    }

    // Admin uchun 
    public function adminSubmissionShow(Group $group, MidtermInterval $midterm, Assignment $assignment, AssignmentSubmission $submission)
    {
        $user = auth()->user();

        // Xavfsizlik: faqat talaba yoki o'qituvchi ko‘ra oladi

        $submissions = AssignmentSubmission::all();


        return view('admins.midterms.assignment.submission.show', compact('submission', 'group',  'submissions', 'midterm', 'assignment'));
    }

    public function adminSubmissionEdit(Group $group, MidtermInterval $midterm, Assignment $assignment, AssignmentSubmission $submission)
    {
        return view('admins.midterms.assignment.submission.show', compact('submission', 'group', 'midterm', 'assignment'));
    }
    
    

}
