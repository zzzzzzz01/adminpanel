    <x-layout.app>
        <x-slot:title>Guruh fanlarini tahrirlash</x-slot:title>


    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"> -->
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
                <li class="breadcrumb-item">
                    <a href="{{ route('groups.index') }}"  class="text-decoration-none">
                        Guruxlar ro'yxati
                    </a>
                </li>
                @if(Route::is('groupSubject.edit'))
                <li class="breadcrumb-item">
                    <a href="{{ route('groupSubject.index', $group->id) }}" class="text-decoration-none">
                        {{ $group->group_name }}
                    </a>
                </li>
                    <li class="breadcrumb-item">
                        <a href="" style="color: #808080;" class="text-decoration-none">
                            {{ $editingSubject->{ 'name_' .app()->getLocale() } }}
                        </a>
                    </li>
                    @else
                    <li class="breadcrumb-item">
                        <a href="{{ route('groupSubject.index', $group->id) }}" style="color: #808080;"  class="text-decoration-none">
                            {{ $group->group_name }}
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
                        <h3 class="mb-0 text-white" style="font-size: 20px;">{{ $group->group_name }} — Fanlarni boshqarish</h3>
                        
                        <div class="plus d-flex justify-content-between align-items-center">
                        <form action="{{ route('groupSubjects.search', $group->id) }}" method="GET" class="d-flex">
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
                                    <th scope="col">Fan nomi</th>
                                    <th scope="col">Audit soati</th>
                                    <th scope="col">O‘qituvchi</th>   
                                    <th scope="col">Semestr</th>
                                    <th scope="col">Oquv yili</th>
                                    <th scope="col">Jurnal yaratish</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groupSubjects as $gs)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('groupSubject.edit', [$group->id, $gs->subject->id]) }}">
                                            {{ $gs->subject->name_uz ?? '-' }}
                                        </a>
                                    </td>
                                    <td>{{ $gs->audit_hours }}</td>
                                    <td>{{ $gs->teacher->name ?? '-' }}</td>
                                    <td>{{ $gs->semester->name ?? '-' }}</td>
                                    <td>{{ $gs->semester->academic_year ?? '-' }}</td>
                                    <td>
                                        @php
                                            $hasJournal = \App\Models\Journal::where('group_subject_id', $gs->id)->exists();
                                        @endphp
                                        <form action="{{ route('groupSubject.createJournal') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="group_subject_id" value="{{ $gs->id }}">
                                            <input type="checkbox" name="create_journal_{{ $gs->id }}" 
                                                onchange="this.form.submit()" 
                                                @if($hasJournal) checked disabled @endif>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach

                                @if($groupSubjects->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">Fanlar mavjud emas</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
            @if(Route::is('groupSubject.edit'))
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 15px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">Fanlarni biriktirish</h3>   
                    </div>

                    <div class="card-body p-3">
                        <form action="{{ route('groupSubject.update', $group->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Fanlar --}}
                            <!-- <select name="subject_id" class="form-select">
                                @foreach($subjects as $subj)
                                    <option value="{{ $subj->id }}" 
                                        @if($editingSubject->id == $subj->id) selected @endif>
                                        {{ $subj->name_uz }}
                                    </option>
                                @endforeach
                            </select> -->

                            <select class="selectpicker w-100" name="subject_id" data-live-search="true" >
                                <option value="" selected >Tanlang...</option>
                                @foreach($subjects as $subj)
                                    <option value="{{ $subj->id }}" 
                                        @if($editingSubject->id == $subj->id) selected @endif>
                                        {{ $subj->name_uz }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- Semestr --}}
                            <div class="mb-3">
                                <label class="form-label">Semestr:</label>
                                <select name="semester_id" class="selectpicker w-100" id="selectpicker" data-live-search="true">
                                    @foreach($group->semesters as $semester)
                                        <option value="{{ $semester->id }}" 
                                            @if($editingSubject->pivot && $editingSubject->pivot->semester_id == $semester->id) selected @endif>
                                            {{ $semester->name }} ({{ $semester->academic_year }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- O‘qituvchi --}}
                            <div class="mb-3">
                                <label class="form-label">O‘qituvchi:</label>
                                <select class="selectpicker w-100" name="teacher_id"  id="selectpicker" data-live-search="true">
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" 
                                            @if($editingSubject->pivot && $editingSubject->pivot->teacher_id == $teacher->id) selected @endif>
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-success btn-sm py-1 px-2   " style="font-size: 12px;">Saqlash</button>
                        </form>
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            {{-- O‘chirish formasi --}}
                            <form action="{{ route('groupSubject.destroy', [$group->id, $editingSubject->id]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-danger btn-sm py-1 px-2" 
                                        style="font-size: 12px;"
                                        >
                                    O‘chirish
                                </button>
                            </form>

                            {{-- Bekor qilish --}}
                            <a href="{{ route('groupSubject.index', $group->id) }}" 
                            class="btn btn-secondary btn-sm py-1 px-2" 
                            style="font-size: 12px;">
                                Bekor qilish
                            </a>
                        </div>
                    </div>
                </div>
            @else
            <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 15px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;"> Fanni biriktirish </h3>
                        
                    </div>

                    <div class="card-body p-3">
                        <form action="{{ route('groupSubject.store', $group->id) }}" method="POST">
                            @csrf 
                            
                            <style>
                                .bootstrap-select .dropdown-menu.inner {
                                    max-height: 200px !important; /* scroll balandligi */
                                    overflow-y: auto !important;
                                }
                            </style>

                            <label class="form-label">Fanlar:</label>

                                <select class="selectpicker w-100 " name="subject_id" id="selectpicker" data-live-search="true">
                                    <option value="" selected >Tanlang...</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" >
                                            {{ $subject->name_uz }}
                                        </option>
                                    @endforeach
                                </select>

                            <div class="mb-3">
                                <label class="form-label">Audit soati</label>
                                <select name="audit_hours"  class="selectpicker w-100" id="selectpicker" data-live-search="true" >
                                    <option value="" selected disabled >Tanlang</option>
                                    <option value="60">60</option>
                                    <option value="120">120</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Semestr:</label>
                                <select name="semester_id" class="selectpicker w-100" id="selectpicker" data-live-search="true">
                                    <option value="" selected disabled >Tanlang</option>
                                    @foreach($group->semesters as $semester)
                                        <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            

                            <div class="mb-3">
                                <label class="form-label">O‘qituvchi:</label>
                                <select name="teacher_id" class="selectpicker w-100" id="selectpicker" data-live-search="true">
                                    <option value="" selected disabled >Tanlang</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="max_current_score" class="form-label">Maksimal joriy baho</label>
                                <input id="max_current_score" class="form-control" type="number" name="max_current_score" value="20" min="0">
                            </div>

                            <div class="mb-3">
                                <label for="max_midterm_score" class="form-label">Maksimal oraliq baho</label>
                                <input id="max_midterm_score" class="form-control" type="number" name="max_midterm_score" value="30" min="0">
                            </div>

                            <div class="mb-3">
                                <label for="max_final_score" class="form-label">Maksimal yakuniy baho</label>
                                <input id="max_final_score" class="form-control" type="number" name="max_final_score" value="50" min="0">
                            </div>

                            <button type="submit" class="btn btn-success w-100">Saqlash</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif





        </div>
    </div>




















    @if($errors->has('max_total'))
    <div class="alert alert-danger position-fixed bottom-0 end-0 p-3" style="background-color: #B22222; color: white;">
        {{ $errors->first('max_total') }}
    </div>
@endif

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
</script>
</x-layout.app>
