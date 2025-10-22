<x-layout.app>

<x-slot:title>
  Yonalishlar
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
                        <i class="fas fa-home"></i> Asosiy
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Yonalishlar royhati
                    </a>
                </li>
            </ol>
        </nav>
    </div>


  <div class="container mt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <!-- Card Header -->
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 20px 15px; min-height: 70px;">
                    <h3 class="mb-0 text-white" style="font-size: 20px;">Yonalishlar royhati</h3>
                    
                    <!-- Search Input -->
                    <div class="plus d-flex justify-content-between align-items-center">
                        <form action="{{ route('programs.search') }}" method="GET" class="d-flex">
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
                        <a href="{{ route('programCreate') }}" class="btn btn-primary ms-2">
                            Yonalish yaratish
                        </a>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body p-3">
                    <table class="table table-hover" style="font-size: 14px;">
                      <thead>
                          <tr>
                            <th class="ps-2">#</th>
                            <th>Kodi</th>
                            <th>Nomi</th>
                            <th>Fakulteti</th>
                            <th>Guruxlar soni</th>
                          </tr>
                      </thead>
                      <tbody>

                      @php

                          function highlight($text, $search) {
                              if (!$search) return e($text);
                              $escaped = preg_quote($search, '/');
                              return preg_replace(
                                  "/($escaped)/iu",
                                  '<span style="background-color: rgba(13,110,253,0.25); border-radius:3px; padding:1px 2px;">$1</span>',
                                  e($text)
                              );
                          }
                      @endphp

                        @foreach($programs as $program)
                          <tr>
                            <td class="ps-2">{{ $loop->iteration }}.</td>
                            <td> {!! isset($search) ? highlight($program->code, $search) : e($program->code) !!} </td>
                            <td>
                              <a href="{{ route('programs.edit', $program->id) }}" class="text-dark">
                               {!! isset($search) ? highlight($program->name, $search) : e($program->name) !!}
                              </a>
                            </td>
                            <td>{{ $program->faculty->name }}</td>
                            <td>{{ $program->groups->count() }}</td>
                          </tr>
                          <tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>






  @if(session('success'))
  <div class="alert alert-success position-fixed bottom-0 end-0 p-3" style="background-color: #5cb85c; color: white;">
    <i class="fa-solid fa-check pe-1"></i> {{ session('success') }}
  </div>
@endif

</x-layout.app>