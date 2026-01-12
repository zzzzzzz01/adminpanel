<x-layout.app>
    <x-slot:title>{{ $group->group_name }} — Fanlar</x-slot:title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home.page') }}"><i class="fas fa-home"></i> Asosiy</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('groups.index') }}">Guruhlar ro'yxati</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $group->group_name }}</li>
            </ol>
        </nav>
    </div>

    <div class="container mt-2">
        <div class="row">
            {{-- Fanlar jadvali --}}
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
                        <h5 class="mb-0">{{ $group->group_name }} — Fanlar</h5>
                        <form action="{{ route('groupSubjects.search', $group->id) }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Fan nomi..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-sm btn-primary ms-2"><i class="fa fa-search"></i></button>
                        </form>
                    </div>

                    <div class="card-body p-2">
                        <table class="table table-hover table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fan nomi</th>
                                    <th>Audit soati</th>
                                    <th>O‘qituvchi</th>
                                    <th>Semestr</th>
                                    <th>Oquv yili</th>
                                    <th>Jurnal</th>
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

            {{-- Fan biriktirish --}}
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">{{ Route::is('groupSubject.edit') ? 'Fanlarni tahrirlash' : 'Fan biriktirish' }}</h5>
                    </div>

                    <div class="card-body">
                        @if(Route::is('groupSubject.edit'))
                        <form action="{{ route('groupSubject.update', $group->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                        @else
                        <form action="{{ route('groupSubject.store', $group->id) }}" method="POST">
                            @csrf
                        @endif

                            {{-- Fanlar --}}
                            <div class="mb-2">
                                <label>Fan:</label>
                                <select class="selectpicker w-100" name="subject_id" data-live-search="true">
                                    <option value="">Tanlang...</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" 
                                            @if(isset($editingSubject) && $editingSubject->subject_id == $subject->id) selected @endif>
                                            {{ $subject->name_uz }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Audit soati --}}
                            <div class="mb-2">
                                <label>Audit soati:</label>
                                <select name="audit_hours" class="selectpicker w-100">
                                    <option value="">Tanlang...</option>
                                    <option value="60" @if(isset($editingSubject) && $editingSubject->audit_hours == 60) selected @endif>60</option>
                                    <option value="120" @if(isset($editingSubject) && $editingSubject->audit_hours == 120) selected @endif>120</option>
                                </select>
                            </div>

                            {{-- Semestr --}}
                            <div class="mb-2">
                                <label>Semestr:</label>
                                <select name="semester_id" class="selectpicker w-100" data-live-search="true">
                                    <option value="">Tanlang...</option>
                                    @foreach($group->semesters as $semester)
                                        <option value="{{ $semester->id }}" 
                                            @if(isset($editingSubject) && $editingSubject->semester_id == $semester->id) selected @endif>
                                            {{ $semester->name }} ({{ $semester->academic_year }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- O‘qituvchi --}}
                            <div class="mb-2">
                                <label>O‘qituvchi:</label>
                                <select name="teacher_id" class="selectpicker w-100" data-live-search="true">
                                    <option value="">Tanlang...</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" 
                                            @if(isset($editingSubject) && $editingSubject->teacher_id == $teacher->id) selected @endif>
                                            {{ $teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Baholar --}}
                            <div class="mb-2">
                                <label>Maksimal joriy baho:</label>
                                <input type="number" name="max_current_score" class="form-control" value="{{ $editingSubject->max_current_score ?? 20 }}" min="0">
                            </div>
                            <div class="mb-2">
                                <label>Maksimal oraliq baho:</label>
                                <input type="number" name="max_midterm_score" class="form-control" value="{{ $editingSubject->max_midterm_score ?? 30 }}" min="0">
                            </div>
                            <div class="mb-2">
                                <label>Maksimal yakuniy baho:</label>
                                <input type="number" name="max_final_score" class="form-control" value="{{ $editingSubject->max_final_score ?? 50 }}" min="0">
                            </div>

                            <button type="submit" class="btn btn-success w-100">{{ Route::is('groupSubject.edit') ? 'Yangilash' : 'Saqlash' }}</button>
                        </form>

                        @if(Route::is('groupSubject.edit'))
                        <form action="{{ route('groupSubject.destroy', [$group->id, $editingSubject->subject_id]) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">O‘chirish</button>
                        </form>
                        <a href="{{ route('groupSubject.index', $group->id) }}" class="btn btn-secondary w-100 mt-1">Bekor qilish</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Xatolar --}}
    @if($errors->any())
        <div class="alert alert-danger fixed-bottom m-3">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.selectpicker').selectpicker();
        });
    </script>
</x-layout.app>
