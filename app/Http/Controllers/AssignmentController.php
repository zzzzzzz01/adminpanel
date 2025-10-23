<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MidtermInterval;
use App\Models\Group;
use App\Models\GroupSubject;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function create(MidtermInterval $midterm)
    {
        // kerakli relationlarni oldindan yuklaymiz
        $midterm->load('groupSubject.semester', 'groupSubject.group', 'groupSubject.subject');
    
        $groupSubject = $midterm->groupSubject;
        if (! $groupSubject) {
            abort(404, 'Bu oraliqqa tegishli groupSubject topilmadi.');
        }
    
        // Semestr (agar mavjud bo'lsa) dan min va max sanalarni ISO formatda olamiz
        $semester = $groupSubject->semester;
        $min = $max = null;
        if ($semester) {
            $min = Carbon::parse($semester->start_date)->toDateString(); // YYYY-MM-DD
            $max = Carbon::parse($semester->end_date)->toDateString();
        }

        // dd($min, $max);
    
        return view('midterms.assignment.create', compact('midterm', 'groupSubject', 'semester', 'min', 'max'));
    }

    public function store(Request $request, MidtermInterval $midterm)
    {

        // dd($request, $midterm->id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_score'   => 'required|integer|min:1',
            'attempts'    => 'required|integer|min:1',
            'due_date'    => 'required|date',
            'due_time'    => 'required',
            'file'        => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:10240',
        ]);

        // dd($request);
    
        // O‘sha midterm_interval uchun mavjud assignmentlarning jami balli
        $existingTotal = $midterm->assignments()->sum('max_score');
    
        $maxMidtermScore = $midterm->groupSubject->max_midterm_score ?? 100;
    
        if (($existingTotal + $request->max_score) > $maxMidtermScore) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'max_score' => "Ushbu vazifa uchun berilgan ball jami $maxMidtermScore dan oshmasligi kerak. Hozirgi mavjud ball: $existingTotal"
                ]);
        }
    
        $data = $request->all();
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $filePath = $file->storeAs('assignments', $originalName, 'public');
            $data['file'] = $filePath;
        }
    
        $midterm->assignments()->create($data);
    
        return redirect()->route('midterms.assignment', $midterm->id)
                         ->with('success', 'Assignment muvaffaqiyatli yaratildi!');
    }

    public function submissions(Assignment $assignment)
    {
        // dd($assignment->id);

        // shu assignment qaysi guruhga tegishli
        $group = $assignment->midtermInterval->groupSubject->group;

        // dd($group);

        // shu guruhdagi talabalar
        $students = $group->students()->with([
            'submissions' => function ($q) use ($assignment) {
                $q->where('assignment_id', $assignment->id);
            }
        ])->get();
        
        return view('students.assignments.submissions', compact('assignment', 'students'));
    }

    public function studentIndex(GroupSubject $groupSubject)
    {
        $user = auth()->user();
    
        if ($groupSubject->group_id !== $user->group_id) {
            abort(403, 'Sizning guruhingizga tegishli emas!');
        }
    
        $assignments = Assignment::where('status', 1)
            ->whereHas('midtermInterval', function($q) use ($groupSubject) {
                $q->where('group_subject_id', $groupSubject->id);
            })
            ->with('midtermInterval')
            ->get();
    
        return view('students.assignments.index', compact('groupSubject', 'assignments'));
    }
    

    public function assignmentStatus(Assignment $assignment)
    {

        // dd($assignment->id);

        if ($assignment->status == 1) {
            return redirect()->back()->with('error', 'Bu oraliq allaqachon faollashgan va endi o‘chirib bo‘lmaydi.');
        }

        $assignment->update(['status' => 1]);

        return redirect()->back()->with('success', 'Oraliq muvaffaqiyatli faollashtirildi!');
    }

    // Admin uchun
    public function AdminCreate(Group $group,MidtermInterval $midterm)
    {
        // kerakli relationlarni oldindan yuklaymiz
        $midterm->load('groupSubject.semester', 'groupSubject.group', 'groupSubject.subject');
    
        $groupSubject = $midterm->groupSubject;
        if (! $groupSubject) {
            abort(404, 'Bu oraliqqa tegishli groupSubject topilmadi.');
        }
    
        $semester = $groupSubject->semester;
        $min = $max = null;
        if ($semester) {
            $min = Carbon::parse($semester->start_date)->toDateString(); // YYYY-MM-DD
            $max = Carbon::parse($semester->end_date)->toDateString();
        }

        // dd($min, $max);
    
        return view('admins.midterms.assignment.create', compact('group','midterm', 'groupSubject', 'semester', 'min', 'max'));
    }

    public function adminStore(Request $request, MidtermInterval $midterm)
    {

        // dd($request, $midterm->id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_score'   => 'required|integer|min:1',
            'attempts'    => 'required|integer|min:1',
            'due_date'    => 'required|date',
            'due_time'    => 'required',
            'file'        => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:10240',
        ]);

        // dd($request);
    
        // O‘sha midterm_interval uchun mavjud assignmentlarning jami balli
        $existingTotal = $midterm->assignments()->sum('max_score');
    
        $maxMidtermScore = $midterm->groupSubject->max_midterm_score ?? 100;
    
        if (($existingTotal + $request->max_score) > $maxMidtermScore) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'max_score' => "Ushbu vazifa uchun berilgan ball jami $maxMidtermScore dan oshmasligi kerak. Hozirgi mavjud ball: $existingTotal"
                ]);
        }
    
        $data = $request->all();
    
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $filePath = $file->storeAs('assignments', $originalName, 'public');
            $data['file'] = $filePath;
        }
    
        $midterm->assignments()->create($data);
    
        return redirect()->route('admins.midterms.assignment', $midterm->id)
                         ->with('success', 'Assignment muvaffaqiyatli yaratildi!');
    }

    public function adminSubmissions(Group $group, MidtermInterval $midterm, Assignment $assignment)
    {
        // dd($assignment->id);

        $group = $assignment->midtermInterval->groupSubject->group;

        // dd($group);

        $students = $group->students()->with([
            'submissions' => function ($q) use ($assignment) {
                $q->where('assignment_id', $assignment->id);
            }
        ])->get();
        
        return view('admins.midterms.assignment.submission.index', compact('group', 'midterm','assignment', 'students'));
    }

}
