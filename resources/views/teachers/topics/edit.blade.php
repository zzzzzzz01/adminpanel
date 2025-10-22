<x-layout.app>
    <x-slot:title>
        Mavzular
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
                        <i class="fas fa-home pe-1"></i> Asosiy
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('teacher.topic', $groupSubject->id) }}" class="text-decoration-none">
                        Biriktirilgan fanlar
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('topics.showByGroupSubject', $groupSubject->id) }}"  class="text-decoration-none">
                        {{ $groupSubject->group->group_name ?? '-' }} guruh 
                        | {{ $groupSubject->subject->name_uz ?? '-' }} fani mavzulari
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ $topic->title }}
                    </a>
                </li>
            </ol>
        </nav>
    </div>

    <div class="container mt-2">
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 20px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">
                            Ozgartirish
                        </h3>
                    </div>
                        <div class="card-body">
                            <form action="{{ route('teacherTopics.update', $topic) }}" method="POST" enctype="multipart/form-data">
                            <!-- Agar Laravel ishlatsangiz -->
                            @csrf
                            @method('PUT')

                            <!-- Title input -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Sarlavha</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $topic->title }}" placeholder="">
                            </div>

                            <!-- File input -->
                            <div class="mb-3">
                                <label for="file" class="form-label">Fayl yuklash</label>
                                <input class="form-control" type="file" name="file_path" >
                                @if($topic->file_path)
                                    <small class="text-muted mt-2">
                                        Joriy fayl: <a href="{{ asset('storage/'. $topic->file_path) }}" target="_blank">{{ $topic->file_path }}</a>
                                    </small>
                                @endif
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-success w-100">Yangilash</button>
                            </form>
                        </div>

    </x-layout.app>