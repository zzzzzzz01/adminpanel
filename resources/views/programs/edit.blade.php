<x-layout.app>

<x-slot:title>
  Yonalishlar
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
                    <a href="{{ route('programs.index') }}" class="text-decoration-none">
                        Yonalishlar royhati
                    </a>
                </li>

                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Yonalish yaratish
                    </a>
                </li>
            </ol>
        </nav>
    </div>






    <div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card p-3 mt-2 shadow-sm mt-5">
        <form id="updateForm" action="{{ route('programs.update', $program->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="turi" class="form-label">Fakultet turi</label>
              <select name="faculty_id" class="form-select form-select-sm">
                <option value="{{ $program->faculty->id }}" selected>{{ $program->faculty->name }}</option>
                @foreach($facultys as $faculty)
                  <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Nomi</label>
              <input type="text" name="name" value="{{ $program->name }}" class="form-control form-control-sm" placeholder="Nomini kiriting">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Kod</label>
              <input type="text" name="code" value="{{ $program->code }}" class="form-control form-control-sm" placeholder="Kodini kiriting">
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Tavsifi</label>
              <textarea name="description" class="form-control form-control-sm" placeholder="Tavsifini kiriting">{{ $program->description }}</textarea>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary py-1 px-2" style="font-size: 12px;">
              Yangilash
            </button>

            <button type="button" id="deleteButton" class="btn btn-danger py-1 px-2" style="font-size: 12px;">
              O‘chirish
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('deleteButton').addEventListener('click', function() {
  if (confirm("Haqiqatan ham o‘chirmoqchimisiz?")) {
    fetch("{{ route('programs.destroy', $program->id) }}", {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ _method: "DELETE" })
    })
    .then(res => {
      if (res.ok) {
        alert("Dastur o‘chirildi!");
        window.location.href = "{{ route('programs.index') }}";
      } else {
        alert("O‘chirishda xatolik yuz berdi!");
      }
    });
  }
});
</script>




</x-layout.app>