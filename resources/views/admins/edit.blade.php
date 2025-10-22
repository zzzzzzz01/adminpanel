<x-layout.app>

<x-slot:title>
    Register admin
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
                    <a href="{{ route('all.admins') }}" class="text-decoration-none">
                      @lang('words.admin.list')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                    {{ $user->last_name }}. {{ $user->name }}
                    </a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page">
                    Mavzular
                </li> -->
            </ol>
        </nav>
    </div>

<div class="container">
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <div class="title">                    
                    <h2> @lang('words.change.admin') </h2>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center py-2">
        <div class="col-lg-6 ">
            <div class="signin-wrapper border border-primary-subtle">
                <div class="form-wrapper">
                    <form action="{{ route('admin.update', $user) }}" id="teacherForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-lg-12">
                            <div class="input-style-1">
                                <label> @lang('words.name') </label>
                                <input type="text" name="name" class="form-control bg-light px-3 border border-primary-subtle" placeholder="{{ $user->name ?? '--' }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-style-1">
                                <label> @lang('words.last.name') </label>
                                <input type="text" name="last_name" class="form-control bg-light px-3 border border-primary-subtle" placeholder="{{ $user->last_name ?? '--' }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-style-1">
                                <label> @lang('words.middle.name') </label>
                                <input type="text" name="middle_name" class="form-control bg-light px-3 border border-primary-subtle" placeholder="{{ $user->middle_name ?? '--' }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-style-1">
                                <label for="exampleInputEmail1" class="form-label"> @lang('words.image')  </label>
                                <input type="file" name="photo" class="form-control bg-light px-3 border border-primary-subtle" style="height: 55px;" id="inputGroupFile02">
                                <img class="img-fluid rounded pt-1" src="{{ asset('storage/'. $user->photo) }}" alt="" width="200">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-style-1">
                                <label> @lang('words.phone.number') </label>
                                <input type="number" name="phone" class="form-control bg-light px-3 border border-primary-subtle" placeholder="{{ $user->phone ?? '--' }}">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="input-style-1">
                                <label>@lang('words.phone.number')</label>
                                <input type="tel" id="phone" class="form-control bg-light px-3 border border-primary-subtle" value="{{ $user->phone ?? '--' }}" required>

                                <!-- Yashirin inputlar Laravelga yuboriladi -->
                                <input type="hidden" name="phone" id="formatted_phone">
                                <input type="hidden" name="country_code" id="country_code">
                                
                                <div class="text-danger mt-1" id="error-msg" style="display: none;">@lang('words.phone.invalid')</div>
                            </div>
                        </div>
                        <a href="{{ route('all.admins') }}" class="btn btn-primary"> @lang('words.back') </a>
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