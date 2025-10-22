<x-layout.app>
<x-slot:title>
  Auditoriyalar
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
                @if(Route::is('auditoriums.edit') && isset($auditorium))
                <li class="breadcrumb-item">
                    <a href="{{ route('auditoriums.index') }}"  class="text-decoration-none">
                        Auditoriyalar royhati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                    {{ $auditorium->name }} | {{ $auditorium->building ?? '-' }}
                    </a>
                </li>
                @else
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Auditoriyalar royhati
                    </a>
                </li>
                @endif
            </ol>
        </nav>
    </div>




<div class="container mt-2">
  <div class="row">
    <!-- Auditoriyalar jadvali -->
    <div class="col-md-8">
      <div class="card p-3 shadow-sm">
        <table class="table" style="font-size: 13px;">
          <thead>
            <tr>
              <th>#</th>
              <th>Nomi</th>
              <th>Sig'im</th>
              <th>Bino</th>
            </tr>
          </thead>
          <tbody>
            @foreach($auditoriums as $aud)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  <a href="{{ route('auditoriums.edit', $aud->id) }}" style="color: #4682B4;">
                    {{ $aud->name }}
                  </a>
                </td>
                <td>{{ $aud->capacity ?? '-' }}</td>
                <td>{{ $aud->building ?? '-' }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <!-- Forma qismi -->
    <div class="col-md-4">
    @if(Route::is('auditoriums.edit') && isset($auditorium))
    <div class="card p-3 shadow-sm">

    <!-- UPDATE FORM -->
    <form action="{{ route('auditoriums.update', $auditorium->id) }}" method="POST">
        @csrf
        @method('PUT')      
        <div class="mb-2">
        <label class="form-label">Auditoriya nomi</label>
        <input type="text" name="name" class="form-control form-control-sm" 
                value="{{ $auditorium->name }}">
        </div>

        <div class="mb-2">
        <label class="form-label">Sig‘imi</label>
        <input type="number" name="capacity" class="form-control form-control-sm" 
                value="{{ $auditorium->capacity }}">
        </div>

        <div class="mb-3">
        <label class="form-label">Bino</label>
        <input type="text" name="building" class="form-control form-control-sm" 
                value="{{ $auditorium->building }}">
        </div>

        <div class="d-flex justify-content-between">
        <a href="{{ route('auditoriums.index') }}" 
            class="btn btn-secondary btn-sm py-1 px-2">Bekor qilish</a>
        <button type="submit" class="btn btn-primary btn-sm py-1 px-2">Yangilash</button>
        </div>
    </form>

    <!-- DELETE FORM -->
    <form action="{{ route('auditoriums.destroy', $auditorium->id) }}" 
            method="POST" class="mt-2 " 
            onsubmit="return confirm('Haqiqatan ham o‘chirmoqchimisiz?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm w-100 py-1">O‘chirish</button>
    </form>

    </div>

    @else
    <!-- CREATE FORM -->
    <form action="{{ route('auditoriums.store') }}" method="POST">
    @csrf
    <div class="card p-3 shadow-sm">
        <div class="mb-2">
        <label class="form-label">Auditoriya nomi</label>
        <input type="text" name="name" class="form-control form-control-sm"
                placeholder="Auditoriya nomini kiriting">
        </div>

        <div class="mb-2">
        <label class="form-label">Sig‘imi</label>
        <input type="number" name="capacity" class="form-control form-control-sm"
                placeholder="Sig‘imini kiriting">
        </div>

        <div class="mb-3">
        <label class="form-label">Bino</label>
        <input type="text" name="building" class="form-control form-control-sm"
                placeholder="Bino nomini kiriting">
        </div>

        <div class="text-end">
        <button type="submit" class="btn btn-primary btn-sm py-1 px-2">Yaratish</button>
        </div>
    </div>
    </form>
    @endif
    </div>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success position-fixed bottom-0 end-0 p-3" 
       style="background-color: #5cb85c; color: white;">
    <i class="fa-solid fa-check pe-1"></i> {{ session('success') }}
  </div>
@endif

</x-layout.app>
