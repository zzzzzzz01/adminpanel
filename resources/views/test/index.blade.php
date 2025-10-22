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
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Testlar ro'yhati
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
                            <!-- <form action="" method="GET" class="d-flex" style="max-width: 250px;">
                                <input type="text" name="search" class="form-control form-control me-2" placeholder="Qidiruv...">
                            </form> -->
                            <a href="{{ route('finalTest.create') }}" class="btn btn-primary" >
                                Yakuniy yaratish
                            </a>
                            <a href="{{ route('all.tests') }}" class="btn btn-info ms-2" >
                                Hamma guruxlar
                            </a>
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
                                <th scope="col">Yaratilgan Sana</th>
                                <th scope="col">Holati</th>
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
                                    <!-- <td class="status-cell" >
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td> -->
                                    <td>
                                        <form action="{{ route('test.toggle-status', $test->id) }}" method="POST">
                                            @csrf
                                            <div class="form-check form-switch">
                                                <input 
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    {{ $test->is_active ? 'checked disabled' : '' }}
                                                    onchange="this.form.submit()"
                                                >
                                            </div>
                                        </form>
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