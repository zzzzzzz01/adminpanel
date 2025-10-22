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


<a href="{{ route('groups.show', $group->id) }}" class="btn btn-primary ms-4 mt-4"> @lang('words.back') </a>


<div class="container">
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <div class="title">                    
                    <h2> @lang('words.student.edit.info') </h2>                    
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center py-2">
        <div class="col-lg-6 ">
            <div class="signin-wrapper border border-primary-subtle">
                <div class="form-wrapper">
                    <form action="{{ route('student.update', $user) }}" id="studentForm" method="POST" enctype="multipart/form-data">
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
                                <label for="exampleInputEmail1" class="form-label"> @lang('words.image') </label>
                                <input type="file" name="photo" class="form-control bg-light px-3 border border-primary-subtle" style="height: 55px;" id="inputGroupFile02">
                                <img class="img-fluid rounded pt-1" src="{{ asset('storage/'. $user->photo) }}" alt="" width="200">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-style-1">
                            <label> @lang('words.select.payment') </label>
                                <select class="form-select px-3 border border-primary-subtle" name="payment" aria-label="Default select example">
                                    <option  selected>{{ $user->payment->{'name_'.app()->getLocale()}  }}</option>
                                    @foreach($payments as $payment)
                                        @if($payment->id !== $user->payment_id)
                                            <option value="{{ $payment->id }}">
                                                {{ $payment->{'name_'.app()->getLocale()} }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-style-1">
                                <label> @lang('words.student.address') </label>
                                <input type="text" class="form-control px-3 border border-primary-subtle" name="address" placeholder="{{ $user->address ?? '--' }}">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="input-style-1">
                                <label> @lang('words.birth.day') </label>
                                @if($user->birth_date)
                                <input type="date" class="form-control bg-light px-3 border border-primary-subtle" value="{{ date('Y-m-d', strtotime($user->birth_date)) }}" id="birth_date" name="birth_date">
                                @else
                                <input type="date" class="form-control bg-light px-3 border border-primary-subtle" id="birth_date" name="birth_date">
                                @endif
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

          document.getElementById("studentForm").addEventListener("submit", function (e) {
            if (!validatePhone()) {
              e.preventDefault();
            }
          });
        </script>
    @endpush
@endonce



</x-layout.app>