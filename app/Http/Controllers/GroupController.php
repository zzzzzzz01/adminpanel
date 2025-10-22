<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Group;
use App\Models\User;
use App\Models\Week;
use App\Models\Program;
use App\Models\Semester; 
use App\Models\Subject; 
use App\Models\AcademicYear;
use App\Models\Payment;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Group::query();

        // dd($query);
    
        // Filtrlash
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }
    
        // if ($request->filled('semester_number')) {
        //     $query->where('current_semester_number', $request->semester_number);
        // }
    
        if ($request->filled('group_name')) {
            $query->where('group_name', 'like', '%' . $request->group_name . '%');
        }
    
        // Oxirida eng yangilar birinchi bo‘lib chiqadi
        $groups = $query->orderBy('created_at', 'desc')->get();
    
        return view('groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programs = Program::all();
        $academicYears = AcademicYear::all();
        
        return view('groups.create', compact('programs', 'academicYears'));
    }

    public function scheduleGroupCreate()
    {
        $programs = Program::all();
        $academicYears = AcademicYear::all();
        
        return view('groups.create', compact('programs', 'academicYears'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);

        $request->validate([
            'group_name' => 'nullable|string',
            'full_group_name' => 'required|string',
            'education_type' => 'required|in:Bakalavr,Magistratura,Doktorantura',
            'academic_year_id' => 'required|exists:academic_years,id',
            'study_duration' => 'required|integer|min:1|max:10',
            'total_semesters' => 'required|integer|min:1|max:20',
            'fall_start_date' => 'required|date',
            'fall_end_date' => 'required|date',
            'spring_start_date' => 'required|date',
            'spring_end_date' => 'required|date',
            // 'current_semester' => 'required|integer|min:1|max:20', 
            'is_graduated' => 'required|boolean',                 
            'program_id' => 'required|exists:programs,id',
        ]);

        // dd($request);
    
        $academicYear = AcademicYear::findOrFail($request->academic_year_id);
        $years = explode('-', $academicYear->name);  // masalan: "2025-2026"
        $start_year = (int) $years[0];
        $end_year   = $start_year + $request->study_duration;
    
        $group = Group::create([
            'group_name' => $request->group_name,
            'full_group_name' => $request->full_group_name,
            'education_type' => $request->education_type,
            'academic_year_id' => $request->academic_year_id,
            'start_year' => $start_year,
            'end_year' => $end_year,
            'study_duration' => $request->study_duration,
            'total_semesters' => $request->total_semesters,
            'current_semester' => 1, // vaqtincha
            'is_graduated' => $request->is_graduated,
            'program_id' => $request->program_id,
        ]);

        // Yangi funksiya — semestrlarni yaratish
        $this->generateSemesters($group, $request);

        // Eski funksiya — haftalarni yaratish (sening mavjud logikang)
        $this->generateWeeks($group, $request);

         // ✅ Endi hozirgi sanaga qarab semestrni aniqlaymiz
        $currentWeek = Week::where('group_id', $group->id)
        ->whereDate('start_date', '<=', now())
        ->whereDate('end_date', '>=', now())
        ->first();

        if ($currentWeek) {
            $group->current_semester = $currentWeek->semester->semester_number;
        } else {
            // Agar hozirgi sana hali 1-semestr boshlanmagan davrda bo‘lsa
            $group->current_semester = 1;
        }

        $group->save();
    
        return redirect()->route('groups.index')->with('success', 'Guruh va haftalar yaratildi.');
    }


    public function generateWeeks(Group $group, Request $request)
    {
        $fallStartTpl   = Carbon::parse($request->fall_start_date);
        $fallEndTpl     = Carbon::parse($request->fall_end_date);
        $springStartTpl = Carbon::parse($request->spring_start_date);
        $springEndTpl   = Carbon::parse($request->spring_end_date);
    
        $totalSemesters = (int)$group->total_semesters;
        $academicYear = AcademicYear::find($group->academic_year_id);
        $startAcademic = (int) explode('-', $academicYear->name)[0];

        // dd($startAcademic);
    
        // Har semestr uchun davrlarni tayyorlaymiz
        $periods = [];
        for ($s = 1; $s <= $totalSemesters; $s++) {
            $yearOffset = intdiv($s - 1, 2);
    
            if ($s % 2 === 1) {
                // Kuz semestr
                $year = $startAcademic + $yearOffset;
                $start = $fallStartTpl->copy()->year($year);
                $end   = $fallEndTpl->copy()->year($year);
            } else {
                // Bahor semestr
                $year = $startAcademic + $yearOffset + 1;
                $start = $springStartTpl->copy()->year($year);
                $end   = $springEndTpl->copy()->year($year);
            }
    
            $periods[] = [
                'sem'   => $s,
                'start' => $start,
                'end'   => $end,
            ];
        }
    
        $overallStart = $periods[0]['start']->copy();
        $overallEnd   = $periods[count($periods)-1]['end']->copy();
    
        // Eski haftalarni o‘chiramiz
        Week::where('group_id', $group->id)->delete();
    
        $weekNumber = 1;
        $current = $overallStart->copy();
    
        while ($current->lte($overallEnd)) {
            $weekStart = $current->copy();
            $weekEnd   = $current->copy()->addDays(6);
            if ($weekEnd->gt($overallEnd)) {
                $weekEnd = $overallEnd->copy();
            }
    
            $semesterForWeek = null;
            $weekType = 'Tatil'; // default Tatil
    
            foreach ($periods as $p) {
                if ($weekStart->between($p['start'], $p['end'])) {
                    $semesterForWeek = $p['sem'];
                    $weekType = "Nazariy talim"; 
                    break;
                }
            }
    
            // Agar semestr aniqlanmagan bo‘lsa (masalan, tatil davri)
            if (!$semesterForWeek) {
                foreach ($periods as $p) {
                    if ($p['start']->gt($weekStart)) {
                        $semesterForWeek = $p['sem'];
                        break;
                    }
                }
                $semesterForWeek = $semesterForWeek ?? $periods[count($periods)-1]['sem'];
            }
    
            $academicStartYear = $startAcademic + intdiv($semesterForWeek - 1, 2);
            $academicYearStr = $academicStartYear . '-' . ($academicStartYear + 1);
    
            // Shu semestrni bazadan topamiz (semester_number bo‘yicha)
            $semester = Semester::where('semester_number', $semesterForWeek)
                ->where('group_id', $group->id) // faqat shu guruh uchun
                ->firstOrFail();
    
            Week::create([
                'group_id'      => $group->id,
                'semester_id'   => $semester->id,   // ✅ endi semester_id saqlanadi
                'week_number'   => $weekNumber,
                'start_date'    => $weekStart->toDateString(),
                'end_date'      => $weekEnd->toDateString(),
                'academic_year' => $academicYearStr,
                'week_type'     => $weekType,
            ]);
    
            $weekNumber++;
            $current->addWeek();
        }
    
        return Week::where('group_id', $group->id)->count();
    }
    

    private function generateSemesters(Group $group, Request $request)
    {
        for ($i = 1; $i <= $request->total_semesters; $i++) {
            $courseYearOffset = floor(($i - 1) / 2);
    
            // Odd semestr: fall, even semestr: spring
            if ($i % 2 != 0) { // odd, fall
                $start_date = \Carbon\Carbon::parse($request->fall_start_date)
                                ->addYears($courseYearOffset);
                $end_date = \Carbon\Carbon::parse($request->fall_end_date)
                                ->addYears($courseYearOffset);
            } else { // even, spring
                $start_date = \Carbon\Carbon::parse($request->spring_start_date)
                                ->addYears($courseYearOffset);
                $end_date = \Carbon\Carbon::parse($request->spring_end_date)
                                ->addYears($courseYearOffset);
            }
    
            // Akademik yilni hisoblash
            $academicStartYear = $group->start_year + $courseYearOffset;
            $academicEndYear   = $academicStartYear + 1;
    
            Semester::create([
                'group_id'       => $group->id,
                'semester_number'=> $i,
                'name'           => $i . '-semestr',
                'academic_year'  => $academicStartYear . '-' . $academicEndYear,
                'start_date'     => $start_date->format('Y-m-d'),
                'end_date'       => $end_date->format('Y-m-d'),
            ]);
        }
    }

    public function weeks(Group $group)
    {
        $weeks = $group->weeks()->orderBy('start_date')->get();
        $weekTypes = ['Nazariy talim', 'Tatil'];
        return view('groups.weeks', compact('group', 'weeks', 'weekTypes'));
    }

    public function semesters(Group $group)
    {
        $semesters = Semester::where('group_id', $group->id)->orderBy('semester_number')->get();

        return view('groups.semesters.index', compact('group', 'semesters'));
    }

    /**
     * Display the specified resource.
     */
    public function showStudents($groupId)
    {
        $group = Group::findOrFail($groupId);

        $users = User::where('group_id', $groupId)->get();
        $payments = Payment::all();

        return view('groups.students.show', compact('group', 'users', 'payments'));
    }

    public function showGroupStudents($groupId)
    {
        $group = Group::findOrFail($groupId);

        $users = User::where('group_id', $groupId)->get();
        $payments = Payment::all();

        return view('groups.students.show', compact('group', 'users', 'payments'));
    }

    public function searchGroupStudents(Request $request, $groupId)
    {
        // dd($request);

        $group = Group::findOrFail($groupId);
        $search = $request->input('search');

        // Agar qidiruv yozilgan bo‘lsa, filtering
        $users = User::where('group_id', $groupId)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->get();

        $payments = Payment::all();

        return view('groups.students.show', compact('group', 'users', 'payments', 'search'));
    }

    public function subjects($groupId)
    {
        $group = Group::with(['groupSubjects.subject'])->findOrFail($groupId);
    
        return view('groups.subjects', compact('group'));
    }

    public function groupSearch(Request $request)
    {
        $search = $request->input('search');
    
        // Agar qidiruv bo‘sh bo‘lsa — orqaga qaytar
        if (empty($search)) {
            return redirect()->route('groups.index');
        }
    
        // Eloquent bilan academicYear munosabatini yuklaymiz
        $groups = Group::with('academicYear')
            ->when($search, function ($query, $search) {
                $query->where('group_name', 'like', "%{$search}%")
                    ->orWhere('full_group_name', 'like', "%{$search}%");
            })
            ->orderBy('group_name')
            ->get();
    
        // Qidiruvdagi so‘zni highlight qilish uchun (optional)
        $highlight = $search;
    
        return view('groups.index', compact('groups', 'highlight'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
