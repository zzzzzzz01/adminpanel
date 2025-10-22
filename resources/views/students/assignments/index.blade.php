<x-layout.app>
    <x-slot:title>
        {{ $groupSubject->subject->name }} - Topshiriqlar
    </x-slot:title>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }

        .accordion {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .accordion-item {
            border: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .accordion-button {
            padding: 18px 20px;
            font-weight: 500;
            color: #2c3e50;
            background-color: white;
            box-shadow: none;
        }

        .accordion-button:not(.collapsed) {
            color: #4169E1;
            background-color: #f8f9ff;
        }

        .assignment-link {
            color: #4169E1;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .assignment-link:hover {
            color: #2a4cb3;
            text-decoration: underline;
        }

        .badge {
            font-weight: 500;
            padding: 6px 10px;
            border-radius: 20px;
        }

        .assignment-details {
            background-color: #f8f9ff;
            padding: 20px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .detail-item {
            margin-bottom: 10px;
            display: flex;
        }

        .detail-label {
            font-weight: 500;
            min-width: 120px;
            color: #555;
        }
    </style>




    <div class="container mt-4">
        {{-- Fan haqida ma’lumot --}}
        <div class="mb-4">
            <h4>{{ $groupSubject->subject->{'name_'.app()->getLocale()} }}</h4>
            <p>
                <strong>Ustoz:</strong> {{ $groupSubject->teacher->name }} <br>
                <strong>Kredit:</strong> {{ $groupSubject->subject->credit_hours }} soat
            </p>
        </div>

        {{-- Topshiriqlar ro‘yxati --}}
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0 text-white">Topshiriqlar ro‘yxati</h5>
            </div>
            <div class="card-body p-0">
                @if($assignments->count() > 0)
                    <div class="accordion" id="assignmentsAccordion">
                        @foreach($assignments as $assignment)
                            <div class="accordion-item">
                            @php
                                $allSubmissions = $assignment->submissions()
                                    ->where('student_id', auth()->id())
                                    ->get();

                                $lastSubmission = $allSubmissions->sortByDesc('created_at')->first();
                                $submissionCount = $allSubmissions->count();

                                $canSubmit = now()->lt(\Carbon\Carbon::parse($assignment->due_date.' '.$assignment->due_time))
                                                && $submissionCount < $assignment->attempts;
                            @endphp

                            <h2 class="accordion-header" id="heading{{ $loop->iteration }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="false" 
                                        aria-controls="collapse{{ $loop->iteration }}">
                                    <span class="me-3 text-primary">{{ $loop->iteration }}</span>
                                    <a href="#" class="assignment-link me-3 ">{{ $assignment->name }}</a>

                                    {{-- STATUS --}}
                                    @if($lastSubmission && $lastSubmission->midtermGrade)
                                        <span class="badge bg-primary status-badge ms-auto me-3">Baholandi</span>
                                    @elseif($lastSubmission && !$lastSubmission->midtermGrade)
                                        <span class="badge bg-warning text-dark status-badge ms-auto me-3">Yuklandi</span>
                                    @else
                                        <span class="badge 
                                            {{ now()->lt($assignment->created_at) ? 'bg-secondary' : 
                                            (now()->between($assignment->created_at, $assignment->due_date) ? 'bg-success' : 'bg-danger') }} 
                                            status-badge ms-auto me-3">
                                            {{ now()->lt($assignment->created_at) ? 'Hali boshlanmagan' : 
                                            (now()->between($assignment->created_at, $assignment->due_date) ? 'Faol' : 'Muddati tugagan') }}
                                        </span>
                                    @endif

                                    {{-- GRADE / MAX SCORE --}}
                                    <span class="text-dark">
                                        <i class="fa-solid fa-star"></i>
                                        @if($lastSubmission && $lastSubmission->midtermGrade)
                                            {{ $lastSubmission->midtermGrade->grade }} / {{ $assignment->max_score }}
                                        @else
                                            0 / {{ $assignment->max_score }}
                                        @endif
                                    </span>
                                </button>
                            </h2>
                                <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $loop->iteration }}" data-bs-parent="#assignmentsAccordion">
                                    <div class="accordion-body">
                                        <div class="assignment-details">
                                            <div class="detail-item">
                                                <span class="detail-label">Nomi:</span>
                                                <span>{{ $assignment->title }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">Tavsif:</span>
                                                <span>{{ $assignment->description }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label pe-2">Topshirish muddati:</span>
                                                <span class="text-primary">{{ \Carbon\Carbon::parse($assignment->due_date)->format('d.m.Y') }} \ {{ \Carbon\Carbon::parse($assignment->due_time)->format('H:i') }}</span>
                                            </div>
                                            <!-- <div class="detail-item">
                                                <span class="detail-label">Status:</span>
                                                <span class="badge {{ now()->lt($assignment->created_at) ? 'bg-secondary' : (now()->between($assignment->created_at, $assignment->due_date) ? 'bg-success' : 'bg-danger') }} status-badge">
                                                    {{ now()->lt($assignment->created_at) ? 'Hali boshlanmagan' : (now()->between($assignment->created_at, $assignment->due_date) ? 'Faol' : 'Muddati tugagan') }}
                                                </span>
                                            </div> -->
                                            <div class="detail-item">
                                                <span class="detail-label pe-3">Topshiriq fayllari:</span>
                                                @if($assignment->file)
                                                @php
                                                    $filePath = storage_path('app/public/' . $assignment->file);
                                                    $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
                                                    $fileSizeKb = round($fileSize / 1024, 2); // KB da
                                                @endphp
                                                    <a href="{{ asset('storage/' . $assignment->file) }}" style="font-size: 13px;" class="text-primary pt-1" download>
                                                        <i class="fas fa-download me-1"></i> Yuklab olish ({{ $fileSizeKb }} KB)
                                                    </a>
                                                @else
                                                    <span>Fayl mavjud emas.</span>
                                                @endif
                                            </div>
                                            @php
                                                // Shu assignment bo'yicha talabaning barcha submissions
                                                $allSubmissions = $assignment->submissions()
                                                    ->where('student_id', auth()->id())
                                                    ->get();

                                                $lastSubmission = $allSubmissions->sortByDesc('created_at')->first();
                                                $submissionCount = $allSubmissions->count(); // Urinishlar soni

                                                $canSubmit = now()->lt(\Carbon\Carbon::parse($assignment->due_date.' '.$assignment->due_time))
                                                                && $submissionCount < $assignment->attempts;
                                            @endphp

                                            @if($lastSubmission)
                                                <div class="detail-item">
                                                    <span class="detail-label pe-3">Yuklangan fayl:</span>
                                                    <br>
                                                    <a href="{{ asset('storage/'.$lastSubmission->file_path) }}" target="_blank">
                                                        📂 {{ basename($lastSubmission->file_path) }}
                                                    </a>
                                                </div>
                                            @endif

                                            <div class="detail-item">
                                                <span class="detail-label pe-3">Urinishlar:</span>
                                                {{ $submissionCount }} / {{ $assignment->attempts }}
                                            </div>

                                            {{-- Yuborish tugmasi faqat baholanmaganida ko‘rsin --}}
                                            @if(!$lastSubmission || !$lastSubmission->midtermGrade)
                                                @if($canSubmit)
                                                    <a href="{{ route('submissions.create', $assignment->id) }}" 
                                                    class="btn btn-primary mt-2">Yuborish</a>
                                                @endif
                                            @endif  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-3 text-center">
                        <em>Hozircha topshiriqlar mavjud emas.</em>
                    </div>
                @endif
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Sahifa yuklandi. Bu yerda ma\'lumotlarni yuklash logikasi bo\'ladi.');
        });
    </script>
</x-layout.app>