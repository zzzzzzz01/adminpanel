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
                        Guruxlar ro'yxati
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
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 20px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">Guruxlar ro'yxati: jami( {{ $groups->count() }} )</h3>
                        
                        <div class="plus d-flex justify-content-between align-items-center">
                            <form action="{{ route('groups.search') }}" method="GET" class="d-flex">
                                <div class="input-group">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        value="{{ request('search') }}" 
                                        class="form-control" 
                                        placeholder="Guruh nomi..."
                                    >
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                            <a href="{{ route('schedule.group.create') }}" class="btn btn-primary ms-2">
                                Yangi guruh yaratish
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <table class="table table-hover" style="font-size: 15px;">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 15%;">Guruh nomi</th>
                                    <th style="width: 15%;">O‘quv yili</th>
                                    <th style="width: 15%;">Semestr</th>
                                    <th style="width: 15%;">Ta'til turi</th>
                                    <th>Actions</th>
                                    <th style="width: 5%;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($groups as $group)
                                <tr>
                                    <td class="ps-2">{{ $loop->iteration }}</td>
                                    <td>
                                        @php
                                            $name = $group->group_name;
                                            if (!empty($highlight)) {
                                                $pattern = '/' . preg_quote($highlight, '/') . '/i';
                                                $name = preg_replace(
                                                    $pattern,
                                                    "<span style='background-color: #87CEFA; padding: 2px 4px; border-radius: 3px;'>$0</span>",
                                                    e($name)
                                                );
                                            } else {
                                                $name = e($name);
                                            }
                                        @endphp

                                        {!! $name !!}
                                    </td>
                                    <td>{{ $group->academicYear->name }}</td>
                                    <td>{{ $group->current_semester }}- semester</td>
                                    <td>{{ $group->education_type }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap " >
                                            <div class="w-100 d-flex gap-2 mb-1">
                                                <a href="{{ route('groups.semesters', $group->id) }}" class="btn btn-success btn-sm" style="padding: 0.2rem 0.3rem; line-height: 1;">
                                                📅 Semestr
                                                </a>
                                                <a href="{{ route('groups.weeks.index', $group->id) }}" class="btn btn-success btn-sm" style="padding: 0.2rem 0.3rem; line-height: 1;">
                                                    ⏳ Hafta
                                                </a>
                                                <a href="{{ route('groupSubject.index', $group->id) }}" class="btn btn-success btn-sm" style="padding: 0.2rem 0.3rem; line-height: 1;">
                                                    📚 Fanlar  
                                                </a>
                                            </div>
                                            <div class="w-100 d-flex gap-2">
                                            <a href="{{ route('show.groups.students', $group->id) }}" class="btn btn-success btn-sm" style="padding: 0.2rem 0.3rem; line-height: 1;">
                                                👨‍🎓 Talabalar
                                            </a>
                                            <a href="{{ route('groups.subjects.for.topic', $group->id) }}" class="btn btn-success btn-sm" style="padding: 0.2rem 0.3rem; line-height: 1;">
                                                🏷️ Mavzular
                                            </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="status-cell">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="customSwitch" style="width: 42px; height: 20px;">
                                            <label class="form-check-label" for="customSwitch"></label>
                                        </div>
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