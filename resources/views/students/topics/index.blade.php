<x-layout.app>
    <x-slot:title>
        {{ $groupSubject->subject->name }} fanining mavzulari
    </x-slot:title>

    <!-- <div class="container mt-3">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5>{{ $groupSubject->subject->{'name_'.app()->getLocale()}  }} – Mavzular</h5>
            </div>
            <div class="card-body">
                @if($topics->isEmpty())
                    <p>Mavzular hali qo‘shilmagan.</p>
                @else
                    <ul class="list-group">
                        @foreach($topics as $topic)
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <strong>{{ $topic->title }}</strong><br>
                                    <small>{{ $topic->user->name ?? 'Admin' }}</small>
                                </div>
                                @if($topic->file)
                                    <a href="{{ asset('storage/'.$topic->file) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                        Faylni yuklab olish
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div> -->

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
                    <a href="{{ route('education.subjects') }}" class="text-decoration-none">
                        Fan resurslari
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                    {{ $groupSubject->subject->{'name_'.app()->getLocale()}  }}
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
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 15px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">{{ $groupSubject->subject->{'name_'.app()->getLocale()}  }} – Mavzular</h3>
                        
                        <div class="plus d-flex justify-content-between align-items-center">
                            <!-- <form action="" method="GET" class="d-flex" style="max-width: 250px;">
                                <input type="text" name="search" class="form-control form-control me-2" placeholder="Qidiruv...">
                            </form> -->
                            <!-- <a href="{{ route('topics.create', $groupSubject->id) }}" class="btn btn-primary btn-sm" >
                               Yaratish
                            </a> -->
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <table class="table table-hover" style="font-size: 15px;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"> Nomi </th>
                                    <th scope="col"> Seemster </th>
                                    <th scope="col"> O'qituvchi </th>
                                    <th scope="col"> Yaratilgan sana </td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($topics as $topic)
                              <tr>
                                <td>
                                  {{ $loop->iteration }}
                                </td>
                                <td>
                                  <div class="product">
                                    <div class="image d-flex align-items-center justify-content-center">
                                    </div>
                                    <p class="text-sm mb-0">
                                        <a href="#"
                                        class="text-decoration-none"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $topic->id }}">
                                            {!! $topic->title !!}
                                        </a>
                                    </p>
                                  </div>

                                  <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{ $topic->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header float-right">
                                                <h5>User details</h5>
                                                <div class="text-right">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Fan nomi</th>
                                                            <td>{{ $topic->groupSubject->subject->{'name_'.app()->getLocale()}  ?? '--' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Xodim</th>
                                                            <td>{{ $topic->groupSubject->teacher->name ?? '--'  }}. {{ $topic->groupSubject->teacher->name ?? '--'  }}. {{ $topic->groupSubject->teacher->name ?? '--'  }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Sarlavha</th>
                                                            <td>{{ $topic->title }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Fayl</th>
                                                            <td>{{ $topic->file_path }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Yaratilgan sana</th>
                                                            <td>{{ \Carbon\Carbon::parse($topic->yaratilgan)->format('d.m.Y | H:i:s') }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <!-- <button type="button" class="btn btn-primary"><a href="{{ asset('storage/'.$topic->file_path) }}"class="btn btn-primary"  download>
                                                    Yuklab olish
                                                </a></button> -->

                                                <a href="{{ asset('storage/topics/' . $topic->file_path) }}" target="_blank" download><button type="button" class="btn btn-primary">
                                                    Yuklab olish
                                                </button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                </td>
                                  <td>
                                    <p class="text-sm"> {{ $topic->groupSubject->semester->name }} </p>
                                  </td>
                                  <td>
                                    <p class="text-sm"> {{ $topic->groupSubject->teacher->name }} </p>
                                  </td>  
                                  <td>
                                    <p class="text-sm"> {{ \Carbon\Carbon::parse($topic->created_at)->format('d.m.Y | H.m.s') }}</p>
                                  </td>  
                              </tr>
                              @endforeach
                              </tbody>








</x-layout.app>
