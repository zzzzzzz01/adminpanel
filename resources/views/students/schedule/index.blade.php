    <x-layout.app>
        <x-slot:title>
            {{ $group->group_name }} — Dars jadvali
        </x-slot:title>

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-white shadow-sm rounded">

            {{-- Guruh nomi + icon --}}
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white d-flex justify-content-center align-items-center" 
                    style="width: 50px; height: 50px; border-radius: 4px;">
                    <i class="fa-solid fa-file" style="font-size: 24px;"></i>
                </div>
                <h5 class="ms-3 mb-0">{{ $group->group_name }}</h5>
            </div>

            {{-- Semesterlar tugmalari --}}
            <div>
                <span class="me-2 text-muted fw-bold">SEMESTR</span>
                @foreach($semesters as $semester)
                    <a href="{{ route('student.schedule', ['group' => $group->id, 'semester_id' => $semester->id]) }}"
                    class="btn btn-sm {{ $selectedSemesterId == $semester->id ? 'btn-primary' : 'btn-outline-primary' }}">
                        {{ $semester->semester_number }}
                    </a>
                @endforeach
            </div>
        </div>


        <!-- <a href="{{ route('home.page') }}" class="btn btn-success mb-3"> @lang('words.back') </a>
        <h1 class="text-center pb-4">
            {{ $group->group_name }} guruxining dars jadvali
        </h1> -->

        {{-- Hafta tanlash --}}
        <div class="mb-3 d-flex justify-content-center">
            <!-- <select id="weekSelect" class="form-select" style="width: 470px;" onchange="window.location.href=this.value;">
                <option value="">Haftani tanlang...</option>
                @foreach($weeks as $week)
                    <option value="{{ route('student.schedule', ['group' => $group->id, 'semester_id' => $selectedSemesterId, 'week_id' => $week->id]) }}"
                        {{ $selectedWeekId == $week->id ? 'selected' : '' }}>
                        {{ $week->week_number }}. {{ \Carbon\Carbon::parse($week->start_date)->translatedFormat('d F') }} / {{ \Carbon\Carbon::parse($week->end_date)->translatedFormat('d F') }}
                    </option>
                @endforeach
            </select> -->

                <select class="selectpicker w-50" name="subject_id" id="selectpicker" data-live-search="true" data-style="btn-primary" data-style="btn-light" style="width: 470px;" onchange="window.location.href=this.value;">
                    <option value="" selected >Tanlang...</option>
                    @php
                        $monthsUz = [
                            1 => 'yanvar',
                            2 => 'fevral',
                            3 => 'mart',
                            4 => 'aprel',
                            5 => 'may',
                            6 => 'iyun',
                            7 => 'iyul',
                            8 => 'avgust',
                            9 => 'sentyabr',
                            10 => 'oktyabr',
                            11 => 'noyabr',
                            12 => 'dekabr',
                        ];
                    @endphp

                    @foreach($weeks->where('is_active', 1) as $week)
                        @php
                            $start = \Carbon\Carbon::parse($week->start_date);
                            $end = \Carbon\Carbon::parse($week->end_date);

                            if (app()->getLocale() == 'uz') {
                                $startText = $start->day.' '.$monthsUz[$start->month];
                                $endText = $end->day.' '.$monthsUz[$end->month];
                            } else {
                                $startText = $start->locale(app()->getLocale())->translatedFormat('d F');
                                $endText = $end->locale(app()->getLocale())->translatedFormat('d F');
                            }
                        @endphp

                        <option value="{{ route('student.schedule', ['group' => $group->id, 'semester_id' => $selectedSemesterId, 'week_id' => $week->id]) }}"
                            {{ $selectedWeekId == $week->id ? 'selected' : '' }}>
                            {{ $week->week_number }}. {{ $startText }} / {{ $endText }}
                        </option>
                    @endforeach

                </select>

            <style>
                .bootstrap-select .dropdown-menu.inner {
                    max-height: 200px !important; /* scroll balandligi */
                    overflow-y: auto !important;
                    font-size: 14px !important;
                }
            </style>
        </div>

        {{-- 6 kunlik dars jadvali --}}
        @php
            $weekDays = [
                1 => 'Dushanba',
                2 => 'Seshanba',
                3 => 'Chorshanba',
                4 => 'Payshanba',
                5 => 'Juma',
                6 => 'Shanba',
            ];
        @endphp

        @if($schedules->isEmpty())
        <div class="text-center py-5" style="background-color:#f2f6fa; border-radius:10px;">
        <i class="fa-solid fa-triangle-exclamation mb-3" style="font-size:36px; color:#b0b0b0;"></i>
        <h5 style="font-size:20px; font-weight:300; color:#6c757d;">
            Ushbu davrga dars soatlari belgilanmagan
        </h5>
    </div>
        @else
        <div class="row">
            @php $hasSchedule = false; @endphp

            @foreach($weekDays as $dayIndex => $dayName)
                @php
                    $daySchedules = $schedules->filter(function($dayItems, $date) use ($dayIndex) {
                        return \Carbon\Carbon::parse($date)->dayOfWeekIso == $dayIndex;
                    })->flatten();
                @endphp

                @if($daySchedules->count() > 0) {{-- faqat dars bor kunlar chiqadi --}}
                    @php $hasSchedule = true; @endphp
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                {{ $dayName }}
                            </div>
                            <div class="card-body">
                                @foreach($daySchedules as $index => $schedule)
                                    <div class="mb-2">
                                        <strong>{{ $schedule->lessonPair->pair_number }}. 
                                            {{ $schedule->groupSubject->subject->{'name_' . app()->getLocale()} }}
                                        </strong><br>
                                        Xona {{ $schedule->room ?? '-' }} | 
                                        {{ $schedule->session->{'name_' . app()->getLocale()} ?? '-' }} | 
                                        O'qituvchi: {{ $schedule->groupSubject->teacher->name ?? '-' }} | 
                                        {{ \Carbon\Carbon::parse($schedule->lessonPair->start_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($schedule->lessonPair->end_time)->format('H:i') }}
                                    </div>

                                    {{-- Oxirgi darsdan keyin chiziq chiqmasin --}}
                                    @if($index < $daySchedules->count() - 1)
                                        <hr class="my-1">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            {{-- Agar butun hafta bo‘yicha umuman dars bo‘lmasa --}}
            @if(!$hasSchedule)
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        Bu haftada dars yo‘qa
                    </div>
                </div>
            @endif
        </div>
        @endif

    </div>

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
