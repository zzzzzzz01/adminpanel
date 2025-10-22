<x-layout.app>
    <x-slot:title>
        {{ $group->group_name }} — {{ $subject->name }} | Jurnal
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
                    <a href="{{ route('teacher.grades') }}"  class="text-decoration-none">
                        Jurnallar royhati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                    {{ $group->group_name }} — {{ $subject->{'name_' . app()->getLocale()} }}
                    </a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page">
                    Mavzular
                </li> -->
            </ol>
        </nav>
    </div>


    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <!-- Card Header -->
                    <div class="card-header" style="background-color: #2c3e50; padding: 20px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">
                            {{ $group->group_name }} — {{ $subject->name }} | Jurnal
                        </h3>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-3">
                        <style>
                            .table-bordered td, 
                            .table-bordered th {
                                border: 1px solid rgba(222, 226, 230, 0.5) !important; /* 50% shaffof */
                            }
                            .table td, 
                            .table th {
                                vertical-align: middle; /* matnni o'rtada ushlaydi */
                                height: 58px;           /* barcha kataklarga bir xil balandlik */
                            }
                        </style>

                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 230px;" class="ps-2">Talaba</th>
                                    @foreach($schedules as $schedule)
                                        @php
                                            $today = \Carbon\Carbon::today();
                                            $scheduleDate = \Carbon\Carbon::parse($schedule->date);

                                            if ($scheduleDate->isFuture()) {
                                                $badgeClass = 'bg-success'; // sariq (hali kelmagan)
                                            } elseif ($scheduleDate->isPast()) {
                                                $badgeClass = 'bg-danger'; // yashil (o‘tib ketgan)
                                            } else {
                                                $badgeClass = 'bg-primary'; // bugun
                                            }
                                        @endphp

                                        <th class="text-center" style="font-size: 14px; width: 20px; min-width: 97px; max-width: 20px;">
                                            <a href="{{ route('schedule.grades', $schedule->id) }}" class="text-decoration-none">
                                                <span class="badge {{ $badgeClass }} mb-1" style="font-size: 12px;">
                                                    {{ $schedule->date }}
                                                </span>
                                                <br>
                                                <small class="text-muted d-block">
                                                    {{ \Carbon\Carbon::parse($schedule->lessonPair->start_time)->format('H:i') }} -
                                                    {{ \Carbon\Carbon::parse($schedule->lessonPair->end_time)->format('H:i') }}
                                                </small>
                                            </a>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td class="ps-2">{{ $student->last_name }}. {{ $student->name }}</td>
                                        @foreach($schedules as $schedule)
                                            @php
                                                $grade = $schedule->grades
                                                    ->where('student_id', $student->id)
                                                    ->first()?->score ?? '';
                                            @endphp
                                            <td class="text-center " >
                                                @if($grade > 0)
                                                    {{ $grade }}
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $schedules->links('vendor.pagination.simple-tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
