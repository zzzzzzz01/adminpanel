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
                    <a href="{{ route('all.admins') }}"  class="text-decoration-none">
                        Adminlar ro'yxati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Admin yaratish
                    </a>
                </li>
            </ol>
        </nav>
    </div>








<div class="container">
    <div class="row g-5 min-vh-100 d-flex justify-content-center align-items-center">
        <div class="col-lg-8">
            <div class="card shadow-lg rounded-4 p-4 border-0 bg-white">
                <h4 class="mb-4 text-center fw-bold">Admin Yaratish</h4>

                <form action="{{ route('registerAdmin.store') }}" id="adminForm" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"> @lang('words.name') </label>
                            <input type="text" class="form-control" id="group_name" name="name" placeholder="@lang('words.name')">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"> @lang('words.last.name') </label>
                            <input type="text" name="last_name" class="form-control" placeholder=" @lang('words.last.name') ">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"> @lang('words.middle.name') </label>
                            <input type="text" class="form-control" id="group_name" name="middle_name" placeholder="@lang('words.middle.name')">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"> @lang('words.image') </label>
                            <input type="file" name="photo" class="form-control" placeholder=" @lang('words.image') ">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"> @lang('words.phone.number') </label>
                            <input type="tel" class="form-control" id="phone" required>

                            <!-- Yashirin inputlar Laravelga yuboriladi -->
                            <input type="hidden" name="phone" id="formatted_phone">
                            <input type="hidden" name="country_code" id="country_code">

                            <div class="text-danger mt-1" id="error-msg" style="display: none;">@lang('words.phone.invalid')</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"> @lang('words.email') </label>
                            <input type="email" name="email" class="form-control" placeholder=" @lang('words.email') ">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"> @lang('words.password') </label>
                            <input type="password" class="form-control" id="group_name" name="password" placeholder="@lang('words.password')">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"> @lang('words.password.confirm') </label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder=" @lang('words.password.confirm') ">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success"> @lang('words.submit') </button>
                </form>
            </div>
        </div>
    </div>
</div>

                    

















@once
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

          document.getElementById("adminForm").addEventListener("submit", function (e) {
            if (!validatePhone()) {
              e.preventDefault();
            }
          });
        </script>
    @endpush
@endonce




</x-layout.app>