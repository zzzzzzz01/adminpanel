<x-layout.app>

<x-slot:title>
  Yangiliklar
</x-slot:title>

<div class="container ">
    <div class="row g-5 vh-100 d-flex justify-content-center align-items-center">
        <div class="col-lg-6 wow slideInUp" data-wow-delay="0.3s">

    <div class="col-6">
        <a href="{{ route('posts.show',['post'=>$post->id]) }}">
            <button  class="btn btn-success mt-2 mb-2">O'rqaga</button>
        </a>
    </div>


            <form action="{{ route('posts.update',['post'=>$post->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">



                    <div class="col-12">
                        <label for=""> @lang('words.title') (Uz) </label>
                        <input type="text" class="form-control bg-light px-4 border border-primary-subtle" name="title_uz" value="{{ $post->title_uz ?? '--' }}" style="height: 55px;">
                    </div>

                    <div class="col-12">
                    <label for=""> @lang('words.title') (Ru) </label>
                        <input type="text" class="form-control bg-light px-4 border border-primary-subtle" name="title_ru" value="{{ $post->title_ru ?? '--' }}" style="height: 55px;">
                    </div>

                    <div class="col-12">
                    <label for=""> @lang('words.title') (En) </label>
                        <input type="text" class="form-control bg-light px-4 border border-primary-subtle" name="title_en" value="{{ $post->title_en ?? '--' }}" style="height: 55px;">
                    </div>
                    <div class="col-12">
                        <label for="exampleInputEmail1" class="form-label"> @lang('words.image') </label>
                        <input type="file" name="photo" class="form-control border-primary-subtle px-4" name="photo"  style="height: 55px;">
                        <img class="img-fluid rounded border border-primary-subtle mt-2 mb-2 " src="{{ asset('storage/'.$post->photo) }}" width="250">
                    </div>

                    <div class="col-12">
                        <select class="form-select border-primary-subtle px-4 p-2" name="category_id" aria-label="select example">
                            <option disabled>@lang('words.select.category')...</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->{'name_'.app()->getLocale()} }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="">@lang('words.enter.tags')</label>
                        <select name="tags[]" id="" class="form-control border-primary-subtle" multiple>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" >
                                    {{ $tag->{'name_' .app()->getLocale()} }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label for=""> @lang('words.brief.info') (Uz) </label>
                        <input type="text" class="form-control bg-light px-4 border-primary-subtle" name="content_uz" value="{{ $post->content_uz }}" style="height: 55px;">
                    </div>

                    <div class="col-12">
                    <label for=""> @lang('words.brief.info') (Ru) </label>
                        <input type="text" class="form-control bg-light px-4 border-primary-subtle" name="content_ru" value="{{ $post->content_ru }}" style="height: 55px;">
                    </div>

                    <div class="col-12">
                    <label for=""> @lang('words.brief.info') (En) </label>
                        <input type="text" class="form-control bg-light px-4 border-primary-subtle" name="content_en" value="{{ $post->content_en }}" style="height: 55px;">
                    </div>

                    <div class="col-12">
                        <label for=""> @lang('words.full.info') (Uz)  </label>
                        <textarea class="form-control bg-light px-4 py-3 border-primary-subtle" name="description_uz" rows="4" value="">{{ $post->description_uz }}</textarea>
                    </div>

                    <div class="col-12">
                        <label for=""> @lang('words.full.info') (Ru) </label>
                        <textarea class="form-control bg-light px-4 py-3 border-primary-subtle" name="description_ru" rows="4" value="">{{ $post->description_ru }}</textarea>
                    </div>

                    <div class="col-12">
                        <label for=""> @lang('words.full.info') (En)  </label>
                        <textarea class="form-control bg-light px-4 py-3 border-primary-subtle" name="description_en" rows="4" value="">{{ $post->description_en }}</textarea>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary w-100 py-3"  type="submit">Yuborish</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</x-layout.app>