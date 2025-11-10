<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TimeTableController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NotificationController; 
use App\Http\Controllers\WeekController; 
use App\Http\Controllers\GroupSubjectController; 
use App\Http\Controllers\JournalController;  
use App\Http\Controllers\AuditoriumController; 
use App\Http\Controllers\AcademicYearController; 
use App\Http\Controllers\FacultyController; 
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\LessonPairController; 
use App\Http\Controllers\AttendanceController; 
use App\Http\Controllers\GradeJournalController;   
use App\Http\Controllers\MidtermIntervalController;
use App\Http\Controllers\MidtermGradeController;
use App\Http\Controllers\AssignmentController;  
use App\Http\Controllers\AssignmentSubmissionController; 
use App\Http\Controllers\FinalTestController; 
use App\Http\Controllers\ExamSessionController;
use App\Http\Controllers\ResultController;  
use App\Http\Controllers\TopicController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


    Route::get('/', [PageController::class, 'homePage'])->name('home.page');

        // login
    Route::get('login',[AuthController::class, 'login'])->name('login');
    Route::post('authanticate',[AuthController::class, 'authanticate'])->name('authanticate');

        //logout
    Route::post('logout',[AuthController::class, 'logout'])->name('logout');




    // Talabaning dars jadvali
    Route::middleware(['auth'])->group(function () {


        // Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
        // Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

            // Teacher
        Route::get('teachers', [PageController::class, 'teachersIndex'])->name('teachers.index');
        Route::get('/search-teacher',[UserController::class,'teacherSearch'])->name('teacher.search'); 
        Route::get('teachers/{user}/show', [PageController::class, 'teachersShow'])->name('teachers.show');

            // Profil
        Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
        Route::get('/profil/change-password', [ProfilController::class, 'changePasswordForm'])->name('profil.changePasswordForm');
        Route::post('/profil/change-password', [ProfilController::class, 'changePassword'])->name('profil.changePassword');

            //Language
        Route::get('/lang/{lang}', [LanguageController::class, 'language'])->name('language');

            //  Notification
        Route::get('/notifications/{notification}/read',[NotificationController::class, 'read'])->name('notification.read');
        Route::get('/notifications/{notification}/read-and-redirect-to-post', [NotificationController::class, 'readAndRedirectToPost'])->name('notifications.read-and-redirect-to-post');
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    });


    Route::middleware(['auth', 'teacher'])->group(function () {

        Route::get('/teacher/exams', [PageController::class, 'teacherExams'])->name('teacher.exams');
        Route::get('/teacher/schedule', [ScheduleController::class, 'teacherSchedule'])->name('teacher.schedule');

        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index'); // Guruhlar ro'yxati
        Route::get('/attendance/all-attendance', [AttendanceController::class, 'teacherAllAttendance'])->name('attendance.all-attendance'); // Guruhlar ro'yxati
        Route::get('/attendances/{groupSubject}/group-subject/{schedule}', [AttendanceController::class, 'showForm'])->name('attendance.form'); // Forma
        Route::get('/attendance/all-attendance/search',[AttendanceController::class,'search'])->name('attendance.all-attendance.search'); 
        Route::get('/attendance/{groupSubject}/group-subject/search',[AttendanceController::class,'attendanceScheduleSearch'])->name('attendance.schedule.search'); 

        
        Route::post('/attendance/{schedule}/save', [AttendanceController::class, 'save'])->name('attendance.save'); // Saqlash

        Route::get('/schedules/{schedule}/attendances', [AttendanceController::class, 'showForm'])->name('attendances.show');
            
        Route::put('/schedules/{schedule}/attendances', [AttendanceController::class, 'update'])->name('attendances.update');

        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::get('/attendances/{groupSubject}/group-subject', [AttendanceController::class, 'groupSubject'])->name('attendances.groupSubject');

        // O‘qituvchi uchun guruhlar ro‘yxati (o‘sha o‘qituvchiga biriktirilgan fanlar bo‘yicha)
        Route::get('/teacher/grades', [GradeJournalController::class, 'index'])->name('teacher.grades');

        Route::get('/groups/{group}/schedule/{date}/grade', [GradeJournalController::class, 'create'])->name('grades.create');

        Route::get('/group-subject/{group}/subject/{subject}/grades', [GradeJournalController::class, 'show'])
        ->name('groupSubject.grades');

        // Faqat bitta dars uchun baho qo‘yish sahifasi
        Route::get('/schedule/{schedule}/grades', [GradeJournalController::class, 'showGrades'])
        ->name('schedule.grades');

            // Baho saqlash
        Route::post('/schedule/{schedule}/grades', [GradeJournalController::class, 'storeGrades'])
        ->name('grades.store');

        // Route::get('/teacher/grades', [GradeJournalController::class, 'teacherGrades'])->name('teacher.grades');

        Route::get('/teacher/grades', [GradeJournalController::class, 'index'])
        ->name('teacher.grades');

        Route::get('/teacher/grades/{group}', [GradeJournalController::class, 'groupGrades'])->name('teacher.group.grades');

        Route::get('/all-journals', [GradeJournalController::class, 'alljournals'])->name('all.journals');
        Route::get('/teacher/journals/search',[GradeJournalController::class,'journalsSearch'])->name('teacher.journals.search'); 


        // Oraliq TEACHER uchun
        Route::get('/midterms', [MidtermIntervalController::class, 'index'])->name('midterms.index');
        Route::get('/all-midterms', [MidtermIntervalController::class, 'allMidterms'])->name('all.midterms');
        Route::get('/midterms/create', [MidtermIntervalController::class, 'create'])->name('midterms.create');
        Route::post('/midterm-intervals', [MidtermIntervalController::class, 'store'])->name('midterm.store');
        Route::get('/midterms/search',[MidtermIntervalController::class,'midtermsSearch'])->name('midterms.search'); 
        Route::get('/midterms/{midterm}/manual', [MidtermIntervalController::class, 'manual'])->name('midterms.manual');
        Route::post('/midterms/{midterm}/manual', [MidtermIntervalController::class, 'storeManual'])->name('midterms.manual.store');
        Route::get('/midterms/{midterm}/assignment', [MidtermIntervalController::class, 'assignment'])->name('midterms.assignment');
        Route::post('/midterms/{midterm}/toggle-status', [MidtermIntervalController::class, 'toggleStatus'])->name('midterms.toggle-status');
        Route::post('/midterm-grades', [MidtermGradeController::class, 'store'])->name('midterm-grades.store');
        Route::put('/midterm-grades/{midtermGrade}', [MidtermGradeController::class, 'update'])->name('midterm-grades.update');
        
        // Talabarni vazifasini tekshirish
        Route::get('assignments/{assignment}/submissions', [AssignmentController::class, 'submissions'])->name('assignments.submissions');
        Route::get('midterms/{midterm}/assignment/create', [AssignmentController::class, 'create'])->name('midterms.assignment.create');
        Route::post('midterms/{midterm}/assignment', [AssignmentController::class, 'store'])->name('midterms.assignment.store');
        Route::post('/midterms/{assignment}/toggle-status', [AssignmentController::class, 'assignmentStatus'])  
        ->name('midterms.assignment-status');

        // Talabani yuborgan vazifasini korish
        Route::get('/submissions/{submission}', [AssignmentSubmissionController::class, 'show'])->name('submissions.show');
        
        // Talabani oraliq baxosini ozgartirish
        Route::get('/submissions/{submission}/edit', [AssignmentSubmissionController::class, 'edit'])->name('submissions.edit');
        

        

        Route::get('/teacher-calendar', [PageController::class, 'showTeacherCalendar'])->name('teachers.calendar');

        Route::get('/teacher/topic', [TopicController::class, 'teacherIndex'])->name('teacher.topic');

        // group_subject bo‘yicha mavzularni ko‘rsatish
        Route::get('/topics/group-subject/{groupSubject}', [TopicController::class, 'showByGroupSubject'])
            ->name('topics.showByGroupSubject'); 

        Route::get('group-subjects/{groupSubject}/teacher-topics/create', [TopicController::class, 'teacherTopicCreate'])->name('teacherTopics.create');
        
        Route::post('group-subjects/{groupSubject}/teacher-topics', [TopicController::class, 'teacherTopicStore'])->name('teacherTopics.store');
        Route::get('group-subjects/{topic}/teacher-topics/edit', [TopicController::class, 'teacherTopicEdit'])->name('teacherTopics.edit');
        Route::put('group-subjects/{topic}/teacher-topics/update', [TopicController::class, 'teacherTopicUpdate'])->name('teacherTopics.update');
        Route::delete('group-subjects/{topic}/teacher-topics/delete', [TopicController::Class, 'teacherTopicDestroy'])->name('teacherTopic.destroy');
        Route::get('/all-topics', [TopicController::class, 'alltopics'])->name('all.topics');
        Route::get('/topics/group-subject/{groupSubject}/all-topics/show', [TopicController::class, 'showAllTopicsByGroupSubject'])
            ->name('all-topics.showByGroupSubject'); 
        Route::get('/topics/{groupSubject}/search',[TopicController::class,'topicsSearch'])->name('topics.search'); 
        Route::get('/all-topics/search',[TopicController::class,'allTopicsSearch'])->name('all.topics.search'); 


        Route::post('/test/question/{question}/toggle-status', [QuestionController::class, 'status'])
        ->name('test.question-status');




    });






    Route::middleware(['auth', 'student'])->group(function () {

        // Route::get('/time-table/{groupId}', [TimeTableController::class, 'groupSchedule'])->name('time-table.group');
        Route::get('/exams-student/{groupId}', [PageController::class, 'studentExam'])->name('student.exam');

        Route::get('attendance-all', [AttendanceController::class, 'attendanceAll'])->name('attendance.all');

        Route::get('attendance-report', [AttendanceController::class, 'attendanceReport'])->name('attendance.report');

        // Talaba: o'z baholarini ko'rish
        Route::get('/student/grades', [GradeJournalController::class, 'studentGrades'])->name('student.grades');

        // Talaba dars jadvali
        Route::get('student/group/{group}/schedule', [ScheduleController::class, 'studentSchedule'])->name('student.schedule');

        // Talaba dan resurslari
        Route::get('/student/assignments/{groupSubject}', [AssignmentController::class, 'studentIndex'])
        ->name('student.assignments');

        Route::get('{assignment}/create', [AssignmentSubmissionController::class, 'create'])->name('submissions.create');
        Route::post('{assignment}/store', [AssignmentSubmissionController::class, 'store'])->name('submissions.store');

        // Guruxini talabari royhati
        Route::get('/student/groups/{group}/students', [GroupController::class, 'showStudents'])->name('student.groups.students');

        // Talaba baxolari
        Route::get('/performance', [PageController::class, 'performance'])->name('students.performance');

        // Fan uchun resurslar
        Route::get('/education/subjects', [PageController::class, 'resources'])->name('education.subjects');
        Route::get('groupsubjects/{groupSubject}/student/topics', [TopicController::class, 'showStudentTopics'])->name('groupsubjects.student.topics');
    });


    Route::middleware(['auth', 'admin'])->group(function () {

        // Gurux talabalari
        Route::get('/groups/{groupId}/students', [UserController::class, 'groupStudents'])->name('group.students');

        
        // Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
        // Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        // Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        // Route::put('/posts/{post}/update', [PostController::class, 'update'])->name('posts.update');
        // Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
        

        Route::get('admins', [PageController::class, 'allAdmins'])->name('all.admins');

            //Admin
        Route::get('register/admin', [AuthController::Class, 'registerAdmin'])->name('register.admin');
        Route::post('register/admin', [AuthController::Class, 'registerAdmin_store'])->name('registerAdmin.store');

        Route::delete('admins/destroy/{user}', [AuthController::class, 'adminDestroy'])->name('admin.destroy');
        Route::get('admins/edit/{user}', [PageController::class, 'adminEdit'])->name('admin.edit');
        Route::put('admins/update/{user}', [AuthController::Class, 'adminUpdate'])->name('admin.update');

            //Student
        Route::get('register/{group}/student', [AuthController::Class, 'registerStudent'])->name('register.student');
        Route::post('register/student', [AuthController::Class, 'registerStudent_store'])->name('registerStudent.store');
        Route::get('student/edit/{user}', [PageController::class, 'studentEdit'])->name('student.edit');
        Route::put('student/update/{user}', [AuthController::Class, 'studentUpdate'])->name('student.update');
        Route::get('student/{user}/show', [PageController::class, 'studentShow'])->name('student.show');
        Route::delete('student/destroy/{user}', [AuthController::class, 'studentDestroy'])->name('student.destroy');


            // Teacher
        Route::get('register/teacher', [AuthController::Class, 'registerTeacher'])->name('register.teacher');
        Route::post('register/teacher', [AuthController::Class, 'registerTeacher_store'])->name('registerTeacher.store');
        Route::get('edit/{user}', [AuthController::Class, 'teacherEdit'])->name('teacher.edit');
        Route::put('update/{user}', [AuthController::Class, 'teacherUpdate'])->name('teacher.update');
        Route::delete('destroy/{user}', [AuthController::class, 'teacherDestroy'])->name('teacher.destroy');

        Route::post('/semester/course/{year}/generate', [GroupController::class, 'generateWeeks'])->name('semester.generateWeeks');

        // Guruh haftalari ro‘yxati
        Route::get('/groups/{group}/weeks', [WeekController::class, 'index'])->name('groups.weeks.index');

        // Guruh haftasini tahrirlash formasi
        Route::get('/groups/{group}/weeks/{week}/edit', [WeekController::class, 'edit'])->name('groups.weeks.edit');

        // Guruh haftasini yangilash
        Route::put('/groups/{group}/weeks/{week}', [WeekController::class, 'update'])->name('groups.weeks.update');

        // Gurux haftalardi faol yoki nofaol 
        Route::put('/weeks/{week}/toggle', [WeekController::class, 'toggleActive'])->name('weeks.toggle');

        // Semesterlar royhati
        Route::get('/groups/{group}/semesters', [GroupController::class, 'semesters'])->name('groups.semesters');

        // Guruxni fanlari
        Route::get('/groups/{group}/subjects', [GroupSubjectController::class, 'index'])->name('groupSubject.index');

        // Fanni biriktirish
        Route::post('/groups/{group}/subjects', [GroupSubjectController::class, 'store'])->name('groupSubject.store');

        Route::get('groups/{group}/subjects/{subject}/edit', [GroupSubjectController::class, 'edit'])->name('groupSubject.edit');
        Route::get('groups/{group}/students/show', [GroupController::class, 'showGroupStudents'])->name('show.groups.students');

        // GroupSubject uchun jurnal yaratish, parametr shart emas
        Route::post('/group-subject/create-journal', [JournalController::class, 'createJournal'])->name('groupSubject.createJournal');

        Route::put('/groups/{group}/subjects', [GroupSubjectController::class, 'update'])->name('groupSubject.update');

        Route::delete('groups/{group}/subjects/{subject}/delete', [GroupSubjectController::class, 'destroy'])->name('groupSubject.destroy');

        Route::get('/academic_year', [AcademicYearController::class, 'index'])->name('academicYear.index');
        Route::post('/academic_year', [AcademicYearController::class, 'store'])->name('academicYear.store');
        Route::get('/academic_year/{academicYear}/edit', [AcademicYearController::class, 'edit'])->name('academicYear.edit');
        Route::delete('/academic_year/{academicYear}/delete', [AcademicYearController::class, 'destroy'])->name('academicYear.delete');

        // Dars jadvali uchun 
        Route::get('/schedule/{group}/semester/{semester}/week/{week?}', [ScheduleController::class, 'bySemesterAndWeek'])->name('schedule.bySemesterWeek');

        Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule.index'); 

        // Route::get('/schedule/create', [ScheduleController::class, 'create'])->name('schedule.create');

        Route::get('/schedule/scheduleCreate', [ScheduleController::class, 'scheduleCreate'])->name('schedule.scheduleCreate'); 
        
        // Route::post('/schedule/store', [ScheduleController::class, 'store'])->name('schedule.store');

        Route::post('/schedule/scheduleStore', [ScheduleController::class, 'scheduleStore'])->name('schedule.scheduleStore');


        Route::get('/schedule/{group}', [ScheduleController::class, 'show'])->name('schedule.show');

        // Tahrirlash sahifasi
        Route::get('/schedules/{id}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');

        // Yangilash (update) uchun
        Route::put('/schedules/{id}', [ScheduleController::class, 'update'])->name('schedules.update');

        // O‘chirish (delete)
        Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

        // Haftadan haftagacha jadval yaratish sahifasi
        Route::get('/schedule/{group_id}/{semester_id}/generate-week', [ScheduleController::class, 'generateWeekPage'])->name('schedule.generate.week');

        // Generatsiya qilish formi
        Route::post('/schedule-generate-week', [ScheduleController::class, 'generateWeekProcess'])->name('schedule.generate.week.process');

        Route::get('/admin/group/{group}/schedule', [ScheduleController::class, 'groupSchedule'])->name('admin.group.schedule');

        // Route::get('student/group/{group}/schedule', [ScheduleController::class, 'studentSchedule'])->name('student.schedule');

        // Filter
        Route::get('/filter/group', [PageController::class, 'filterGroup'])->name('filter.groups');
        Route::get('/filter/groups-by-program/{program}', [PageController::class, 'getGroupsByProgram'])->name('filter.groups.by.program');
        Route::get('/filter/semesters-by-group/{groupId}', [PageController::class, 'getSemestersByGroup'])->name('filter.semesters.by.group');
        Route::get('/calendar/show', [PageController::class, 'showCalendar'])->name('calendar.show');

        Route::get('schedule/group/create', [GroupController::class, 'scheduleGroupCreate'])->name('schedule.group.create');

        Route::get('groups/topics/{group}/subjects', [GroupController::class, 'subjects'])->name('groups.subjects.for.topic');

        // GroupSubject ichida mavzular
        Route::get('group-subjects/{groupSubject}/topics', [TopicController::class, 'index'])->name('topics.index');
        Route::get('group-subjects/{groupSubject}/topics/create', [TopicController::class, 'create'])->name('topics.create');
        Route::post('group-subjects/{groupSubject}/topics', [TopicController::class, 'store'])->name('topics.store');
        Route::get('topics/{topic}/edit', [TopicController::class, 'edit'])->name('topics.edit');
        Route::put('topics/{topic}', [TopicController::class, 'update'])->name('topics.update'); 

        // Davomat
        Route::get('/attendance/for-admin/group', [AttendanceController::class, 'adminAttendanceIndex'])->name('attendanceAdmin.index'); 
        Route::get('/attendance/{group}/admin', [AttendanceController::class, 'adminAttendanGroup'])->name('attendanceAdmin.group'); 
        Route::get('/attendance/{group}/admin/{groupSubject}', [AttendanceController::class, 'adminGroupSubject'])->name('attendanceAdmin.groupSubject'); 
        
        Route::get('/attendance/schedule/{schedule}/admin', [AttendanceController::class, 'showAdminAttendanceForm'])->name('showAdminAttendance.form'); // Forma
        Route::post('/attendance/{schedule}/admin/save', [AttendanceController::class, 'adminAttendanceSave'])->name('adminAttendance.save'); // Saqlash

        // Joriy baho
        Route::get('/journals/admin', [JournalController::class, 'adminJournalIndex'])->name('adminJournal.index');
        Route::get('/journals/{group}/admin', [JournalController::class, 'adminJournalGroupSubject'])->name('adminJournal.groupSubject');
        Route::get('/journals/{group}/admin/{groupSubject}/subjects', [JournalController::class, 'adminGroupJurnalsIndex'])->name('adminGroupJournal.index');
        Route::get('/journals/schedule/{schedule}/grades', [JournalController::class, 'showJournalGroupGrades'])
        ->name('journalGroup.grades');
        Route::post('/journal/schedule/{schedule}/grades/store', [JournalController::class, 'storeJournalGroupGrades'])
        ->name('journalGroupgrades.store');
        
        // Guruxni qidirish

        Route::get('/group/search',[GroupController::class,'groupSearch'])->name('groups.search'); 
        Route::get('/admin/search',[PageController::class,'adminSearch'])->name('admins.search'); 
        Route::get('groups/{group}/subjects/search', [GroupSubjectController::class, 'groupSubjectSearch'])->name('groupSubjects.search');
        Route::get('groups/{group}/students', [GroupController::class, 'searchGroupStudents'])
        ->name('searchGroups.students');
        Route::get('groups/{topic}/search', [TopicController::class, 'searchGroupTopics'])->name('searchGroups.topics');
        Route::get('/subject/search',[SubjectController::class,'subjectSearch'])->name('subjects.search'); 

        Route::get('/journal/search',[JournalController::class,'journalSearch'])->name('journals.search'); 
        Route::get('/groups/{group}/journals/search', [JournalController::class, 'groupJournalsSearch'])->name('group.journals.search');

        Route::get('/attendance/search/groups',[AttendanceController::class,'attendanceSearch'])->name('attendances.search'); 
        Route::get('/groups/{group}/attendances/search', [AttendanceController::class, 'groupAttendanceSearch'])->name('group.attendances.search');
        Route::get('/groups/{group}/attendances/{groupSubject}/schedules', [AttendanceController::class, 'adminAttendanceGroupSubject'])
        ->name('admin.attendance.group.subject');


        // Dars jadvalini filtirlash
        Route::get('/schedules/filter', [ScheduleController::class, 'filter'])->name('schedules.filter');
        Route::get('/schedules/get-semesters/{group}', [ScheduleController::class, 'getSemesters'])->name('schedules.getSemesters');

        // Program search
        Route::get('/programs/search', [ProgramController::class, 'programsSearch'])->name('programs.search');



        // Oraliq ADMIN uchun
        Route::get('/admin/midterms', [MidtermIntervalController::class, 'adminIndex'])->name('admin.midterms.index');
        Route::get('/admin/{group}/midterms', [MidtermIntervalController::class, 'adminGroupMidterm'])->name('adminGroup.midterm');
        Route::get('/admin/{group}/midterms/{midterm}/manual', [MidtermIntervalController::class, 'adminManual'])->name('admins.midterms.manual');
        Route::post('/admin/{group}/midterms/{midterm}/manual', [MidtermIntervalController::class, 'sadminStoreManual'])->name('admins.midterms.manual.store');
        Route::get('/admin/{group}/midterms/{midterm}/assignment', [MidtermIntervalController::class, 'adminAssignment'])->name('admins.midterms.assignment');
        Route::get('/admin/{group}/midterms/{midterm}/assignment/create', [AssignmentController::class, 'adminCreate'])->name('admin.midterms.assignment.create');
        Route::post('/admin/{group}/midterms/{midterm}/assignment', [AssignmentController::class, 'adminStore'])->name('admin.midterms.assignment.store');
        // Talabarni vazifasini tekshirish
        Route::get('/admin/{group}/midterms/{midterm}/assignment/{assignment}/submissions', [AssignmentController::class, 'adminSubmissions'])
        ->name('admin.assignments.submissions');
        Route::get('/admin/{group}/midterms/{midterm}/assignment/{assignment}/submissions/{submission}', [AssignmentSubmissionController::class, 'adminSubmissionShow'])
        ->name('admin.submissions.show');
        // Talabani oraliq baxosini ozgartirish
        Route::get('/admin/{group}/midterms/{midterm}/assignment/{assignment}/submissions/{submission}/edit', [AssignmentSubmissionController::class, 'adminSubmissionEdit'])
        ->name('admin.submissions.edit');
        Route::post('admin/midterm-grades', [MidtermGradeController::class, 'adminSubmissionStore'])->name('admin.midterm-grades.store');
        Route::get('/admin/midterm/search',[MidtermIntervalController::class,'adminMidtermSearch'])->name('admin.midterm.search'); 
        



        

        



        Route::resources([
            
            'groups'=>GroupController::Class,
            'subject'=>SubjectController::Class,
            'exams'=>ExamController::Class,
            'categories'=>CategoryController::class,
            'tags'=>TagController::class,
            'auditoriums'=> AuditoriumController::class,
            'facultys'=>FacultyController::class,
            'programs'=>ProgramController::class,
            'lessonPairs'=> LessonPairController::class,
        ]);

        Route::get('/programs/create/admin', [ProgramController::Class, 'programCreate'])->name('programCreate');

        // Route::resource('schedule', ScheduleController::class)
        // ->parameters(['schedule' => 'group']);
    });

    Route::get('/tests', [FinalTestController::Class, 'index'])->name('test.index');
    Route::get('/tests/all-tests', [FinalTestController::Class, 'allTests'])->name('all.tests');
    Route::get('/tests/search', [FinalTestController::class, 'testsSearch'])->name('test.search');

    Route::get('/final/test/create',[FinalTestController::class, 'finalTestCreate'])->name('finalTest.create');
    Route::post('/test/{test}/toggle-status', [FinalTestController::class, 'toggleTestStatus'])
    ->name('test.toggle-status');

    Route::post('/tests', [FinalTestController::class, 'store'])->name('tests.store');

    Route::get('/tests/{test}/questions', [FinalTestController::class, 'addQuestions'])->name('tests.addQuestions');
    Route::get('/tests/{test}/questions/preview', [FinalTestController::class, 'preview'])->name('tests.preview');
    Route::post('/tests/{test}/store-questions', [FinalTestController::class, 'storeQuestions'])->name('tests.storeQuestions');
    Route::get('tests/{test}/questions/show', [FinalTestController::Class, 'show'])->name('questions.show');
    Route::get('tests/{test}/questions/{question}/edit', [FinalTestController::Class, 'edit'])->name('questions.edit');
    Route::put('tests/{test}/questions/{question}', [FinalTestController::class, 'update'])->name('questions.update');
    Route::delete('tests/{test}/questions/{question}', [FinalTestController::class, 'destroy'])->name('questions.destroy');
    Route::get('/tests/{test}/search', [FinalTestController::class, 'searchQuestions'])->name('tests.search');




    // Yakuniy nazorat
     Route::get('exam/sessions', [ExamSessionController::class, 'index'])->name('examSession.index');
     Route::get('exam/sessions/create', [ExamSessionController::class, 'create'])->name('examSession.create');
     Route::get('/exam/sessions/all', [ExamSessionController::class, 'allSessions'])->name('examSession.all');

     Route::post('exam/sessions/store', [ExamSessionController::class, 'store'])->name('examSession.store');

     // routes/web.php
     Route::get('/student/test/{test}', [ExamSessionController::class, 'startTest'])->name('student.test.start');

     Route::post('/exam/answer', [ExamSessionController::class, 'answerStore'])->name('exam.answer.store');
     Route::get('/exam/{test}/finish', [ExamSessionController::class, 'finish'])->name('exam.finish');

     // groupSubject bo‘yicha talabalar ro‘yxati
     Route::get('/exam-sessions/{session}/tests/{test}/group-subject/{groupSubject}', [ExamSessionController::class, 'showGroupSubjectStudents'])
     ->name('exam.groupSubject.students');

     Route::post('/exam-sessions/{session}/tests/{test}/group-subject/{groupSubject}/give-access', [ExamSessionController::class, 'giveAccess'])
     ->name('exam.groupSubject.giveAccess');

     Route::get('/exam-sessions/search', [ExamSessionController::class, 'search'])->name('examSession.search');

     Route::get('/results/{result}', [ResultController::class, 'show'])->name('results.show');






    // Shaxsiy malumot
Route::get('personal-data', [PageController::class, 'personalData'])->name('personal.data');

    // Shaxsiy malumot


     //Kategoriya tanlash
Route::get('/category/{slug}',[PageController::class, 'categoryPosts'])->name('category.posts');

     //Tag tanlash
Route::get('/tag/{slug}',[PageController::class, 'tagPosts'])->name('tag.posts');

     // Search  
Route::get('/search',[PostController::class,'search'])->name('search'); 

     // Ckeditor
Route::get('ckeditor/upload', [PageController::class, 'upload'])->name('ckeditor.upload');

Route::get('/chats',[PageController::class,'ChatsIndex'])->name('chats.index'); 

















Route::resources([
    'posts'=>PostController::class,
    'comments'=>CommentController::class,
    'exams'=>ExamController::class,
    
    'notifications'=>NotificationController::class,
]);


Route::get('/lang/{lang}', function ($lang) {
    $available = ['uz', 'en', 'ru']; // mavjud tillar

    if (in_array($lang, $available)) {
        session(['lang' => $lang]);
        app()->setLocale($lang);
    }

    return redirect()->back();
})->name('language');

