<x-layout.app>

<x-slot:title>
  Yangiliklar
</x-slot:title>


    <!-- Blog Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">

    <div class="col-lg-6 ps-2">
    <a href="{{ route('home.page') }}" class="btn btn-primary"> @lang('words.back') </a>
    
        <a href="{{ route('posts.create') }}"><button type="button" class="btn btn-success">@lang('words.post.add')</button></a>
    </div>

    @if(isset($message))
        <div class="container my-3"> {{-- konteyner ichida --}}
            <div class="alert alert-info w-100 text-center">
                {{ $message }}
            </div>
        </div>
    @endif

        <div class="container py-5">
            <div class="row g-5">
                <!-- Blog list Start -->
                <div class="col-lg-8">
                    <div class="row g-5">
                    @foreach($posts as $post)
                        <div class="col-md-6 wow slideInUp" data-wow-delay="0.1s">
                            <div class="blog-item bg-light rounded overflow-hidden border border-primary-subtle">
                                <div class="blog-img position-relative overflow-hidden">
                                    <img class="img-fluid" src="{{ asset('storage/'.$post->photo) }}" alt="">
                                    <!-- <a class="position-absolute top-0 start-0 bg-primary text-white rounded-end mt-5 py-2 px-4 " href="">Web Design</a> -->
                                </div>
                                <div class="p-4">
                                    <div class="d-flex mb-3">
                                        <small class="me-3"><i class="far fa-user text-primary me-2"></i>{{ $post->user->name }}</small>
                                        <small><i class="far fa-calendar-alt text-primary me-2"></i> {{ \Carbon\Carbon::parse($post->created_at)->translatedFormat('d F, Y') }} </small>
                                    </div>
                                    <h4 class="mb-3">{{ $post->{'title_' . app()->getLocale()} }}</h4>
                                    <a class="text-uppercase pt-2" href="{{ route('posts.show',['post'=>$post->id]) }}"> @lang('words.read.more')  <i class="fa-solid fa-arrow-right"></i> </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- <div class="col-12 wow slideInUp" data-wow-delay="0.1s">
                            <nav aria-label="Page navigation">
                              <ul class="pagination pagination-lg m-0">
                                <li class="page-item">
                                  <a class="page-link rounded-0" href="#" aria-label="Previous">
                                    <span aria-hidden="true"><i class="fa-solid fa-arrow-left"></i></span>
                                  </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                  <a class="page-link rounded-0" href="#" aria-label="Next">
                                    <span aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span>
                                  </a>
                                </li>
                              </ul>
                            </nav>
                        </div> -->

                        
                    </div>
                </div>
                <!-- Blog list End -->
    
                <!-- Sidebar Start -->
                <div class="col-lg-4">
                    <!-- Search Form Start -->
                    <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                        <form action="{{ route('search') }}" method="GET">
                            @csrf
                        <div class="input-group">
                            <input type="text" name="q" class="form-control p-3 border border-primary-subtle" placeholder="@lang('words.keyword')">
                            <button class="btn btn-primary px-4 "><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                        </form>
                    </div>
                    <!-- Search Form End -->
    
                    <!-- Category Start -->
                    @include('section.categories')
                    <!-- Category End -->
    
                    <!-- Recent Post Start -->
                    @include('section.latestPosts')
                    <!-- Recent Post End -->
    
                    <!-- Image Start -->
                    <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                        <img src="{{ asset('temp/images/blog/blog-1.jpg') }}" alt="" class="img-fluid rounded">
                    </div>
                    <!-- Image End -->

                    <!-- Popular posts start -->
                    @include('section.popularPosts')
                    <!-- Popular posts End -->
    
                    <!-- Tags Start -->
                    @include('section.tags')
                    <!-- Tags End -->
    
                    <!-- Plain Text Start -->
                    <!-- <div class="wow slideInUp" data-wow-delay="0.1s">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="mb-0">Plain Text</h3>
                        </div>
                        <div class="bg-light text-center border border-primary-subtle" style="padding: 30px;">
                            <p>Vero sea et accusam justo dolor accusam lorem consetetur, dolores sit amet sit dolor clita kasd justo, diam accusam no sea ut tempor magna takimata, amet sit et diam dolor ipsum amet diam</p>
                            <a href="" class="btn btn-primary py-2 px-4">Read More</a>
                        </div>
                    </div> -->
                    <!-- Plain Text End -->
                </div>
                <!-- Sidebar End -->
            </div>
        </div>
    </div>
    <!-- Blog End -->

    @if(session('createPost'))
    <div class="alert alert-success position-fixed bottom-0 end-0 p-3 " id="createPost-alert" style="background-color: #5cb85c; color: white;">
        {{ session('createPost') }}
    </div>
    @endif  

    @if(session('deletePost'))
    <div class="alert alert-danger position-fixed bottom-0 end-0 p-3 " id="deletePost-alert" style="background-color: #B22222; color: white;">
        {{ session('deletePost') }}
    </div>
    @endif 
    
    @if(session('createCategory'))
    <div class="alert alert-success position-fixed bottom-0 end-0 p-3 " id="createCategory-alert" style="background-color: #5cb85c; color: white;">
        {{ session('createCategory') }}
    </div>
    @endif 

    @if(session('createTag'))
    <div class="alert alert-success position-fixed bottom-0 end-0 p-3 " id="createTag-alert" style="background-color: #5cb85c; color: white;">
        {{ session('createTag') }}
    </div>
    @endif 
    
    <script>
        // Faqat create va delete alertlar 5 soniyadan so‘ng yo‘qoladi
        setTimeout(function() {
            let createAlert = document.getElementById('createPost-alert');
            if (createAlert) createAlert.remove();

            let deleteAlert = document.getElementById('deletePost-alert');
            if (deleteAlert) deleteAlert.remove();
            
            let createCategory = document.getElementById('createCategory-alert');
            if (createCategory) createCategory.remove();

            let createTag = document.getElementById('createTag-alert');
            if (createTag) createTag.remove();

        }, 5000);
    </script>

    

</x-layout.app>