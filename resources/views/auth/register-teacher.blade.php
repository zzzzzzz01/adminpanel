<x-layout.app>

<x-slot:title>
    Teachers yaratish
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


<div class="container">
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <div class="title">
                    <h2>O'qituvchini ro'yxatdan o'tkazish</h2>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center py-2">
        <div class="col-6">
            <div class="signin-wrapper">
                <div class="form-wrapper ">
                    <form action="{{ route('registerTeacher.store') }}" id="teacherForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label for="exampleInputEmail1" class="form-label"> @lang('words.name') </label>
                            <input type="text" name="name" class="form-control bg-light px-3 border border-primary-subtle" placeholder="@lang('words.name')">
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="input-style-1">
                        <label for="exampleInputEmail1" class="form-label"> @lang('words.last.name') </label>
                            <input type="text" name="last_name" class="form-control bg-light px-3 border border-primary-subtle" placeholder="@lang('words.last.name')">
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="input-style-1">
                        <label for="exampleInputEmail1" class="form-label"> @lang('words.middle.name') </label>
                            <input type="text" name="middle_name" class="form-control bg-light px-3 border border-primary-subtle" placeholder="@lang('words.middle.name')">
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label for="exampleInputEmail1" class="form-label"> @lang('words.image')  </label>
                            <input type="file" name="photo" class="form-control bg-light px-3 border border-primary-subtle" id="inputGroupFile02">
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
                            <label for="exampleInputEmail1" class="form-label"> @lang('words.specialization')  </label>
                            <input type="text" name="specialization" class="form-control bg-light px-3 border border-primary-subtle" placeholder="@lang('words.specialization')">
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label for="exampleInputPassword1" class="form-label"> @lang('words.education.level') </label>
                            <input type="text" name="degree" class="form-control bg-light px-3 border border-primary-subtle" placeholder="@lang('words.education.level')">
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label for="exampleInputPassword1" class="form-label"> @lang('words.work.experience') </label>
                            <input type="number" name="experience" class="form-control bg-light px-3 border border-primary-subtle" placeholder="@lang('words.work.experience')">
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
                            <label for="exampleInputPassword1" class="form-label h-100"> @lang('words.about.me') </label>
                            <div class="col-12">
                                <textarea class="form-control bg-light px-4 py-3 border-primary-subtle " id="description" name="description" rows="4" placeholder="@lang('words.about.me')"></textarea>
                            </div>
                        </div>
                    </div>
        
                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label for="exampleInputPassword1" class="form-label"> @lang('words.certificates') </label>
                            <input type="text" name="certificate" class="form-control bg-light px-3 border border-primary-subtle" placeholder="@lang('words.certificates')">
                        </div>
                    </div>
                    
                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label for="exampleInputPassword1" class="form-label"> @lang('words.personal.website') </label>
                            <input type="text" name="social_links" class="form-control bg-light px-3 border border-primary-subtle" placeholder="@lang('words.personal.website')">
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label for="exampleInputPassword1" class="form-label"> @lang('words.email') </label>
                            <input type="email" name="email" class="form-control bg-light px-3 border border-primary-subtle" placeholder="@lang('words.email')">
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label> @lang('words.password') </label>
                            <input type="password" class="form-control bg-light px-3 border border-primary-subtle" name="password" placeholder="@lang('words.password')" />
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label> @lang('words.password.confirm') </label>
                            <input type="password" class="form-control bg-light px-3 border border-primary-subtle" name="password_confirmation" placeholder=" @lang('words.password.confirm') " />
                        </div>
                    </div>
        
                    <a href="{{ route('teachers.index') }}"class="btn btn-primary"> @lang('words.back') </a>
                    <button type="submit" class="btn btn-success"> @lang('words.submit') </button>
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

          document.getElementById("teacherForm").addEventListener("submit", function (e) {
            if (!validatePhone()) {
              e.preventDefault();
            }
          });
        </script>
    @endpush
@endonce



</x-layout.app>