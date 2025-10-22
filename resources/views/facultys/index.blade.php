<x-layout.app>

<x-slot:title>
  Fakultetlar
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
                @if(Route::is('facultys.edit') && isset($faculty))
                <li class="breadcrumb-item">
                    <a href="{{ route('facultys.index') }}"  class="text-decoration-none">
                        Facultetlar royhati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                      {{ $faculty->name }}
                    </a>
                </li>
                @else
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Facultetlar royhati
                    </a>
                </li>
                @endif
            </ol>
        </nav>
    </div>






<div class="container mt-2">
  <div class="row">
    <!-- Fakultetlar jadvali -->
    <div class="col-md-8">
      <div class="card p-3 shadow-sm">
        <table class="table" style="font-size: 13px;">
          <thead class="table">
            <tr>
              <th>#</th>
              <th>Nomi</th>
              <th>Turi</th>
              <th>Mashgulot</th>
            </tr>
          </thead>
          <tbody>
            @foreach($facultys as $fac)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  <a href="{{ route('facultys.edit', $fac->id) }}" class="text-dark">
                    {{ $fac->name }}
                  </a>
                </td>
                <td>{{ $fac->faculty_type }}</td>
                <td>
                  <a href="#" data-bs-toggle="modal" data-bs-target="#deleteFacultyModal{{ $fac->id }}">
                        <i class="fa-solid fa-trash text-danger ps-4" style="cursor:pointer;"></i>
                    </a>
                </td>
              </tr>
              <div class="modal fade" id="deleteFacultyModal{{ $fac->id }}" tabindex="-1" aria-labelledby="deleteFacultyLabel{{ $fac->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-sm">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title text-white" id="deleteFacultyLabel{{ $fac->id }}">Fakultetni o‘chirish</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Yopish"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-0">
                                <strong>{{ $fac->name }}</strong> fakulteti butunlay o‘chiriladi.
                                Ushbu amaliyotni bajarishni xohlaysizmi?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                            <form action="{{ route('facultys.destroy', $fac->id) }}" method="POST">
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

    <!-- Forma qismi -->
    <div class="col-md-4">
    @if(Route::is('facultys.edit') && isset($faculty))
      <form action="{{ route('facultys.update', $faculty->id) }}" method="POST">
        @csrf
        @method('PUT')      
        <div class="card p-3 shadow-sm">
          <div class="mb-2">
            <label  class="form-label">Fakultet nomi</label>
            <input type="text"  name="name" class="form-control form-control-sm" value="{{ $faculty->name  }}" >
          </div>

          <div class="mb-3">
            <label class="form-label">Fakultet turi</label>
            <select name="faculty_type"  class="form-select form-select-sm">
              <option selected>{{ $faculty->faculty_type }}</option>
              @foreach(['Mahalliy', 'Boshqasi'] as $type)
                  @if($type !== $faculty->faculty_type)
                      <option value="{{ $type }}">{{ $type }}</option>
                  @endif
              @endforeach
            </select>
          </div>

        <div class="text-end mt-auto pt-2">
      </form>

      <a href="{{ route('facultys.index') }}" class="btn btn-secondary btn-sm py-1 px-2" style="font-size: 12px;">Bekor qilish</a>
      
      <button type="submit" class="btn btn-primary py-1 px-2" style="font-size: 12px;">
        Yangilash
      </button>
      @else
          <form action="{{ route('facultys.store') }}" method="POST">
            @csrf
            <div class="card p-3 shadow-sm">
              <div class="mb-2">
                <label for="fakultet" class="form-label">Fakultet nomi</label>
                <input type="text"  name="name" class="form-control form-control-sm"
                     placeholder="Fakultet nomini kiriting">
              </div>
              <div class="mb-3">
                <label for="turi" class="form-label">Fakultet turi</label>
                <select name="faculty_type"  class="form-select form-select-sm">
                  <option value=""  selected> Tanlang </option>
                  <option value="Mahalliy" >Mahalliy</option>
                  <option value="Boshqasi">Boshqasi</option>
                </select>
              </div>
                
              <div class="text-end">
                <button type="submit" class="btn btn-primary py-1 px-2" style="font-size: 12px;">
                  Yaratish
                </button>
              </div>
            </div>
          </form>
      @endif
    </div>
  </div>
</div>

@if(session('success'))
  <div class="alert alert-success position-fixed bottom-0 end-0 p-3" style="background-color: #5cb85c; color: white;">
    <i class="fa-solid fa-check pe-1"></i> {{ session('success') }}
  </div>
@endif

</x-layout.app>