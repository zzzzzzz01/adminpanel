<x-layout.app>
    <x-slot:title>
        Yozma oraliq baxoni baxolash
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
                    <a href="{{ route('admin.midterms.index') }}" class="text-decoration-none">
                        Oqaliq guruxlari
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('adminGroup.midterm', $group->id) }}" class="text-decoration-none">
                        {{ $group->group_name }} guruh fanlari
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ $midterm->groupSubject->subject->{'name_'.app()->getLocale()} }}
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
                        <h3 class="mb-0 text-white" style="font-size: 20px;">{{ $groupSubject->group->group_name }} - {{ $groupSubject->subject->{'name_'.app()->getLocale()} }}. Max ball: ({{ $groupSubject->max_midterm_score }})</h3>
                        <div>
                            <span class="me-3">Muddat sanasi: <strong> {{ \Carbon\Carbon::parse($groupSubject->semester->end_date )->format('d.m.Y') }} </strong></span>
                            <span class="badge bg-success">Yozma imtihon</span>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <form action="{{ route('admins.midterms.manual.store', ['group' => $group->id, 'midterm' => $midterm->id]) }}" method="POST">
                        @csrf
                        <table class="table table-hover" style="font-size: 14px;">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="35%">Talaba</th>
                                    <th width="25%">Tolov turi</th>
                                    <th width="20%">Holati</th>
                                    <th width="20%">Baho</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="student-name"> {{ $student->name }} </td>
                                    <td>Davlat granti</td>
                                    <td>
                                        @if(isset($grades[$student->id]) && $grades[$student->id]->grade !== null)
                                            <span class="badge text-bg-success">Baho qo'yilgan</span>
                                        @else
                                            <span class="badge text-bg-danger">Baho qo'yilmagan</span>
                                        @endif
                                    </td>
                                    <td>
                                    <input type="number" step="1" min="0" max="100"
                                            name="grades[{{ $student->id }}]"
                                            value="{{ isset($grades[$student->id]) ? intval($grades[$student->id]->grade) : '' }}"
                                            class="grade-input text-center">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="p-4">
                                <div class="action-buttons">
                                    <a href="">
                                        <button class="btn btn-secondary btn-sm py-1 px-2" style="font-size: 14px;">
                                             Orqaga qaytish
                                        </button>
                                    </a>
                                    <button type="submit" class="btn btn-primary py-1 px-2" style="font-size: 14px;">
                                        <i class="bi bi-check-circle"></i> Baholarni saqlash
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
                        













    </x-layout.app>