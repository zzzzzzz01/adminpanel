<x-layout.app>

<x-slot:title>
  Guruxlar
</x-slot:title>

<div class="container mt-4">
    <a href="{{ route('home.page') }}" class="btn btn-success mb-3"> @lang('words.back') </a>
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
        @foreach($weekdays as $weekday)
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="bg-primary text-white">{{ $weekday->{'name_' . app()->getLocale()} ?? 'Kunni nomi topilmadi' }}</h3>
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
                            </div>
                            @if(!$loop->last)
                                <hr class="my-1" style="margin-left: -1rem; margin-right: -1rem;">
                            @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

</x-layout.app>