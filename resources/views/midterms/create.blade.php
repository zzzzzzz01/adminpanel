<x-layout.app>
    <x-slot:title>
        Oraliq yaratish
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
                    <a href="{{ route('midterms.index') }}" class="text-decoration-none">
                        Oraliq nazorat
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Oraliq nazorat yaratish
                    </a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page">
                    Mavzular
                </li> -->
            </ol>
        </nav>


    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="card p-3 shadow-sm">
                    <form action="{{ route('midterm.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Guruh va Fan</label>
                            <select name="group_subject_id" class="form-select" required>
                                <option value="" selected disabled>Tanlang...</option>
                                @foreach($groupSubjects as $gs)
                                    <option value="{{ $gs->id }}">
                                        {{ $gs->group->group_name }} | {{ $gs->semester->name }} | {{ $gs->subject->{'name_'.app()->getLocale()} }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Oraliq turi</label>
                            <select name="type" class="form-select" required>
                                <option value="" selected disabled>Tanlang</option>
                                <option value="manual">Yozma</option>
                                <option value="assignment">Vazifa</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Yaratish</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-layout.app>
