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
                    <a href="{{ route('attendanceAdmin.index') }}" class="text-decoration-none">
                        Guruxlar royhati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ $group->group_name }} guruh fanlari
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
                    <div class="plus d-flex justify-content-between align-items-center">
                        <form action="{{ route('group.attendances.search', $group->id) }}" method="GET" class="d-flex">
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
                                <th>Darslar soni</th>
                                <th>Semester</th>
                                <th>O'quv yili</th>
                                <th>Hodim</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($groupSubjects as $gs)
                            <tr>
                                <td scope="row" class="ps-1">{{ $loop->iteration }}</td>
                                <td>{{ $gs->group->group_name }} </td>
                                <td>
                                    <a href="{{ route('attendanceAdmin.groupSubject', [$group->id, $gs->id]) }}" class="badge" style="background-color: #483D8B; color: white; font-size: 12px;">
                                        {{ $gs->subject->name_uz }}
                                    </a>
                                    <td>{{ $gs->schedules->count() }}</td>
                                </td>
                                <td>{{ $gs->semester->name }}</td>
                                <td>{{ $gs->group->academicYear->name }}</td>
                                <td> {{ $gs->teacher->last_name }}. {{ $gs->teacher->name }}. {{ $gs->teacher->middle_name }} </td>
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