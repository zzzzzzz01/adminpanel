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
          <form action="{{ route('programs.store') }}" method="POST">
              @csrf
              <div class="card p-3 mt-2 shadow-sm mt-5">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="turi" class="form-label">Fakultet turi</label>
                      <select name="faculty_id"  class="form-select form-select-sm">
                        <option value=""  selected> Tanlang </option>
                        @foreach($facultys as $faculty)
                        <option value="{{ $faculty->id }}" >{{ $faculty->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label  class="form-label">Nomi</label>
                      <input type="text"  name="name" class="form-control form-control-sm"placeholder="Nomini kiriting">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 mb-3">
                    <label  class="form-label">Kod</label>
                    <input type="text"  name="code" class="form-control form-control-sm"placeholder="Kodini kiriting">
                  </div>

                  <div class="col-md-6 mb-3">
                    <label  class="form-label">Tavsifi</label>
                    <textarea name="description" class="form-control form-control-sm"placeholder="Tavsifini kiriting"></textarea>
                    <!-- <input type="text"  name="description" class="form-control form-control-sm"placeholder="Tavsifini kiriting"> -->
                  </div>
                  </div>
                  
                <div class="text-end">
                  <button type="submit" class="btn btn-primary py-1 px-2" style="font-size: 12px;">
                    Yaratish
                  </button>
                </div>
              </div>
            </form>
      </div>
    </div>
</div>



</x-layout.app>