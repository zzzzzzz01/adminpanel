<x-layout.app>
    <x-slot:title>
        {{ $user->group->group_name }} — Fan resurslari
    </x-slot:title>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .subject-card {
            border-radius: 12px;
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
        }
        .card-header {
            border-radius: 12px 12px 0 0 !important;
            padding: 15px 20px;
        }
        .card-body {
            padding: 20px;
        }
        .badge {
            font-size: 0.85rem;
            padding: 0.5em 0.8em;
            border-radius: 20px;
        }
        .semester-btn {
            border-radius: 20px;
            padding: 8px 20px;
            margin-right: 10px;
            margin-bottom: 10px;
            font-weight: 500;
        }
        .stats-container {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
        }
        .stats-label {
            font-size: 1rem;
            opacity: 0.9;
        }
        .subject-title {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 5px;
        }
        .subject-meta {
            font-size: 0.85rem;
            opacity: 0.9;
        }
        .list-unstyled li {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .list-unstyled li:last-child {
            border-bottom: none;
        }
    </style>

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
                    <a href="{{ route('education.subjects') }}" style="color: #808080;" class="text-decoration-none">
                        Fan resurslari
                    </a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page">
                    Mavzular
                </li> -->
            </ol>
        </nav>
    </div>



    <div class="container mt-4">
        {{-- Semestr tanlash --}}
        <!-- <div class="mb-3">
            @foreach($semesters as $semester)
                <a href="{{ route('education.subjects', ['semester_id' => $semester->id]) }}"
                   class="btn btn-sm {{ $semesterId == $semester->id ? 'btn-primary' : 'btn-outline-primary' }}">
                    {{ $semester->name }}
                </a>
            @endforeach
        </div> -->

        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-white shadow-sm rounded">

            {{-- Guruh nomi + icon --}}
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white d-flex justify-content-center align-items-center" 
                    style="width: 50px; height: 50px; border-radius: 4px;">
                    <i class="fa-solid fa-file" style="font-size: 24px;"></i>
                </div>
                <h5 class="ms-3 mb-0">{{ $user->group->group_name }}</h5>
            </div>

            {{-- Semesterlar tugmalari --}}
            <div>
                <span class="me-2 text-muted fw-bold">SEMESTR</span>
                @foreach($semesters as $semester)
                    <a href="{{ route('education.subjects', ['semester_id' => $semester->id]) }}"
                    class="btn btn-sm {{ $semesterId == $semester->id ? 'btn-primary' : 'btn-outline-primary' }}">
                        {{ $semester->semester_number }}
                    </a>
                @endforeach
            </div>
        </div>




        <div class="row mt-3">
            @foreach($groupSubjects as $gs)
            <div class="col-md-6 col-lg-4">
                <div class="card subject-card shadow-sm">
                    <div class="card-header text-white" style="background-color: #4169E1; color: white;">
                        <h5 class="subject-title text-white">{{ $gs->subject->{'name_'.app()->getLocale()} }}</h5>
                        <div class="subject-meta">{{ $gs->audit_hours }} soat | {{ $gs->teacher->name ?? '-' }}</div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between align-items-center">
                                <span><a href="{{ route('groupsubjects.student.topics', $gs->id) }}" class="text-dark">Resurslar soni</a></span>
                                <span class="badge bg-primary">{{ $gs->topics->count() ?? 0 }}</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <span>
                                    <a href="{{ route('student.assignments', $gs->id) }}" class="text-dark">
                                        Topshiriqlar soni
                                    </a>
                                </span>
                                <span class="badge bg-danger">{{ $gs->assignments_count ?? 0 }}/{{ $gs->assignments_total ?? 0 }}</span>
                            </li>
                            <!-- <li class="d-flex justify-content-between align-items-center">
                                <span>Testlar</span>
                                <span class="badge bg-success">2/3</span>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-layout.app>
