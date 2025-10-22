<x-layout.app>
    <x-slot:title>
        {{ $midterm->groupSubject->group->group_name }} — Vazifalar
    </x-slot:title>


    <style>
        /* body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        } */
        .card-up-header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 10px 10px;
        }
        .exam-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .exam-card-up-header {
            background-color: #2c3e50;
            color: white;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .exam-table {
            width: 100%;
            border-collapse: collapse;
        }
        .exam-table th {
            background-color: #f8f9fa;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            /* border-bottom: 2px solid #e9ecef; */
        }
        .exam-table td {
            padding: 1rem;
            /* border-bottom: 1px solid #e9ecef; */
            vertical-align: middle;
        }

        .exam-table tr {
            border-bottom: 1px solid #e9ecef; /* Qo'shildi */
        }
        
        .exam-table tr:hover {
            background-color: #f8f9fa;
        }
        .group-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
            background-color: #6a11cb;
            color: white;
            text-decoration: none;
        }
        .date-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
            background-color: #1E90FF;
            color: white;
            display: inline-block;
        }
        .btn-create {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .footer {
            text-align: center;
            margin-top: 2rem;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        /* Switch uchun stil */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #28a745;
        }
        input:checked + .slider:before {
            transform: translateX(26px);
        }
        .status-cell {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }
        
        @media (max-width: 768px) {
            .exam-table {
                display: block;
                overflow-x: auto;
            }
        }

        .breadcrumb {
            background: white;
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
                    <a href="{{ route('admin.midterms.index') }}"  class="text-decoration-none">
                        Oraliq guruxlari
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('adminGroup.midterm', $group) }}" class="text-decoration-none">
                        {{ $midterm->groupSubject->group->group_name }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ $midterm->groupSubject->subject->{'name_'.app()->getLocale()} }}
                    </a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page">
                    Mavzular
                </li> -->
            </ol>
        </nav>
    </div>
    
    <div class="container mt-2">
        <div class="exam-container">
            <div class="exam-card-up-header">
                <h3 class="mb-0 text-white">{{ $midterm->groupSubject->group->group_name }} guruhi uchun {{ $midterm->groupSubject->subject->name }} fanidan vazifalar</h3>
                @php
                    $now = \Carbon\Carbon::now();
                    $semester = $midterm->groupSubject->semester ?? null;

                        // Hozircha mavjud assignmentlardagi maksimal ballni hisoblaymiz
                    $totalScore = $midterm->assignments->sum('max_score');
                    $maxScore = $midterm->groupSubject->max_midterm_score ?? 0;
                @endphp
                
                @if($semester && $now->between($semester->start_date, $semester->end_date) && $totalScore < $maxScore)
                <button class="btn-create">
                    <a href="{{ route('admin.midterms.assignment.create', ['group' => $group->id, 'midterm' => $midterm->id]) }}" class="text-white">
                        <i class="bi bi-plus-circle"></i> Yaratish
                    </a>
                </button>
                @endif
            </div>

            <div class="p-4">
                <table class="exam-table">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Nomi</th>
                        <th>Muddat</th>
                        <th>Fayl</th>
                        <th class="ps-4">Statistika</th> {{-- Yangi ustun --}}
                        <th>Holati</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($midterm->assignments as $assignment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('admin.assignments.submissions', ['group' => $group->id, 'midterm' => $midterm->id, 'assignment' => $assignment->id]) }}"class="group-badge text-white">
                                    {{ $assignment->name }}
                                </a>
                                <div class="text-muted small">
                                    Maksimal ball: {{ $assignment->max_score }} |
                                    Urinishlar soni: {{ $assignment->attempts }}
                                </div>
                            </td>
                            <!-- <td>
                                <a href="" class="group-badge text-white">
                                {{ $midterm->groupSubject->group->group_name ?? '-' }}
                                </a>
                            </td> -->
                            <!-- <td><span class="group-badge">RI76-22</span></td> -->
                            <td>
                            @if($assignment->due_date && $assignment->due_time)
                                @php
                                    $datetime = \Carbon\Carbon::parse($assignment->due_date . ' ' . $assignment->due_time);
                                @endphp
                                {{ $datetime->format('d.m.Y | H:i') }}
                            @else
                                -
                            @endif
                            </td>
                            <td>
                            @if($assignment->file)
                                @php
                                    $filePath = storage_path('app/public/' . $assignment->file);
                                    $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
                                    $fileSizeKb = round($fileSize / 1024, 2);
                                @endphp
                                <a href="{{ asset('storage/' . $assignment->file) }}" target="_blank">
                                    {{ basename($assignment->file) }} ({{ $fileSizeKb }} KB)
                                </a>
                            @else
                                -
                            @endif
                            </td>
                            <td>
                            @php
                                // Yuborilganlar = guruhdagi talabalar soni
                                $studentCount = $midterm->groupSubject->group->students->count();

                                // Bajarganlar = shu assignment uchun submissions kiritgan talabalar
                                $submittedCount = $assignment->submissions->pluck('student_id')->unique()->count();

                                // Baholanganlar = shu assignment submissions uchun grades bor
                                $gradedCount = $assignment->submissions
                                                    ->flatMap(fn($s) => $s->grades)
                                                    ->pluck('student_id')
                                                    ->unique()
                                                    ->count();
                            @endphp

                            <span class="badge bg-primary" style="font-size: 10px;">Yuborildi: {{ $studentCount }}</span>
                            <span class="badge bg-warning text-dark" style="font-size: 10px;">Bajargan: {{ $submittedCount }}</span>
                            <span class="badge bg-success" style="font-size: 10px;">Baholandi: {{ $gradedCount }}</span> 
                            </td>
                            <td>
                                <form action="{{ route('midterms.assignment-status', $assignment->id) }}" method="POST">
                                    @csrf
                                    <div class="form-check form-switch">
                                        <input 
                                            class="form-check-input"
                                            type="checkbox"
                                            {{ $assignment->status ? 'checked disabled' : '' }}
                                            onchange="this.form.submit()"
                                        >
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Hozircha oraliq imtihonlar yo‘q</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- <nav aria-label="Exam navigation" class="p-4 pt-0">
                <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Oldingi</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Keyingi</a>
                    </li>
                </ul>
            </nav> -->
        </div>

        <div class="footer">
            <p>© 2023 O'quv Dasturi. Barcha huquqlar himoyalangan.</p>
        </div>
    </div>










</x-layout.app>
