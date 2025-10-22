<x-layout.app>

<x-slot:title>
Davomat
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
                    <a href="{{ route('attendance.index') }}" class="text-decoration-none">
                        Guruhlar ro'yhati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ $groupSubject->group->group_name }}
                    </a>
                </li>
            </ol>
        </nav>
    </div>

    @if(auth()->user()->hasRole('teacher'))
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <!-- Card Header -->
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 20px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">Davomat Qilish Kerak Bo'lgan Guruhlar</h3>
                        
                        <!-- Search Input -->
                        <div class="plus d-flex justify-content-between align-items-center">
                            <form action="{{ route('attendance.schedule.search', $groupSubject->id) }}" method="GET" class="d-flex">
                                <div class="input-group">
                                    <input 
                                        type="date" 
                                        name="search" 
                                        value="{{ request('search') }}" 
                                        class="form-control" 
                                        placeholder="Qidirish..."
                                    >
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-3">
                        <table class="table table-hover" style="font-size: 14px;">
                            <thead>
                                <tr>
                                <th>#</th>
                                <th>Gurux</th>
                                <th>Dars sanasi</th>
                                <th>Semester</th>
                                <th>Fan</th>
                                <th>Mashgulot</th>
                                <th>Vaqti</th>
                                <th>Hona</th>
                                <th>Ustoz</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($schedules as $schedule)
                                <tr>
                                    <td scope="row" class="ps-1">{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('attendance.form', ['groupSubject' => $groupSubject->id, 'schedule' => $schedule->id]) }}" class="badge" style="background-color: #483D8B; color: white; font-size: 12px;">
                                            {{ $schedule->group->group_name }}
                                        </a>
                                    </td>
                                    
                                    
                                    @php
                                        // Davomat saqlanganligini tekshirish
                                        $isSaved = $schedule->attendances()->where('status', '!=', 0)->exists();
                                    @endphp

                                    <td>
                                        <span class="badge {{ $isSaved ? 'bg-success' : 'bg-danger' }}" style="font-size: 12px;">
                                            {{ \Carbon\Carbon::parse($schedule->date)->format('d.m.Y') }}
                                        </span>
                                    </td>

                                    <td>{{ $schedule->semester->name }}</td>
                                    
                                    <td>{{ $schedule->groupSubject->subject->{'name_' . app()->getLocale()} }}</td>
                                    <td>{{ $schedule->session->{'name_' . app()->getLocale()} }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($schedule->lessonPair->start_time)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($schedule->lessonPair->end_time)->format('H:i') }}
                                    </td>
                                    <td>{{ $schedule->auditorium->name }}</td>
                                    <td>{{ $schedule->groupSubject->teacher->name }}. {{ $schedule->groupSubject->teacher->name }}</td>
                                </tr>
                                @empty
                                @endforelse
                                <tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <p class="position-absolute top-50 start-50 translate-middle">Sizning rolingiz Teacher emas!</p>
    @endif

</x-layout.app>