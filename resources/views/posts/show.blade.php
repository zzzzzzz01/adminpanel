<x-layout.app>

<x-slot:title>
  Yangiliklar
</x-slot:title>

    <!-- Blog Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-4">
                    <a href="{{ route('posts.index') }}" class="btn btn-success">@lang('words.back')</a>
                </div>

                @if(auth()->user()->hasRole('admin'))
                <div class="col-2 d-flex">
                    <form action="{{ route('posts.destroy',['post'=>$post->id]) }}" method="POST" >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">@lang('words.delete')</button>
                    </form>
                </div>
                @endif

                <div class="col-2">
                @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('posts.edit',['post'=>$post->id]) }}" class="btn btn-warning">@lang('words.change')</a>
                @endif
                </div>
                
                <div class="col-lg-8">
                <div class="first d-flex  mt-3 mb-3">
                    <p class="pe-2">{{ $post->user->name }} | {{ $post->created_at->format('H:i') }}</p>
                    <p><i class="fa-solid fa-eye"></i> {{ $post->views }}</p>
                </div>


                    <!-- <h3 class="pb-2">@lang('words.views'): {{ $post->views }} @lang('words.views.times') /{{ $post->created_at->format('Y-m-d'." / ".'H:i') }}</h3> -->
                    <!-- Blog Detail Start -->
                    <div class="mb-5">
                        <h1 class="mb-4">{{ $post->{'title_' . app()->getLocale()} }}</h1>
                        <span>{{ $post->{'content_' . app()->getLocale()} }}</span>
                        <img class="img-fluid w-100 rounded mt-2 mb-2" src="{{ asset('storage/'.$post->photo) }}" alt="">
                        {!! str_replace('<img', '<img class="img-fluid w-100 rounded mb-5"', $post->{'description_' . app()->getLocale()}) !!}

                        <div class="tags pt-5">
                            @foreach($post->tags as $tag)
                            <a href="{{ route('tag.posts', $tag->slug) }}" class="btn btn-outline-primary  border border-primary-subtle text-black">{{ $tag->{'name_'.app()->getLocale()} }}</a>
                            @endforeach
                        </div>
                        
                    </div>
                    <!-- Blog Detail End -->
    
                    <!-- Comment List Start -->
                    <div class="mb-5">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="mb-0">@lang('words.comment.number') ({{ $post->comments()->count() }}) @lang('words.ta')</h3>
                        </div>
                        @foreach($post->comments as $comment)
                        <div class="d-flex mb-4">
                            <img src="{{ asset('storage/'. $comment->user->photo) }}" class="img-fluid rounded border border-primary-subtle" style="width: 45px; height: 45px;">
                            <div class="ps-3">
                            <h6>
                                @if($comment->user->hasRole('teacher'))
                                    <a href="{{ route('teachers.show', $comment->user->id) }}" class="text-primary">
                                        {{ $comment->user->name }}
                                    </a>
                                @else
                                    {{ $comment->user->name }}
                                @endif
                                <small><i> | {{ $comment->created_at->locale(app()->getLocale())->translatedFormat('d F Y') }}</i></small>
                            </h6>
                                <div class="commentandchange d-flex">
                                    <p>{{ $comment->message }}</p>
                                    @if(auth()->user()->id === $comment->user->id)
                                        <!-- <a href="" class="text-success ps-2"><i class="fa-solid fa-repeat"></i></a> -->
                                        <form action="{{ route('comments.destroy',['comment'=>$comment->id]) }}" method="POST">
                                            @csrf 
                                            @method('DELETE')
                                            <button class="text-danger ps-2 border-0"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    @endif
                                </div>
                                <!-- <button class="btn btn-sm btn-light">Reply</button> -->
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- Comment List End -->
    
                    <!-- Comment Form Start -->
                    <div class="bg-light rounded p-5">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="mb-0">@lang('words.leave.comment')</h3>
                        </div>
                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <textarea class="form-control bg-white border-primary-subtle" name="message" rows="5" placeholder="@lang('words.leave.comment')"></textarea>
                                </div>
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">@lang('words.sending')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Comment Form End -->
                </div>
    
                <!-- Sidebar Start -->
                <div class="col-lg-4">
                    <!-- Search Form Start -->
                    <div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
                        <div class="input-group">
                            <input type="text" class="form-control p-3 border border-primary-subtle" placeholder="Keyword">
                            <button class="btn btn-primary px-4 "><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
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
                    <div class="wow slideInUp" data-wow-delay="0.1s">
                        <div class="section-title section-title-sm position-relative pb-3 mb-4">
                            <h3 class="mb-0">Plain Text</h3>
                        </div>
                        <div class="bg-light text-center border border-primary-subtle" style="padding: 30px;">
                            <p>Vero sea et accusam justo dolor accusam lorem consetetur, dolores sit amet sit dolor clita kasd justo, diam accusam no sea ut tempor magna takimata, amet sit et diam dolor ipsum amet diam</p>
                            <a href="" class="btn btn-primary py-2 px-4">Read More</a>
                        </div>
                    </div>
                    <!-- Plain Text End -->
                </div>
                <!-- Sidebar End -->
            </div>
        </div>
    </div>
    <!-- Blog End -->

    @if(session('success'))
    <div class="alert alert-success position-fixed bottom-0 end-0 p-3" style="background-color: #5cb85c; color: white;">
        {{ session('success') }}
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