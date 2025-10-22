admin

<li><a href="{{ route('groups.index') }}"> @lang('words.groups') </a></li>
<li><a href="{{ route('all.admins') }}"> @lang('words.admin.list') </a></li>
<li><a href="{{ route('subject.index') }}"> @lang('words.subject.list') </a></li>
<li><a href="{{ route('schedule.index') }}"> @lang('words.manage.schedule') </a></li>
<li><a href="{{ route('academicYear.index') }}"> O'quv yili </a></li>
<li><a href="{{ route('lessonPairs.index') }}"> Juftliklar </a></li>
<li><a href="{{ route('auditoriums.index') }}"> Auditoriya </a></li>
<li><a href="{{ route('examSession.index') }}"> Yakuniy nazorat </a> </li>
<li><a href="{{ route('facultys.index') }}"> Fakultetlar </a></li>
<li><a href="{{ route('programs.index') }}"> Yo'nalishlar </a></li>

student 

<li><a href="{{ route('group.students', ['groupId' => auth()->user()->group_id ?? 0]) }}" > @lang('words.students') </a></li>
<li><a href="{{ route('exams.index') }}" > @lang('words.exams') </a></li>
<li><a href="{{ route('student.schedule', ['group' => auth()->user()->group_id ?? 0]) }}" > @lang('words.schedule') </a></li>
<li><a href="{{ route('attendance.all') }}" >Davomat</a></li>
<li><a href="{{ route('attendance.report') }}" >Davomat hisobi</a></li>
<li><a href="{{ route('student.grades') }}" >Baxolar (talaba uchun)</a></li>
<li><a href="{{ route('students.performance') }}" >Ozlashtirish (talaba uchun)</a></li>
<li><a href="{{ route('education.subjects') }}" >Fanlar resurslari</a></li>
<li><a href="{{ route('exams.index') }}"> @lang('words.exam.list') </a> </li>

teacher

<li><a href="{{ route('attendance.index') }}" >Davomat (oqituvchi) </a></li>
<li><a href="{{ route('midterms.index') }}" >Oraliq nazorat</a></li>
<li><a href="{{ route('teacher.exams') }}" > @lang('words.exams') </a></li>
<li><a href="{{ route('test.index') }}">Yakuniy nazorat</a></li>
<li><a href="{{ route('teacher.grades') }}" >Joriy nazorat</a></li>
<li><a href="{{ route('teachers.calendar') }}" > Dars jadvali (o'qituvchi) </a></li>
<li><a href="" > Mavzular </a></li>

umumiy

<li><a href="{{ route('personal.data') }}"> @lang('words.person.info') </a></li>
<li><a href="{{ route('profil.index') }}"> @lang('words.profile') </a></li>
<li><a href="{{ route('notifications.index') }}"> @lang('words.notification') </a></li>
<li><a href="{{ route('teachers.index') }}"> @lang('words.teachers') </a></li>
<li><a href="{{ route('posts.index') }}"> @lang('words.news') </a></li>
<li><a href="{{ route('chats.index') }}"> Chatlar </a></li>