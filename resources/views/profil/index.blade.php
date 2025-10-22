<x-layout.app>

<x-slot:title>
  Yangiliklar
</x-slot:title>


<style>
        .profile-image {
            width: 120px;
            height: 150px;
            border: 2px dashed #ccc;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center mt-5">
    <div class="w-100" style="max-width: 1100px;">
        <h4 class="mb-4"> @lang('words.my.profile') </h4>
        <form>
            <div class="row ">
                <div class="col-lg-8 col-md-8 ">
                    <div class="card-style mb-30 d-flex justify-content-between flex-wrap w-100 gap-5 ">
                        <div class="flex-grow-1" style="min-width: 300px; max-width: 700px;">
                            <div class="mb-3">
                                <label class="form-label"> @lang('words.name') </label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"> @lang('words.email') </label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                            </div>
                            <a href="{{ route('home.page') }}" class="btn btn-primary"> @lang('words.back') </a>
                            <a href="{{ route('profil.changePasswordForm') }}" class="btn btn-success"> @lang('words.change.password') </a>
                        </div>
                        
                        <div class="card-right">
                            <div class="col-md-4 text-center">
                                <label class="form-label"> @lang('words.image') </label><br>
                                <img src="{{ asset('storage/'. $user->photo) }}" alt="" class="profile-image"  style="width: 200px; height: 250px;"  >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
    
    
@if(session('success'))
    <div class="alert alert-success position-fixed bottom-0 end-0 p-3">
        {{ session('success') }}
    </div>
@endif
    

    




</x-layout.app>