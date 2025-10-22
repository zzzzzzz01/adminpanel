<x-layout.app>
    <x-slot:title>
        Yozma oraliq baxoni baxolash
    </x-slot:title>

    <!-- <style>
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
    </style> -->

    <!-- <div class="container mt-2">
        <div class="container-main">
            <div class="group-card-up-header">
                <h3 class="mb-0 text-white">{{ $groupSubject->group->group_name }} - {{ $groupSubject->subject->name }}</h3>
                <div>
                    <span class="me-3">Muddat sanasi: <strong> {{ \Carbon\Carbon::parse($groupSubject->semester->end_date )->format('d.m.Y') }} </strong></span>
                    <span class="badge bg-success">Yozma imtihon</span>
                </div>
            </div>

            <form action="{{ route('midterms.manual.store', $midterm->id) }}" method="POST">
                    @csrf
            <div class="p-4">
                <table class="students-table">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="55%">Talaba</th>
                            <th width="20%">Holati</th>
                            <th width="20%">Baho</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="student-name"> {{ $student->name }} </td>
                            <td>
                                @if(isset($grades[$student->id]) && $grades[$student->id]->grade !== null)
                                    <span class="grade-status graded">Baho qo'yilgan</span>
                                @else
                                    <span class="grade-status not-graded">Baho qo'yilmagan</span>
                                @endif
                            </td>
                            <td>
                            <input type="number" step="1" min="0" max="100"
                                    name="grades[{{ $student->id }}]"
                                    value="{{ isset($grades[$student->id]) ? intval($grades[$student->id]->grade) : '' }}"
                                    class="grade-input">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                <div class="action-buttons">
                    <button class="btn-back">
                        <i class="bi bi-arrow-left"></i> Orqaga qaytish
                    </button>
                    <button class="btn-save">
                        <i class="bi bi-check-circle"></i> Baholarni saqlash
                    </button>
                </div>
            </div>
            </form>
        </div>

        <div class="footer">
            <p>© 2023 O'quv Dasturi. Barcha huquqlar himoyalangan.</p>
        </div>
    </div> -->


    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 20px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">{{ $groupSubject->group->group_name }} - {{ $groupSubject->subject->name }}. Max ball: ({{ $groupSubject->max_midterm_score }})</h3>
                        <div>
                            <span class="me-3">Muddat sanasi: <strong> {{ \Carbon\Carbon::parse($groupSubject->semester->end_date )->format('d.m.Y') }} </strong></span>
                            <span class="badge bg-success">Yozma imtihon</span>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <form action="{{ route('midterms.manual.store', $midterm->id) }}" method="POST">
                        @csrf
                        <table class="table table-hover" style="font-size: 14px;">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="35%">Talaba</th>
                                    <th width="25%">Tolov turi</th>
                                    <th width="20%">Holati</th>
                                    <th width="20%">Baho</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="student-name"> {{ $student->name }} </td>
                                    <td>Davlat granti</td>
                                    <td>
                                        @if(isset($grades[$student->id]) && $grades[$student->id]->grade !== null)
                                            <span class="badge text-bg-success">Baho qo'yilgan</span>
                                        @else
                                            <span class="badge text-bg-danger">Baho qo'yilmagan</span>
                                        @endif
                                    </td>
                                    <td>
                                    <input type="number" step="1" min="0" max="100"
                                            name="grades[{{ $student->id }}]"
                                            value="{{ isset($grades[$student->id]) ? intval($grades[$student->id]->grade) : '' }}"
                                            class="grade-input text-center">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="p-4">
                                <div class="action-buttons">
                                    <a href="">
                                        <button class="btn btn-secondary btn-sm py-1 px-2" style="font-size: 14px;">
                                             Orqaga qaytish
                                        </button>
                                    </a>
                                    <button type="submit" class="btn btn-primary py-1 px-2" style="font-size: 14px;">
                                        <i class="bi bi-check-circle"></i> Baholarni saqlash
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
                        













    </x-layout.app>