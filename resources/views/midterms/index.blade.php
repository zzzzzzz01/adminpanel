<x-layout.app>
    <x-slot:title>
        Oraliqlar royhati
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
                        Oraliq nazorat
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
                        <h3 class="mb-0 text-white" style="font-size: 20px;">Barcha Oraliq nazoratlari</h3>

                        <div class="plus d-flex justify-content-between align-items-center">
                            <form action="" method="GET" class="d-flex">
                                <div class="input-group">
                                    <!-- <input 
                                        type="text" 
                                        name="search" 
                                        value="{{ request('search') }}" 
                                        class="form-control" 
                                        placeholder="Qidirish..."
                                    >
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                    </button> -->
                                </div>
                            </form>
                            <a href="{{ route('midterms.create') }}" class="btn btn-primary ms-2">
                                Yaratish
                            </a>
                            <a href="{{ route('all.midterms') }}" class="btn btn-info ms-2">
                                Hamma oraliqlar
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <table class="table table-hover" style="font-size: 14px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Guruh</th>
                                    <th>Fan</th>
                                    <th>Turi</th>
                                    <th class="ps-1">Semester</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($midterms as $midterm)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($midterm->type === 'manual')
                                            <a href="{{ route('midterms.manual', $midterm->id) }}"class="badge text-bg-info" style="font-size: 12px;">
                                                {{ $midterm->groupSubject->group->group_name ?? '-' }}
                                            </a>
                                        @elseif($midterm->type === 'assignment')
                                            <a href="{{ route('midterms.assignment', $midterm->id) }}" class="badge text-bg-info" style="font-size: 12px;">
                                                {{ $midterm->groupSubject->group->group_name ?? '-' }}
                                            </a>
                                        @else
                                            {{ $midterm->groupSubject->group->group_name ?? '-' }}
                                        @endif
                                    </td>
                                    <!-- <td>
                                        <a href="" class="group-badge text-white">
                                        {{ $midterm->groupSubject->group->group_name ?? '-' }}
                                        </a>
                                    </td> -->
                                    <!-- <td><span class="group-badge">RI76-22</span></td> -->
                                    <td>{{ $midterm->groupSubject->subject->name_uz ?? '-' }}</td>
                                    <td>
                                        @if($midterm->type === 'manual')
                                            Yozma
                                        @elseif($midterm->type === 'assignment')
                                            Vazifa
                                        @endif
                                    </td>
                                    <td>
                                        <div class="ps-2">{{ $midterm->groupSubject->semester->name ?? '-' }}</div>
                                        <span class="badge text-bg-primary text-white ms-1">{{ $midterm->groupSubject->semester->end_date ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('midterms.toggle-status', $midterm->id) }}" method="POST">
                                            @csrf
                                            <div class="form-check form-switch">
                                                <input 
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    {{ $midterm->status ? 'checked disabled' : '' }}
                                                    onchange="this.form.submit()"
                                                >
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted pb-3">Hozircha oraliq imtihonlar yo‘q</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>










    </x-layout.app>