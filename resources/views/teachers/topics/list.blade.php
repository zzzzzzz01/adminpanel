<x-layout.app>
    <x-slot:title>
        {{ $groupSubject->group->group_name ?? '-' }} | {{ $groupSubject->subject->name ?? '-' }} - Mavzular
    </x-slot:title>

    <!-- <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>
                {{ $groupSubject->group->group_name ?? '-' }} guruh 
                | {{ $groupSubject->subject->name ?? '-' }} fani
            </h4>
            <a href="" class="btn btn-success">
                + Yangi mavzu qo‘shish
            </a>
        </div>

        @if($groupSubject->topics->count() > 0)
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="table">
                            <tr>
                                <th>#</th>
                                <th>Mavzu nomi</th>
                                <th>Fayl</th>
                                <th>Qoʻshgan</th>
                                <th>Amallar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groupSubject->topics as $index => $topic)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $topic->title }}</td>
                                    <td>{{ $topic->file_path ?? '-' }}</td>
                                    <td>{{ $topic->user->roles->pluck('name')->implode(', ')  ?? '-' }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary">Tahrirlash</a>
                                        <a href="#" class="btn btn-sm btn-danger">O‘chirish</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="alert alert-warning">
                Hozircha hech qanday mavzu qo‘shilmagan.
            </div>
        @endif
    </div> -->


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
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ $groupSubject->group->group_name ?? '-' }} guruh 
                        | {{ $groupSubject->subject->name_uz ?? '-' }} fani mavzulari
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
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 10px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">
                        {{ $groupSubject->group->group_name ?? '-' }} guruh 
                        | {{ $groupSubject->subject->name_uz ?? '-' }} fani
                        </h3>
                        
                        <div class="plus d-flex justify-content-between align-items-center">
                            <form action="{{ route('topics.search', $groupSubject->id) }}" method="GET" class="d-flex pe-2">
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
                            <a href="{{ route('teacherTopics.create', $groupSubject->id) }}" class="btn btn-primary" >
                               Yaratish
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <table class="table table-hover" style="font-size: 15px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mavzu nomi</th>
                                    <th>Fayl</th>
                                    <th>Qoʻshgan</th>
                                    <th>Amallar</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($topics as $topic)
                              <tr>
                                <td>
                                  {{ $loop->iteration }}
                                </td>
                                <td>
                                  <div class="product">
                                    <div class="image d-flex align-items-center justify-content-center">
                                    </div>
                                    <p class="text-sm" ><a href="{{ route('teacherTopics.edit', $topic->id) }}" style="color: #7B68EE;">{!! $topic->title !!}</a></p>
                                  </div>
                                </td>
                                  <td>
                                    <p class="text-sm">{{ $topic->file_path ?? '-' }}</p>
                                  </td>
                                  <td>
                                    <p class="text-sm">{{ $topic->user->roles->pluck('name')->implode(', ')  ?? '-' }}</p>
                                  </td>
                                <td>
                                <div class="action-buttons">
                                    <!-- Delete tugma modalni ochadi -->
                                    <button type="button" class="btn btn-sm btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $topic->id }}">
                                        <i class="fas fa-trash text-danger"></i>
                                    </button>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal{{ $topic->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $topic->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="deleteModalLabel{{ $topic->id }}">O‘chirishni tasdiqlash</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Yopish"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Haqiqatan ham <strong>{{ $topic->title }}</strong> mavzusini o‘chirmoqchimisiz?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                                                
                                                <!-- Formani modal ichida yuborish -->
                                                <form action="{{ route('teacherTopic.destroy', $topic->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Ha, o‘chirish</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
