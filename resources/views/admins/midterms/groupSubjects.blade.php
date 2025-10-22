<x-layout.app>

<x-slot:title>
  Davomat
</x-slot:title>


<!-- <h3>{{ $group->group_name }} guruh fanlari</h3>
<ul>
    @foreach($groupSubjects as $gs)
        <li>
            <a href="{{ route('attendanceAdmin.groupSubject', [$group->id, $gs->id]) }}">
                {{ $gs->subject->name_uz }} - {{ $gs->teacher->name ?? 'O‘qituvchi yo‘q' }}
            </a>
        </li>
    @endforeach
</ul> -->

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
                    <a href="{{ route('admin.midterms.index') }}" class="text-decoration-none">
                        Oqaliq guruxlari
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ $group->group_name }} 
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
                    <h3 class="mb-0 text-white" style="font-size: 20px;">{{ $group->group_name }} guruh fanlari</h3>
                    
                    <!-- Search Input -->
                    <!-- <div class="plus d-flex justify-content-between align-items-center">
                        <form action="{{ route('group.journals.search', $group->id) }}" method="GET" class="d-flex">
                            <div class="input-group">
                                <input 
                                    type="text" 
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
                    </div> -->
                </div>

                <!-- Card Body -->
                <div class="card-body p-3">
                    <table class="table table-hover" style="font-size: 14px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Gurux</th>
                                <th>Fan</th>
                                <th>Oraliq turi</th>
                                <th>Semester</th>
                                <th>O'quv yili</th>
                                <th>Hodim</th>
                                <th>Holati</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($groupSubjects as $gs)
                            <tr>
                                <td scope="row" class="ps-1">{{ $loop->iteration }}</td>
                                <td>{{ $gs->group->group_name }} </td>
                                <td>
                                    <span class="badge" style="background-color: #483D8B; color: white; font-size: 12px;">{{ $gs->subject->name_uz }}</span>
                                </td>
                                <td>
                                    @if ($gs->midtermIntervals->isEmpty())
                                        <span class="text-muted" style="font-size: 12px;">Hali yaratilmagan</span>
                                    @else
                                        @foreach ($gs->midtermIntervals as $interval)
                                            @if($interval->type === 'manual')
                                                <a href="{{ route('admins.midterms.manual', ['group' => $group->id, 'midterm' => $interval->id]) }}" class="badge text-bg-info" style="font-size: 12px;">
                                                    Yozma
                                                </a>
                                            @elseif($interval->type === 'assignment')
                                                <a href="{{ route('admins.midterms.assignment', ['group' => $group->id, 'midterm' => $interval->id]) }}" class="badge text-dark" style="font-size: 12px; background-color: #E9967A;">
                                                    Vazifa
                                                </a>
                                            @else
                                                {{ $midterm->groupSubject->group->group_name ?? '-' }}
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $gs->semester->name }}</td>
                                <td>{{ $gs->group->academicYear->name }}</td>
                                <td> {{ $gs->teacher->last_name }}. {{ $gs->teacher->name }}. {{ $gs->teacher->middle_name }} </td>
                                <td>
                                    @php
                                        $today = \Carbon\Carbon::today();
                                        $semester = $gs->semester;
                                    @endphp

                                    @if($today->gt($semester->end_date))
                                        <span class="status-badge bg-danger text-white px-2 py-1 rounded-pill">Tugagan</span>
                                    @elseif($today->between($semester->start_date, $semester->end_date))
                                        <span class="badge" style="background-color: #008000; color: white; font-size: 12px;">Davom etmoqda</span>
                                    @else
                                        <span class="badge" style="background-color: #FFD700; color: black; font-size: 12px;">Hali boshlanmagan</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                            <tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>






</x-layout.app>