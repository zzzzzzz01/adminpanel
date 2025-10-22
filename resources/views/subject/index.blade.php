<x-layout.app>

<x-slot:title>
    Adminlar
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

        /* Select elementlar uchun border va styling */
        .bootstrap-select .dropdown-toggle {
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
            padding: 0.375rem 0.75rem !important;
            background-color: #fff !important;
        }
        
        .bootstrap-select .dropdown-toggle:focus {
            border-color: #86b7fe !important;
            outline: 0 !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        }
        
        .bootstrap-select .filter-option {
            color: #212529 !important;
        }
        
        .bootstrap-select .dropdown-menu {
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
        }
        
        .bootstrap-select .dropdown-menu.inner {
            max-height: 200px !important;
            overflow-y: auto !important;
        }

        /* Form selectlar uchun */
        .form-select {
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
        }
        
        .form-select:focus {
            border-color: #86b7fe !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        }

        /* Tugmalar bir qatorda */
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
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
                @if(Route::is('subject.edit') && isset($subject))
                <li class="breadcrumb-item">
                    <a href="{{ route('subject.index') }}" class="text-decoration-none">
                        Fanlar ro'yxati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ $subject->{'name_'.app()->getLocale()} }}
                    </a>
                </li>
                @else
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Fanlar ro'yxati
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
                        <h3 class="mb-0 text-white" style="font-size: 20px;"> Fanlar royhati </h3>
                        
                        <div class="plus d-flex justify-content-between align-items-center">
                            <form action="{{ route('subjects.search') }}" method="GET" class="d-flex">
                                <div class="input-group">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        value="{{ request('search') }}" 
                                        class="form-control" 
                                        placeholder="Fan nomi..."
                                    >
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <table class="table table-hover" style="font-size: 15px;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Fan nomi (UZ)</th>
                                    <th scope="col">Fan nomi (RU)</th>
                                    <th scope="col">Fan nomi (EN)</th>
                                    <th scope="col">Yaratilgan sana</th>
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
                                
                            @foreach($subjects as $s)
                            <tr>
                                <td>
                                  {{ $loop->iteration }}
                                </td>
                                <td>
                                  <div class="product">
                                    <div class="image d-flex align-items-center justify-content-center"> 
                                    </div>
                                    <p class="text-sm"> <a href="{{ route('subject.edit', $s->id) }}" style="color: #483D8B;"> {!! isset($search) ? highlight($s->name_uz, $search) : e($s->name_uz) !!} </a> </p>
                                  </div>
                                </td>
                                  <td>
                                    <p class="text-sm"> {!! isset($search) ? highlight($s->name_ru, $search) : e($s->name_ru) !!} </p>
                                  </td>
                                  <td>
                                    <p class="text-sm"> {!! isset($search) ? highlight($s->name_en, $search) : e($s->name_en) !!} </p>
                                  </td>
                                  <td>
                                    <p class="text-sm"> {{ \Carbon\Carbon::parse($s->created_at)->format('d.m.Y | h:m:s') }} </p>
                                  </td>
                                  </tr>
                              @endforeach
                              </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            @if(Route::is('subject.edit') && isset($subject))
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 15px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">Fan o'zgartirish</h3>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('subject.update', $subject->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')  
                            <table class="table" style="font-size: 13px;">
                                <tr>
                                    <th style="width: 100px;"> @lang('words.subject.name') (uz) </th>
                                    <td>
                                        <input type="text" placeholder="" name="name_uz" class="form-control form-control-sm"
                                            value="{{ $subject->name_uz }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('words.subject.name') (ru)</th>
                                    <td>
                                        <input type="text"  name="name_ru" class="form-control form-control-sm"
                                            value="{{ $subject->name_ru }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('words.subject.name') (en)</th>
                                    <td>
                                        <input type="text"  name="name_en" class="form-control form-control-sm"
                                            value="{{ $subject->name_en }}">
                                    </td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-end gap-2 pt-3">
                                <button type="submit" class="btn btn-primary py-1 px-2" style="font-size: 12px;">Saqlash</button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 15px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">Fan yaratish</h3>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('subject.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <table class="table" style="font-size: 13px;">
                                <tr>
                                    <th style="width: 100px;"> @lang('words.subject.name') (uz) </th>
                                    <td>
                                        <input type="text" placeholder="" name="name_uz" class="form-control form-control-sm"
                                            value="">
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('words.subject.name') (ru)</th>
                                    <td>
                                        <input type="text"  name="name_ru" class="form-control form-control-sm"
                                            value="">
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('words.subject.name') (en)</th>
                                    <td>
                                        <input type="text"  name="name_en" class="form-control form-control-sm"
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
            @endif
            </div>
        </div>
    </div>






<!-- <div class="container">
  <div class="title-wrapper pt-30">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="title">
            <h2> @lang('words.subject.list') </h2>
        </div>
      </div>

      <div class="col-6">
        <div class="title">                       
            <a href="{{ route('subject.create') }}" class="btn btn-success"> @lang('words.subject.create') </a>
        </div>
      </div>
    <div class="row">
        @foreach($subjects as $subject)
            <div class="col-lg-3 col-md-4 col-sm-12 mb-3">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center ">
                        <div class="card-left">
                            <h5 class="card-title mb-1">{{ $subject->name }}  {{ $subject->{'name_' . app()->getLocale()} }}</h5>
                        </div>
                        <div class="card-right">
                            <a href="" data-toggle="modal" data-target="#deleteModal-{{ $subject->id }}">
                                <i class="fa-solid fa-trash text-danger"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteModal-{{ $subject->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel"> @lang('words.subject.delete') </h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if (App::getLocale() == 'uz')
                                Siz "{{ $subject->name_uz }}" fanni o'chirishni tasdiqlaysizmi?
                            @elseif (App::getLocale() == 'ru')
                                Вы уверены, что хотите удалить тему «{{ $subject->name_ru }}»?
                            @elseif (App::getLocale() == 'en')
                                Are you sure you want to delete the subject "{{ $subject->name_en }}"?
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal"> @lang('words.close') </button>
                            <form action="{{ route('subject.destroy', $subject->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"> @lang('words.delete') </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
   </div>
  </div>
</div> -->



    @if(session('success'))
        <div class="alert alert-success position-fixed bottom-0 end-0 p-3" style="background-color: #5cb85c; color: white;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('subjectTrash'))
        <div class="alert alert-success position-fixed bottom-0 end-0 p-3" style="background-color: #B22222; color: white;">
            {{ session('subjectTrash') }}
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