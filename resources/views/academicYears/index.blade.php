<x-layout.app>

<x-slot:title>
  Oquv yili
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
                @if(Route::is('academicYear.edit'))
                <li class="breadcrumb-item">
                    <a href="{{ route('academicYear.index') }}" class="text-decoration-none">
                        O'quv yillar royhati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ $academicYear->name }}
                    </a>
                </li>
                @else
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        O'quv yillar royhati
                    </a>
                </li>
                @endif
            </ol>
        </nav>
    </div>



<div class="container mt-2">
    <div class="row">
        <div class="col-md-8">
            <div class="card p-3 shadow-sm">
                <table class="table" style="font-size: 13px;">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Nomi</th>
                        <th>Yaratilgan sana</th>
                        <th>Harakatlar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($academicYears as $year)
                        <tr>
                            <td> {{ $loop->iteration }} </td>
                            <td>
                            <a href="{{ route('academicYear.edit', $year->id) }}" style="color: #4682B4;">
                                {{ $year->name }}
                            </a>
                            </td>
                            <td> {{ \Carbon\Carbon::parse($year->created_at)->format('Y.m.d | H:i:s') }}</td>
                            <td>
                                <form action="{{ route('academicYear.delete', $year->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            style="border: none; background: none; padding: 0; cursor: pointer;">
                                        <i class="fa-solid fa-trash text-danger ps-2"></i>
                                    </button>
                                </form>
                            </td>
                            <!-- <td><a href=""><i class="fa-solid fa-trash text-danger ps-2"></i></a></td> -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if(Route::is('academicYear.edit') && isset($year))
        <div class="col-md-4">
            <form action="{{ route('academicYear.store') }}" method="POST">
            @csrf
                <div class="card p-3 shadow-sm">
                    <div class="mb-2">
                        <label class="form-label">Nomi</label>
                        <input type="text" value="{{ $academicYear->name }}" name="name" class="form-control form-control-sm"
                                placeholder="O'quv yili nomini kiriting">
                        </div>

                        <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-sm py-1 px-2">Yangilash</button>
                    </div>
                </div>
            </form>
        </div>
        @else
        <div class="col-md-4">
            <form action="{{ route('academicYear.store') }}" method="POST">
            @csrf
                <div class="card p-3 shadow-sm">
                    <div class="mb-2">
                        <label class="form-label">Nomi</label>
                        <input type="text" name="name" class="form-control form-control-sm"
                                placeholder="O'quv yili nomini kiriting">
                        </div>

                        <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-sm py-1 px-2">Yaratish</button>
                    </div>
                </div>
            </form>
        </div>
        @endif
        </div>
    </div>
</div>






</x-layout.app>