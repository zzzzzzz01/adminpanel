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
                        <i class="fas fa-home"></i> Asosiy
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Biriktirilgan fanlar
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
                        <h3 class="mb-0 text-white" style="font-size: 20px;">
                            @if($groupSubjects->count() > 0)
                                {{ $groupSubjects->first()->teacher->name ?? '-' }}. uchun biriktirilgan fanlar
                            @endif
                        </h3>
                        
                        <div class="plus d-flex justify-content-between align-items-center">
                            <!-- <form action="" method="GET" class="d-flex" style="max-width: 250px;">
                                <input type="text" name="search" class="form-control form-control me-2" placeholder="Qidiruv...">
                            </form> -->
                            <a href="{{ route('all.topics') }}" class="btn btn-info ms-2">
                                Hamma guruxlar
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <table class="table table-hover" style="font-size: 15px;">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col"> Gurux </th>
                                  <th scope="col"> Fan </th>
                                  <th scope="col"> Seemster </th>
                                  <th scope="col"> Mavzular soni </th>
                                  <th scope="col"> O'qituvchi </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groupSubjects as  $gs)
                              <tr>
                                <td>
                                  {{ $loop->iteration }}
                                </td>
                                <td>
                                  <div class="product">
                                    <div class="image d-flex align-items-center justify-content-center">
                                    </div>
                                    <p class="text-sm" >{{ $gs->group->group_name ?? '-' }}</p>
                                  </div>
                                </td>
                                  <td>
                                    <p class="text-sm">{{ $gs->subject->name_uz }}</p>
                                  </td>
                                  <td>
                                    <p class="text-sm">{{ $gs->semester->name }}</p>
                                  </td>
                                  <td>
                                    <span class="badge text-bg-primary text-white ms-1"><a href="{{ route('topics.showByGroupSubject', $gs->id) }}" class="text-white">{{ $gs->topics->count() ?? 0 }}</a></span>
                                  </td>
                                  <td>
                                    <p class="text-sm">{{ $gs->teacher->name }}</p>
                                  </td>  
                                <!-- <td>
                                  <div class="action-buttons">
                                      <form action="" method="POST" style="display:inline;">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-sm btn-delete">
                                              <i class="fas fa-trash text-danger"></i>
                                          </button>
                                      </form>
                                  </div>   
                                </td> -->
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
