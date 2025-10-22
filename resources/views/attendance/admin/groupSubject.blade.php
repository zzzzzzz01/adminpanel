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
                    <a href="{{ route('attendanceAdmin.index') }}" class="text-decoration-none">
                        Guruxlar royhati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('attendanceAdmin.group', $group->id) }}" class="text-decoration-none">
                        {{ $group->group_name }} guruh fanlari
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ $groupSubject->subject->name_uz }}
                    </a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page">
                    Mavzular
                </li> -->
            </ol>
        </nav>
    </div>


<div class="container mt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <!-- Card Header -->
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 20px 15px; min-height: 70px;">
                    <h3 class="mb-0 text-white" style="font-size: 20px;">{{ $group->group_name }} guruxi uchun davomat kunlari</h3>
                    
                    <!-- Search Input -->
                    <div class="plus d-flex justify-content-between align-items-center">
                        <form action="{{ route('admin.attendance.group.subject', [$group->id, $groupSubject->id]) }}" method="GET" class="d-flex">
                            <div class="input-group">
                            @if(request('search'))
                                <a href="{{ route('admin.attendance.group.subject', [$group->id, $groupSubject->id]) }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            @endif
                                <input 
                                    type="date" 
                                    name="search" 
                                    value="{{ request('search') }}" 
                                    class="form-control" 
                                    placeholder="Fan nomi..."
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
                                    <a href="{{ route('showAdminAttendance.form', $schedule) }}" class="badge" style="background-color: #483D8B; color: white; font-size: 12px;">
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
                                
                                <td>{{ $schedule->groupSubject->subject->name_uz }}</td>
                                <td>{{ $schedule->session->name_uz }}</td>
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




</x-layout.app>