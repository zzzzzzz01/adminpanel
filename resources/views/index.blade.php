@if(auth()->user())
 <x-layout.app>

 <x-slot:title>
  Bo'sh sahifa
</x-slot:title>

<div class="container">
@if(!auth()->user()->hasRole('admin'))
  <div class="title-wrapper pt-30">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="title">
            <h2> @lang('words.lesson') </h2>
        </div>
      </div>
    </div>
  </div>
      <div class="row">
      @if(auth()->user()->hasRole('student'))
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="icon-card mb-30">
            <div class="icon purple">
            <i class="fa-solid fa-users"></i>
            </div>
            <div class="content">
              <h6 class="mb-10"><a href="{{ route('group.students', ['groupId' => auth()->user()->group_id ?? 0]) }}">@lang('words.students')</a></h6>
              <h3 class="text-bold mb-10"> {{ $users->where('group_id', auth()->user()->group_id)->count() }} </h3>
              <p class="text-sm text-success">
                <span class="text-gray">@lang('words.student.count')</span>
              </p>
            </div>
          </div>
        </div>
        @endif
        @if(auth()->user()->hasRole('student'))
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="icon-card mb-30">
            <div class="icon success">
            <i class="fa-solid fa-table"></i>
            </div>
            <div class="content">
            <h6 class="mb-10"><a  href="">@lang('words.schedule')</a></h6>
              <h3 class="text-bold mb-10">Dushanba</h3>
              <p class="text-sm text-success">
                <span class="text-gray">@lang('words.today')</span>
              </p>
            </div>
          </div>
        </div>
        @endif
        @if(auth()->user()->hasRole('student'))
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="icon-card mb-30">
            <div class="icon orange">
            <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div class="content">
              <h6 class="mb-10"><a href="{{ route('student.exam', ['groupId' => auth()->user()->group_id ?? 0]) }}">@lang('words.exams')</a></h6>
              <h3 class="text-bold mb-10"> {{ $examCount }}</h3>
              <p class="text-sm text-danger">
                <span class="text-gray">@lang('words.exams.count')</span>
              </p>
            </div>
          </div>
        </div>
        @endif
        @if(auth()->user()->hasRole('teacher'))
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="icon-card mb-30">
            <div class="icon orange">
            <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div class="content">
              <h6 class="mb-10"><a href="{{ route('teacher.exams') }}">@lang('words.exams')</a></h6>
              <h3 class="text-bold mb-10"> {{ $examCount }}</h3>
              <p class="text-sm text-danger">
                <span class="text-gray">@lang('words.exams.count')</span>
              </p>
            </div>
          </div>
        </div>
        @endif
        @if(auth()->user()->hasRole('teacher'))
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="icon-card mb-30">
            <div class="icon success">
            <i class="fa-solid fa-table"></i>
            </div>
            <div class="content">
            <h6 class="mb-10"><a  href="{{ route('teacher.schedule') }}">@lang('words.schedule')</a></h6>
              <h3 class="text-bold mb-10">Dushanba</h3>
              <p class="text-sm text-success">
                <span class="text-gray">@lang('words.today')</span>
              </p>
            </div>
          </div>
        </div>
        @endif
      </div>
      @endif
      
      @if(auth()->user()->hasRole('admin'))
      <div class="title-wrapper pt-30">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class="title">
            <h2> @lang('words.for.admin') </h2>
           </div>
         </div>
       </div>
     </div>
    
    <!-- ========== section start ========== -->
    <div class="row">
      <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
          <div class="icon purple">
            <i class="fa-solid fa-users"></i>
          </div>
          <div class="content">
            <h6 class="mb-10"><a href="{{ route('groups.index') }}">@lang('words.groups')</a></h6>
            <h3 class="text-bold mb-10">{{ $groups->count() }}</h3>
            <p class="text-sm text-success">
              <span class="text-gray">@lang('words.groups.count')</span>
            </p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
          <div class="icon primary">
            <i class="fa-solid fa-list"></i>
          </div>
          <div class="content">
            <h6 class="mb-10"><a  href="{{ route('all.admins') }}"> @lang('words.admin.list') </a></h6> 
             
            <h3 class="text-bold mb-10">{{ $adminCount }}</h3>
             
            <p class="text-sm text-success">
              <span class="text-gray"> @lang('words.admins.count') </span>
            </p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
          <div class="icon orange">
            <i class="fa-solid fa-book-open-reader"></i>
          </div>
          <div class="content">
            <h6 class="mb-10"><a href="{{ route('subject.index') }}"> @lang('words.subject.list') </a></h6>
            <h3 class="text-bold mb-10">{{ $subjects->count() }}</h3>
            <p class="text-sm text-danger">
              <span class="text-gray"> @lang('words.subjects.count') </span>
            </p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
          <div class="icon danger">
          <i class="fa-solid fa-hexagon-nodes"></i>
          </div>
          <div class="content">
            <h6 class="mb-10"><a href="{{ route('exams.index') }}"> Imtihonlar ro'yhati </a></h6>
            <h3 class="text-bold mb-10"> {{ $exams->count() }}  </h3>
            <p class="text-sm text-danger">
              <span class="text-gray"> Imtihonlar soni </span>
            </p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
          <div class="icon success">
            <i class="fa-solid fa-sliders"></i>
          </div>
          <div class="content">
            <h6 class="mb-10"><a href="{{ route('schedule.index') }}"> @lang('words.manage.schedule') </a></h6>
          </div>
        </div>
      </div>
    </div>
    @endif
    
    
    
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title">
              <h2> Ma'lumotnomalar</h2>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
          <div class="icon purple">
          <i class="fa-solid fa-file"></i>
          </div>
          <div class="content">
            <h6 class="mb-10"><a href="{{ route('personal.data') }}"> @lang('words.person.info') </a></h6>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
          <div class="icon success">
          <i class="fa-solid fa-user"></i>
          </div>
          <div class="content">
            <h6 class="mb-10"><a href="{{ route('profil.index') }}"> @lang('words.profile') </a></h6>
          </div>
        </div>
      </div>
    </div>
      
      
      
      <div class="title-wrapper pt-30">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class="title">
              <h2> @lang('words.about.uni') </h2>
            </div>
          </div>
        </div>
      </div>
      
      <!-- ========== section start ========== -->
      <div class="row">
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="icon-card mb-30">
            <div class="icon primary">
              <i class="fa-solid fa-person-chalkboard"></i>
            </div>
            <div class="content">
              <h6 class="mb-10"><a href="{{ route('teachers.index') }}"> @lang('words.teachers') </a></h6>
              <h3 class="text-bold mb-10"> {{ $teacherCount }} </h3>
              <p class="text-sm text-success">
                <span class="text-gray"> @lang('words.teachers.count') </span>
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="icon-card mb-30">
            <div class="icon success">
              <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="content">
              <h6 class="mb-10"><a href="{{ route('posts.index') }}"> @lang('words.news') </a></h6>
              <h3 class="text-bold mb-10"> {{ $posts->count() }} </h3>
              <p class="text-sm text-danger">
                <span class="text-gray"> @lang('words.news.count') </span>
              </p>
            </div>
          </div>
        </div>
    </div>

</div>
  
  
  
  
  @if(session('success'))
  <div class="alert alert-success position-fixed bottom-0 end-0 p-3" style="background-color: #5cb85c; color: white;">
    <i class="fa-solid fa-check"></i> {{ session('success') }}
  </div>
  @endif

  <script>
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            alert.remove();
        });
    }, 5000); // 5 sekunddan keyin barcha alertlar yo'qoladi
</script>  
  
</x-layout.app>

    @else
      @include('auth.login')
    @endif