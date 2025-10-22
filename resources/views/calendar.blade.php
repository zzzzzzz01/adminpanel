<x-layout.app>
    <x-slot:title>
        Guruxni Filtirlash
    </x-slot:title>


    <style>    
        .breadcrumb {
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
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

        /* Select elementlar uchun border va styling */
        .bootstrap-select .dropdown-toggle {
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
            padding: 0.375rem 0.75rem !important;
            background-color: #fff !important;
        }
        
        .bootstrap-select .dropdown-toggle:focus {
            border-color: #86b7fe !important;
            outline: 0 !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        }
        
        .bootstrap-select .filter-option {
            color: #212529 !important;
        }
        
        .bootstrap-select .dropdown-menu {
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
        }
        
        .bootstrap-select .dropdown-menu.inner {
            max-height: 200px !important;
            overflow-y: auto !important;
        }

        /* Form selectlar uchun */
        .form-select {
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
        }
        
        .form-select:focus {
            border-color: #86b7fe !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        }

        /* Tugmalar bir qatorda */
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
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
                    <a href="{{ route('schedule.index') }}"  class="text-decoration-none">
                        Dars jadvalini boshqarish
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                    {{ $group->group_name }} | {{ $semester->name ?? '--' }}
                    </a>
                </li>
            </ol>
        </nav>
    </div>


<div class="container mt-4">
    <div class="d-flex align-items-center">
        <!-- <a href="{{ route('schedule.index') }}" class="btn btn-primary me-2">Orqaga</a> -->
        <!-- <a href="{{ route('schedule.generate.week', [
                    'group_id' => $group->id,
                    'semester_id' => $semester->id
                ]) }}" class="btn btn-success me-2">Generatsiya</a> -->
        <!-- <h4 class="pb-4">
            {{ $group->group_name }} — {{ $semester->name ?? 'Semestr tanlanmagan' }} uchun Calendar
        </h4> -->
    </div>

    <div class="mb-3 d-flex justify-content-between">
        {{-- Oldingi oy --}}
        @if($prevMonth)
            <a href="{{ route('calendar.show', [
                'group_id' => $group->id,
                'academic_year' => request('academic_year'),
                'program_id' => $group->program->id,
                'semester_id' => $semester->id,
                'month' => $prevMonth
            ]) }}" class="btn btn-primary">←</a>
        @else
            <button class="btn btn-secondary" disabled>←</button>
        @endif

        <h5 class="mb-0">{{ $currentMonth->translatedFormat('F Y') }}</h5>

        {{-- Keyingi oy --}}
        @if($nextMonth)
            <a href="{{ route('calendar.show', [
                'group_id' => $group->id,
                'academic_year' => request('academic_year'),
                'program_id' => $group->program->id,
                'semester_id' => $semester->id,
                'month' => $nextMonth
            ]) }}" class="btn btn-primary">→</a>
        @else
            <button class="btn btn-secondary" disabled>→</button>
        @endif
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
                                    @if($day['in_range'])
                                        <div class="bg-primary text-white d-flex align-items-center px-2"
                                            style="gap: 8px; padding-top: 5px; padding-bottom: 5px;">
                                            {{-- Form har bir kun uchun --}}
                                            <form action="{{ route('schedule.scheduleCreate') }}"style="margin:0;">
                                                @csrf
                                                <input type="hidden" name="date" value="{{ $day['date']->format('Y-m-d') }}">
                                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                                <input type="hidden" name="semester_id" value="{{ $semester->id }}">
                                                <button type="submit" class="btn btn-sm fw-bold p-0 text-white" style="width:20px; height:23px; "> <i class="fa-solid fa-plus"></i> </button>
                                            </form>

                                            <strong class="mx-auto" style="font-size: 16px;">
                                                {{ $day['date']->format('d') }}
                                            </strong>
                                        </div>

                                        <div class="d-flex flex-column h-100" >
                                            <!-- Darslar qismi - dinamik -->
                                            <div class="border border-top-0 p-1 flex-grow-1" style="min-height: 80px; margin-bottom: 5px; overflow: hidden;">
                                              
                                            @foreach($day['schedules'] as $schedule)
                                                    <div class="card shadow-sm bg-light mb-1 p-1" style="font-size: 13px;">
                                                    <a href="{{ route('schedules.edit', [
                                                                'id'            => $schedule->id,
                                                                'program_id'    => request('program_id'),
                                                                'group_id'      => request('group_id'),
                                                                'academic_year' => request('academic_year'),
                                                                'semester_id'   => request('semester_id'),
                                                            ]) }}" class="text-dark text-decoration-none">
                                                            <div class="text-start">
                                                            @if($schedule->lessonPair)
                                                                {{ \Carbon\Carbon::parse($schedule->lessonPair->start_time)->format('H:i') }} -
                                                                {{ \Carbon\Carbon::parse($schedule->lessonPair->end_time)->format('H:i') }}
                                                                @endif
                                                                <strong>{{ $schedule->groupSubject->subject->name_uz  ?? '-' }}</strong>
                                                            </div>
                                                            <div class="text-start">
                                                                <span class="badge bg-secondary">{{ $schedule->session->name_uz ?? '-' }}</span>
                                                                @if($schedule->auditorium)
                                                                    <span class="ms-1">({{ $schedule->auditorium->name }})</span>
                                                                @endif
                                                            </div>
                                                            <div class="text-start text-muted">
                                                                {{ $schedule->groupSubject->teacher->name ?? '-'  }}
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach

                                               
                                            </div>
                                        </div>


                                    @else
                                        <span class="text-muted">{{ $day['date']->format('d') }}</span>
                                    @endif
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