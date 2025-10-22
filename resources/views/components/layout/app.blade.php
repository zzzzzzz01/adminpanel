<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('temp/images/favicon.svg') }}" type="image/x-icon" />
    <title>Title</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{ asset('temp/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('temp/css/lineicons.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('temp/css/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('temp/css/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('temp/css/main.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    @stack('styles')

  </head>
  <body>
    <!-- ======== Preloader =========== -->
    <!-- <div id="preloader">
      <div class="spinner"></div>
    </div> -->
    <!-- ======== Preloader =========== -->

    <!-- ======== sidebar-nav start =========== -->
    <aside class="sidebar-nav-wrapper">
      <div class="navbar-logo">
        <a href="{{ route('home.page') }}">
          <!-- Logo web site-->
          <img src="{{ asset('temp/images/logo/logo.svg') }}" alt="logo" />  
        </a>
      </div>
      <nav class="sidebar-nav">
        <ul>
            @if(auth()->user()->hasRole('admin'))
                <li class="nav-item nav-item-has-children">
                  @php
                      $isAdminMenuActive = Request::is('groups*') || Request::is('admins*') || Request::is('subject*');
                  @endphp
                    <a href="#0" 
                    class="{{ $isAdminMenuActive ? '' : 'collapsed' }}" 
                    data-bs-toggle="collapse"
                    data-bs-target="#admin_menu" 
                    aria-controls="admin_menu" 
                    aria-expanded="{ $isAdminMenuActive ? 'true' : 'false' }}" 
                    aria-label="Toggle navigation">
                        <span class="icon"><i class="fa-solid fa-user-shield"></i></span>
                        <span class="text">Admin Bo'limi</span>
                    </a>
                    <ul id="admin_menu" class="collapse dropdown-nav {{ $isAdminMenuActive ? 'show' : '' }}">
                        <li>
                          <a href="{{ route('groups.index') }}"
                          class="{{ Request::is('groups*') ? 'active' : '' }}">
                            @lang('words.groups')
                          </a>
                        </li>

                        <li>
                          <a href="{{ route('all.admins') }}"
                          class="{{ Request::is('admins*') ? 'active' : '' }}">
                            @lang('words.admin.list')
                          </a>
                        </li>
                        <li>
                          <a href="{{ route('subject.index') }}"
                          class="{{ Request::is('subject*') ? 'active' : '' }}">
                            @lang('words.subject.list')
                          </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-item-has-children">
                  @php
                      $isActiveMenu = Request::is('schedule*') || Request::is('academic_year*') || Request::is('attendance/for-admin*');
                  @endphp

                  <a href="#0" 
                    class="{{ $isActiveMenu ? '' : 'collapsed' }}" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#schedule_menu" 
                    aria-controls="schedule_menu" 
                    aria-expanded="{{ $isActiveMenu ? 'true' : 'false' }}" 
                    aria-label="Toggle navigation">
                      <span class="icon"><i class="fa-solid fa-calendar-alt"></i></span>
                      <span class="text">O‘qish jarayoni</span>
                  </a>

                  <ul id="schedule_menu" 
                      class="collapse dropdown-nav {{ $isActiveMenu ? 'show' : '' }}">
                      
                      <li>
                          <a href="{{ route('schedule.index') }}" 
                            class="{{ Request::is('schedule*') ? 'active' : '' }}">
                              @lang('words.manage.schedule')
                          </a>
                      </li>

                      <li>
                          <a href="{{ route('academicYear.index') }}" 
                            class="{{ Request::is('academic_year*') ? 'active' : '' }}">
                              O‘quv yili
                          </a>
                      </li>

                      <li>
                          <a href="{{ route('attendanceAdmin.index') }}" 
                            class="{{ Request::is('attendance/for-admin*') ? 'active' : '' }}">
                              Davomat
                          </a>
                      </li>
                  </ul>
              </li>

                <li class="nav-item nav-item-has-children">
                  @php
                      $isActiveResources = Request::is('lessonPairs*') || Request::is('auditoriums*') || Request::is('facultys*') || Request::is('programs*');
                  @endphp
                    <a href="#0"
                    class="{{ $isActiveResources ? '' : 'collapsed' }}" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#resources_menu" 
                    aria-controls="resources_menu" 
                    aria-expanded="{{ $isActiveResources ? 'true' : 'false' }}" 
                    aria-label="Toggle navigation">
                        <span class="icon"><i class="fa-solid fa-chart-simple"></i></span>
                        <span class="text">Manitoring</span>
                    </a>
                    <ul id="resources_menu" class="collapse dropdown-nav {{ $isActiveResources ? 'show' : '' }}">
                        <li>
                          <a href="{{ route('lessonPairs.index') }}"
                          class="{{ Request::is('lessonPairs*') ? 'active' : '' }}">
                            Juftliklar
                          </a>
                        </li>
                        <li>
                          <a href="{{ route('auditoriums.index') }}"
                          class="{{ Request::is('auditoriums*') ? 'active' : '' }}">
                            Auditoriya
                          </a>
                        </li>
                        <!-- <li><a href="{{ route('examSession.index') }}">Yakuniy nazorat</a></li> -->
                        <li>
                          <a href="{{ route('facultys.index') }}"
                          class="{{ Request::is('facultys*') ? 'active' : '' }}">
                            Fakultetlar
                          </a>
                        </li>
                        <li>
                          <a href="{{ route('programs.index') }}"
                          class="{{ Request::is('programs*') ? 'active' : '' }}">
                            Yo'nalishlar
                          </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-item-has-children">
                  @php
                      $isActiveControl = Request::is('admin/midterms*') || Request::is('exam/sessions*') || Request::is('journals/admin*');
                  @endphp
                    <a href="#0" 
                    class="{{ $isActiveControl ? '' : 'collapsed' }}" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#control_menu" 
                    aria-controls="control_menu" 
                    aria-expanded="{{ $isActiveControl ? 'true' : 'false' }}" 
                    aria-label="Toggle navigation">
                        <span class="icon"><i class="fa-solid fa-check-circle"></i></span>
                        <span class="text">Nazoratlar</span>
                    </a>
                    <ul id="control_menu" class="collapse dropdown-nav {{ $isActiveControl ? 'show' : '' }}">
                        <li>
                          <a href="{{ route('admin.midterms.index') }}"
                            class="{{ Request::is('admin/midterms*') ? 'active' : '' }}">
                            Oraliq nazorat
                          </a>
                        </li>
                        <li>
                          <a href="{{ route('examSession.index') }}"
                          class="{{ Request::is('exam/sessions*') ? 'active' : '' }}">
                            Yakuniy nazorat
                          </a>
                        </li>
                        <li>
                          <a href="{{ route('adminJournal.index') }}"
                          class="{{ Request::is('journals/admin*') ? 'active' : '' }}">
                            Joriy nazorat
                          </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()->hasRole('student'))
              <li class="nav-item nav-item-has-children">
                  <a href="#0" data-bs-toggle="collapse" data-bs-target="#student_menu" aria-controls="student_menu" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="icon"><i class="fa-solid fa-clipboard"></i></span>
                      <span class="text">Nazorat</span>
                  </a>
                  <ul id="student_menu" class="collapse dropdown-nav">
                    <li><a href="{{ route('student.groups.students', ['group' => auth()->user()->group_id ?? 0]) }}">@lang('words.students')</a></li>
                    <li><a href="{{ route('student.schedule', ['group' => auth()->user()->group_id ?? 0]) }}">@lang('words.schedule')</a></li>
                    <li><a href="{{ route('education.subjects') }}">Fanlar resurslari</a></li>
                    <li><a href="{{ route('attendance.all') }}">Davomat</a></li>
                    <li><a href="{{ route('attendance.report') }}">Davomat hisobi</a></li>

                  </ul>
              </li>

              <li class="nav-item nav-item-has-children">
                  <a href="#0" data-bs-toggle="collapse" data-bs-target="#exams_menu" aria-controls="exams_menu" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="icon"> <i class="fa-solid fa-user-graduate"></i></span>
                      <span class="text">O'quv reja</span>
                  </a>
                  <ul id="exams_menu" class="collapse dropdown-nav">
                    <li><a href="{{ route('exams.index') }}">@lang('words.exams')</a></li>
                    <!-- <li><a href="{{ route('student.grades') }}">Baxolar (talaba uchun)</a></li> -->
                    <li><a href="{{ route('students.performance') }}">Ozlashtirish</a></li>

                  </ul>
              </li>
            @endif

            @if(auth()->user()->hasRole('teacher'))
              <li class="nav-item nav-item-has-children">
                  <a href="#0" data-bs-toggle="collapse" data-bs-target="#assessment_menu" aria-controls="assessment_menu" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="icon"><i class="fa-solid fa-clipboard-list"></i></span>
                      <span class="text">Nazoratlar</span>
                  </a>
                  <ul id="assessment_menu" class="collapse dropdown-nav">
                      <li><a href="{{ route('midterms.index') }}">Oraliq nazorat</a></li>
                      <li><a href="{{ route('test.index') }}">Yakuniy nazorat</a></li>
                      <li><a href="{{ route('teacher.grades') }}">Joriy nazorat</a></li>
                      <!-- <li><a href="{{ route('teacher.exams') }}">Imtihonlar</a></li> -->
                  </ul>
              </li>

              <li class="nav-item nav-item-has-children">
                  <a href="#0"  data-bs-toggle="collapse" data-bs-target="#schedule_menu" aria-controls="schedule_menu" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="icon"><i class="fa-solid fa-calendar-alt"></i></span>
                      <span class="text">O'quv reja</span>
                  </a>
                  <ul id="schedule_menu" class="collapse dropdown-nav">
                      <li><a href="{{ route('attendance.index') }}">Davomat</a></li>
                      <li><a href="{{ route('teachers.calendar') }}">Dars jadvali </a></li>
                      <li><a href="{{ route('teacher.topic') }}">Mavzular</a></li>
                  </ul>
              </li>
            @endif

            <li class="nav-item nav-item-has-children">
              @php
                  $isActiveReferences = Request::is('personal-data*') || Request::is('profil*') || Request::is('notifications*');
              @endphp
                <a href="#0" 
                class="{{ $isActiveReferences ? '' : 'collapsed' }}" 
                data-bs-toggle="collapse" 
                data-bs-target="#references_menu" 
                aria-controls="references_menu" 
                aria-expanded="{{ $isActiveReferences ? 'true' : 'false' }}" 
                aria-label="Toggle navigation">
                    <span class="icon"><i class="fa-solid fa-book"></i></span>
                    <span class="text">Ma'lumotnomalar</span>
                </a>
                <ul id="references_menu" class="collapse dropdown-nav {{ $isActiveReferences ? 'show' : '' }}">
                    <li>
                      <a href="{{ route('personal.data') }}"
                      class="{{ Request::is('personal-data*') ? 'active' : '' }}">
                        Shaxsiy ma'lumot
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('profil.index') }}"
                      class="{{ Request::is('profil*') ? 'active' : '' }}">
                        Profil
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('notifications.index') }}"
                      class="{{ Request::is('notifications*') ? 'active' : '' }}">
                        Bildirishnomalar
                      </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-item-has-children">
                <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#about_uni_menu" aria-controls="about_uni_menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon"><i class="fa-solid fa-building-columns"></i></span>
                    <span class="text">Universitet Haqida</span>
                </a>
                <ul id="about_uni_menu" class="collapse dropdown-nav">
                    <li><a href="{{ route('teachers.index') }}">O'qituvchilar</a></li>
                    <li><a href="{{ route('posts.index') }}">Yangiliklar</a></li>
                    <li><a href="{{ route('chats.index') }}">Chatlar</a></li>
                </ul>
            </li>
        </ul>
      </nav>
      
    </aside>
    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
      <!-- ========== header start ========== -->
      <header class="header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
              <div class="header-left d-flex align-items-center">
                <div class="menu-toggle-btn mr-15">
                  <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                    <i class="lni lni-chevron-left me-2"></i> @lang('words.menu')
                  </button>
                </div>
              </div>
            </div>
            @php
                $notifications = auth()->user()->unreadNotifications; // Faqat o'qilmagan xabarlarni olish
            @endphp
            <div class="col-lg-7 col-md-7 col-6">
              <div class="header-right">
                <!-- notification start -->
                <div class="notification-box ml-15 d-none d-md-flex">
                  <button class="dropdown-toggle" type="button" id="notification" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <a href="" class="text-dark">
                    <i class="fa-solid fa-bell"></i>
                    </a>
                    @if(auth()->user()->unreadNotifications()->count() > 0)
                    <span class="position-absolute rounded translate-middle badge bg-danger px-2 py-2 fs-7"
                        style="top: 20%; left: 95%; width: 30px; height: 22px;">
                        {{ auth()->user()->unreadNotifications()->count() }}
                    </span>
                    @endif
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notification">
                    @if(count($notifications) > 0)
                      @foreach($notifications->take(3) as $notification)
                      <li>
                        <a href="{{ route('notifications.read-and-redirect-to-post', ['notification' => $notification->id]) }}">
                          <div class="content">
                              <span class="text-regular">
                              {{ $notification->data['title_' . app()->getLocale()] ?? 'Sarlavha' }}
                              </span>
                              <p>
                              {{ Str::limit($notification->data['content_'.app()->getLocale()] ?? 'Kontent', 100, '...') }}
                              </p>
                            <span>{{ str_replace(['сония', 'дақиқа', 'аввал', 'соат'], ['soniya', 'daqiqa', 'avval', 'soat'], \Carbon\Carbon::parse($notification->data['created_at'])->diffForHumans()) }}</span>
                          </div>
                        </a>
                      </li>
                      @endforeach
                    @endif
                    <li>
                      <a href="{{ route('notifications.index') }}">Hamma xabarlarni ko'rish</a>
                    </li>
                  </ul>
                </div>
                <!-- notification end -->

                <!-- language start -->
                <div class="notification-box ml-15 d-none d-md-flex">
                  <button class="dropdown-toggle" type="button" id="notification" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fa-solid fa-earth-americas"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notification">
                    <li>
                      <a href="/lang/uz">
                        <div class="image">
                          <img src="{{ asset('temp/images/lead/Uzbekistan.webp') }}" alt="" />
                        </div>
                        <div class="content">
                          <h6>
                            O'zbekcha
                          </h6>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="/lang/en">
                        <div class="image">
                          <img src="{{ asset('temp/images/lead/English.webp') }}" alt="" />
                        </div>
                        <div class="content">
                          <h6>
                            English
                          </h6>
                          
                        </div>
                      </a>
                      <li>
                        <a href="/lang/ru">
                          <div class="image">
                            <img src="{{ asset('temp/images/lead/Russian.png') }}" alt="" />
                          </div>
                          <div class="content">
                            <h6>
                              Русский
                            </h6>
                          </div>
                        </a>
                      </li>
                </div>
                <!-- language end -->
                
                <!-- message start -->
                <!-- <div class="header-message-box ml-15 d-none d-md-flex">
                  <button class="dropdown-toggle" type="button" id="message" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M7.74866 5.97421C7.91444 5.96367 8.08162 5.95833 8.25005 5.95833C12.5532 5.95833 16.0417 9.4468 16.0417 13.75C16.0417 13.9184 16.0364 14.0856 16.0259 14.2514C16.3246 14.138 16.6127 14.003 16.8883 13.8482L19.2306 14.629C19.7858 14.8141 20.3141 14.2858 20.129 13.7306L19.3482 11.3882C19.8694 10.4604 20.1667 9.38996 20.1667 8.25C20.1667 4.70617 17.2939 1.83333 13.75 1.83333C11.0077 1.83333 8.66702 3.55376 7.74866 5.97421Z"
                        fill="" />
                      <path
                        d="M14.6667 13.75C14.6667 17.2938 11.7939 20.1667 8.25004 20.1667C7.11011 20.1667 6.03962 19.8694 5.11182 19.3482L2.76946 20.129C2.21421 20.3141 1.68597 19.7858 1.87105 19.2306L2.65184 16.8882C2.13062 15.9604 1.83338 14.89 1.83338 13.75C1.83338 10.2062 4.70622 7.33333 8.25004 7.33333C11.7939 7.33333 14.6667 10.2062 14.6667 13.75ZM5.95838 13.75C5.95838 13.2437 5.54797 12.8333 5.04171 12.8333C4.53545 12.8333 4.12504 13.2437 4.12504 13.75C4.12504 14.2563 4.53545 14.6667 5.04171 14.6667C5.54797 14.6667 5.95838 14.2563 5.95838 13.75ZM9.16671 13.75C9.16671 13.2437 8.7563 12.8333 8.25004 12.8333C7.74379 12.8333 7.33338 13.2437 7.33338 13.75C7.33338 14.2563 7.74379 14.6667 8.25004 14.6667C8.7563 14.6667 9.16671 14.2563 9.16671 13.75ZM11.4584 14.6667C11.9647 14.6667 12.375 14.2563 12.375 13.75C12.375 13.2437 11.9647 12.8333 11.4584 12.8333C10.9521 12.8333 10.5417 13.2437 10.5417 13.75C10.5417 14.2563 10.9521 14.6667 11.4584 14.6667Z"
                        fill="" />
                    </svg>
                    <span></span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="message">
                    <li>
                      <a href="#0">
                        <div class="image">
                          <img src="assets/images/lead/lead-5.png" alt="" />
                        </div>
                        <div class="content">
                          <h6>Jacob Jones</h6>
                          <p>Hey!I can across your profile and ...</p>
                          <span>10 mins ago</span>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#0">
                        <div class="image">
                          <img src="assets/images/lead/lead-3.png" alt="" />
                        </div>
                        <div class="content">
                          <h6>John Doe</h6>
                          <p>Would you mind please checking out</p>
                          <span>12 mins ago</span>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#0">
                        <div class="image">
                          <img src="assets/images/lead/lead-2.png" alt="" />
                        </div>
                        <div class="content">
                          <h6>Anee Lee</h6>
                          <p>Hey! are you available for freelance?</p>
                          <span>1h ago</span>
                        </div>
                      </a>
                    </li>
                  </ul>
                </div> -->
                <!-- message end -->
                <!-- profile start -->
                @auth
                <div class="profile-box ml-15">
                  <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-info">
                      <div class="info">
                        <div class="image">
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="" style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover;">
                        </div>
                        <div>
                        @php
                            function getInitial($word) {
                                $doubleLetters = ['Sh', 'Ch', 'G\'', 'O\''];
                                $start = mb_substr($word, 0, 2); // 2 ta harf olib tekshiramiz
                                if (in_array(ucfirst($start), $doubleLetters)) {
                                    return strtoupper($start) . '.';
                                }
                                return strtoupper(mb_substr($word, 0, 1)) . '.';
                            }
                        @endphp

                        <h6 class="fw-500">
                            {{ strtoupper(auth()->user()->last_name) }}
                            {{ getInitial(auth()->user()->middle_name) }}
                            {{ getInitial(auth()->user()->name) }}
                        </h6>
                          @foreach(Auth::user()->roles as $role)
                            <p>{{ ucfirst($role->name) }}</p>
                          @endforeach
                        </div>
                      </div>
                    </div>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                    <li>
                      <div class="author-info flex items-center !p-1">
                        <div class="image">
                          <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="image">
                        </div>
                        <div class="content">
                          <h4 class="text-sm"> 
                          {{ strtoupper(auth()->user()->last_name) }}
                          {{ getInitial(auth()->user()->middle_name) }}
                          {{ getInitial(auth()->user()->name) }}
                           </h4>
                          <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs" href="#">{{ auth()->user()->email }}</a>
                        </div>
                      </div>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <a href="{{ route('profil.index') }}">
                        <i class="lni lni-user"></i> Profilni korish
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('notifications.index') }}">
                        <i class="lni lni-alarm"></i> Bildirishnomalar
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('personal.data') }}"> <i class="fa-solid fa-file-invoice"></i> @lang('words.person.info') </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                    <form action="{{ route('logout') }}" method="POST">
                          @csrf
                          <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                              <i class="lni lni-exit"></i> Chiqish
                          </button>
                      </form>
                    </li>
                  </ul>
                </div>
                @else
                <div class="exit ps-3">
                  <a href="{{ route('login') }}" class="btn btn-primary d-flex align-items-center">Kirish</a>
                </div>
                @endauth
                <!-- profile end -->
              </div>
            </div>
          </div>
        </div>
      </header>


      {{ $slot }}


    </main>
    <!-- ======== main-wrapper end =========== -->
    


    <!-- ========= All Javascript files linkup ======== -->
    <script src="{{ asset('temp/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('temp/js/Chart.min.js') }}"></script>
    <script src="{{ asset('temp/js/dynamic-pie-chart.js') }}"></script>
    <script src="{{ asset('temp/js/moment.min.js') }}"></script>
    <script src="{{ asset('temp/js/fullcalendar.js') }}"></script>
    <script src="{{ asset('temp/js/jvectormap.min.js') }}"></script>
    <script src="{{ asset('temp/js/world-merc.js') }}"></script>
    <script src="{{ asset('temp/js/polyfill.js') }}"></script>
    <script src="{{ asset('temp/js/main.js') }}"></script>

    <!--show.blade.php script -->

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @stack('scripts')

  </body>
</html>
