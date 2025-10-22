<x-layout.app>

<x-slot:title>
  Imtihonlar
</x-slot:title>



<div class="container">
<a href="{{ route('home.page') }}" class="btn btn-success mb-3 mt-2"> @lang('words.back') </a>
  <div class="title-wrapper pt-30">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="title">
          <h2> @lang('words.exams') </h2>
        </div>
      </div>
    </div>
  </div>


<!-- ========== section start ========== -->
        <div class="row">
          @foreach($exams as $exam)
            <div class="col-xl-12 col-lg-12 col-sm-12">
              <div class="icon-card mb-30">
                <div class="icon purple">
                <i class="fa-solid fa-calendar"></i>
                </div>
                <div class="content">
                <h3 class="mb-10 text-purple">{{ $exam->subject->{'name_' . app()->getLocale()} }}</h3>
                <h6 class="text-bold pb-1">
                  {{ date('j F',  strtotime($exam->date)) }} soat {{ substr($exam->time, 0, 5) }} da {{ $exam->room }} honada
                </h6>
                  <p class="text-sm text-success">
                    <span class="text-gray"> @lang('words.teacher')  ({{ $exam->user->name }})</span>
                  </p>
                </div>
              </div>
              <!-- End Icon Cart -->
            </div>
            @endforeach
          </div>
      <!-- ========== section end ========== -->
</x-layout.app>