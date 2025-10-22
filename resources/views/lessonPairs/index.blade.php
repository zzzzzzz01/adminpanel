<x-layout.app>
<x-slot:title>
  Juftliklar (Lesson Pairs)
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
                @if(Route::is('lessonPairs.edit') && isset($lessonPair))
                <li class="breadcrumb-item">
                    <a href="{{ route('lessonPairs.index') }}"  class="text-decoration-none">
                        Juftliklar royhati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                      {{ $lessonPair->pair_number }}.  {{ \Carbon\Carbon::parse($lessonPair->start_time)->format('h:m') }}-{{ \Carbon\Carbon::parse($lessonPair->end_time)->format('h:m') }}
                    </a>
                </li>
                @else
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Juftliklar royhati
                    </a>
                </li>
                @endif
            </ol>
        </nav>
    </div>





<div class="container mt-2">
  <div class="row">
    <!-- Forma qismi -->
    <div class="col-md-4">
      @if(Route::is('lessonPairs.edit') && isset($lessonPair))
        <div class="card p-3 shadow-sm">

          <!-- UPDATE FORM -->
          <form action="{{ route('lessonPairs.update', $lessonPair->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-2">
              <label class="form-label">Nomi</label>
              <input type="text" name="pair_number" class="form-control form-control-sm" value="{{ $lessonPair->pair_number }}">
            </div>

            <div class="mb-2">
              <label class="form-label">Boshlanish va Tugash vaqti</label>
              <div class="d-flex align-items-center">
                <input type="time" name="start_time" class="form-control form-control-sm me-2" value="{{ $lessonPair->start_time }}">
                <span class="me-2">to</span>
                <input type="time" name="end_time" class="form-control form-control-sm" value="{{ $lessonPair->end_time }}">
              </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
              <a href="{{ route('lessonPairs.index') }}" class="btn btn-secondary me-2">Bekor qilish</a>
              <button type="submit" class="btn btn-primary me-2">Yangilash</button>
            </div>
          </form>

          <!-- DELETE FORM -->
          <form action="{{ route('lessonPairs.destroy', $lessonPair->id) }}" method="POST"
                onsubmit="return confirm('Haqiqatan ham o‘chirmoqchimisiz?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">O‘chirish</button>
          </form>
        </div>
      @else
        <!-- CREATE FORM -->
        <form action="{{ route('lessonPairs.store') }}" method="POST">
          @csrf
          <div class="card p-3 shadow-sm">
            <div class="mb-2">
              <label class="form-label">Nomi</label>
              <input type="text" name="pair_number" class="form-control form-control-sm" placeholder="Masalan: 1, 2, 3...">
            </div>

            <div class="mb-2">
              <label class="form-label">Boshlanish va Tugash vaqti</label>
              <div class="d-flex align-items-center">
                <input type="time" name="start_time" class="form-control form-control-sm me-2">
                <span class="me-2">to</span>
                <input type="time" name="end_time" class="form-control form-control-sm">
              </div>
            </div>

            <div class="text-end mt-2">
              <button type="submit" class="btn btn-primary btn-sm py-1 px-2">Saqlash</button>
            </div>
          </div>
        </form>
      @endif
    </div>

    <!-- Jadval qismi -->
    <div class="col-md-8">
      <div class="card p-3 shadow-sm">
        <table class="table" style="font-size: 13px;">
          <thead>
            <tr>
              <th>#</th>
              <th>Nomi</th>
              <th>Boshlanish vaqti</th>
              <th>Yaratilgan sana</th>
            </tr>
          </thead>
          <tbody>
            @foreach($lessonPairs as $pair)
              <tr>
                <td><i class="fa-solid fa-bars"></i></td>
                <td>
                    {{ $pair->pair_number }}
                </td>
                <td>
                    <a href="{{ route('lessonPairs.edit', $pair->id) }}" class="text-dark">
                    {{ \Carbon\Carbon::parse($pair->start_time)->format('H:i') }}
                    -
                    {{ \Carbon\Carbon::parse($pair->end_time)->format('H:i') }}
                    </a>
                </td>
                <td>
                  {{ \Carbon\Carbon::parse($pair->created_at)->format('d.m.Y | H:i') }}
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
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
