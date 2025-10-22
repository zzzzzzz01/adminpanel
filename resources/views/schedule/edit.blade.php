<x-layout.app>
    <x-slot:title>
        Dars jadvalini tahrirlash
    </x-slot:title>

    <div class="container" style="font-size: 13px;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm mt-5">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Dars jadvalini tahrirlash</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <!-- Asosiy forma -->
                        <form id="editForm" action="{{ route('schedules.update', $schedule->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- calendar.show ga qaytish uchun paramlar --}}
                            <input type="hidden" name="program_id"    value="{{ request('program_id') }}">
                            <input type="hidden" name="group_id"      value="{{ request('group_id', $schedule->group_id) }}">
                            <input type="hidden" name="academic_year" value="{{ request('academic_year') }}">
                            <input type="hidden" name="semester_id"   value="{{ request('semester_id', $schedule->semester_id) }}">
                                            
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Boshlanish vaqti</label>
                                    <input type="time" name="start_time" class="form-control form-control-sm" 
                                        value="{{ old('start_time', $schedule->lessonPair->start_time) }}" required>
                                    @error('start_time')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Tugash vaqti</label>
                                    <input type="time" name="end_time" class="form-control form-control-sm" 
                                        value="{{ old('end_time', $schedule->lessonPair->end_time) }}" required>
                                    @error('end_time')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Fan</label>
                                    <select name="subject_id" class="form-select form-select-sm" required>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" 
                                                {{ $schedule->subject_id == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->name_uz }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subject_id')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Mashg‘ulot turi</label>
                                    <select name="session_id" class="form-select form-select-sm" required>
                                        @foreach($sessions as $session)
                                            <option value="{{ $session->id }}" 
                                                {{ $schedule->session_id == $session->id ? 'selected' : '' }}>
                                                {{ $session->name_uz }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('session_id')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">O‘qituvchi</label>
                                    <select name="teacher_id" class="form-select form-select-sm" required>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" 
                                                {{ $schedule->teacher_id == $teacher->id ? 'selected' : '' }}>
                                                {{ $teacher->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('teacher_id')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Xona</label>
                                    <input type="text" name="room" class="form-control form-control-sm" 
                                        value="{{ old('room', $schedule->auditorium->name) }}">
                                    @error('room')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </form>

                        <!-- Tugmalar guruhi - formlardan tashqarida -->
                        <div class="d-flex justify-content-between mt-4">
                            <!-- O'chirish uchun alohida form -->
                            <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" 
                                onsubmit="return confirm('Haqiqatan ham o\'chirmoqchimisiz?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger px-4" style="font-size: 13px;">O'chirish</button>
                            </form>
                            
                            <!-- Saqlash tugmasi asosiy formaga bog'langan -->
                            <button type="submit" form="editForm" class="btn btn-primary px-4" style="font-size: 13px;">Saqlash</button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>