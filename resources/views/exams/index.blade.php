<x-layout.app>
    <x-slot:title>
        Yakuniylar
    </x-slot:title>
    <style>
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .card-up-header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .card-up-header h1 {
            font-size: 32px;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .card-up-header p {
            font-size: 18px;
            color: #7f8c8d;
            margin-bottom: 20px;
        }
        
        .create-btn {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s;
        }
        
        .create-btn:hover {
            background: #2980b9;
        }
        
        .search-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .search-input {
            flex: 1;
            min-width: 300px;
            padding: 12px 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        .filters {
            display: flex;
            gap: 10px;
        }
        
        .filter-btn {
            padding: 10px 15px;
            background: #f1f1f1;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .filter-btn:hover {
            background: #e9e9e9;
        }
        
        .filter-btn.active {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }
        
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .test-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .test-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
        }
        
        .card-card-up-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .test-name {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .test-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .status-active {
            background: #e8f5e9;
            color: #2e7d32;
        }
        
        .status-inactive {
            background: #ffebee;
            color: #c62828;
        }
        
        .card-content {
            margin-bottom: 20px;
        }
        
        .test-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 15px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            font-size: 12px;
            color: #7f8c8d;
            margin-bottom: 4px;
        }
        
        .info-value {
            font-size: 16px;
            font-weight: 500;
            color: #2c3e50;
        }
        
        .info-value.highlight {
            color: #3498db;
            font-weight: 600;
        }
        
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
        
        .test-date {
            font-size: 14px;
            color: #7f8c8d;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .action-btn {
            padding: 8px 12px;
            background: #f1f1f1;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .action-btn:hover {
            background: #e9e9e9;
        }
        
        .action-btn.view {
            color: #2E8B57;
        }
        
        .action-btn.edit {
            color: #f1f1f1;
            background-color: #4682B4;
        }

        .action-btn.edit-2 {
            color: #4682B4;
            background-color: #f1f1f1;
        }
        
        .action-btn.delete {
            color: #e74c3c;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            gap: 10px;
        }
        
        .pagination button {
            padding: 10px 16px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .pagination button:hover {
            background: #f1f1f1;
        }
        
        .pagination button.active {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            color: #7f8c8d;
            font-size: 14px;
        }
        
        .semester-buttons {
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        @media (max-width: 768px) {
            .search-box {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-input {
                min-width: auto;
            }
            
            .filters {
                justify-content: center;
            }
            
            .cards-container {
                grid-template-columns: 1fr;
            }
            
            .semester-buttons .btn {
                margin-bottom: 5px;
                width: 100%;
            }
        }
    </style>

    <div class="container mt-2">
        <!-- <div class="card-up-header">
            <h1>Yakuniy Testlar Ro'yxati</h1>
            <p>Barcha testlar va ularning natijalari</p>
        </div> -->
        
        <!-- Semestr tugmalari -->
        <!-- <div class="semester-buttons mb-3">
            @foreach($semesters as $semester)
                <a href="{{ route('exams.index', ['semester_id' => $semester->id]) }}"
                   class="btn btn-sm {{ $semesterId == $semester->id ? 'btn-primary' : 'btn-outline-primary' }}">
                    {{ $semester->name }}
                </a>
            @endforeach
        </div> -->

        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-white shadow-sm rounded">
        {{-- Guruh nomi + icon --}}
            <div class="d-flex align-items-center ">
                <div class="bg-primary text-white d-flex justify-content-center align-items-center" 
                    style="width: 50px; height: 50px; border-radius: 4px;">
                    <i class="fa-solid fa-file" style="font-size: 24px;"></i>
                </div>
                <h5 class="ms-3 mb-0">{{ $user->group->group_name }}</h5>
            </div>

            {{-- Semesterlar tugmalari --}}
            <div>
                <span class="me-2 text-muted fw-bold">SEMESTR</span>
                @foreach($semesters as $semester)
                    <a href="{{ route('exams.index', ['semester_id' => $semester->id]) }}"
                    class="btn btn-sm {{ $semesterId == $semester->id ? 'btn-primary' : 'btn-outline-primary' }}">
                        {{ $semester->semester_number }}
                    </a>
                @endforeach
            </div>
        </div>
        
        <!-- <div class="search-box">
            <input type="text" class="search-input" placeholder="Q. Testlarni qidirish...">
            <div class="filters">
                <button class="filter-btn active">Barchasi</button>
                <button class="filter-btn">Faol</button>
                <button class="filter-btn">Nofaol</button>
            </div>
        </div> -->
        
        <div class="cards-container">
            <!-- Test 1 -->
            @forelse($tests as $test)
            <div class="test-card">
                <div class="card-card-up-header">
                    <div class="test-name">{{ $test->title }}</div>
                    <!-- <div class="test-status 
                        {{ $test->is_active ? 'status-active' : 'status-inactive' }}">
                        
                        @if ($test->end_time < now())
                            Muddat tugadi
                        @else
                            {{ $test->is_active ? 'Faol' : 'Nofaol' }}
                        @endif
                    </div> -->
                    @php
                        $session = $test->examSessions->sortByDesc('end_time')->first();
                        $now = now();
                    @endphp

                    <div class="test-status
                        @if(!$session)
                            status-inactive
                        @elseif($now->lt($session->start_time))
                            status-inactive
                        @elseif($now->between($session->start_time, $session->end_time))
                            status-active
                        @else
                            status-inactive
                        @endif
                    ">
                        @if(!$session)
                            Session mavjud emas
                        @elseif($now->lt($session->start_time))
                            Test hali boshlanmadi
                        @elseif($now->between($session->start_time, $session->end_time))
                            Test davom etmoqda
                        @else
                            Test tugagan
                        @endif
                    </div>

                </div>
                <div class="card-content">
                    <div class="test-info">
                        <div class="info-item">
                            <span class="info-label">Fan</span>
                            <span class="info-value">{{ $test->groupSubject->subject->{'name_'.app()->getLocale()} ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Savollar soni</span>
                            <span class="info-value">{{ $test->questions->count() }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Guruh</span>
                            <span class="info-value highlight">{{ $test->groupSubject->group->group_name ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Maksimal ball</span>
                            <span class="info-value">{{ $test->groupSubject->max_final_score ?? 0 }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Toplamgan ball</span>
                            <span class="info-value highlight">
                            {{ $test->student_result['earned_score'] }}/{{ $test->student_result['max_score'] }}
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Xona</span>
                            <span class="info-value">
                            @foreach($test->examSessions as $session)
                            {{ $session->room ?? '-' }}
                        @endforeach
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Imtinon vaqti</span>
                            <span class="info-value highlight">
                                {{ $test->time_limit ?? '-' }} daqiqa
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Test topshirganlar</span>
                            <span class="info-value">
                            {{ $test->student_result['correct_answers'] }}/{{ $test->student_result['total_questions'] }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="test-date">
                    @foreach($test->examSessions as $session)
                        {{ \Carbon\Carbon::parse($session->start_time)->format('d.m.Y H:i') }}
                    @endforeach
                    </div>
                    <div class="action-buttons">
                        @if(isset($results[$test->id]))
                            <span class="badge bg-success">Siz bu testni topshirdingiz</span>
                            <a href="{{ route('results.show', $results[$test->id]) }}" class="action-btn view">
                                <i class="fas fa-eye"></i>
                            </a>
                        @elseif($accessList[$test->id] ?? false)
                            <a href="{{ route('student.test.start', $test->id) }}" class="btn btn-primary btn-sm">
                                Testni boshlash
                            </a>
                        @else
                            <span class="badge bg-secondary">Sizga ruxsat berilmagan</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Testni topshirishni boshlaysizmi?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                            <a href="{{ route('student.test.start', $test->id) }}" class="btn btn-primary">
                                Ha
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            @empty
            <!-- <div class="alert alert-info text-center">
                        Ushbu semestr uchun ma’lumot topilmadi
                    </div> -->
            @endforelse
            <!-- Test 2
            <div class="test-card">
                <div class="card-card-up-header">
                    <div class="test-name">Yakuniy 3</div>
                    <div class="test-status status-inactive">Nofaol</div>
                </div>
                <div class="card-content">
                    <div class="test-info">
                        <div class="info-item">
                            <span class="info-label">Fan</span>
                            <span class="info-value">Ingliz tili</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Savollar soni</span>
                            <span class="info-value">0</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Guruh</span>
                            <span class="info-value highlight">RI74-22</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Maksimal ball</span>
                            <span class="info-value">50</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">O'rtacha ball</span>
                            <span class="info-value">-</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Test topshirganlar</span>
                            <span class="info-value">0/25</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="test-date">20.11.2023</div>
                    <div class="action-buttons">
                        <button class="action-btn view"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
            </div>
            
            <!-- Test 3 -->
            <!-- <div class="test-card">
                <div class="card-card-up-header">
                    <div class="test-name">Yakuniy 2</div>
                    <div class="test-status status-inactive">Nofaol</div>
                </div>
                <div class="card-content">
                    <div class="test-info">
                        <div class="info-item">
                            <span class="info-label">Fan</span>
                            <span class="info-value">Fizika</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Savollar soni</span>
                            <span class="info-value">0</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Guruh</span>
                            <span class="info-value highlight">RI74-22</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Maksimal ball</span>
                            <span class="info-value">50</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">O'rtacha ball</span>
                            <span class="info-value">-</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Test topshirganlar</span>
                            <span class="info-value">0/25</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="test-date">20.11.2023</div>
                    <div class="action-buttons">
                        <button class="action-btn view"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
            </div> -->
            
            <!-- Test 4 -->
            <!-- <div class="test-card">
                <div class="card-card-up-header">
                    <div class="test-name">Yakuniy 1</div>
                    <div class="test-status status-active">Faol</div>
                </div>
                <div class="card-content">
                    <div class="test-info">
                        <div class="info-item">
                            <span class="info-label">Fan</span>
                            <span class="info-value">Matematika</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Savollar soni</span>
                            <span class="info-value">0</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Guruh</span>
                            <span class="info-value highlight">RI74-22</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Maksimal ball</span>
                            <span class="info-value">50</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">O'rtacha ball</span>
                            <span class="info-value highlight">38.2</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Test topshirganlar</span>
                            <span class="info-value">22/25</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="test-date">20.11.2023</div>
                    <div class="action-buttons">
                        <button class="action-btn view"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
            </div> --> 
        </div>
        
        <!-- <div class="pagination">
            <button>Avvalgi</button>
            <button class="active">1</button>
            <button>2</button>
            <button>3</button>
            <button>Keyingi</button>
        </div>
        
        <div class="footer">
            <p>&copy; 2023 Test Tizimi. Barcha huquqlar himoyalangan.</p>
        </div> -->
    </div>

 </x-layout.app>