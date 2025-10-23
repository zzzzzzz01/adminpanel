<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Weekday;
use App\Models\Session;
use App\Models\Subject; 
use App\Models\Schedule;
use App\Models\Semester;
use App\Models\Week;
use App\Models\Attendance;
use App\Models\GradeJournal;  
use App\Models\GroupSubject;
use App\Models\Auditorium;
use App\Models\LessonPair;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{

        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::with(['program'])->get();
        $academicYear = $groups->first()->academic_year ?? '2023-2024';
        $groupSemesterPairs = [];
    
        foreach ($groups as $group) {
            $semestersWithSchedules = $group->schedules()
                ->select('semester_id')
                ->distinct()
                ->pluck('semester_id');
    
            foreach ($semestersWithSchedules as $semesterId) {
                $semester = Semester::find($semesterId);
                if ($semester) {
                    $weeks = Week::where('semester_id', $semester->id)
                        ->where('group_id', $group->id)
                        ->where('week_type', 'Nazariy talim')
                        ->orderBy('week_number')
                        ->get();
    
                    if ($weeks->isNotEmpty()) {
                        $weekData = [];
    
                        foreach ($weeks as $week) {
                            $count = Schedule::where('group_id', $group->id)
                                ->where('semester_id', $semester->id)
                                ->where('week_id', $week->id)
                                ->count();
    
                            $weekData[] = [
                                'week' => $week,
                                'schedule_count' => $count,
                            ];
                        }
    
                        $groupSemesterPairs[] = [
                            'group' => $group,
                            'semester' => $semester,
                            'weeks' => $weekData,
                        ];
                    }
                }
            }
        }
    
        return view('schedule.index', compact('groupSemesterPairs', 'academicYear', 'groups'))
            ->with([
                'selectedGroup' => null,
                'selectedSemester' => null,
            ]);
    }
    
    public function filter(Request $request)
    {
        $groupId = $request->input('group_id');
        $semesterId = $request->input('semester_id');
    
        if (!$groupId || !$semesterId) {
            return redirect()->route('schedule.index')->with('error', 'Iltimos, guruh va semestrni tanlang.');
        }
    
        $group = Group::findOrFail($groupId);
        $semester = Semester::findOrFail($semesterId);
    
        // Faqat dars jadvali (schedule) mavjud bo‘lgan haftalarni olish
        $weeks = Week::where('group_id', $group->id)
            ->where('semester_id', $semester->id)
            ->where('week_type', 'Nazariy talim')
            ->orderBy('week_number')
            ->get();
    
        $weekData = [];
        foreach ($weeks as $week) {
            $count = Schedule::where('group_id', $group->id)
                ->where('semester_id', $semester->id)
                ->where('week_id', $week->id)
                ->count();
    
            //  Agar shu hafta uchun kamida bitta dars mavjud bo‘lsa — qo‘shamiz
            if ($count > 0) {
                $weekData[] = [
                    'week' => $week,
                    'schedule_count' => $count,
                ];
            }
        }
    
        // Faqat dars mavjud bo‘lsa — semestrni ko‘rsatamiz
        $groupSemesterPairs = [];
        if (!empty($weekData)) {
            $groupSemesterPairs[] = [
                'group' => $group,
                'semester' => $semester,
                'weeks' => $weekData,
            ];
        }
    
        $groups = Group::all();
        $academicYear = $group->academic_year ?? '2023-2024';
    
        $groupName = $group->group_name ?? '-';
        $semesterName = $semester->name ?? '-';
    
        return view('schedule.index', compact(
            'groupSemesterPairs',
            'academicYear',
            'groups',
            'groupName',
            'semesterName'
        ))->with([
            'selectedGroup' => $groupId,
            'selectedSemester' => $semesterId,
        ]);
    }    
    
    
    public function getSemesters(Group $group)
    {
        $semesters = $group->semesters()->select('id', 'name')->get();
        return response()->json($semesters);
    }
    

    
    
    public function edit(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $subjects = Subject::all();
        $teachers = User::whereHas('roles', function ($query) {
            $query->where('roles.id', 3); 
            })->get();
        $sessions = Session::all();

        $programId    = $request->query('program_id')    ?? optional($schedule->group)->program_id;
        $groupId      = $request->query('group_id')      ?? $schedule->group_id;
        $academicYear = $request->query('academic_year') ?? ($schedule->academic_year ?? null);
        $semesterId   = $request->query('semester_id')   ?? $schedule->semester_id;

        return view('schedule.edit', compact('schedule', 'subjects', 'teachers', 'sessions', 'programId','groupId','academicYear','semesterId'));
    }


    public function scheduleCreate(Request $request)
    {
        $auditoriums = Auditorium::all();
        $lessonPairs = LessonPair::all();

        // dd($request->all()); 

        if (!$request->group_id || !$request->semester_id) {
            return back()->with('error', 'Group yoki Semester tanlanmagan!');
        }
    
        $date = $request->date 
            ? Carbon::parse($request->date) 
            : Carbon::parse(Semester::findOrFail($request->semester_id)->start_date);

        $group_id = $request->group_id;
        
        $groups = Group::all();
        $teachers = User::whereHas('roles', function ($query) {
            $query->where('roles.id', 3);
        })->get();
    
        $group = Group::with('semesters')->findOrFail($group_id);
        $semester = Semester::findOrFail($request->semester_id);
    
        // $semesterId foydalanuvchi tanlagan semestr
        $semesterId = $request->semester_id; 

        // Guruhga biriktirilgan fanlar, faqat tanlangan semestrga tegishlilari
        $groupSubjects = GroupSubject::with(['subject', 'teacher'])
            ->where('group_id', $group->id)
            ->where('semester_id', $semesterId)
            ->get();    

        $sessions = Session::all();
    
        $week = Week::where('group_id', $group->id)
            ->where('semester_id', $semester->id)
            ->where('week_type', 'Nazariy talim')
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->first();
    
        return view('schedule.create', compact(
            'date', 'group_id', 'groups', 'group', 'teachers',
            'semester','groupSubjects', 'sessions', 'week', 'auditoriums', 'lessonPairs'
        ));
    }
    


    public function scheduleStore(Request $request)
    {

        // dd($request);

        $request->validate([
            'date'        => 'required|date',
            'semester_id' => 'required|exists:semesters,id',
            'session_id'  => 'required|exists:sessions,id',
            'lesson_pair_id'    => 'required|exists:lesson_pairs,id',
            'auditorium_id'    => 'required|exists:auditoriums,id',
            'group_subject_id' => 'required|exists:group_subjects,id',
        ]);

        // dd($request);

        $date = Carbon::parse($request->date);
    
        //  Kiritilgan sanani mos haftaga tekshiramiz
        $weekId = Week::where('semester_id', $request->semester_id)
            ->where('group_id', $request->group_id)
            ->where('start_date', '<=', $request->date)
            ->where('end_date', '>=', $request->date)
            ->value('id');

            // dd($weekId);
    
        if (!$weekId) {
            return back()->withErrors(['date' => 'Tanlangan sana hech qaysi haftaga mos kelmadi!']);
        }
    
        // Dars jadvalini yaratamiz
        $schedule = Schedule::create([
            'date'        => $request->date,
            'group_id'    => $request->group_id,
            'semester_id' => $request->semester_id,
            'session_id'  => $request->session_id,
            'lesson_pair_id'    => $request->lesson_pair_id,
            'auditorium_id'    => $request->auditorium_id,
            'week_id'     => $weekId, 
            'group_subject_id' => $request->group_subject_id,
        ]);

        $students = User::where('group_id', $request->group_id)->get();

        foreach ($students as $student) {
            GradeJournal::create([
                'schedule_id' => $schedule->id,
                'student_id'  => $student->id,
                'grade'       => null,
            ]);
        }
    
        return redirect()->route('calendar.show', [
            'group_id'     => $request->group_id,
            'semester_id'  => $request->semester_id,
            'academic_year'=> $request->academic_year ?? now()->year,
            'program_id'   => $request->program_id ?? 1,
            'month'        => \Carbon\Carbon::parse($request->date)->format('Y-m')
        ])->with('success', 'Dars muvaffaqiyatli yaratildi!');
    }
    
    


    public function update(Request $request, $id)
    {
        // dd('Update method ishladi', $request->all());

        $schedule = Schedule::findOrFail($id);
    
        $request->validate([
            'start_time' => 'sometimes|',
            'end_time' => 'sometimes|after:start_time',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:users,id',
            'session_id' => 'required|exists:sessions,id',
            'room' => 'nullable|string|max:50',
        ]);
    
        // Faqat o'zgartirilgan ustunlarni olish
        $changedData = [];
        foreach (['start_time', 'end_time', 'subject_id', 'teacher_id', 'session_id', 'room'] as $field) {
            if ($request->has($field) && $request->$field != $schedule->$field) {
                $changedData[$field] = $request->$field;
            }
        }
    
        if (!empty($changedData)) {
            $schedule->update($changedData);
        }
    
        return redirect()->route('calendar.show', [
            'program_id' => $request->program_id,
            'group_id' => $request->group_id,
            'academic_year' => $request->academic_year,
            'semester_id' => $request->semester_id
        ])->with('success', 'Dars jadvali yangilandi');
    }

    // generate-week sahifasini chiqarish
    public function generateWeekPage(Request $request)
    {
        
        $groupId = $request->group_id;
        $semesterId = $request->semester_id;
        
        // dd($groupId, $semesterId);

        $weeks = Week::where('group_id', $groupId)
            ->where('semester_id', $semesterId)
            ->orderBy('week_number')
            ->get();
    
        return view('schedule.generate-week', compact('weeks', 'groupId', 'semesterId'));
    }
       

    // Jadvalni ko‘paytirish jarayoni
    public function generateWeekProcess(Request $request)
    {
        $request->validate([
            'source_week' => 'required|exists:weeks,id',
            'target_week' => 'required|exists:weeks,id',
            'group_id'    => 'required|exists:groups,id',
            'semester_id' => 'required|integer'
        ]);

        // dd($request);
    
        // Manba va maqsad haftalarni topamiz
        $sourceWeek = Week::findOrFail($request->source_week);
        $targetWeek = Week::findOrFail($request->target_week);
    
        // Semester topiladi
        $semester = Semester::findOrFail($request->semester_id);

        // dd($semester->id);

        // dd(
        //     Schedule::where('week_id', $sourceWeek->id)->get(),
        //     Schedule::where('group_id', $request->group_id)->get()
        // );
    
        // Source haftadagi barcha darslar
        $sourceSchedules = Schedule::where('week_id', $sourceWeek->id) // <-- shu joyda $sourceWeek->id bo‘lishi kerak
            ->where('group_id', $request->group_id)
            ->get();


        // dd($sourceSchedules->all());
    
        // Oraliqdagi barcha haftalar (source_week dan target_week gacha)
        $weeksInRange = Week::where('semester_id', $semester->id)
            ->whereBetween('week_number', [
                min($sourceWeek->week_number, $targetWeek->week_number),
                max($sourceWeek->week_number, $targetWeek->week_number)
            ])
            ->orderBy('week_number')
            ->get();

        // dd($weeksInRange->pluck('id', 'week_number'));
    
        foreach ($weeksInRange as $week) {
            // Har safar source_week dagi jadvaldan nusxa olamiz
            foreach ($sourceSchedules as $schedule) {
                Schedule::create(
                    [
                        'group_id'    => $schedule->group_id,
                        'semester_id' => $semester->id,
                        'week_id'     => $week->id,
                        'subject_id'  => $schedule->subject_id,
                        'teacher_id'  => $schedule->teacher_id,
                        'start_time'  => $schedule->start_time,
                        'session_id'  => $schedule->session_id,
                    ],
                    [
                        'room'        => $schedule->room,
                        'end_time'    => $schedule->end_time,
                        'date'        => $week->start_date,
                    ]
                );
            }
        }
    
        return redirect()->route('calendar.show', [
            'group_id'    => $request->group_id,
            'semester_id' => $semester->id
        ])->with('success', 'Jadval muvaffaqiyatli ko‘paytirildi!');
    }


    public function studentSchedule(Request $request, Group $group)
    {
        $semesters = $group->semesters;
    
        $selectedSemesterId = $request->semester_id ?? $semesters->first()->id ?? null;
        $selectedSemester = Semester::find($selectedSemesterId);
    
        // Tanlangan semesterga tegishli haftalar
        $weeks = collect();
        if ($selectedSemester) {
            $weeks = Week::where('group_id', $group->id)
                ->where('semester_id', $selectedSemester->id)
                ->where('week_type', 'Nazariy talim')
                ->orderBy('week_number')
                ->get();
        }
    
        // Tanlangan hafta — hozirgi sana oralig‘idagi hafta avtomatik tanlansin
        $selectedWeekId = $request->week_id;

        if (!$selectedWeekId && $weeks->isNotEmpty()) {
            $today = \Carbon\Carbon::today();
            $currentWeek = $weeks->first(function ($week) use ($today) {
                $start = \Carbon\Carbon::parse($week->start_date);
                $end = \Carbon\Carbon::parse($week->end_date);
                return $today->between($start, $end);
            });

            // Agar hozirgi hafta topilmasa, oxirgi "Nazariy talim" haftasini tanla
            if ($currentWeek) {
                $selectedWeekId = $currentWeek->id;
            } else {
                $selectedWeekId = $weeks->where('week_type', 'Nazariy talim')->last()->id ?? $weeks->first()->id;
            }
        }
    
        // Tanlangan hafta va semestrga mos darslar
        $schedules = Schedule::where('group_id', $group->id)
            ->where('semester_id', $selectedSemesterId)
            ->where('week_id', $selectedWeekId)
            ->with(['subject', 'teacher', 'session'])
            ->orderBy('date')
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
            });
    
        return view('students.schedule.index', compact(
            'group',
            'semesters',
            'selectedSemesterId',
            'weeks',
            'selectedWeekId',
            'schedules'
        ));
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(Group $group, Request $request)
    {
        $groups = Group::all();
        $weekdays = Weekday::all();
        $sessions = Session::all();
        $user = auth()->user();
        $isAdmin = $user->roles->contains('id', 1);
    
        // Tanlangan semestrni aniqlaymiz
        $semesterId = $request->input('semester_id', $group->current_semester);
    
        // Faqat shu semestrdagi haftalarni olamiz
        $weeks = Week::where('group_id', $group->id)
             ->where('semester_number', $semesterId)
             ->where('week_type', 'Nazariy talim')
             ->get();
    
        // Hozirgi sana bo‘yicha hafta topiladi (yoki oxirgi hafta tanlanadi)
        $currentDate = now()->format('Y-m-d');
        $defaultWeek = $weeks->firstWhere(fn($w) => $w->start_date <= $currentDate && $w->end_date >= $currentDate);
    
        // So‘rovdan yoki oxirgi haftadan hafta aniqlanadi
        $week_id = $request->input('week_id') ?? $defaultWeek?->id ?? $weeks->last()?->id;
    
        // Dars jadvalini har bir kun uchun olib kelamiz
        $schedules = [];
        foreach ($weekdays as $weekday) {
            $schedules[$weekday->id] = Schedule::where('weekday_id', $weekday->id)
                ->where('group_id', $group->id)
                ->where('week_id', $week_id)
                ->with(['subject', 'teacher', 'session', 'weekday', 'week'])
                ->orderBy('start_time')
                ->get();
        }
    
        return view('schedule.show', compact(
            'groups',
            'group',
            'weekdays',
            'schedules',
            'sessions',
            'weeks',
            'week_id',
            'semesterId'
        ));
    }
    
    
    
    
    public function bySemesterAndWeek(Group $group, $semesterId, $weekId = null)
    {
        // Agar weekId yo‘q bo‘lsa — o‘sha semestrdagi eng so‘nggi hafta tanlanadi
        if (!$weekId) {
            $week = Week::where('semester_id', $semesterId)->orderByDesc('week_number')->first();
            if (!$week) {
                return back()->with('error', 'Ushbu semestr uchun hafta mavjud emas.');
            }
            return redirect()->route('schedule.bySemesterWeek', [
                'group' => $group->id,
                'semester' => $semesterId,
                'week' => $week->id,
            ]);
        }
    
        $weeks = Week::where('semester_id', $semesterId)->orderBy('week_number')->get();
        $currentWeek = Week::findOrFail($weekId);
    
        $schedules = Schedule::where('group_id', $group->id)
                             ->where('semester_id', $semesterId)
                             ->where('week_id', $weekId)
                             ->with(['subject', 'teacher', 'weekday'])
                             ->get();
    
        return view('schedule.show', compact(
            'group', 'semesterId', 'weeks', 'currentWeek', 'schedules'
        ));
    }

    public function weekStore(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
    
        // Guruh va semesterni yuklab olamiz
        $group = Group::with('semester')->findOrFail($request->group_id);
    
        if (!$group->semester) {
            return back()->withErrors(['group_id' => 'Bu guruhga biriktirilgan semestr yo\'q!']);
        }
    
        $week = Week::create([
            'group_id' => $group->id,
            'semester_id' => $group->semester->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'week_number' => Week::where('group_id', $group->id)
                                ->where('semester_id', $group->semester->id)
                                ->count() + 1,
        ]);
    
        return redirect()->route('schedule.show', [
            'group' => $group->id,
            'week_id' => $week->id
        ])->with('success', 'Yangi hafta muvaffaqiyatli qo\'shildi!');
    }

    public function weekCreate(Group $group)
    {
        $semesters = Semester::all();
        $semester = $group->semester;
        
        $group->load('semester');
    
        $weeks = Week::where('group_id', $group->id)
                    ->orderBy('week_number')
                    ->get();

        return view('schedule.week-create', compact('group', 'semester', 'weeks'));
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
