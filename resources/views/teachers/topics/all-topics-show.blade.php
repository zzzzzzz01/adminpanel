<x-layout.app>
    <x-slot:title>
        {{ $groupSubject->group->group_name ?? '-' }} | {{ $groupSubject->subject->name ?? '-' }} - Mavzular
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
                    <a href="{{ route('all.topics') }}" class="text-decoration-none">
                        Hamma fanlar
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
                            <form action="" method="GET" class="d-flex" style="max-width: 250px;">
                                <input type="text" name="search" class="form-control form-control me-2" placeholder="Qidiruv...">
                            </form>
                            <a href="{{ route('teacherTopics.create', $groupSubject->id) }}" class="btn btn-primary btn-sm" >
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
                            @foreach($groupSubject->topics as  $topic)
                              <tr>
                                <td>
                                  {{ $loop->iteration }}
                                </td>
                                <td>
                                  <div class="product">
                                    <div class="image d-flex align-items-center justify-content-center">
                                    </div>
                                    <p class="text-sm" ><a href="{{ route('teacherTopics.edit', $topic->id) }}" style="color: #7B68EE;">{{ $topic->title }}</a></p>
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





    @if(session('error'))
    <div class="alert alert-danger  position-fixed bottom-0 end-0 p-3" style="background-color: #B22222; color: white;">
        {{ session('error') }}
    </div>  
    @endif

    <script>
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.remove();
            });
        }, 5000); // 5 sekunddan keyin barcha alertlar yo'qoladi
    </script>








</x-layout.app>
