<x-layout.app>
    <x-slot:title>
    {{ $schedule->groupSubject->subject->name }} — {{ $schedule->week->name }} | Baholar
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
                    <a href="{{ route('adminJournal.index') }}" class="text-decoration-none">
                        Joriy baxo uchun guruxlar
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('adminJournal.groupSubject', $group->id) }}"  class="text-decoration-none">
                        {{ $group->group_name }} guruh fanlari
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('adminGroupJournal.index', [$group->id, $groupSubject->id]) }}"  class="text-decoration-none">
                        {{ $groupSubject->subject->name_uz }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ \Carbon\Carbon::parse($schedule->date)->format('d.m.Y') }}
                    </a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page">
                    Mavzular
                </li> -->
            </ol>
        </nav>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex align-items-center" 
                        style="background-color: #2c3e50; min-height: 80px; border-radius: 5px 5px 0 0;">
                        <!-- <h3 class="mb-0 text-white" style="font-size: 24px;">
                            {{ $schedule->groupSubject->subject->name_uz }} — 
                            {{ $schedule->groupSubject->group->group_name }} | Joriy baholar
                        </h3> -->
                        <h3 class="mb-0 text-white" style="font-size: 24px;">
                            {{ $schedule->groupSubject->subject->name_uz }} — 
                            fanidan ({{ \Carbon\Carbon::parse($schedule->date)->format('d.m.Y') }}) kuni uchun joriy baholar
                        </h3>
                    </div>

                    <!-- ✅ card-body endi card ichida -->
                    <div class="card-body p-3">
                        <form action="{{ route('journalGroupgrades.store', $schedule->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="journal_id" value="{{ $schedule->groupSubject->journal->id ?? '' }}">
                            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                            <table class="table table-hover" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="35%">Talaba</th>
                                        <th width="15%">Tolov-turi</th>
                                        <th width="17%">Holati</th>
                                        <th width="15%">Joriy baho</th>
                                        <th width="15%">Umumiy joriy baho</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        @php
                                            $grade = $grades[$student->id]->score ?? 0;
                                            $maxCurrent = $schedule->groupSubject->max_current_score;
                                            $disableInput = $student->total_current_score >= $maxCurrent;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="student-name">{{ $student->name }}. {{ $student->name }}. {{ $student->name }}</td>
                                            <td>Davlat granti</td>
                                            <td>
                                                @if(isset($grades[$student->id]) && $grades[$student->id]->score > 0)
                                                    <span class="badge text-bg-success">Baho qo'yilgan</span>
                                                @else
                                                    <span class="badge text-bg-danger">Baho qo'yilmagan</span>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="number"
                                                    name="grades[{{ $student->id }}]"
                                                    value="{{ $grade }}"
                                                    min="0"
                                                    max="{{ $maxCurrent }}"
                                                    class="grade-input text-center"
                                                    @if($disableInput) disabled @endif>
                                            </td>
                                            <td class="ps-4" >{{ $student->total_current_score }}/{{ $maxCurrent }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="p-4">
                                <div class="mt-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary py-1 px-2" style="font-size: 14px;">
                                        <i class="bi bi-check-circle"></i> Baholarni saqlash
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> <!-- ✅ card to‘liq yopildi -->
            </div>
        </div>
    </div>


    @if(session('storeError'))
    <div class="alert alert-storeError position-fixed bottom-0 end-0 p-3" style="background-color: #B22222; color: white;">
        <i class="fa-solid fa-check"></i> {{ session('storeError') }}
    </div>
    @endif

    <script>
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.remove();
            });
        }, 5000); // 5 sekunddan keyin barcha alertlar yo'qoladi
    </script>  





</x-layout.app>