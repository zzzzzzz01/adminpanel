<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Program;
use App\Models\Group;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Semester;
use App\Models\Week; 
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\Result; 
use App\Models\MidtermGrade;  
use App\Models\MidtermManualGrade; 
use App\Models\Assignment;
use App\Models\GroupSubject;
use App\Models\AcademicYear;
use App\Models\LessonPair;
use App\Models\Auditorium;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;  

class PageController extends Controller
{
    public function homePage()
    {
        $users = User::all();
        $posts = Post::all();
        $groups = Group::all();
        $subjects = Subject::all();
        $exams = Exam::all();
        $academicYears = AcademicYear::all();
        $lastAcademicYear = $academicYears->last();
        $lessonPairs = LessonPair::all();
        $auditoriums = Auditorium::all();
        $facultys = Faculty::all();
        $programs = Program::all();


        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $teacherCount = User::whereHas('roles', function($query) {
            $query->where('name', 'teacher');
        })->count();

        $adminCount = User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->count();

        $groupId = auth()->user()->group_id;

        // Examlar sonini hisoblash
        $examCount = Exam::whereHas('groups', function($query) use ($groupId) {
            $query->where('group_id', $groupId);
        })->count();
         
        return view('index', compact('groups', 'users', 'subjects', 'exams', 'teacherCount',
         'examCount', 'adminCount', 'posts', 'lastAcademicYear', 'lessonPairs', 'auditoriums', 'facultys', 'programs'));
    }

    public function allAdmins(){

        $users = User::whereHas('roles', function ($query) {
            $query->where('roles.id', 1); 
        })->get();

        return view('admins.index', compact('users'));
    }

    public function teachersIndex(){

        $users = User::whereHas('roles', function ($query) {
            $query->where('roles.id', 3); 
        })->get();

        return view('teachers.index', compact('users'));
    }

    public function teachersShow(User $user)
    {
        return view('teachers.show')->with(['user' => $user]);
    }

    public function timeTable(){
        return view('time-table.index');
    }

    public function personalData()
    {
        $user = auth()->user(); // 
    
        return view('personal-data', compact('user'));
    }

    public function adminEdit(User $user)
    {
        return view('admins.edit')->with(['user' => $user]);
    }

    public function studentEdit(User $user)
    {
        $payments = Payment::all();
        $group = $user->group;

        return view('students.edit', compact('payments','group'))->with(['user' => $user]);
    }

    public function studentShow(User $user)
    {
        $groups = Group::all();

        return view('students.show')->with(['user' => $user, 'group' => $groups,]);
    }



    public function chatsIndex()
    {
        return view('chats.index');
    }

    
    public function studentExam($groupId)
    {
        $user = auth()->user();
    
        // Foydalanuvchining admin yoki yo'qligini tekshiramiz
        $isAdmin = $user->roles->contains('id', 1);
    
        // Agar foydalanuvchi admin bo'lmasa va group_id yo'q bo'lsa => 404
        if (!$isAdmin && !$user->group_id) {
            abort(404, 'Siz hech qanday guruhga biriktirilmagansiz');
        }
    
        // Admin bo‘lsa - kiritilgan groupId, oddiy foydalanuvchi bo‘lsa - o‘zining group_id si
        $effectiveGroupId = $isAdmin ? $groupId : $user->group_id;
    
        $group = Group::findOrFail($effectiveGroupId);
    
        $exams = Exam::whereHas('groups', function ($query) use ($effectiveGroupId) {
            $query->where('groups.id', $effectiveGroupId);
        })
        ->with(['subject', 'user', 'groups'])
        ->orderBy('date')
        ->get();
    
        return view('exam-student', compact('exams', 'group'));
    }

    public function teacherExams()
    {
        $user = auth()->user();
        $exams = Exam::where('user_id', $user->id)
            ->with(['subject', 'groups']) 
            ->orderBy('date')
            ->get();
    
        return view('teachers.exam', compact('exams'));
    }

    public function categoryPosts($slug){
        $category = Category::where('slug', $slug)->first();
        $posts = $category->posts()->paginate(10);
        $categories = Category::all();
        return view('category-posts', compact('category', 'posts', 'categories'));
    }

    public function tagPosts($slug){
        $tag = Tag::where('slug', $slug)->first();
        $posts = $tag->posts()->paginate(10);
        $tags = Tag::all();
        return view('tag-posts', compact('tag', 'posts', 'tags'));
    }

    public function upload(Request $request): JsonResponse
    {

        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('media'), $fileName);

            $url = asset('media/' . $fileName);

            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);

        }

    }

    public function filterGroup(Request $request)
    {

        // dd($request->all());
        $programs = Program::orderBy('name')->get();

        // dd($programs);
        $selectedProgram = $request->program_id ?? null;
        // dd($selectedProgram);

        $selectedGroup = $request->group_id ?? null;
        $selectedSemester = $request->semester_id ?? null;
    
        return view('filter', compact('programs', 'selectedProgram', 'selectedGroup', 'selectedSemester'));
    }
    
    public function getGroupsByProgram($programId)
    {
        $groups = Group::where('program_id', $programId)->orderBy('group_name')->get();
        return response()->json($groups);
    }
    
    // Guruh bo‘yicha semestrlar
    public function getSemestersByGroup($groupId)
    {
        $semesters = Semester::where('group_id', $groupId)
            ->orderBy('start_date')
            ->get();

        return response()->json($semesters);
    }


    public function showCalendar(Request $request)
    {

        // dd($request->all());    

        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'program_id' => 'required|exists:programs,id',
            'semester_id' => 'required|exists:semesters,id'
        ]);

        // dd($request->all());
    
        $group = Group::with('program')->findOrFail($request->group_id);
        $semester = Semester::findOrFail($request->semester_id);
    
        // Faqat tanlangan semestrning start va end date
        $startDate = \Carbon\Carbon::parse($semester->start_date);
        $endDate = \Carbon\Carbon::parse($semester->end_date);
    
        $currentMonth = $request->month
            ? \Carbon\Carbon::createFromFormat('Y-m', $request->month)
            : $startDate->copy();
    
        $monthStart = $currentMonth->copy()->startOfMonth();
        $monthEnd = $currentMonth->copy()->endOfMonth();
    
        // Oy chegarasini semestrga moslash
        if ($monthStart->lt($startDate)) $monthStart = $startDate->copy();
        if ($monthEnd->gt($endDate)) $monthEnd = $endDate->copy();
    
        // Hafta boshini dushanbaga, oxirini shanbaga moslash
        if ($monthStart->dayOfWeek != 1) $monthStart->subDays($monthStart->dayOfWeek - 1);
        if ($monthEnd->dayOfWeek != 6) $monthEnd->addDays(6 - $monthEnd->dayOfWeek);
    
        $currentDate = $monthStart->copy();
        $calendar = [];
    
        // Faqat tanlangan semestrga tegishli haftalarni olish
        $weeks = Week::where('semester_id', $semester->id)
            ->where('group_id', $group->id)
            ->where('week_type', 'Nazariy talim')
            ->orderBy('week_number')
            ->get();

        // dd($weeks);
    
        // Faqat tanlangan semestr va haftalarga tegishli darslar
        $schedules = Schedule::where('group_id', $group->id)
            ->where('semester_id', $semester->id)
            ->whereIn('week_id', $weeks->pluck('id'))
            ->with(['subject', 'teacher', 'session', 'lessonPair', 'auditorium'])
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->date)->format('Y-m-d');
            });

        // dd($schedules);
    
        while ($currentDate <= $monthEnd) {
            $weekRow = [];
    
            for ($i = 1; $i <= 6; $i++) { // dushanba–shanba
                if ($currentDate->between($startDate, $endDate) && $currentDate->month == $currentMonth->month) {
                    $dateKey = $currentDate->format('Y-m-d');
    
                    // Faqat Nazariy talim haftasidagi sanalar
                    $inWeek = $weeks->first(function ($week) use ($currentDate) {
                        return $currentDate->between($week->start_date, $week->end_date);
                    });
    
                    if ($inWeek) {
                        $weekRow[] = [
                            'date' => $currentDate->copy(),
                            'in_range' => true,
                            'schedules' => $schedules->has($dateKey) ? $schedules[$dateKey] : collect(),
                        ];
                    } else {
                        $weekRow[] = null;
                    }
                } else {
                    $weekRow[] = null;
                }
    
                $currentDate->addDay();
                if ($currentDate->isSunday()) $currentDate->addDay();
                if ($currentDate > $monthEnd) break;
            }
    
            $calendar[] = $weekRow;
        }
    
        $prevMonth = $currentMonth->copy()->subMonth();
        $nextMonth = $currentMonth->copy()->addMonth();
    
        if ($prevMonth->endOfMonth()->lt($startDate)) $prevMonth = null;
        else $prevMonth = $prevMonth->format('Y-m');
    
        if ($nextMonth->startOfMonth()->gt($endDate)) $nextMonth = null;
        else $nextMonth = $nextMonth->format('Y-m');
    
        return view('calendar', compact(
            'group',
            'semester',
            'calendar',
            'currentMonth',
            'prevMonth',
            'nextMonth',
            'schedules'
        ));
    }

    public function performance(Request $request)
    {
        $user = auth()->user();  
    
        $semesterId = $request->get('semester_id');
        $group = $user->group;
    
        $semesters = $group->semesters;
    
        if (!$semesterId) {
            $semesterId = $semesters->first()->id ?? null;
        }
    
        $groupSubjects = GroupSubject::where('group_id', $user->group_id)
            ->where('semester_id', $semesterId)
            ->with('subject')
            ->get();
    
        $grades = Grade::where('student_id', $user->id)
            ->where('type', 'current')
            ->whereHas('schedule', function ($q) use ($semesterId) {
                $q->where('semester_id', $semesterId);
            })
            ->with('schedule')
            ->get();
    
        $results = Result::where('student_id', $user->id)
            ->with('test')
            ->get();
    
        // Fan va umumiy ball hisoblash
        $subjectsWithScores = $groupSubjects->map(function ($groupSubject) use ($grades, $results, $user) {
            $score = $grades
                ->filter(fn($g) => $g->schedule->group_subject_id == $groupSubject->id)
                ->sum('score');
    
            // MidtermGrade dan oraliq bahoni olish
            $midtermGrade = MidtermGrade::where('student_id', $user->id)
                ->where('group_subject_id', $groupSubject->id)
                ->value('grade');
    
            if (is_null($midtermGrade)) {
                $midtermGrade = MidtermManualGrade::where('student_id', $user->id)
                    ->where('group_subject_id', $groupSubject->id)
                    ->value('grade');
            }
    
            // Yakuniy bahoni olish
            $finalGrade = $results
                ->firstWhere(fn($r) => $r->test->group_subject_id == $groupSubject->id)?->score ?? 0;
    
            //  Umumiy ball = joriy + oraliq + yakuniy
            $total = $score + ($midtermGrade ?? 0) + $finalGrade;
    
            return [
                'subject_name'     => $groupSubject->subject->name_uz,
                'score'            => $score,
                'midterm_grade'    => $midtermGrade ?? 0,
                'final_grade'      => $finalGrade,
                'total'            => $total,
                'group_subject_id' => $groupSubject->id,
            ];
        });
    
        return view('students.performance', [
            'user'               => $user,
            'semesters'          => $semesters,
            'semesterId'         => $semesterId,
            'subjectsWithScores' => $subjectsWithScores,
        ]);
    }
    
    

    public function resources(Request $request)
    {
        $user = auth()->user();
        $semesterId = $request->get('semester_id');
        $group = $user->group;
        $semesters = $group->semesters;
    
        if (!$semesterId) {
            $semesterId = $semesters->first()->id ?? null;
        }
    
        $groupSubjects = GroupSubject::where('group_id', $user->group_id)
            ->where('semester_id', $semesterId)
            ->with(['subject', 'teacher'])
            ->get()
            ->map(function ($gs) use ($user) {
    
                // Umumiy faol topshiriqlar (status = 1)
                $assignmentsQuery = Assignment::where('status', 1)
                    ->whereHas('midtermInterval', function($q) use ($gs) {
                        $q->where('group_subject_id', $gs->id);
                    });
    
                $assignments_total = $assignmentsQuery->count();
    
                // Talabaning yuklagan topshiriqlari
                $assignments_completed = Assignment::where('status', 1)
                    ->whereHas('midtermInterval', function($q) use ($gs) {
                        $q->where('group_subject_id', $gs->id);
                    })
                    ->whereHas('submissions', function($q) use ($user) {
                        $q->where('student_id', $user->id);
                    })
                    ->count();
    
                $gs->assignments_total = $assignments_total;
                $gs->assignments_count = $assignments_completed;
    
                return $gs;
            });
    
        return view('students.resources', compact('user', 'semesters', 'semesterId', 'groupSubjects'));
    }
    

    public function showTeacherCalendar(Request $request)
    {
        $teacher = auth()->user();

        if (!$teacher) {
            abort(403, 'Siz ushbu sahifani ko\'rish huquqiga ega emassiz.');
        }

        // Joriy oyni o'rnatish. Agar so'rovda oy ko'rsatilmagan bo'lsa, joriy oyni oladi.
        $currentMonth = $request->month
            ? Carbon::createFromFormat('Y-m', $request->month)
            : Carbon::now();

        $monthStart = $currentMonth->copy()->startOfMonth();
        $monthEnd = $currentMonth->copy()->endOfMonth();

        // Hafta boshini dushanbaga, oxirini shanbaga moslash
        if ($monthStart->dayOfWeek != 1) {
            $monthStart->subDays($monthStart->dayOfWeek - 1);
        }
        if ($monthEnd->dayOfWeek != 6) {
            $monthEnd->addDays(6 - $monthEnd->dayOfWeek);
        }

        $currentDate = $monthStart->copy();
        $calendar = [];

        // Faqat autentifikatsiyadan o'tgan o'qituvchiga tegishli darslarni olish
        $schedules = Schedule::whereHas('groupSubject', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })
            ->with(['group', 'subject', 'session', 'lessonPair', 'auditorium'])
            ->whereDate('date', '>=', $monthStart->format('Y-m-d'))
            ->whereDate('date', '<=', $monthEnd->format('Y-m-d'))
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            });

        while ($currentDate <= $monthEnd) {
            $weekRow = [];

            for ($i = 1; $i <= 6; $i++) { // dushanba–shanba
                $dateKey = $currentDate->format('Y-m-d');
                
                // Kalendar faqat joriy oyning kunlarini ko'rsatadi
                if ($currentDate->month == $currentMonth->month) {
                    $weekRow[] = [
                        'date' => $currentDate->copy(),
                        'schedules' => $schedules->has($dateKey) ? $schedules[$dateKey] : collect(),
                    ];
                } else {
                    $weekRow[] = null;
                }

                $currentDate->addDay();
                if ($currentDate->isSunday()) {
                    $currentDate->addDay();
                }
                if ($currentDate > $monthEnd) {
                    break;
                }
            }
            
            $calendar[] = $weekRow;
        }

        $prevMonth = $currentMonth->copy()->subMonth();
        $nextMonth = $currentMonth->copy()->addMonth();

        return view('teachers.calendar', compact(
            'teacher',
            'calendar',
            'currentMonth',
            'prevMonth',
            'nextMonth',
            'schedules'
        ));
    }

    public function adminSearch(Request $request)
    {
        $search = $request->input('search');

        if (empty($search)) {
            return redirect()->route('all.admins');
        }
    
        $users = User::whereHas('roles', function ($query) {
                $query->where('roles.id', 1); 
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('middle_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->get();
    
        return view('admins.index', compact('users', 'search'));
    }
    
    
    
}
