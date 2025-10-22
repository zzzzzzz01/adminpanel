<x-layout.app>
<x-slot:title>
        Yakuniylar
    </x-slot:title>

    <style>
        :root {
            --primary-color: #4a6bdf;
            --secondary-color: #32c48d;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* .container {
            max-width: 1000px;
            margin: 0 auto;
        } */
        
        /* .header {
            background: linear-gradient(135deg, var(--primary-color), #6c8eff);
            color: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        } */
        
        .card {
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            border: none;
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
            padding: 15px 20px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: #3a56c4;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(74, 107, 223, 0.25);
        }
        
        .question-box {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }
        
        .option-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: background-color 0.2s;
        }
        
        .correct-answer {
            background-color: #e8f5e9;
            border-left: 4px solid var(--secondary-color);
        }
        
        .preview-container {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            max-height: 900px;
            overflow-y: auto;
        }
        
        .format-example {
            background-color: #f0f4ff;
            padding: 15px;
            border-radius: 8px;
            font-family: monospace;
            white-space: pre-wrap;
            margin-bottom: 20px;
        }
        
        .instructions {
            background-color: #fff8e1;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .instructions ul {
            margin-bottom: 0;
            padding-left: 20px;
        }
        
        .instructions li {
            margin-bottom: 5px;
        }

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
                        Test yaratish
                    </a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page">
                    Mavzular
                </li> -->
            </ol>
        </nav>
    </div>

    
    <div class="container mt-2">     
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-info-circle me-2"></i>Test Ma'lumotlari
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tests.store') }}"  method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="testName" class="form-label">Test Nomi</label>
                                <input type="text" name="name" class="form-control" id="testName" placeholder="Test nomini kiriting">
                            </div>
                            
                            <div class="mb-3">
                                <label for="testGroups" class="form-label">Guruhlar</label>
                                <select class="form-select" name="group_subject_id">
                                    <option value="" selected disabled>Guruxni tanlag</option>
                                @foreach($groupSubjects as $groupSubject)
                                    <option value="{{ $groupSubject->id }}" >
                                        {{ $groupSubject->group->group_name ?? '-' }} | {{ $groupSubject->subject->name_uz ?? '-' }} | {{ $groupSubject->semester->name ?? '-' }}
                                    </option>
                                @endforeach
                                </select>
                                <div class="form-text">Bir nechta guruhni tanlash uchun Ctrl (yoki Cmd) tugmasini bosib turib tanlang</div>
                            </div>
                            <div class="mb-3">
                                <label for="timeLimit" class="form-label">
                                    <i class="fas fa-clock info-icon pe-1"></i>Test Vaqti (daqiqa)
                                </label>

                                <input type="number" name="time_limit" class="form-control" id="timeLimit" placeholder="45" min="1" value="45">
                                <div class="form-text">Agar bo'sh qoldirilsa, standart 45 daqiqa bo'ladi</div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary create-btn">
                                <i class="fas fa-plus-circle me-2"></i>Test Yaratish
                            </button>
                        </form>
                    </div>
                </div>               
            </div>
        </div>
    </div>


    </x-layout.app>