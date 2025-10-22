<x-layout.app>

<x-slot:title>
  Guruxlar
</x-slot:title>



<div class="container mt-4">
    <a href="{{ route('schedule.index') }}" class="btn btn-success mb-3"> @lang('words.back') </a>
      <h1 class="text-center pb-4">
        @if (App::getLocale() == 'uz')
            {{ $group->name }} guruxining dars jadvali
        @elseif (App::getLocale() == 'ru')
            Расписание занятий для группы {{ $group->name }}
        @elseif (App::getLocale() == 'en')
            Class schedule for group {{ $group->name }}
        @endif
      </h1>
        <div class="row">

        <div class="row">
            @foreach($weekdays as $weekday)
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h3 class="bg-primary text-white">{{ $weekday->{'name_' . app()->getLocale()} ?? 'Kunni nomi topilmadi' }}</h3>
                                <a href="{{ route('schedule.create') }}">
                                    <i class="fa-solid fa-plus text-white"></i>
                                </a>
                        </div>

                        <div class="card-body">
                            @if($schedules[$weekday->id]->isNotEmpty())
                                @foreach($schedules[$weekday->id] as $schedule)
                                <div class="mb-1 relative group d-flex justify-content-between align-items-center">
                                    <div class="card-left">
                                        <a href="" class="text-dark block">
                                            <strong>{{ $schedule->subject->{'name_'.app()->getLocale()} }}</strong><br>
                                            {{ $schedule->room }} | {{ $schedule->session->{'name_'.app()->getLocale()} }} | {{ $schedule->teacher->name }} | {{ substr($schedule->start_time, 0, 5) }}-{{ substr($schedule->end_time, 0, 5) }}
                                        </a>
                                    </div>
                                    <!-- Axlat iconi -->
                                    <div class="card-right">
                                        <form action="" method="POST" class="absolute top-0 right-0 hidden group-hover:block">
                                            @csrf
                                            @method('DELETE')
                                            <a href="" style="background: none; border: none;" title="O'chirish" data-toggle="modal" data-target="#deleteModal-{{ $schedule->id }}">
                                                <i class="fas fa-trash text-danger"></i>
                                            </a>
                                        </form>
                                    </div>

                                    <div class="modal fade" id="deleteModal-{{ $schedule->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel"> Darsni o'chirish </h5>
                                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Siz <strong>{{ $group->name }}</strong> guruhining <strong>{{ $weekday->name }}</strong> kunidagi <strong>{{ $schedule->subject->name }}</strong> darsini o'chirishni tasdiqlaysizmi?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Yopish</button>
                                                    <form action="{{ route('schedule.destroy', $schedule->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">O'chirish</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @if(!$loop->last)
                                    <hr class="my-1" style="margin-left: -1rem; margin-right: -1rem;">
                                @endif
                                @endforeach
                                @else
                                <div>Dars yo'q</div>
                            @endif
                        </div>
                    </div>
                    
                </div>
            @endforeach
        </div>
    </div>
</div>

    @if(session('success'))
    <div class="alert alert-success  position-fixed bottom-0 end-0 p-3" style="background-color: #5cb85c; color: white;">
      {{ session('success') }}
    </div>
    @endif  

    @if(session('trashSchedule'))
    <div class="alert alert-success  position-fixed bottom-0 end-0 p-3" style="background-color: #B22222; color: white;">
      {{ session('trashSchedule') }}
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