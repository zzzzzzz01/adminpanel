<x-layout.app>

<x-slot:title>
  Yangiliklar
</x-slot:title>

<div class="container ">
    <div class="row g-5 vh-100 d-flex justify-content-center align-items-center">
        <div class="col-lg-6 wow slideInUp" data-wow-delay="0.3s">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">

                <div class="col-6">
                <a href="{{ route('posts.index') }}" class="btn btn-success mt-2">@lang('words.back')</a>
                </div>

                    <div class="col-12">
                        <input type="text" class="form-control bg-light px-4 border border-primary-subtle" name="title_uz" placeholder="@lang('words.title') (uz)" style="height: 55px;">
                    </div>

                    <div class="col-12">
                        <input type="text" class="form-control bg-light px-4 border border-primary-subtle" name="title_ru" placeholder="@lang('words.title') (ru)" style="height: 55px;">
                    </div>
                    
                    <div class="col-12">
                        <input type="text" class="form-control bg-light px-4 border border-primary-subtle" name="title_en" placeholder="@lang('words.title') (en)" style="height: 55px;">
                    </div>


                    <div class="col-12">
                        <label for="exampleInputEmail1" class="form-label">@lang('words.image')</label>
                        <input type="file" name="photo" class="form-control border-primary-subtle px-4" style="height: 55px;">
                    </div>
                    
                    <div class="col-12">
                        <select class="form-select border-primary-subtle px-4 p-2" name="category_id" aria-label="select example">
                            <option disabled selected>@lang('words.select.category')...</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->{'name_'.app()->getLocale()} }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="">@lang('words.enter.tags')</label>
                        <select name="tags[]" id="" class="form-control border-primary-subtle" multiple>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->{'name_' .app()->getLocale()} }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Content -->

                    <div class="col-12">
                        <input type="text" class="form-control bg-light px-4 border-primary-subtle" name="content_uz" placeholder="@lang('words.brief.info') (uz)" style="height: 55px;">
                    </div>

                    <div class="col-12">
                        <input type="text" class="form-control bg-light px-4 border-primary-subtle" name="content_ru" placeholder="@lang('words.brief.info') (ru)" style="height: 55px;">
                    </div>

                    <div class="col-12">
                        <input type="text" class="form-control bg-light px-4 border-primary-subtle" name="content_en" placeholder="@lang('words.brief.info') (en)" style="height: 55px;">
                    </div>

                    <!-- Description -->

                    <div class="col-12">
                        <textarea class="form-control bg-light px-4 py-3 border-primary-subtle " id="description_uz" name="description_uz" rows="4" placeholder="@lang('words.full.info') (uz)"></textarea>
                    </div>

                    <div class="col-12 ">
                        <textarea class="form-control bg-light px-4 py-3 border-primary-subtle " id="description_ru" name="description_ru" rows="4" placeholder="@lang('words.full.info') (ru)"></textarea>
                    </div>

                    <div class="col-12">
                        <textarea class="form-control bg-light px-4 py-3 border-primary-subtle " id="description_en" name="description_en" rows="4" placeholder="@lang('words.full.info') (en)"></textarea>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary w-100 py-3" type="submit">@lang('words.sending')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .cke_notifications_area 
    {
        display: none !important;
    }
</style>


<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description_uz'), {
            ckfinder: {
                uploadUrl: "{{ route('ckeditor.upload') }}?_token={{ csrf_token() }}",
                
            }
        })
        .catch(error => {
            console.error(error);
        });

        ClassicEditor
        .create(document.querySelector('#description_ru'), {
            ckfinder: {
                uploadUrl: "{{ route('ckeditor.upload') }}?_token={{ csrf_token() }}",
            }
        })
        .catch(error => {
            console.error(error);
        });

        ClassicEditor
        .create(document.querySelector('#description_en'), {
            ckfinder: {
                uploadUrl: "{{ route('ckeditor.upload') }}?_token={{ csrf_token() }}",
            }
        })
        .catch(error => {
            console.error(error);
        });
        
</script>



</x-layout.app>