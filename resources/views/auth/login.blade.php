<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('temp/images/favicon.svg') }}" type="image/x-icon" />
    <title>Kirish</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{ asset('temp/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('temp/css/lineicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('temp/css/materialdesignicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('temp/css/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('temp/css/main.css') }}" />

    <style>
      .lang-dropdown {
        position: absolute;
        top: 15px;
        right: 15px;
      }

      .lang-dropdown img {
        width: 25px;
        height: 18px;
        border-radius: 3px;
        margin-right: 8px;
      }

      .lang-dropdown .dropdown-menu a {
        display: flex;
        align-items: center;
        padding: 8px 12px;
      }

      .lang-dropdown .dropdown-menu h6 {
        margin: 0;
        font-size: 14px;
      }
    </style>
  </head>
  <body>
    <main class="main-wrapper">
      <section class="signin-section">
        <div class="container-fluid" style="padding-left: 200px;">
          <div class="title-wrapper pt-30">
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="title">
                  <h2>@lang('words.authorization')</h2>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="signin-wrapper border border-primary-subtle position-relative">
                
                <!-- 🌐 Til tanlash dropdown -->
                <div class="dropdown lang-dropdown">
                  @php
                      // Hozirgi tilni sessiyadan olamiz (yo‘q bo‘lsa 'uz' bo‘ladi)
                      $locale = session('lang', 'uz');

                      // Tillar ro‘yxati
                      $languages = [
                          'uz' => ['name' => "O'zbekcha", 'flag' => asset('temp/images/lead/Uzbekistan.webp')],
                          'en' => ['name' => 'English', 'flag' => asset('temp/images/lead/English.webp')],
                          'ru' => ['name' => 'Русский', 'flag' => asset('temp/images/lead/Russian.png')],
                      ];
                  @endphp

                  <!-- Tugmada tanlangan til ko‘rsatiladi -->
                  <button class="btn btn-light border dropdown-toggle d-flex align-items-center"
                          type="button" id="langMenu" data-bs-toggle="dropdown" aria-expanded="false">
                      <img src="{{ $languages[$locale]['flag'] }}" alt="{{ $locale }}" width="25" height="18" class="me-2 rounded" />
                      <span>{{ $languages[$locale]['name'] }}</span>
                  </button>

                  <!-- Barcha tillar ro‘yxati -->
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langMenu">
                      @foreach ($languages as $code => $lang)
                          <li>
                              <a href="{{ route('language', $code) }}"
                                class="dropdown-item d-flex align-items-center {{ $locale === $code ? 'active bg-light fw-bold' : '' }}">
                                  <img src="{{ $lang['flag'] }}" alt="{{ $code }}" width="25" height="18" class="me-2 rounded" />
                                  <span>{{ $lang['name'] }}</span>
                              </a>
                          </li>
                      @endforeach
                  </ul>
                </div>
                <!-- 🔚 Til tanlash tugadi -->

                <div class="form-wrapper p-4">
                  @if ($errors->has('email'))
                    <div class="alert alert-danger">
                      {{ $errors->first('email') }}
                    </div>
                  @endif
                  
                  <form action="{{ route('authanticate') }}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-12">
                        <div class="input-style-1">
                          <label for="exampleInputEmail1" class="form-label"> @lang('words.email') </label>
                          <input type="email" name="email" class="form-control bg-light px-3 border border-primary-subtle" placeholder="@lang('words.login')">
                          @error('email')
                            <small class="text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="input-style-1">
                          <label> @lang('words.password') </label>
                          <input type="password" name="password" class="form-control bg-light px-3 border border-primary-subtle" placeholder="@lang('words.password')" />
                          @error('password')
                            <small class="text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="button-group d-flex justify-content-center flex-wrap">
                          <button class="main-btn primary-btn btn-hover w-100 text-center">
                          @lang('words.enter')
                          </button>
                          <button type="button" id="guestLoginBtn" class="main-btn secondary-btn btn-hover w-100 text-center mt-2"> @lang('words.log.guest') </button>
                          
                          <!-- Role tanlash uchun modal -->
                          <div class="modal fade" id="guestModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title"> @lang('words.select.rol') </h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                  <button class="btn btn-outline-primary m-2" onclick="setGuest('admin')"> @lang('words.enter.admin') </button>
                                  <button class="btn btn-outline-success m-2" onclick="setGuest('teacher')"> @lang('words.enter.teacher') </button>
                                  <button class="btn btn-outline-info m-2" onclick="setGuest('student')"> @lang('words.enter.student') </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>
    </main>


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
    
    <script>
      document.addEventListener('DOMContentLoaded', function() {

          function setLang(lang) {
              fetch(`/lang/${lang}`)
                  .then(() => window.location.reload());
          }

          const guestBtn = document.getElementById('guestLoginBtn');
          if (guestBtn) {
              guestBtn.addEventListener('click', function() {
                  var myModal = new bootstrap.Modal(document.getElementById('guestModal'));
                  myModal.show();
              });
          }

          window.setGuest = function(role) {
              let emailInput = document.querySelector('input[name="email"]');
              let passwordInput = document.querySelector('input[name="password"]');

              if (role === 'admin') {
                  emailInput.value = 'admin@gmail.com';
                  passwordInput.value = 'admin';
              } else if (role === 'teacher') {
                  emailInput.value = 'teacher@gmail.com';
                  passwordInput.value = 'teacher';
              } else if (role === 'student') {
                  emailInput.value = 'student@gmail.com';
                  passwordInput.value = 'student';
              }

              var modal = bootstrap.Modal.getInstance(document.getElementById('guestModal'));
              modal.hide();
          }
      });
    </script>

  </body>
</html>
