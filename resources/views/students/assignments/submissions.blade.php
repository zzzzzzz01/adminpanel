<x-layout.app>
    <x-slot:title>
        {{ $assignment->name }} — Topshiriqlar
    </x-slot:title>

    <!-- <h4>
        {{ $assignment->midtermInterval->groupSubject->subject->name }} fani  
    </h4>

    <h5>Vazifa: {{ $assignment->name }} (Maks: {{ $assignment->max_score }})</h5>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Guruxi</th>
                <th>Talaba</th>
                <th>Status</th>
                <th>Baxo</th>
                <th>Muddat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            @php
                // faqat ohirgi submissionni olish
                $submission = $student->submissions
                    ->where('assignment_id', $assignment->id) // shu topshiriqqa tegishli bo'lgan
                    ->sortByDesc('created_at')
                    ->first();

                $dueDateTime = $assignment->due_date && $assignment->due_time
                    ? \Carbon\Carbon::parse($assignment->due_date . ' ' . $assignment->due_time)
                    : null;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $assignment->midtermInterval->groupSubject->group->group_name }}</td>
                <td>{{ $student->name }}</td>
                <td>
                    @if($submission)
                        @if($submission->midtermGrade)
                            <span class="text-primary">📌 Baholandi</span>
                        @else
                            <a href="{{ route('submissions.show', $submission->id) }}" class="text-success">
                                ✅ Topshirdi ({{ $submission->created_at->format('d.m.Y H:i') }})
                            </a>
                        @endif
                    @else
                        <span class="text-danger">❌ Berildi</span>
                    @endif
                </td>
                <td>
                @if($submission && $submission->midtermGrade)
                    {{ $submission->midtermGrade->grade }} / {{ $assignment->max_score }}
                @else
                    -
                @endif
                </td>
                <td>
                    @if($dueDateTime)
                        {{ $dueDateTime->format('d.m.Y H:i') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table> -->



    <style>
        /* body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        } */
        .card-up-header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            border-radius: 10px;
        }
        .container-main {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            overflow: hidden;
            margin-bottom: 2rem;
            padding: 0;
        }
        .group-card-up-header {
            background-color: #2c3e50;
            color: white;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .students-table {
            width: 100%;
            border-collapse: collapse;
        }
        .students-table th {
            background-color: #f8f9fa;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 2px solid #e9ecef;
        }
        .students-table td {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }
        .students-table tr:hover {
            background-color: #f8f9fa;
        }
        .student-name {
            font-weight: 500;
        }
        .grade-input {
            width: 60px;
            text-align: center;
            padding: 5px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .btn-save {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 2rem;
            color: #6c757d;
            font-size: 0.9rem;
        }
        .grade-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .graded {
            background-color: #d4edda;
            color: #155724;
        }
        .not-graded {
            background-color: #f8d7da;
            color: #721c24;
        }
        @media (max-width: 768px) {
            .students-table {
                display: block;
                overflow-x: auto;
            }
            .action-buttons {
                flex-direction: column;
            }
        }

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
                    <a href="{{ route('midterms.index') }}"  class="text-decoration-none">
                        Oraliq nazorat
                    </a>
                </li>
                @if($assignment->midtermInterval->type === 'manual')
                <li class="breadcrumb-item">
                    <a href="{{ route('midterms.manual', $assignment->midtermInterval->id) }}"  class="text-decoration-none">
                        {{ $assignment->midtermInterval->groupSubject->subject->{'name_' . app()->getLocale()} }} - {{ $assignment->midtermInterval->groupSubject->group->group_name }}
                    </a>
                </li>
                @elseif($assignment->midtermInterval->type === 'assignment')
                <li class="breadcrumb-item">
                    <a href="{{ route('midterms.assignment', $assignment->midtermInterval->id) }}"  class="text-decoration-none">
                        {{ $assignment->midtermInterval->groupSubject->subject->{'name_' . app()->getLocale()} }} - {{ $assignment->midtermInterval->groupSubject->group->group_name }}
                    </a>
                </li>
                @endif
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                    {{ $assignment->name }}
                    </a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page">
                    Mavzular
                </li> -->
            </ol>
        </nav>
    </div>

    <div class="container mt-2">
        <div class="container-main">
            <div class="group-card-up-header">
                <h3 class="mb-0 text-white">{{ $assignment->midtermInterval->groupSubject->subject->name }} fani - Vazifa: {{ $assignment->name }} (Maks: {{ $assignment->max_score }})</h3>
                <div>
                    @php 
                        $dueDateTime = $assignment->due_date && $assignment->due_time
                        ? \Carbon\Carbon::parse($assignment->due_date . ' ' . $assignment->due_time)
                        : null;
                    @endphp
                    <span class="me-3">Muddat sanasi: <strong> {{ $dueDateTime->format('d.m.Y H:i') }} </strong></span>
                    <span class="badge bg-success">Yozma imtihon</span>
                </div>
            </div>

            <div class="p-4">
                <table class="students-table">
                    <thead>
                        <tr>
                            <!-- <th width="5%">#</th>
                            <th width="55%">Talaba</th>
                            <th width="20%">Holati</th>
                            <th width="20%">Baho</th> -->

                            <th width="5%">#</th>
                            <th width="40%">Talaba</th>
                            <th width="20%">Guruxi</th>
                            <th width="25%">Status</th>
                            <th width="10%">Baxo</th>
                            <!-- <th>Muddat</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                        @php
                            // faqat ohirgi submissionni olish
                            $submission = $student->submissions
                                ->where('assignment_id', $assignment->id) // shu topshiriqqa tegishli bo'lgan
                                ->sortByDesc('created_at')
                                ->first();

                            
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $student->name }}</td>
                            <td class="student-name"> {{ $assignment->midtermInterval->groupSubject->group->group_name }} </td>
                            <td>
                            @if($submission)
                                @if($submission->midtermGrade)
                                    <span class="badge bg-success"> Baholandi</span>
                                @else
                                    <a href="{{ route('submissions.show', $submission->id) }}" class="badge bg-warning text-dark">
                                        Topshirdi ({{ $submission->created_at->format('d.m.Y H:i') }})
                                    </a>
                                @endif
                            @else
                                <span class="badge bg-danger"> Berildi</span>
                            @endif
                            </td>
                            <td>
                                @if($submission && $submission->midtermGrade)
                                    {{ $submission->midtermGrade->grade }} / {{ $assignment->max_score }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- <div class="p-4">
                <div class="action-buttons">
                    <button class="btn-back">
                        <i class="bi bi-arrow-left"></i> Orqaga qaytish
                    </button>
                    <button class="btn-save">
                        <i class="bi bi-check-circle"></i> Baholarni saqlash
                    </button>
                </div>
            </div> -->
        </div>

        <div class="footer">
            <p>© 2023 O'quv Dasturi. Barcha huquqlar himoyalangan.</p>
        </div>
    </div>
















</x-layout.app>
