<?php

namespace App\Http\Controllers;

use App\Models\GroupSubject;
use App\Models\Group;
use App\Models\MidtermInterval;
use App\Models\MidtermManualGrade;
use Illuminate\Http\Request;

class MidtermIntervalController extends Controller
{
    public function index()
    {
        $teacherId = auth()->id();
        $today = now()->toDateString(); // bugungi sana
    
        // faqat davom etayotgan semestrlardagi oraliq imtihonlar
        $midterms = MidtermInterval::with(['groupSubject.group', 'groupSubject.subject', 'groupSubject.semester'])
            ->whereHas('groupSubject', function ($q) use ($teacherId, $today) {
                $q->where('teacher_id', $teacherId)
                  ->whereHas('semester', function ($semester) use ($today) {
                      $semester->where('start_date', '<=', $today)
                               ->where('end_date', '>=', $today);
                  });
            })
            ->get();
    
        return view('midterms.index', compact('midterms'));
    }

    public function allMidterms()
    {
        $teacherId = auth()->id();

        // faqat o‘zining oraliqlari
        $midterms = MidtermInterval::with(['groupSubject.group', 'groupSubject.subject'])
        ->whereHas('groupSubject', function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })
        ->get();


        return view('midterms.all-midterms', compact('midterms'));
    }

    public function midtermsSearch(Request $request)
    {
        $search = $request->input('search');

        if (empty($search)) {
            return redirect()->route('all.midterms');
        }

        $teacherId = auth()->id();

        $midterms = MidtermInterval::with(['groupSubject.group', 'groupSubject.subject', 'groupSubject.semester'])
            ->whereHas('groupSubject', function ($q) use ($search, $teacherId) {
                $q->where('teacher_id', $teacherId)
                ->whereHas('group', function ($groupQuery) use ($search) {
                    $groupQuery->where('group_name', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('midterms.all-midterms', compact('midterms', 'search'));
    }
    

    public function create()
    {
        $teacherId = auth()->id();
        $today = now()->toDateString();

        $groupSubjects = GroupSubject::with(['group', 'subject', 'semester'])
            ->where('teacher_id', $teacherId)   // faqat shu ustozga tegishli
            ->whereHas('semester', function ($q) use ($today) {
                $q->whereDate('start_date', '<=', $today)
                  ->whereDate('end_date', '>=', $today);
            })
            ->whereDoesntHave('midtermIntervals')       // hali yaratilmagan midterm 
            ->get();

            
    
    
        return view('midterms.create', compact('groupSubjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_subject_id' => 'required|exists:group_subjects,id',
            'type'             => 'required|in:manual,assignment',
        ]);

        // dd($request);

        MidtermInterval::create([
            'group_subject_id' => $request->group_subject_id,
            'type'             => $request->type,
        ]);

        return redirect()
            ->route('midterms.index')
            ->with('success', 'Oraliq imtihon muvaffaqiyatli yaratildi!');
    }

    public function manual(MidtermInterval $midterm)
    {
        $groupSubject = $midterm->groupSubject;

        $students = $groupSubject->group->students;

        // Oldingi manual baholarni olish
        $grades = MidtermManualGrade::where('midterm_interval_id', $midterm->id)->get()
            ->keyBy('student_id');

        return view('midterms.manual', compact('midterm', 'groupSubject', 'students', 'grades'));
    }

    // Baholarni saqlash
    public function storeManual(Request $request, MidtermInterval $midterm)
    {
        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'nullable|numeric|min:0|max:100',
        ]);

        // dd($request);

        foreach ($request->grades as $studentId => $grade) {
            MidtermManualGrade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'group_subject_id' => $midterm->group_subject_id,
                    'midterm_interval_id' => $midterm->id,
                ],
                ['grade' => $grade]
            );
        }

        return redirect()->route('midterms.manual', $midterm->id)
                         ->with('success', 'Baholar saqlandi!');
    }

    public function assignment(MidtermInterval $midterm)
    {

        // dd($midterm->all());
        return view('midterms.assignment.index', compact('midterm'));
    }

    public function toggleStatus(MidtermInterval $midterm)
    {

        // dd($midterm->id);

        if ($midterm->status == 1) {
            return redirect()->back()->with('error', 'Bu oraliq allaqachon faollashgan va endi o‘chirib bo‘lmaydi.');
        }

        $midterm->update(['status' => 1]);

        return redirect()->back()->with('success', 'Oraliq muvaffaqiyatli faollashtirildi!');
    }


    //Admin uchun
    public function adminIndex()
    {
        $groups = Group::all();

        return view('admins.midterms.index', compact('groups'));
    }

    public function adminGroupMidterm(Group $group)
    {
        $groupSubjects = GroupSubject::with(['subject', 'teacher', 'midtermIntervals'])
            ->where('group_id', $group->id)
            ->get();

        return view('admins.midterms.groupSubjects', compact('groupSubjects', 'group'));
    }

    public function adminManual(Group $group, MidtermInterval $midterm)
    {
        $groupSubject = $midterm->groupSubject;

        $students = $groupSubject->group->students;

        $grades = MidtermManualGrade::where('midterm_interval_id', $midterm->id)->get()
            ->keyBy('student_id');

        return view('admins.midterms.manual', compact('group','midterm', 'groupSubject', 'students', 'grades'));
    }

    public function adminMidtermSearch(Request $request)
    {
        $search = $request->input('search');
    
        if (empty($search)) {
            return redirect()->route('admin.midterms.index');
        }

        $groups = Group::where('group_name', 'like', "%{$search}%")
            ->orderBy('group_name')
            ->get();

        return view('admins.midterms.index', compact('groups', 'search'));
    } 

    // Baholarni saqlash
    public function sadminStoreManual(Request $request, Group $group, MidtermInterval $midterm)
    {
        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'nullable|numeric|min:0|max:100',
        ]);
    
        foreach ($request->grades as $studentId => $grade) {
            // Agar input bo'sh yoki null bo'lsa — o'tkazib yubor
            if ($grade === null || $grade === '') {
                continue;
            }
    
            // Qo'shimcha tekshiruv: faqat sonli qiymatlarni qabul qilamiz
            if (!is_numeric($grade)) {
                continue;
            }
    
            // Agar kerak bo'lsa, butun yoki onlikga aylantirish
            $gradeValue = $grade + 0; // numeric string -> number
    
            MidtermManualGrade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'group_subject_id' => $midterm->group_subject_id,
                    'midterm_interval_id' => $midterm->id,
                ],
                ['grade' => $gradeValue]
            );
        }
    
        return redirect()->route('admins.midterms.manual', ['group' => $group->id, 'midterm' => $midterm->id])
                         ->with('success', 'Baholar saqlandi!');
    }

    public function adminAssignment(Group $group, MidtermInterval $midterm)
    {

        // dd($midterm->all());
        return view('admins.midterms.assignment.index', compact('group', 'midterm'));
    }
    
}
