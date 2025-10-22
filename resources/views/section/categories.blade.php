<div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
    <div class="section-title section-title-sm position-relative pb-3 mb-4">
       <h3 class="mb-0">@lang('words.categories')</h3>
    </div>
    <div class="link-animated d-flex flex-column justify-content-start">
        @foreach($categories as $category)
        <a class="h5 fw-semi-bold bg-light rounded py-2 px-3 mb-2 border border-primary-subtle" href="{{ route('category.posts', $category->slug) }}"><i class="fa-solid fa-arrow-right"></i>{{ $category->{'name_'.app()->getLocale()} }} ({{ $category->posts()->count() }})</a>
        @endforeach
        @if(auth()->user()->hasRole('admin'))
        <a class="h5 text-white py-2 px-3 mb-2 btn btn-success" href="{{ route('categories.create') }}"> @lang('words.category.add') </a>
        @endif
    </div>
</div>