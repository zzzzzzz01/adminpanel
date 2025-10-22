<x-layout.app>
    <x-slot:title>
        Guruxlar
    </x-slot:title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">


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
                @if(Route::is('schedules.filter'))
                <li class="breadcrumb-item">
                    <a href="{{ route('schedule.index') }}" class="text-decoration-none">
                        Dars jadvalini boshqarish
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" style="color: #808080;" class="text-decoration-none">
                        {{ $groupName ?? 'Barcha guruhlar' }}
                        @if($semesterName)
                            | {{ $semesterName }}
                        @endif
                    </a>
                </li>
                @else
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Dars jadvalini boshqarish
                    </a>
                </li>
                @endif
            </ol>
        </nav>
    </div>









    <!-- Filtirlash paneli (alohida komponent sifatida) -->
    <div class="container mt-2">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Filtrlar</h4>
                        <form action="{{ route('schedules.filter') }}" method="GET"> 
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="group" class="form-label">Guruh</label>
                                    <select name="group_id" id="group" class="selectpicker w-100" data-live-search="true" required>
                                        <option value="">Tanlang</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}" 
                                                {{ isset($selectedGroup) && $selectedGroup == $group->id ? 'selected' : '' }}>
                                                {{ $group->group_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="semester" class="form-label">Semestr</label>
                                    <select name="semester_id" id="semester" class="selectpicker w-100" data-live-search="true" required>
                                        <option value="">Tanlang</option>
                                        @if(isset($selectedGroup))
                                            @php
                                                $semesters = \App\Models\Semester::where('group_id', $selectedGroup)->get();
                                            @endphp
                                            @foreach($semesters as $semester)
                                                <option value="{{ $semester->id }}" 
                                                    {{ isset($selectedSemester) && $selectedSemester == $semester->id ? 'selected' : '' }}>
                                                    {{ $semester->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('schedule.index') }}" class="btn btn-secondary me-2">Bekor qilish</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter me-2"></i>Filtrni qo'llash
                                    </button>
                                    <a href="{{ route('filter.groups') }}" class="btn btn-success me-2">
                                        <i class="fas fa-plus me-2"></i>Yaratish
                                    </a>
                                </div>
                            </div>
                        </form>


                        
                        
                        <!-- <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-primary">Excel yuklab olish</button>
                            <div>
                                <a href="{{ route('filter.groups') }}" class="btn btn-success me-2">
                                    <i class="fas fa-plus me-2"></i>Yaratish
                                </a>
                                <button class="btn btn-primary">
                                    <i class="fas fa-filter me-2"></i>Filtrni qo'llash
                                </button>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Asosiy kontent -->
    <div class="container" style="font-size: 13px;">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card shadow-sm mb-4">
                <div class="card-body p-2">

                    <table class="table table-hover mb-0" style="font-size: 13px;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 10%;" class="ps-2">O'quv reja</th>
                                <th style="width: 10%;">O'quv yili</th>
                                <th style="width: 10%;">Semestr</th>
                                <th style="width: 10%;">Guruh</th>
                                <th style="width: 60%;">Haftalar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groupSemesterPairs as $pair)
                            <tr>
                                <td class="ps-2">{{ $pair['group']->program->name ?? '-' }}</td>
                                <td>{{ $pair['semester']->academic_year }}</td>
                                <td>{{ $pair['semester']->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('calendar.show', [
                                            '_token' => csrf_token(),
                                            'program_id' => $pair['group']->program_id,
                                            'group_id' => $pair['group']->id,
                                            'academic_year' => $academicYear,
                                            'semester_id' => $pair['semester']->id
                                        ]) }}" style="text-decoration: none; color: #483D8B;">
                                        <strong>{{ $pair['group']->group_name ?? '-' }}</strong>
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                    @foreach($pair['weeks'] as $weekData)
                                        @if($weekData['week'])  <!-- Hafta mavjudligini tekshirish -->
                                            <button type="button" class="btn btn-outline-primary btn-sm position-relative mb-1" 
                                                    style="padding: 0.2rem 0.3rem; line-height: 1; font-size: 12px; min-width: 35px; text-align: center;">
                                                {{ $weekData['week']->week_number }}-hafta
                                                @if($weekData['schedule_count'] > 0)
                                                    <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle p-1" style="font-size: 0.55rem;">
                                                        {{ $weekData['schedule_count'] }}
                                                    </span>
                                                @endif
                                            </button>
                                        @endif
                                    @endforeach
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



<script>
    document.getElementById('group').addEventListener('change', function() {
        let groupId = this.value;
        let semesterSelect = document.getElementById('semester');
        semesterSelect.innerHTML = '<option value="">Yuklanmoqda...</option>';
        $('.selectpicker').selectpicker('refresh');

        if (groupId) {
            fetch(`/schedules/get-semesters/${groupId}`)
                .then(res => res.json())
                .then(data => {
                    semesterSelect.innerHTML = '<option value="">Tanlang</option>';
                    data.forEach(s => {
                        semesterSelect.innerHTML += `<option value="${s.id}">${s.name}</option>`;
                    });
                    $('.selectpicker').selectpicker('refresh');
                });
        } else {
            semesterSelect.innerHTML = '<option value="">Tanlang</option>';
            $('.selectpicker').selectpicker('refresh');
        }
    });
</script>



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker();
        });
    </script>




    <!-- Kurslar bo'yicha guruhlar -->

</x-layout.app>