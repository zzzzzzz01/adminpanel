<x-layout.app>

<x-slot:title>
  Yangiliklar
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
                    <a href="{{ route('groups.index') }}"  class="text-decoration-none">
                        Guruxlar ro'yxati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('groups.weeks.index', $group->id) }}"  class="text-decoration-none">
                        {{ $group->group_name }}
                    </a>
                </li>
                @if(isset($week))
                    <li class="breadcrumb-item">
                        <a href="" style="color: #808080;" class="text-decoration-none">
                            {{ \Carbon\Carbon::parse($week->start_date)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($week->end_date)->format('d.m.Y') }}
                        </a>
                    </li>
                @endif
            </ol>
        </nav>
    </div>




    <div class="container mt-2">
    <div class="row">
        <!-- Chap jadval -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center" 
                    style="background-color: #2c3e50; min-height: 70px; border-radius: 5px 5px 0 0;">
                    <h3 class="mb-0 text-white" style="font-size: 20px;">
                        {{ $group->group_name }} guruhining haftalari
                    </h3>
                </div>
                <div class="card-body p-3">
                    <table class="table table-hover " style="font-size: 14px;">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-2">#</th>
                                <th>Hafta</th>
                                <th>Semestr</th>
                                <th>Hafta turi</th>
                                <th>Faol</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($weeks as $w)
                            <tr @if($w->week_type === 'Tatil') style="background-color: #fed2cd; color: dark;" @endif>
                                <td class="ps-2">{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('groups.weeks.edit', [$group->id, $w->id]) }}" style="color: #483D8B;">
                                        {{ \Carbon\Carbon::parse($w->start_date)->format('d.m.Y') }} –
                                        {{ \Carbon\Carbon::parse($w->end_date)->format('d.m.Y') }}
                                    </a>
                                </td>
                                <td>{{ $w->semester->name }}</td>
                                <td>{{ $w->week_type ?? '-' }}</td>
                                <td>
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <form action="{{ route('weeks.toggle', $w->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input class="form-check-input" type="checkbox" 
                                                onChange="this.form.submit()" 
                                                {{ $w->is_active ? 'checked' : '' }}>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- O‘ng forma -->
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 100px;">
                <div class="card-body p-3">
                    @if(isset($week))
                    <form action="{{ route('groups.weeks.update', [$group->id, $week->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <table class="table table-borderless mb-3" style="font-size: 14px;">
                            <tr>
                                <th style="width: 45%">Boshlanish sanasi</th>
                                <td><input type="date" name="start_date" class="form-control form-control-sm" value="{{ \Carbon\Carbon::parse($week->start_date)->format('Y-m-d') }}"></td>
                            </tr>
                            <tr>
                                <th>Tugash sanasi</th>
                                <td><input type="date" name="end_date" class="form-control form-control-sm" value="{{ \Carbon\Carbon::parse($week->end_date)->format('Y-m-d') }}"></td>
                            </tr>
                            <tr>
                                <th>Hafta raqami</th>
                                <td><input type="number" class="form-control form-control-sm" value="{{ $week->week_number }}" disabled></td>
                            </tr>
                            <tr>
                                <th>Semestr</th>
                                <td><input type="text" class="form-control form-control-sm" value="{{ $week->semester->name }}" disabled></td>
                            </tr>
                            <tr>
                                <th>Hafta turi</th>
                                <td>
                                    <select name="week_type" class="form-select form-select-sm">
                                        @foreach($weekTypes as $type)
                                            <option value="{{ $type }}" {{ $week->week_type === $type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('groups.weeks.index', $group->id) }}" class="btn btn-secondary btn-sm px-3">Bekor qilish</a>
                            <button type="submit" class="btn btn-primary btn-sm px-3">Yangilash</button>
                        </div>
                    </form>
                    @else
                    <form>
                        <table class="table table-borderless mb-3" style="font-size: 14px;">
                            <tr><th>Boshlanish sanasi</th><td><input type="date" class="form-control form-control-sm"></td></tr>
                            <tr><th>Tugash sanasi</th><td><input type="date" class="form-control form-control-sm"></td></tr>
                            <tr><th>Hafta raqami</th><td><input type="number" class="form-control form-control-sm"></td></tr>
                            <tr><th>Semestr</th><td><select class="form-select form-select-sm"><option>Tanlash</option></select></td></tr>
                            <tr><th>Hafta turi</th><td><select class="form-select form-select-sm"><option>Tanlash</option></select></td></tr>
                        </table>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>





</x-layout.app>