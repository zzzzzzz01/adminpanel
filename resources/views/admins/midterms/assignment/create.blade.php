<!-- resources/views/assignments/create.blade.php -->
<x-layout.app>
    <x-slot:title>Vazifa yaratish</x-slot:title>

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
                    <a href="{{ route('admin.midterms.index') }}"  class="text-decoration-none">
                        Oqaliq guruxlari
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('adminGroup.midterm', $group) }}" class="text-decoration-none">
                        {{ $midterm->groupSubject->group->group_name }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admins.midterms.assignment', ['group' => $group->id, 'midterm' => $midterm->id]) }}"  class="text-decoration-none">
                        {{ $midterm->groupSubject->subject->{'name_'.app()->getLocale()} }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Oraliq yaratish
                    </a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page">
                    Mavzular
                </li> -->
            </ol>
        </nav>
    </div>
    


    <div class="container" style="font-size: 13px;">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm mt-5">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">{{ $midterm->groupSubject->group->group_name ?? '-' }} guruhiga vazifa yaratish</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('midterms.assignment.store', $midterm->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Vazifa nomi</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Sarlavha</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Tavsif</label>
                                    <textarea name="description" class="form-control"></textarea>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Fayl yuklash</label>
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3  mb-2">
                                    <label class="form-label">Maksimal ball</label>
                                    <input type="number" name="max_score" class="form-control" value="0" required>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Urinishlar soni</label>
                                    <input type="number" name="attempts" class="form-control" value="1" required>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Tugash sanasi</label>
                                    <input type="date"
                                        id="exam_date"
                                        name="due_date"
                                        class="form-control"
                                        @if($min) min="{{ $min }}" @endif
                                        @if($max) max="{{ $max }}" @endif
                                        required>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Tugash vaqti</label>
                                    <input type="time" name="due_time" class="form-control" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary px-4" style="font-size: 13px;">Saqlash</button>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($errors->has('max_score'))
        <div class="alert alert-danger position-fixed bottom-0 end-0 p-3" style="background-color: #B22222; color: white;">
            {{ $errors->first('max_score') }}
        </div>
    @endif














    
</x-layout.app>
