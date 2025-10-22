<x-layout.app>

<x-slot:title>
  Imtihonlar
</x-slot:title>



<div class="container-fluid">
  <div class="title-wrapper pt-30">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="title">
          <h2>Imtihonlar</h2>
        </div>
      </div>
    </div>
  </div>

  <div class="col-6 pb-3">
    <a href="{{ route('exams.create') }}" class="btn btn-success">Imtihon qoshish</a>
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
          <h3 class="mb-10">{{ $exam->subject->name }}</h3>
          <h6 class="text-bold pb-1">
            {{ date('j F', strtotime($exam->date)) }} soat {{ substr($exam->time, 0, 5) }} da {{ $exam->room }} honada
          </h6>

          <p class="text-sm text-success ">
            <span class="text-gray">O'qituvchi: {{ $exam->user->name }}</span>
          </p>

          <p class="text-sm text-success">
            <span class="text-gray">
              Guruxlar: {{ $exam->groups->pluck('name')->unique()->implode(', ') }}
            </span>
          </p>
        </div>
      </div>
    </div>
  @endforeach
</div>

</div>
      <!-- ========== section end ========== -->
</x-layout.app>