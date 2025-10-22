<x-layout.app>

<x-slot:title>
    Teachers
</x-slot:title>




<!-- ========= card-style-4 start ========= -->
            <div class="container">
              <div class="row">                
                <div class="col-6">
                  <div class="title mt-30 mb-30">                       
                    <h2> @lang('words.teachers') </h2>
                  </div>
                </div>

                <div class="col-6">
                  <div class="title mt-30 mb-30">                       
                  @if(auth()->user()->hasRole('admin'))
                  <a href="{{ route('register.teacher') }}" class="btn btn-success" > @lang('words.add.teacher') </a>
                  @endif
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-4">
                    <form action="{{ route('teacher.search') }}" method="GET">
                      <div class="input-group">
                        <input type="text" name="q" class="form-control p-3 border border-primary-subtle" placeholder="@lang('words.keyword')">
                        <button class="btn btn-primary px-4"><i class="fa-solid fa-magnifying-glass"></i></button>
                      </div>
                    </form>
                  </div>
                </div>

                @if(isset($message))
                    <div class="container my-3"> {{-- konteyner ichida --}}
                        <div class="alert alert-info w-100 text-center">
                            {{ $message }}
                        </div>
                    </div>
                @endif


                

                <!-- end col -->
                @foreach($users as $user)
                <div class="col-xl-3 col-lg-3 col-md-6">
                  <div class="card-style-4 mb-30">
                    <div class="card-image" style="height: 250px; " >
                      <a href="#0" >
                        <img src="{{ asset('storage/'. $user->photo) }}"  alt=""/>
                      </a>
                    </div>
                    <div class="card-content">
                      <a href="{{ route('teachers.show', $user) }}">
                        <h4 class="pb-2">{{ $user->last_name }}. {{ $user->name }}. {{ $user->middle_name }}.</h4>
                      </a>
                      <p> @lang('words.specialization') : {{ $user->specialization ?? '--' }}</p>

                      @if(auth()->user()->hasRole('admin'))
                      <a href="{{ route('teachers.show', $user) }}" class="read-more"></a>

                      <!-- Example single danger button -->
                      <div class="btn-group pt-2">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                          <ul class="dropdown-menu">
                              <li>
                                  <a class="dropdown-item text-dark" href="{{ route('teacher.edit', $user) }}" style="color: black;"> @lang('words.change') </a>
                              </li>
                              <li>
                                  <form action="{{ route('teacher.destroy', $user) }}" method="POST" enctype="multipart/form-data">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="dropdown-item text-dark" data-bs-toggle="modal"> @lang('words.delete') </button>
                                  </form>
                              </li>
                          </ul>
                      </div>
                      @endif
                    </div>
                  </div>                  
                </div>
                @endforeach
              </div>
              
            </div>
            <!-- end row -->
            <!-- ========= card-style-4 end ========= -->

            @if(session('trash'))
            <div class="alert alert-danger  position-fixed bottom-0 end-0 p-3" style="background-color: #B22222; color: white;">
              {{ session('trash') }}
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success  position-fixed bottom-0 end-0 p-3" style="background-color: #5cb85c; color: white;">
              {{ session('success') }}
            </div>  
            @endif  

            @if(session('createSuccess'))
            <div class="alert alert-success  position-fixed bottom-0 end-0 p-3" style="background-color: #5cb85c; color: white;">
              {{ session('createSuccess') }}
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