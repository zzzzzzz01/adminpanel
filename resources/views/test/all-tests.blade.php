<x-layout.app>
    <x-slot:title>
        Yakuniylar
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
                        <i class="fas fa-home me-1"></i> Asosiy
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('test.index') }}" class="text-decoration-none">
                        Testlar ro'yhati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Hamma guruxlar
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
                        <h3 class="mb-0 text-white" style="font-size: 20px;">Yakuniy Testlar Ro'yxati</h3>
                        
                        <div class="plus d-flex justify-content-between align-items-center">
                            <form action="{{ route('test.search') }}" method="GET" class="d-flex pe-2">
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
                                <!-- <a href="{{ route('finalTest.create') }}" class="btn btn-primary" >
                                    Yakuniy yaratish
                                </a> -->
                            <!-- <a href="{{ route('all.tests') }}" class="btn btn-info ms-2" >
                                Hamma guruxlar
                            </a> -->
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <table class="table table-hover" style="font-size: 15px;">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Test Nomi</th>
                                <th scope="col">Fan</th>
                                <th scope="col">Savollar soni</th>
                                <th scope="col">Guruh</th>
                                <th scope="col">Maksimal ball</th>
                                <th scope="col">Yartilgan sana</th>
                                <th scope="col" class="ps-4">Semester(D)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tests as $test)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $test->name }}</td>
                                    <td>{{ $test->groupSubject->subject->{'name_' . app()->getLocale()} }}</td>
                                    <td><a href="{{ route('questions.show', $test->id) }}" style="color: #6c8eff;">{{ $test->questions->count() }}</a></td>
                                    <td><span class="badge text-bg-primary">{{ $test->groupSubject->group->group_name }}</span></td>
                                    <!-- <td><a href="{{ route('tests.addQuestions', $test->id) }}" style="color: #6c8eff;">{{ $test->questions->count() }}</a></td> -->
                                    <!-- <td>30</td> -->
                                    <td> {{ $test->groupSubject->max_final_score }} </td>
                                    <td>{{ \Carbon\Carbon::parse($test->created_at)->format('d.m.Y | H:i') }}</td>
                                    <td class="pb-2">

                                    @php
                                        $semester = $test->groupSubject->semester ?? null;
                                        $badgeClass = '';

                                        if ($semester) {
                                            $today = now()->toDateString();

                                            if ($today < $semester->start_date) {
                                                $badgeClass = 'bg-warning text-dark'; // hali boshlanmadi
                                            } elseif ($today > $semester->end_date) {
                                                $badgeClass = 'bg-danger'; // tugagan
                                            } else {
                                                $badgeClass = 'bg-success'; // davom etmoqda
                                            }
                                        } else {
                                            $badgeClass = 'bg-secondary';
                                        }
                                    @endphp

                                        <div class="ps-5">{{ $test->groupSubject->semester->name ?? '-' }}</div>
                                        <span class="badge {{ $badgeClass }} text-white ms-2">{{ \Carbon\Carbon::parse($test->groupSubject->semester->end_date ?? '-')->format('d.m.Y') }} | {{ $test->groupSubject->semester->end_date ?? '-' }}</span>
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