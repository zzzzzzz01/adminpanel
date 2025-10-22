<x-layout.app>

<x-slot:title>
  Guruxlar
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
                    <a href="{{ route('schedule.index') }}" class="text-decoration-none">
                        Dars jadvalini boshqarish
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('calendar.show', [
                        '_token' => csrf_token(),
                        'program_id' => $group->program_id,
                        'group_id' => $group->id,
                        'academic_year' => $semester->academic_year ?? '2023-2024',
                        'semester_id' => $semester->id
                    ]) }}" class="text-decoration-none">
                        {{ $group->group_name ?? 'Noma’lum guruh' }} |
                        {{ $semester->name ?? 'Noma’lum semestr' }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Dars yaratish
                    </a>
                </li>
            </ol>
        </nav>
    </div>







<div class="container">
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <div class="title">
                    <h2> @lang('words.create.shcedule') </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center py-2">
        <div class="col-6">
            <div class="signin-wrapper">
                <div class="form-wrapper">
                    <form action="{{ route('schedule.scheduleStore') }}" method="POST">
                    @csrf
                        <!-- <div class="col-lg-12">
                            <div class="input-style-1">
                            <label class="form-label"> Ustoz </label>
                                <select class="form-control border-primary-subtle px-3 p-2" name="teacher_id" aria-label="Default select example">
                                <option disabled selected> Ustoz tanlang ...</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                            </select>
                            </div>
                        </div> -->



                        <div class="col-lg-12">
                            <div class="input-style-1">
                                <label class="form-label"> Fan </label>
                                <select class="form-control border-primary-subtle px-3 p-2" name="group_subject_id" aria-label="Default select example">
                                    <option disabled selected> Fan tanlang ...</option>
                                    @foreach($groupSubjects as $gs)
                                        <option value="{{ $gs->id }}">
                                            {{ $gs->subject->{ 'name_' .app()->getLocale() } }} — {{ $gs->teacher->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-style-1">
                                <label> Xona </label>
                                <select class="form-control border-primary-subtle px-3 p-2" name="auditorium_id" id="">
                                    <option value="" selected disabled>Tanlang...</option>
                                    @foreach($auditoriums as $auditorium)
                                    <option value="{{ $auditorium->id }}">
                                        {{ $auditorium->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="input-style-1">
                            <label clas="form-label"> Mashgulot </label>
                                <select class="form-control border-primary-subtle px-3 p-2" name="session_id" aria-label="Default select example">
                                    <option disabled selected> @lang('words.select.session')...</option>
                                    @foreach($sessions as $session)
                                        <option value="{{ $session->id }}">{{ $session->{ 'name_' .app()->getLocale() } }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="input-style-1">
                                <label> Boshlanish vaqti </label>
                                <select class="form-control border-primary-subtle px-3 p-2" name="lesson_pair_id" id="">
                                    <option value="" selected disabled>Tanlang...</option>
                                    @foreach($lessonPairs as $pair)
                                    <option value="{{ $pair->id }}">
                                        {{ $pair->pair_number }}.  {{ \Carbon\Carbon::parse($pair->start_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($pair->end_time)->format('H:i') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                        <input type="hidden" name="semester_id" value="{{ $semester->id }}">
                        <input type="hidden" name="date" value="{{ $date }}"> <!-- o'sha kun -->
                        @if($week)
                            <input type="hidden" name="week_id" value="{{ $week->id }}">
                        @endif


                        <!-- <a href="{{ route('schedule.index') }}" class="btn btn-primary mt-3"> @lang('words.back') </a> -->
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-success">
                                Yuborish
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>






</x-layout.app>