<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use App\Models\Group;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Semester;  
use App\Models\Subject;
use App\Models\GroupSubject;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // public function index() {
        
    //     $today = Carbon::today();
    //     $schedules = Schedule::with('lessonPair') // lessonPair ni olish
    //     ->whereHas('groupSubject', function ($query) {
    //         $query->where('teacher_id', auth()->id());
    //     })
    //     ->get()
    //     ->filter(function ($schedule) use ($today) {
    //         return $schedule->lessonPair && \Carbon\Carbon::parse($schedule->lessonPair->start_time)->isToday();
    //     });

    //     return view('attendance.index', compact('schedules'));
    // }

    public function index()
    {
        $teacherId = auth()->id(); // joriy tizimga kirgan o‘qituvchi
        $today = Carbon::today();
    
        $groupSubjects = GroupSubject::with(['group', 'subject', 'semester'])
            ->where('teacher_id', $teacherId)
            ->whereHas('semester', function ($query) use ($today) {
                $query->where('start_date', '<=', $today)
                      ->where('end_date', '>=', $today);
            })
            ->get();
    
        return view('attendance.index', compact('groupSubjects'));
    }

    public function groupSubject(GroupSubject $groupSubject)
    {
        // Shu groupSubjectga tegishli barcha schedule larni olish
        $schedules = Schedule::with('lessonPair')
            ->where('group_subject_id', $groupSubject->id)
            ->get();
    
        return view('attendance.group-subject', compact('schedules', 'groupSubject'));
    }

    public function teacherAllAttendance()
    {
        $teacherId = auth()->id(); // joriy tizimga kirgan o‘qituvchi
        $today = Carbon::today();
    
        $groupSubjects = GroupSubject::with(['group', 'subject'])
            ->where('teacher_id', $teacherId)
            ->get();
    
        return view('attendance.all-attendance', compact('groupSubjects'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        if (empty($search)) {
            return redirect()->route('attendance.all-attendance');
        }

        $teacherId = auth()->id();

        $groupSubjects = GroupSubject::with(['group', 'subject'])
            ->where('teacher_id', $teacherId)
            ->whereHas('group', function ($query) use ($search) {
                $query->where('group_name', 'like', '%' . $search . '%');
            })
            ->get();

        return view('attendance.all-attendance', compact('search', 'groupSubjects'));
    }

    public function attendanceScheduleSearch(GroupSubject $groupSubject, Request $request)
    {
        $search = $request->input('search');
    
        if (empty($search)) {
            return redirect()->route('attendances.groupSubject', $groupSubject->id);
        }
    
        $teacherId = auth()->id();
    
        $schedules = Schedule::with(['groupSubject.group', 'groupSubject.subject'])
            ->whereHas('groupSubject', function ($query) use ($teacherId, $groupSubject) {
                $query->where('teacher_id', $teacherId)
                      ->where('id', $groupSubject->id);
            })
            ->whereDate('date', $search)
            ->get();
    
        return view('attendance.group-subject', compact('search', 'schedules', 'groupSubject'));
    }
    
    




    // 2. Davomat formasi (talabalar bilan)
    public function showForm(GroupSubject $groupSubject, Schedule $schedule)
    {
        // Faqat o‘qituvchi o‘z darsi davomatini ko‘rsin
        if (auth()->id() !== $schedule->groupSubject->teacher_id) {
            abort(403, 'Bu dars davomatini ko‘rish uchun ruxsatingiz yo‘q');
        }

        // Agar davomat yozuvlari bo‘sh bo‘lsa — avtomatik yaratish
        if ($schedule->attendances->isEmpty()) {
            $students = $schedule->group->students()->get();
            
            foreach ($students as $student) {
                Attendance::create([
                    'schedule_id' => $schedule->id,
                    'student_id' => $student->id,
                    'status' => 0, // 0 — keldi (qoldirmagan)
                ]);
            }

            $schedule->refresh();
        }

        $group = $schedule->group;
        $groupSubject = $schedule->groupSubject;

        // Fan uchun jami soatlar
        $auditHours = $groupSubject->audit_hours ?? 0;

        // Har bir talaba uchun umumiy qoldirgan soatlarini va % ni hisoblash
        $studentStats = [];
        foreach ($group->students as $student) {
            // Shu talabaning shu fan bo‘yicha barcha qoldirgan soatlari
            $missedHours = Attendance::whereHas('schedule', function ($q) use ($groupSubject) {
                                    $q->where('group_subject_id', $groupSubject->id);
                                })
                                ->where('student_id', $student->id)
                                ->sum('status'); // status = qoldirgan soat soni

            $percentage = ($auditHours > 0)
                ? round(($missedHours / $auditHours) * 100, 2)
                : 0;

            $studentStats[$student->id] = $percentage;
        }

        // Davomat yozuvlarini olish
        $attendances = $schedule->attendances()
            ->with(['student:id,name,payment_id'])
            ->get();

        return view('attendance.form', compact('schedule', 'attendances', 'studentStats', 'groupSubject'));
    }
    


    // 3. Saqlash
    public function save(Request $request, Schedule $schedule) {
        foreach ($request->students as $studentId => $status) {
            $schedule->attendances()
                    ->where('student_id', $studentId)
                    ->update(['status' => $status]);
        }
        
        return redirect()->route('attendance.index')->with('success', 'Davomat saqlandi!');
    }

    public function attendanceAll(Request $request)
    {
        $user = auth()->user(); // hozirgi foydalanuvchi
        $group = $user->group;
    
        $semesters = $group->semesters;
        $selectedSemesterId = $request->semester_id ?? $semesters->first()->id ?? null;
        $selectedSemester = Semester::find($selectedSemesterId);
    
        // Faqat shu foydalanuvchining davomatini olish (faqat kelmaganlar va tanlangan semestr bo‘yicha)
        $attendances = Attendance::where('student_id', $user->id)
            ->where('status', 2)
            ->whereHas('schedule', function ($q) use ($group, $selectedSemesterId) {
                $q->where('group_id', $group->id)
                ->where('semester_id', $selectedSemesterId);
            })
            ->with(['schedule.subject', 'schedule.group'])
            ->get()
            ->sortBy(function ($attendance) {
                return $attendance->schedule->lesson_date; // shu yerda jadvaldagi aniq ustunni yozing
            });
    
        return view('attendance.attendance-all', compact(
            'attendances',
            'semesters',
            'group',
            'user',
            'selectedSemesterId',
            'selectedSemester'
        ));
    }
    

    public function attendanceReport(Request $request)
    {
        $user  = auth()->user();
        $group = $user->group;
    
        $semesters = $group->semesters;
    
        $selectedSemesterId = $request->semester_id ?? $semesters->first()->id ?? null;
        $selectedSemester = Semester::find($selectedSemesterId);

        // dd($selectedSemester->id);
    
        // Shu semestrdagi fanlar
        $subjects = Subject::whereHas('schedules', function ($q) use ($group, $selectedSemesterId) {
            $q->where('group_id', $group->id)
              ->where('semester_id', $selectedSemesterId);
        })->get();

        // dd($subjects);
        
    
        $subjectReports = [];
        foreach ($subjects as $subject) {
            // Pivotdan audit soatlarini olish
            $auditHours = $group->subjects()
                ->where('subjects.id', $subject->id)
                ->first()
                ->pivot
                ->audit_hours ?? 0;
    
            // Shu semestrda shu fandan qo‘yilgan darslar soni
            $placedLessons = Schedule::where('group_subject_id', $subject->id)
                ->where('semester_id', $selectedSemesterId)
                ->count();
            

            // Har bir darsni 2 soat deb hisoblash
            $placedLessons = $placedLessons * 2;
    
            // Talabaning shu fandan jami qoldirgan darslari
            $attendance = Attendance::where('student_id', $user->id)
            ->where('status', 2) // faqat qoldirilganlarini sanaymiz
            ->whereHas('schedule', function ($q) use ($selectedSemesterId, $subject) {
                $q->where('semester_id', $selectedSemesterId)
                  ->where('group_subject_id', $subject->id);
            })
            ->count() * 2;
        
    
            // Foizni faqat auditHours bo‘yicha hisoblash
            $foiz = $auditHours > 0 ? round(($attendance / $auditHours) * 100, 2) : 0 * 2;
    
            $subjectReports[] = [
                'subject'       => $subject->{'name_'.app()->getLocale()},
                'audit_hours'   => $auditHours,     // Umumiy auditoriya soati
                'placed_lessons'=> $placedLessons,  // Belgilangan darslar
                'jami'          => $attendance,     // Talabaning qoldirganlari
                'foiz'          => $foiz,           // Foiz
            ];
        }
    
        return view('attendance.attendance-report', compact(
            'user', 'group', 'semesters',
            'selectedSemesterId', 'selectedSemester',
            'subjectReports'
        ));
    }

    public function adminAttendanceIndex()
    {
        // Barcha guruhlarni olish
        $groups = Group::all();
        
        return view('attendance.admin.index', compact('groups'));
    }

    public function adminAttendanGroup(Group $group)
    {
        // Guruhga tegishli group_subject lar
        $groupSubjects = GroupSubject::with('subject', 'teacher')
            ->where('group_id', $group->id)
            ->get();

        return view('attendance.admin.group', compact('group', 'groupSubjects'));
    }

    public function adminGroupSubject(Group $group, GroupSubject $groupSubject)
    {
        // GroupSubject ga tegishli darslar
        $schedules = Schedule::where('group_subject_id', $groupSubject->id)->get();

        return view('attendance.admin.groupSubject', compact('group', 'groupSubject', 'schedules'));
    }

    // 2. Davomat formasi (talabalar bilan)
    public function showAdminAttendanceForm(Schedule $schedule)
    {
        // Agar davomat yozuvlari bo'sh bo'lsa
        if ($schedule->attendances->isEmpty()) {
            $students = $schedule->group->students()->get();
            
            foreach ($students as $student) {
                Attendance::create([
                    'schedule_id' => $schedule->id,
                    'student_id' => $student->id,
                    'status' => 0, // Default: keldi
                ]);
            }
            
            $schedule->refresh();
        }
        
        $attendances = $schedule->attendances()
                        ->with(['student:id,name,payment_id'])
                        ->get();
    
        $group = $schedule->group;
        $groupSubject = $schedule->groupSubject;
    
        // Umumiy darslar soni
        $auditHours = $groupSubject->audit_hours;
    
        // Har bir student uchun % hisoblash
        $studentStats = [];
        foreach ($group->students as $student) {
            $missedCount = Attendance::whereHas('schedule', function ($q) use ($groupSubject) {
                                    $q->where('group_subject_id', $groupSubject->id);
                                })
                                ->where('student_id', $student->id)
                                ->where('status', '>', 0) // faqat qoldirilgan
                                ->count();
        
            // Foizni hisoblash va 2 ga ko‘paytirish
            $percentage = $auditHours > 0 
                            ? round(($missedCount / $auditHours) * 100 * 2, 2)
                            : 0;
        
            $studentStats[$student->id] = $percentage;
        }
        
    
        return view('attendance.admin.form', compact('schedule', 'attendances', 'group', 'groupSubject', 'studentStats'));
    }
    
    
    public function adminAttendanceSave(Request $request, Schedule $schedule) 
    {
        if ($request->has('students')) {
            foreach ($request->students as $studentId => $status) {
                // faqat qiymat kelsa (null yoki bo‘sh bo‘lmasa) saqlanadi
                if (!is_null($status) && $status !== '') {
                    $schedule->attendances()
                            ->where('student_id', $studentId)
                            ->update(['status' => $status]);
                }
            }
        }
    
        $group = $schedule->group;
        $groupSubject = $schedule->groupSubject;
    
        return redirect()->route('attendanceAdmin.groupSubject', [
            'group' => $group->id,
            'groupSubject' => $groupSubject->id,
        ])->with('success', 'Davomat saqlandi!');
    }

    public function attendanceSearch(Request $request)
    {
        // dd($request);

        $search = $request->input('search');
    
        // Agar qidiruv maydoni bo‘sh bo‘lsa — guruh fanlar sahifasiga qaytadi
        if (empty($search)) {
            return redirect()->route('attendanceAdmin.index');
        }

        $groups = Group::where('group_name', 'like', "%{$search}%")
            ->orderBy('group_name')
            ->get();

        return view('attendance.admin.index', compact('groups', 'search'));
    } 

    public function groupAttendanceSearch(Request $request, Group $group)
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

        return view('attendance.admin.group', compact('group', 'groupSubjects', 'search'));

    }
    

    public function adminAttendanceGroupSubject(Request $request, Group $group, GroupSubject $groupSubject)
    {
        $search = $request->input('search');

        $schedules = Schedule::where('group_subject_id', $groupSubject->id)
            ->when($search, function ($query, $search) {
                $query->whereDate('date', 'like', "%{$search}%");
            })
            ->orderBy('date', 'asc')
            ->get();

        return view('attendance.admin.groupSubject', compact('group', 'groupSubject', 'schedules', 'search'));
    }

    

    
    
    
    
    
    
    
    
    

}
