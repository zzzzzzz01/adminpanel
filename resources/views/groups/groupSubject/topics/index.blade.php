<x-layout.app>
    <x-slot:title>Guruh fanlarini tahrirlash</x-slot:title>


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
                    <a href="{{ route('groups.index') }}" class="text-decoration-none">
                        Guruxlar ro'yxati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('groups.subjects.for.topic', $groupSubject->group->id) }}"  class="text-decoration-none">
                      {{ $groupSubject->group->group_name }} 
                    </a>
                </li>
                
                @if(isset($topic))
                <li class="breadcrumb-item">
                    <a href="{{ route('topics.index', $groupSubject->id) }}"class="text-decoration-none">
                      {{ $groupSubject->subject->{'name_' .app()->getLocale()} }} 
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                    {{ $topic->title }}
                    </a>
                </li>
                @else
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                      {{ $groupSubject->subject->{'name_' .app()->getLocale()} }} 
                    </a>
                </li>
                @endif
            </ol>
        </nav>
    </div>



    <div class="container mt-2">
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 15px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">{{ $groupSubject->subject->name_uz }} - Mavzular</h3>
                        
                        <div class="plus d-flex justify-content-between align-items-center">
                        @php
                            // xavfsiz topicId aniqlash
                            $topicId = optional($topics->first())->id
                                ?? (isset($topic) ? $topic->id : null)
                                ?? optional($groupSubject->topics->first())->id;
                        @endphp

                        @if($topicId)
                        <form action="{{ route('searchGroups.topics', $topicId) }}" method="GET" class="d-flex">
                            <div class="input-group">
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ request('search') }}" 
                                    class="form-control" 
                                    placeholder="Mavzu nomi..."
                                >
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                        @else
                        <!-- Agar topicId mavjud emas bo'lsa, oddiy non-submit qidiruv (yoki forma ko'rsatilmasin) -->
                        <div class="input-group">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}" 
                                class="form-control" 
                                placeholder="Mavzu nomi..."
                                disabled
                            >
                            <button type="button" class="btn btn-secondary" disabled>
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                        @endif
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
                                    <th scope="col"> Yuklangar fayil </th>
                                    <th scope="col"> Faol </td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($topics as $t) 
                              <tr>
                                <td>
                                  {{ $loop->iteration }}
                                </td>
                                <td>
                                  <div class="product">
                                    <div class="image d-flex align-items-center justify-content-center">
                                    </div>
                                    <p class="text-sm"> <a href="{{ route('topics.edit', $t) }}"> {!! $t->title !!} </a> </p>
                                  </div>
                                </td>
                                  <td>
                                    <p class="text-sm">{{ $t->groupSubject->semester->name }}</p>
                                  </td>
                                  <td>
                                    <p class="text-sm"><a href="{{ asset('storage/'.$t->file_path) }}" download>{{ $t->file_path }}</a></p>
                                  </td>
                                  <td class="status-cell">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input"  type="checkbox" checked>
                                    </div>
                                </td>   
                              </tr>
                              @endforeach
                              </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
            @if(isset($topic))
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 15px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">Mavzu yaratish</h3>
                        
                    </div>

                    <div class="card-body p-3">
                        <form action="{{ route('topics.update', $topic->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <table class="table" style="font-size: 13px;">
                                <tr>
                                    <th style="width: 200px;">Nomi</th>
                                    <td>
                                        <input type="text" name="title" class="form-control form-control-sm"
                                            value="{{ $topic->title }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fayl</th>
                                    <td>
                                        <input type="file" name="file" class="form-control form-control-sm"
                                            value="{{ $topic->file }}">
                                    </td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-end gap-2 pt-3">
                                <a href="{{ route('topics.index', $groupSubject->id) }}" class="btn btn-secondary btn-sm py-1 px-2" style="font-size: 12px;">
                                    Bekor qilish
                                </a>
                                <button type="submit" class="btn btn-primary py-1 px-2" style="font-size: 12px;">Saqlash</button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
            <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 15px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">Mavzu yaratish</h3>
                        
                    </div>

                    <div class="card-body p-3">
                        <form action="{{ route('topics.store', $groupSubject->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <table class="table" style="font-size: 13px;">
                                <tr>
                                    <th style="width: 100px;">Nomi</th>
                                    <td>
                                        <input type="text" placeholder="Nomini yozing" name="title" class="form-control form-control-sm"
                                            value="">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fayl</th>
                                    <td>
                                        <input type="file"  name="file" class="form-control form-control-sm"
                                            value="">
                                    </td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-end gap-2 pt-3">
                                <button type="submit" class="btn btn-primary py-1 px-2" style="font-size: 12px;">Saqlash</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>





</x-layout.app>
