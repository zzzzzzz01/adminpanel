<x-layout.app>
    <x-slot:title>
        {{ $submission->assignment->name }} — Fayl
    </x-slot:title>

    <!-- <h4>
        {{ $submission->assignment->name }} 
        (Talaba: {{ $submission->student->name }})
    </h4>

    @php
        // Talabaga tegishli barcha submissionlarni olish
        $allSubmissions = $submission->assignment
            ->submissions()
            ->where('student_id', $submission->student_id)
            ->orderBy('created_at', 'desc')
            ->get();
    @endphp

    <p>
        <strong>Umumiy urinishlar:</strong> 
        {{ $allSubmissions->count() }} / {{ $submission->assignment->attempts }}
    </p>

    <p>
        <strong>Status:</strong>
        @if($submission->file_path)
            <span class="text-success">Topshirdi</span>
        @else
            <span class="text-danger">Berilmadi</span>
        @endif
    </p>

    <p>
        <strong>Oxirgi yuklangan fayl:</strong>
        @if($allSubmissions->first()?->file_path)
            <a href="{{ asset('storage/'.$allSubmissions->first()->file_path) }}" target="_blank">
                {{ basename($allSubmissions->first()->file_path) }}
            </a>
        @else
            Hech qanday fayl yuklanmagan
        @endif
    </p>

    <p>
        <strong>Izoh:</strong> {{ $submission->comment ?? '-' }}
    </p>

    <p>
        <strong>Yuklangan vaqti:</strong> {{ $submission->created_at->format('d.m.Y H:i') }}
    </p>

    <hr>

    <h5>Barcha urinishlar:</h5>
    <ul>
    {{-- Baholash formasi --}}
    <form action="{{ route('midterm-grades.store') }}" method="POST">
        @csrf
        {{-- Yashirin inputlar --}}
        <input type="hidden" name="assignment_submission_id" value="{{ $submission->id }}">
        <input type="hidden" name="student_id" value="{{ $submission->student_id }}">

        <div class="mb-3">
            <label for="grade" class="form-label">Baho qo‘yish</label>
            <input type="number" step="0.1" name="grade" id="grade" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Saqlash</button>
    </form>

    <hr>

    <h5>Barcha urinishlar:</h5>
    <ul>
        @foreach($allSubmissions as $try)
            <li>
                {{ $try->created_at->format('d.m.Y H:i') }} — 
                <a href="{{ asset('storage/'.$try->file_path) }}" target="_blank">
                    📂 {{ basename($try->file_path) }}
                </a>
            </li>
        @endforeach
    </ul> -->





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
    </style>

    <div class="container mt-2">
        <div class="row">
            <div class="col-md-7">
                <div class="container-main">
                    <div class="group-card-up-header">
                        <h3 class="mb-0 text-white">Javoblar royhati 1</h3>
                        
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
                                    <th width="40%">Izoh</th>
                                    <th width="20%">Berilgan sana</th>
                                    <th width="25%">Ball</th>
                                    <th width="10%">Topshirilgan sana</th>
                                    <!-- <th>Muddat</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allSubmissions as $try)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('submissions.edit', $try->id) }}" class="text-dark">{{ $try->comment ?? '-' }}</a>
                                        </td>
                                        <td>{{ $try->assignment->created_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            @if($try->midtermGrade)
                                                {{ $try->midtermGrade->grade }} 
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            {{ $try->created_at->format('d.m.Y H:i') }}
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
            </div>
            <div class="col-md-5">
                @if(Route::is('submissions.edit') && isset($submission))
                    <div class="container-main">
                        <div class="card shadow-sm border-0">
                            <div class="card-header  text-white py-3">
                                <h4 class="mb-0 text-white"><i class="fas fa-info-circle me-2"></i>Topshiriq Ma'lumotlari</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('midterm-grades.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="assignment_submission_id" value="{{ $submission->id }}">
                                    <input type="hidden" name="student_id" value="{{ $submission->student_id }}">
                                    <!-- Fayllar qismi -->
                                    <div class="form-group mb-4">
                                        <label for="fileList" class="form-label fw-semibold text-dark mb-3">
                                            <i class="fas fa-file-alt me-2 text-primary"></i>Yuklangan Fayllar
                                        </label>
                                        <div class="file-list-container border rounded-3 p-3 bg-light">
                                            <ul class="list-unstyled mb-0" id="fileList">
                                                @foreach($allSubmissions as $try)
                                                    <li class="file-item mb-2 p-2 bg-white rounded-2 border">
                                                        <a href="{{ asset('storage/'.$try->file_path) }}" 
                                                        target="_blank" 
                                                        class="text-decoration-none d-flex align-items-center">
                                                            <span class="file-icon me-2 text-primary">📂</span>
                                                            <span class="file-name text-dark flex-grow-1">
                                                                {{ basename($try->file_path) }}
                                                            </span>
                                                            <span class="badge bg-secondary ms-2">
                                                                <i class="fas fa-external-link-alt fa-xs"></i>
                                                            </span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Ball qismi -->
                                    <div class="form-group mb-4">
                                        <label for="grade" class="form-label fw-semibold text-dark">
                                            Baholash
                                        </label>
                                        <div class="input-group">
                                            <input type="number" 
                                                class="form-control" 
                                                id="grade" 
                                                name="grade"
                                                min="0" 
                                                max="100" 
                                                step="1"
                                                required>
                                        </div>
                                    </div>

                                    <!-- Sharh qismi -->
                                    <div class="form-group mb-4">
                                        <label for="comment" class="form-label fw-semibold text-dark">
                                            Baholash Sharhi
                                        </label>
                                        <textarea class="form-control" 
                                                id="comment" 
                                                name="comment"
                                                rows="4" 
                                                placeholder="Talaba ishini baholash bo'yicha sharhingiz..."
                                                style="resize: none;"></textarea>
                                    </div>

                                    <!-- Tasdiqlash tugmasi -->
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success btn-lg py-2">
                                            <i class="fas fa-check-circle me-2"></i>Bahoni Saqlash
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

    <style>
        .container-main {
            padding: 0;
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            background-color: #2c3e50;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .file-list-container {
            max-height: 200px;
            overflow-y: auto;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .file-item {
            transition: all 0.3s ease;
            border: 1px solid #dee2e6;
        }

        .file-item:hover {
            background-color: #f8f9fa !important;
            border-color: #007bff;
            transform: translateX(5px);
        }

        .file-item a:hover .file-name {
            color: #007bff !important;
        }

        .input-group-text {
            border-right: none;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        /* Scrollbar stil */
        .file-list-container::-webkit-scrollbar {
            width: 6px;
        }

        .file-list-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .file-list-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .file-list-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Validation styles */
        .was-validated .form-control:invalid,
        .form-control.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .was-validated .form-control:valid,
        .form-control.is-valid {
            border-color: #28a745;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
    </style>

    <script>
        // Form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.needs-validation');
            
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
            
            // Ballni tekshirish
            const gradeInput = document.getElementById('grade');
            gradeInput.addEventListener('input', function() {
                if (this.value > 100) {
                    this.value = 100;
                } else if (this.value < 0) {
                    this.value = 0;
                }
            });
        });
    </script>
        </div>

        
    </div>
    
</x-layout.app>








