<x-layout.app>

<x-slot:title>
  Yonalishlar
</x-slot:title>



    <style>    
        .breadcrumb {
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
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
                    <a href="{{ route('groups.index') }}"  class="text-decoration-none">
                        Guruxlar ro'yxati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ $group->group_name }}
                    </a>
                </li>
            </ol>
        </nav>
    </div>



    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 20px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">{{ $group->full_group_name }} ( {{ $group->group_name }} ) — Semestrlar</h3> 
                    </div>

                    <div class="card-body p-3">
                        <table class="table table-hover" style="font-size: 15px;">
                            <thead>
                                <tr>
                                <th>#</th>
                                <th>Nomi</th>
                                <th>Muddat</th>
                                <th>O'quv yili</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($semesters as $semester)
                                <tr>
                                    <td class="ps-2">{{ $loop->iteration }}</td>
                                    <td>{{ $semester->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($semester->start_date)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($semester->end_date)->format('d.m.Y') }}</td>
                                    <td>{{ $semester->academic_year }}</td>
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