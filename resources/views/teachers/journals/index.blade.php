<x-layout.app>
    <x-slot:title>
        Jurnalar royhati
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
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Jurnallar royhati
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
                        <h3 class="mb-0 text-white" style="font-size: 20px;">Mening Jurnallarim</h3>
                        
                        <!-- Search Input -->
                        <!-- <form action="" method="GET" class="d-flex" style="max-width: 250px;">
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Qidiruv...">
                        </form> -->
                        <a href="{{ route('all.journals') }}" class="btn btn-info ms-2">
                            Hamma Jurnallar
                        </a>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-3">
                        <table class="table table-hover" style="font-size: 14px;">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 20%;">Guruh Nomi</th>
                                    <th style="width: 20%;">Fan</th>
                                    <th style="width: 20%;">Semester</th>
                                    <th style="width: 20%;">O'quv Yili</th>
                                    <th style="width: 20%;">Holati</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($journals as $journal)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('groupSubject.grades', ['group' => $journal->groupSubject->group->id, 'subject' => $journal->groupSubject->subject->id]) }}" style="color: #483D8B;">
                                                {{ $journal->groupSubject->group->group_name }}
                                            </a>
                                        </td>
                                        <td>{{ $journal->groupSubject->subject->name_uz }}</td>
                                        <td>{{ $journal->groupSubject->semester->name }}</td>
                                        <td>{{ $journal->groupSubject->semester->academic_year }}</td>
                                        <td>
                                            @php
                                                $today = \Carbon\Carbon::today();
                                                $semester = $journal->groupSubject->semester;
                                            @endphp

                                            @if($today->gt($semester->end_date))
                                                <span class="status-badge bg-danger text-white px-2 py-1 rounded-pill">Tugagan</span>
                                            @elseif($today->between($semester->start_date, $semester->end_date))
                                                <span class="status-badge bg-success text-white px-2 py-1 rounded-pill">Davom etmoqda</span>
                                            @else
                                                <span class="status-badge bg-warning text-dark px-2 py-1 rounded-pill">Hali boshlanmagan</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




</x-layout.app>