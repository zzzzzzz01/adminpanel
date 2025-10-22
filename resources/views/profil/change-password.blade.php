<x-layout.app>

<x-slot:title>
  Yangiliklar
</x-slot:title>



<a href="{{ route('profil.index') }}"><button type="submit" class="btn btn-primary mt-5 ms-5 "> @lang('words.back') </button></a>

<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-8">
            <div class="card-style position-absolute top-50 start-50 translate-middle w-50">
                 <form action="{{ route('profil.changePassword') }}" method="POST">
                    @csrf

                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ implode('', $errors->all(':message')) }}
                        </div>
                    @endif

                    <div class="mb-3 row">
                        <label for="current_password" class="col-sm-4 col-form-label">@lang('words.current.password')</label>
                        <div class="col-sm-8 input-container">
                            <input type="password" name="current_password" class="form-control" id="current_password" placeholder="@lang('words.current.password')" required>
                            <i class="fa-solid fa-eye eye-icon pe-2" id="toggleCurrentPassword"></i>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="new_password" class="col-sm-4 col-form-label">@lang('words.new.password')</label>
                        <div class="col-sm-8 input-container">
                            <input type="password" name="new_password" class="form-control" id="new_password" placeholder="@lang('words.new.password')" required>
                            <i class="fa-solid fa-eye eye-icon pe-2" id="toggleNewPassword"></i>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="new_password_confirmation" class="col-sm-4 col-form-label">@lang('words.new.password.confirm')</label>
                        <div class="col-sm-8 input-container">
                            <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" placeholder="@lang('words.new.password.confirm')" required>
                            <i class="fa-solid fa-eye eye-icon pe-2" id="toggleConfirmPassword"></i>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-success">@lang('words.submit')</button>
                        </div>
                    </div>
                </form>

                <script>
                    const toggleCurrentPassword = document.getElementById('toggleCurrentPassword');
                    const currentPasswordInput = document.getElementById('current_password');
                    
                    const toggleNewPassword = document.getElementById('toggleNewPassword');
                    const newPasswordInput = document.getElementById('new_password');
                    
                    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
                    const confirmPasswordInput = document.getElementById('new_password_confirmation');

                    [toggleCurrentPassword, toggleNewPassword, toggleConfirmPassword].forEach((toggle, index) => {
                        toggle.addEventListener('click', function () {
                            const input = [currentPasswordInput, newPasswordInput, confirmPasswordInput][index];
                            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                            input.setAttribute('type', type);
                            this.classList.toggle('fa-eye-slash');
                            this.classList.toggle('fa-eye');
                        });
                    });
                </script>

                <style>
                    .input-container {
                        position: relative;
                    }
                    .input-container input {
                        padding-right: 40px; /* Ikonani joylashtirish uchun joy qoldiradi */
                    }
                    .eye-icon {
                        position: absolute;
                        top: 50%;
                        right: 10px;
                        transform: translateY(-50%);
                        cursor: pointer;
                    }
                </style>

                <style>
                    .input-container {
                        position: relative;
                    }
                    .input-container input {
                        padding-right: 40px; /* Ikonani joylashtirish uchun joy qoldiradi */
                    }
                    .eye-icon {
                        position: absolute;
                        top: 50%;
                        right: 10px;
                        transform: translateY(-50%);
                        cursor: pointer;
                    }
                </style>
            </div>
        </div>
    </div>
</div>














</x-layout.app>