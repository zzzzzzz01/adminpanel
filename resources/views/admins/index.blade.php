<x-layout.app>

<x-slot:title>
    Adminlar
</x-slot:title>

<!-- <div class="container">
  <div class="title-wrapper pt-30">
    <div class="row align-items-center">
      <div class="title mt-30 mb-30"> 
        <h2> @lang('words.admin.list') </h2>
        <div class="col-6">
          <div class="title mt-30 mb-30">                       
            <a href="{{ route('register.admin') }}" class="btn btn-success" > @lang('words.admin.create') </a>
          </div>
        </div>
      </div>
        




    <div class="tables-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <div class="card-style mb-30">
            <h4 class="mb-10"> @lang('words.admin.count') ( {{ $users->count() }} )</h4>
            <div class="table-wrapper table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th class="lead-info">
                      <h6 class="ps-5"> @lang('words.admin.full.name') </h6>
                    </th>
                    <th class="lead-email">
                      <h6> @lang('words.email') </h6>
                    </th>
                    <th class="lead-phone">
                      <h6> @lang('words.phone.number') </h6>
                    </th>
                    <th class="lead-company">
                      <h6> @lang('words.data.register') </h6>
                    </th>
                    <th>
                     
                    </th>
                  </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                  <tr>
                    <td class="min-width">
                      <div class="lead">
                        <div class="lead-image">
                          <img src="{{ asset('storage/'. $user->photo) }} " alt="" />
                        </div>
                        <div class="lead-text">
                          <p>{{ $user->name }}. {{ $user->last_name }}. {{ $user->middle_name }}</p>
                        </div>
                      </div>
                    </td>
                    <td class="min-width">
                      <p><a href="#0">{{ $user->email ?? '--' }}</a></p>
                    </td>
                    <td class="min-width">
                      @if($user->phone)
                      <p>{{ $user->phone }}</p>
                      @else
                      <p>--</p>
                      @endif
                    </td>
                    <td class="min-width">
                      <p>{{ $user->created_at->format('Y-m-d') }}</p>
                    </td>
                    <td>

                      <div class="icons d-flex ">
                        <div class="action">
                          <button type="submit" class="btn btn-link p-0">
                            <a href="" data-toggle="modal" data-target="#deleteModal-{{ $user->id }}">
                                <i class="lni lni-trash-can p-0 me-3 text-danger"></i>
                            </a>
                          </button>
                        </div>

                        <div class="modal fade" id="deleteModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel"> @lang('words.admin.delete') </h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                  @if (App::getLocale() == 'uz')
                                    Siz admin "{{ $user->name }}. {{ $user->last_name }}. {{ $user->middle_name }}" ni o'chirishni tasdiqlaysizmi?
                                  @elseif (App::getLocale() == 'ru')
                                    Вы уверены, что хотите удалить администратора "{{ $user->name }}. {{ $user->last_name }}. {{ $user->middle_name }}"?
                                  @elseif (App::getLocale() == 'en')
                                    Are you sure you want to delete admin "{{ $user->name }}. {{ $user->last_name }}. {{ $user->middle_name }}"?
                                  @endif
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal"> @lang('words.close') </button>
                                <form action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"> @lang('words.delete') </button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                            <a href="{{ route('admin.edit', $user) }}"><i class="fa-solid fa-repeat text-success"></i></a>
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
                        <i class="fas fa-home"></i> Asosiy
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                      @lang('words.admin.list')
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
                  <!-- Card Header -->
                  <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 20px 15px; min-height: 70px;">
                      <h3 class="mb-0 text-white" style="font-size: 20px;"> @lang('words.admin.list'): jami( {{ $users->count() }} ) </h3>
                      
                      <div class="plus d-flex justify-content-between align-items-center">
                        <form action="{{ route('admins.search') }}" method="GET" class="d-flex">
                          <div class="input-group">
                              <input 
                                  type="text" 
                                  name="search" 
                                  value="{{ request('search') }}" 
                                  class="form-control" 
                                  placeholder="Admin ismi yoki familiyasi..."
                              >
                              <button type="submit" class="btn btn-primary">
                                  <i class="fa fa-search"></i>
                              </button>
                          </div>
                        </form>
                            <a href="{{ route('register.admin') }}" class="btn btn-primary ms-2">
                              @lang('words.admin.create')
                            </a>
                        </div>
                  </div>

                  @php
                      // request('search') dan olinadi — undefined xatosi ketadi
                      $search = request('search') ?? '';

                      /**
                      * Matndagi qidiruv so'zlarini ajratib beradi.
                      * - UTF-8 va case-insensitive ishlaydi
                      * - Xavfsiz: barcha chiqishlar e() bilan escapelangan
                      */
                      function highlight($text, $search) {
                          if (!$search) {
                              return e($text);
                          }

                          // qidiruv so'zini regex uchun escape qilamiz
                          $escapedSearch = preg_quote($search, '/');

                          // pattern — case-insensitive va unicode
                          $pattern = '/(' . $escapedSearch . ')/iu';

                          // matnni pattern bo‘yicha bo‘lib, mos kelgan qismlarni ajratib markuplaymiz
                          $parts = preg_split($pattern, $text, -1, PREG_SPLIT_DELIM_CAPTURE);

                          $result = '';
                          foreach ($parts as $part) {
                              // agar part qidiruvga mos kelsa — uni highlight bilan o‘rab, escapelaymiz
                              if (preg_match($pattern, $part)) {
                                  $result .= '<span class="search-highlight">' . e($part) . '</span>';
                              } else {
                                  $result .= e($part);
                              }
                          }

                          return $result;
                      }
                  @endphp

                  <style>
                    .search-highlight {
                        background-color: rgba(13, 110, 253, 0.35); /* yumshoq ko‘k fon */
                        color: inherit; /* matn rangini o‘zgartirmaydi */
                        padding: 0; /* ichki bo‘shliq yo‘q */
                        border-radius: 0; /* radiussiz */
                    }
                  </style>

                  <!-- Card Body -->
                  <div class="card-body p-3">
                    <table class="table table-hover" style="font-size: 14px;">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>@lang('words.admin.full.name')</th>
                              <th>@lang('words.email')</th>
                              <th>@lang('words.phone.number')</th>
                              <th>@lang('words.data.register')</th>
                              <th>Mashg‘ulot</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($users as $user)
                              <tr>
                                  <td class="ps-1">{{ $loop->iteration }}</td>
                                  <td>
                                      {!! highlight($user->name, $search) !!} 
                                      {!! highlight($user->last_name, $search) !!} 
                                      {!! highlight($user->middle_name, $search) !!}
                                  </td>
                                  <td>{!! highlight($user->email, $search) !!}</td>
                                  <td>{{ $user->phone ?? '--' }}</td>
                                  <td>{{ $user->created_at->format('d.m.Y') }}</td>
                                  <td>
                                      <a href=""  
                                          data-bs-toggle="modal" 
                                          data-bs-target="#deleteModal{{ $user->id }}"><i class="fa fa-trash text-danger ps-2"></i></a>
                                          <a href="{{ route('admin.edit', $user) }}"><i class="fa-solid fa-repeat ps-4  "></i></a>
                                  </td>
                              </tr>

                              <!-- 🧱 Modal -->
                              <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                      <div class="modal-content border-0 shadow-sm">
                                          <div class="modal-header bg-primary text-white">
                                              <h5 class="modal-title text-white" id="deleteModalLabel{{ $user->id }}">Adminni o‘chirish</h5>
                                              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Yopish"></button>
                                          </div>
                                          <div class="modal-body">
                                              <p class="mb-0">
                                                  <strong>{{ $user->name }} {{ $user->last_name }}</strong> ma’lumotlari butunlay o‘chiriladi. 
                                                  Ushbu amaliyotni bajarishni xohlaysizmi?
                                              </p>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                                              <form action="{{ route('admin.destroy', $user->id) }}" method="POST">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button type="submit" class="btn btn-danger">Ha, o‘chirish</button>
                                              </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>
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
      {{ session('success') }}
    </div>
    @endif

      @if(session('addAdmin'))
      <div class="alert alert-success position-fixed bottom-0 end-0 p-3" style="background-color: #5cb85c; color: white;"> 
        {{ session('addAdmin') }}
      </div>
      @endif

      
      @if(session('adminDelete'))
      <div class="alert alert-danger position-fixed bottom-0 end-0 p-3" style="background-color: #B22222; color: white;">  
        {{ session('adminDelete') }}
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