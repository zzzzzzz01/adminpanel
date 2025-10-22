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
                        Hamma guruxlar
                    </a>
                </li>
            </ol>
        </nav>
    </div>






<div class="container mt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <!-- Card Header -->
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 20px 15px; min-height: 70px;">
                    <h3 class="mb-0 text-white" style="font-size: 20px;">Davomat Qilish Kerak Bo'lgan Guruhlar</h3>
                    
                    <!-- Search Input -->
                    <div class="plus d-flex justify-content-between align-items-center">
                        <form action="{{ route('attendance.all-attendance.search') }}" method="GET" class="d-flex">
                            <div class="input-group">
                                <input 
                                    type="text" 
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
                            <th>Fan</th>
                            <th class="ps-4">Semester(T/v)</th>
                            <th>O'quv yili</th>
                            <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($groupSubjects as $gs)
                        <tr>
                                <td scope="row" class="ps-1">{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('attendances.groupSubject', $gs->id) }}" class="badge" style="background-color: #483D8B; color: white; font-size: 12px;">
                                        {{ $gs->group->group_name }}
                                    </a>
                                </td>

                                <td>{{ $gs->subject->{'name_'.app()->getLocale()} }}</td>

                                <td>
                                    <div class="ps-5">{{ $gs->semester->name ?? '-' }}</div>
                                    <span class="badge text-bg-primary text-white ms-2">{{ \Carbon\Carbon::parse($gs->semester->end_date ?? '-')->format('d.m.Y') }} | {{ $gs->semester->end_date ?? '-' }}</span>
                                </td>
                                
                                <td>{{ $gs->semester->academic_year }}</td>
                                <td>
                                        @php
                                            $semester = $gs->semester ?? null;
                                            $status = '';
                                            $badgeClass = '';

                                            if ($semester) {
                                                $today = now()->toDateString();

                                                if ($today < $semester->start_date) {
                                                    $status = 'Hali boshlanmadi';
                                                    $badgeClass = 'bg-warning text-dark';
                                                } elseif ($today > $semester->end_date) {
                                                    $status = 'Tugagan';
                                                    $badgeClass = 'bg-danger';
                                                } else {
                                                    $status = 'Davom etmoqda';
                                                    $badgeClass = 'bg-success';
                                                }
                                            } else {
                                                $status = 'Maʼlumot yo‘q';
                                                $badgeClass = 'bg-secondary';
                                            }
                                        @endphp

                                        <span class="badge {{ $badgeClass }}" style="font-size: 13px;">
                                            {{ $status }}
                                        </span>
                                    </td>
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