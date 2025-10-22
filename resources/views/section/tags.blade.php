<div class="mb-5 wow slideInUp" data-wow-delay="0.1s">
    <div class="section-title section-title-sm position-relative pb-3 mb-4">
        <h3 class="mb-0">@lang('words.tags')</h3>
    </div>
    <div class="d-flex flex-wrap m-n1">
        @foreach($tags as $tag)
            <a href="{{ route('tag.posts', $tag->slug) }}" class="btn btn-outline-primary m-1 border border-primary-subtle text-black">{{ $tag->{'name_'.app()->getLocale()} }} </a>
        @endforeach
        @if(auth()->user()->hasRole('admin'))
        <a class="m-1 text-white btn btn-success" href="{{ route('tags.create') }}">@lang('words.tag.add')</a>
        @endif
    </div>
</div>