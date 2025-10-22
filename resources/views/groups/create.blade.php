<x-layout.app>

<x-slot:title>
  Yangiliklar
</x-slot:title>

<div class="container">
    <div class="row g-5 min-vh-100 d-flex justify-content-center align-items-center">
        <div class="col-lg-8">
            <div class="card shadow-lg rounded-4 p-4 border-0 bg-white">
                <h4 class="mb-4 text-center fw-bold">Guruh Yaratish</h4>

                <form action="{{ route('groups.store') }}" method="POST">
                    @csrf

                    {{-- Guruh nomi --}}
                    <div class="mb-3">
                        <label  class="form-label">Guruh nomi (ixtiyoriy)</label>
                        <input type="text" class="form-control" id="group_name" name="group_name">
                    </div>

                    {{-- To‘liq nom --}}
                    <div class="mb-3">
                        <label  class="form-label">To‘liq guruh nomi</label>
                        <input type="text" class="form-control" id="full_group_name" name="full_group_name" required>
                    </div>

                    <div class="mb-3">
                        <label  class="form-label">Yo'nalish</label>
                        <select name="program_id" class="form-select" required>
                            <option value="" selected>Yo'nalish tanlang</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Taʼlim shakli</label>
                            <select name="education_type" class="form-select" required>
                                <option value="Bakalavr">Bakalavr</option>
                                <option value="Magistratura">Magistratura</option>
                                <option value="Doktorantura">Doktorantura</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">O‘qish muddati (yil)</label>
                            <input type="number" name="study_duration" class="form-control" >
                        </div>
                    </div>

                    {{-- Boshlanish yili & Semestrlar soni --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Oquv yili</label>
                            <select name="academic_year_id" class="form-select" >
                                <option value="" selected disabled > Tanlang... </option>
                                @foreach($academicYears as $year)
                                <option value="{{ $year->id }}"> {{ $year->name }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label  class="form-label">Semestrlar soni</label>
                            <select name="total_semesters" class="form-select" required>
                                <option value="2">2 </option>
                                <option value="4">4 </option>
                                <option value="6">6 </option>
                                <option value="8" selected>8 </option>
                            </select>
                        </div>
                    </div>

                    {{-- Semestr davrlari --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kuzgi davr </label>
                            <div class="d-flex">
                                <input type="date" name="fall_start_date" class="form-control" required>
                                <span class="px-2 d-flex align-items-center">to</span>
                                <input type="date" name="fall_end_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Baxorgi davr </label>
                            <div class="d-flex">
                                <input type="date" name="spring_start_date" class="form-control" required>
                                <span class="px-2 d-flex align-items-center">to</span>
                                <input type="date" name="spring_end_date" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    {{-- Hidden fields --}}
                    <!-- <input type="hidden" name="current_semester" value="1"> -->
                    <input type="hidden" name="is_graduated" value="0">

                    {{-- Submit --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">Saqlash</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


</x-layout.app>