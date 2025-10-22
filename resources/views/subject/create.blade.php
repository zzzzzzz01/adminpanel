<x-layout.app>

<x-slot:title>
    Adminlar
</x-slot:title>



<div class="container ">
    <div class="row g-5 vh-100 d-flex justify-content-center align-items-center">
        <div class="col-lg-6 wow slideInUp" data-wow-delay="0.3s">
            <form action="{{ route('subject.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">

                <div class="col-6">
                <a href="{{ route('subject.index') }}" class="btn btn-success "> @lang('words.back') </a>
                </div>
                    <div class="col-12">
                        <label for=""> @lang('words.subject.name') (uz) </label>
                        <input type="text" class="form-control bg-light px-4 border-primary-subtle" name="name_uz" placeholder="@lang('words.subject.name')" style="height: 55px;">
                    </div>

                    <div class="col-12">
                        <label for="">@lang('words.subject.name') (ru)</label>
                        <input type="text" class="form-control bg-light px-4 border-primary-subtle" name="name_ru" placeholder="@lang('words.subject.name')" style="height: 55px;">
                    </div>

                    <div class="col-12">
                        <label for="">@lang('words.subject.name') (en)</label>
                        <input type="text" class="form-control bg-light px-4 border-primary-subtle" name="name_en" placeholder="@lang('words.subject.name')" style="height: 55px;">
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary w-100 py-3" type="submit">@lang('words.submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



</x-layout.app>