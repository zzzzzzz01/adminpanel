<div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
    <div class="section-title section-title-sm position-relative pb-3 mb-4">
        <h3 class="mb-0">@lang('words.popular.posts')</h3>
    </div>
    @foreach($popularPosts as $post)
    <div class="d-flex  rounded overflow-hidden mb-3 border border-primary-subtle">
        <img class="img-fluid" src="{{ asset('storage/'.$post->photo) }}" style="width: 100px; height: 100px; object-fit: cover;" alt="">
        <a href="{{ route('posts.show',['post'=>$post->id]) }}" class="h5 fw-semi-bold d-flex align-items-center bg-light px-3 mb-0">{{ $post->{'title_'.app()->getLocale()} }}   <i class="fa-solid fa-eye ps-5"></i> {{ $post->views }}</a>
    </div>
    @endforeach
</div>