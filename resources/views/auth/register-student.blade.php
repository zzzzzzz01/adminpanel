<x-layout.app>

<x-slot:title>
  Talabalar royhati
</x-slot:title>

@once
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">
        <style>
            #phone {
                padding-left: 100px !important; /* Bayroq uchun joy */
            }
        </style>

    @endpush
@endonce


<style>    
        .breadcrumb {
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px 20px;
            margin-bottom: 20px;
        }
        .breadcrumb-item a {
            color: #495057;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .breadcrumb-item a:hover {
            color: #0d6efd;
        }
        .breadcrumb-item.active {
            color: #6c757d;
            font-weight: 600;
        }
        .breadcrumb-item + .breadcrumb-item::before {
            color: #6c757d;
            font-weight: bold;
        }
    </style>



    <!-- Breadcrumb -->
    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home.page') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> Asosiy
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('show.groups.students', $group->id) }}"  class="text-decoration-none">
                        Talabalar ro'yxati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ $group->group_name }}
                    </a>
                </li>
            </ol>
        </nav>
    </div>




<div class="container">
  <div class="title-wrapper pt-30">
    <div class="row align-items-center">
      <div class="col-md-12 text-center">
        <div class="title">
          <h2> @lang('words.student.create') </h2>
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center py-2">
    <div class="col-lg-6">
      <div class="signin-wrapper">
        <div class="form-wrapper">
          <form action="{{ route('registerStudent.store') }}" id="studentForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
            
              <div class="col-lg-12">
                <div class="input-style-1">
                  <label> @lang('words.name') </label>
                  <input type="text" class="form-control bg-light px-3 border border-primary-subtle" name="name" placeholder="@lang('words.name')" />
                </div>
              </div>

              <div class="col-lg-12">
                <div class="input-style-1">
                  <label> @lang('words.last.name') </label>
                  <input type="text" class="form-control bg-light px-3 border border-primary-subtle" name="last_name" placeholder=" @lang('words.last.name') " />
                </div>
              </div>


              <div class="col-lg-12">
                <div class="input-style-1">
                  <label> @lang('words.middle.name') </label>
                  <input type="text" class="form-control bg-light px-3 border border-primary-subtle" name="middle_name" placeholder=" @lang('words.middle.name') " />
                </div>
              </div>


              <div class="col-lg-12">
                <div class="input-style-1">
                  <label> @lang('words.image') </label>
                  <input type="file" name="photo" class="form-control bg-light px-3 border border-primary-subtle" placeholder="Sarlavha" style="height: 55px;">
                </div>
              </div>

              <div class="col-lg-12">
                <div class="input-style-1">
                  <label> @lang('words.birth.day') </label>
                  <input type="date" class="form-control bg-light px-3 border border-primary-subtle" id="birth_date" name="birth_date">
                </div>
              </div>
              
              <div class="col-lg-12">
                <div class="input-style-1">
                    <label>@lang('words.phone.number')</label>
                    <input type="tel" id="phone" class="form-control bg-light px-3 border border-primary-subtle" required>

                    <!-- Yashirin inputlar Laravelga yuboriladi -->
                    <input type="hidden" name="phone" id="formatted_phone">
                    <input type="hidden" name="country_code" id="country_code">
                    
                    <div class="text-danger mt-1" id="error-msg" style="display: none;">@lang('words.phone.invalid')</div>
                </div>
            </div>

              <div class="col-lg-12">
                <div class="input-style-1">
                  <label clas="form-label"> @lang('words.group') </label>
                    <select class="form-control border-primary-subtle px-3 p-2" name="group_id" aria-label="Default select example">
                    <option disabled selected> @lang('words.choose.course') ...</option>
                    @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>


              <div class="col-lg-12">
                <div class="input-style-1">
                  <label> @lang('words.payment') </label>
                    <select class="form-select px-3 border border-primary-subtle" name="payment_id" aria-label="Default select example">
                      <option disabled selected> @lang('words.select.payment') ...</option>
                      @foreach($payments as $payment)
                      <option value="{{ $payment->id }}"> {{ $payment->{'name_'. app()->getLocale()} }} </option>
                      @endforeach
                    </select>
                </div>
              </div>

              <div class="col-lg-12">
                <div class="input-style-1">
                  <label> @lang('words.student.address') </label>
                  <input type="text" class="form-control px-3 border border-primary-subtle" name="address" placeholder=" @lang('words.address') ">
                </div>
              </div>

              <div class="col-lg-12">
                <div class="input-style-1">
                  <label> @lang('words.email') </label>
                  <input type="email" class="form-control px-3 border border-primary-subtle" name="email" placeholder="@lang('words.email')" />
                </div>
              </div>
              
              <div class="col-lg-12">
                <div class="input-style-1">
                  <label> @lang('words.password') </label>
                  <input type="password" class="form-control bg-light px-3 border border-primary-subtle" name="password" placeholder=" @lang('words.password') " />
                </div>
              </div>

              <div class="col-lg-12">
                <div class="input-style-1">
                  <label> @lang('words.password.confirm') </label>
                  <input type="password" class="form-control bg-light px-3 border border-primary-subtle" name="password_confirmation" placeholder=" @lang('words.password.confirm') " />
                </div>
              </div>

              <!-- <div class="col-xxl-12 col-lg-12 col-md-6">
                <div class="form-check checkbox-style mb-30">
                  <input class="form-check-input" type="checkbox" value="" id="checkbox-remember" />
                  <label class="form-check-label" for="checkbox-remember">
                    Eslab qolish
                  </label>
                </div>
              </div> -->
              <div class="col-lg-12">
                <div class="button-group d-flex justify-content-center flex-wrap">
                  <button class="main-btn primary-btn btn-hover w-100 text-center">
                    @lang('words.sign.up')
                  </button>
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



@once

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" />
    @endpush

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>

        <script>
          const phoneInput = document.querySelector("#phone");
          const errorMsg = document.querySelector("#error-msg");

          const iti = window.intlTelInput(phoneInput, {
            initialCountry: "auto",
            preferredCountries: ["uz", "us", "ru"],
            separateDialCode: true,
            geoIpLookup: function (callback) {
              fetch("https://ipinfo.io?token=fba11d31c212b7")
                .then(response => response.json())
                .then(data => callback(data.country))
                .catch(() => callback("uz"));
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
          });

          function validatePhone() {
            if (iti.isValidNumber()) {
              document.getElementById("formatted_phone").value = iti.getNumber(); // E.164
              document.getElementById("country_code").value = iti.getSelectedCountryData().iso2;
              errorMsg.style.display = "none";
              return true;
            } else {
              errorMsg.style.display = "block";
              return false;
            }
          }

          document.getElementById("studentForm").addEventListener("submit", function (e) {
            if (!validatePhone()) {
              e.preventDefault();
            }
          });
        </script>
    @endpush
@endonce



</x-layout.app>