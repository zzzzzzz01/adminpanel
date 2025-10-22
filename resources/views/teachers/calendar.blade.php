<x-layout.app>

<x-slot:title>
  Guruxlar
</x-slot:title>

<style>    
        .breadcrumb {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px 20px;
            margin-bottom: 20px;
        }
        .breadcrumb-item a {
            color: #495057;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .breadcrumb-item a:hover {
            color: #0d6efd;
        }
        .breadcrumb-item.active {
            color: #6c757d;
            font-weight: 600;
        }
        .breadcrumb-item + .breadcrumb-item::before {
            color: #6c757d;
            font-weight: bold;
        }

        /* Asosiy container scrollni yo‘qotish */
        .container, 
        .card, 
        .table-responsive {
            overflow: hidden !important;
        }

        /* Jadval scroll bermasligi uchun */
        .table-responsive {
            max-height: none !important;
            overflow-x: hidden !important;
            overflow-y: hidden !important;
        }

        /* Jadvalning to‘liq sig‘ishi uchun */
        table.table {
            width: 100% !important;
            table-layout: fixed !important;
        }

        /* Browserdagi scroll ni ham yo‘qotish (fallback) */
        body {
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }
    </style>



    <!-- Breadcrumb -->
    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home.page') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> Asosiy
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                    {{ $teacher->last_name }}. {{ $teacher->name }} uchun dars jadvali
                    </a>
                </li>
            </ol>
        </nav>
    </div>





<div class="container mt-4">
    <!-- <div class="d-flex align-items-center">
        <a href="{{ url()->previous() }}" class="btn btn-primary me-2">Orqaga</a>
        <h4 class="pb-4">
            {{ $teacher->name }} uchun Kalendar
        </h4>
    </div> -->

    <div class="mb-3 d-flex justify-content-between">
        {{-- Oldingi oy --}}
        <a href="{{ route('teachers.calendar', [
            'teacher_id' => $teacher->id,
            'month' => $prevMonth->format('Y-m')
        ]) }}" class="btn btn-primary">←</a>

        <h5 class="mb-0">{{ $currentMonth->translatedFormat('F Y') }}</h5>

        {{-- Keyingi oy --}}
        <a href="{{ route('teachers.calendar', [
            'teacher_id' => $teacher->id,
            'month' => $nextMonth->format('Y-m')
        ]) }}" class="btn btn-primary">→</a>
    </div>

    <div class="card p-3 shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Dush</th>
                        <th>Sesh</th>
                        <th>Chor</th>
                        <th>Pay</th>
                        <th>Juma</th>
                        <th>Shan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($calendar as $week)
                        <tr>
                            @foreach($week as $day)
                                @if($day)
                                <td style="height:80px; width:120px;">
    @php
        $isToday = $day['date']->isToday();
    @endphp

    <div class="{{ $isToday ? 'bg-success' : 'bg-primary' }} text-white d-flex align-items-center px-2"
        style="gap: 8px; padding-top: 5px; padding-bottom: 5px;">
        <strong class="mx-auto" style="font-size: 16px;">
            {{ $day['date']->format('d') }}
        </strong>
    </div>

    <div class="d-flex flex-column h-100">
        <div class="border border-top-0 p-1 flex-grow-1" style="min-height: 80px; margin-bottom: 5px; overflow: hidden;">
            @foreach($day['schedules'] as $schedule)
                <div class="card shadow-sm bg-light mb-1 p-1" style="font-size: 13px;">
                    <div class="text-start">
                        @if($schedule->lessonPair)
                            {{ $schedule->lessonPair->pair_number }}.
                            {{ \Carbon\Carbon::parse($schedule->lessonPair->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($schedule->lessonPair->end_time)->format('H:i') }}
                        @endif
                        <strong>{{ $schedule->groupSubject->subject->{'name_'.app()->getLocale()} ?? '-' }}</strong>
                    </div>

                    <div class="text-start">
                        <strong class="text-dark">
                            {{ $schedule->session->{'name_'.app()->getLocale()} ?? '-' }}
                        </strong>
                        @if($schedule->auditorium)
                            <span class="ms-1 text-muted">({{ $schedule->auditorium->name }})</span>
                        @endif
                    </div>

                    <div class="text-start mt-1">
                        <span class="badge" style="background-color: #483D8B; color: white; font-size: 11px;">
                            {{ $schedule->group->group_name ?? '-' }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</td>

                                @else
                                    <td></td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>








</x-layout.app>