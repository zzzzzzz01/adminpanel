<x-layout.app>

<x-slot:title>
  Talabalar royhati
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
                @if(auth()->user()->hasRole('admin'))
                <li class="breadcrumb-item">
                    <a href="{{ route('groups.index') }}" class="text-decoration-none">
                        Guruxlar ro'yxati
                    </a>
                </li>
                @endif
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Talabalar ro'yxati
                    </a>
                </li>
                <!-- <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ $group->group_name }}
                    </a>
                </li> -->
            </ol>
        </nav>
    </div>



      <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 20px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">{{ $group->full_group_name }}  ({{$group->group_name}}) guruhi talabalari</h3>
                        
                        @if(auth()->user()->hasRole('admin'))
                        <div class="plus d-flex justify-content-between align-items-center">
                          <form action="{{ route('searchGroups.students', $group->id) }}" method="GET" class="d-flex">
                            <div class="input-group">
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ request('search') }}" 
                                    class="form-control" 
                                    placeholder="Talabani qidirish..."
                                >
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                          </form>
                            <a href="{{ route('register.student', $group->id) }}" class="btn btn-primary ms-2" >
                                Talaba qo'shish
                            </a>
                        </div>
                        @endif
                    </div>

                    <div class="card-body p-3">
                        <table class="table table-hover" style="font-size: 15px;">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Talabaning I.F.Sh </th>
                                  <th scope="col">To'lov shakli</th>
                                  <th scope="col">Email</th>
                                  <th scope="col">Telefon raqami</th>
                                  <th scope="col"></td>
                                </tr>
                            </thead>
                            <tbody>

                              @php
                                  // Agar qidiruv bo‘lgan bo‘lsa, $subjects dan foydalanamiz
                                  $subjectList = isset($isSearch) ? $subjects : $group->subjects;

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

                              @foreach($users as $user)
                              <tr>
                                <td>
                                  {{ $loop->iteration }}
                                </td>
                                <td>
                                  <div class="product">
                                    <div class="image d-flex align-items-center justify-content-center">
                                      <img src="{{ asset('storage/'.$user->photo) }}" alt=""  />
                                    </div>
                                    <p class="text-sm" ><a href="">
                                      {!! isset($search) ? highlight($user->last_name, $search) : e($user->last_name) !!}. {!! isset($search) ? highlight($user->name, $search) : e($user->name) !!}. {!! isset($search) ? highlight($user->middle_name, $search) : e($user->middle_name) !!}
                                    </a></p>
                                  </div>
                                </td>
                                  <td>
                                    <p class="text-sm">Davlat granti</p>
                                  </td>
                                  <td>
                                    <p class="text-sm">{{ $user->email }}</p>
                                  </td>
                                  <td>
                                    <p class="text-sm">{{ $user->phone ?? '+000 00 000 00 00 ' }}</p>
                                  </td>
                                  @if(auth()->user()->hasRole('admin'))
                                <td>
                                  <div class="action-buttons">
                                      <form action="" method="POST" style="display:inline;">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-sm btn-delete">
                                              <i class="fas fa-trash text-danger"></i>
                                          </button>
                                      </form>
                                  </div>   
                                </td>
                                @endif
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