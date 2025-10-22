<x-layout.app>
    <x-slot:title>
        Yakuniylar
    </x-slot:title>
    
    <style>
        /* * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        } */
        
        /* body {
            background: linear-gradient(135deg, #1a2a6c 0%, #b21f1f 50%, #fdbb2d 100%);
            color: #333;
            min-height: 100vh;
            padding: 20px;
        } */
        
        .container-bot {
            max-width: 1250px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            margin-top: 30px;
        }
        
        .card-up-header {
            background: #2c3e50;
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        .card-up-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .card-up-header p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .controls {
            padding: 20px;
            background: #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .date-filter {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .date-filter input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #3498db;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2980b9;
        }
        
        .content {
            padding: 20px;
        }
        
        .time-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        
        .time-table th, 
        .time-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .time-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
            position: sticky;
            top: 0;
        }
        
        .time-table tr.time-row {
            background: #e6f7ff;
            font-weight: 600;
        }
        
        .time-table tr.session-row:hover {
            background: #f5f7fa;
        }
        
        .time-table tr.session-row td {
            padding-left: 40px;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-planned {
            background: #e6f3ff;
            color: #3498db;
        }
        
        .status-ongoing {
            background: #fef5e6;
            color: #f39c12;
        }
        
        .status-completed {
            background: #e7f6e9;
            color: #27ae60;
        }
        
        .status-cancelled {
            background: #fceae8;
            color: #e74c3c;
        }
        
        /* Guruh-Fan badge uchun yangi uslub */
        .subject-group-badge {
            display: inline-flex;         /* yonma-yon chiqadi */
            align-items: center;          /* matnni vertikal markazda */
            background: #2c3e50;
            color: #fff;
            font-size: 10px;              /* kichikroq */
            padding: 4px 10px;            /* ichki joy */
            border-radius: 8px;           /* burchaklarni yumshatish */
            white-space: nowrap;          /* bo‘linmasin */
        }

        .subject-group-container {
            display: flex;
            flex-wrap: wrap; /* sig‘maganlari pastga tushadi */
            gap: 6px;        /* oraliq */
        }
        
        .subject-group-badge:hover {
            background: #3498db;
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }
        
        .btn-danger {
            background: #e74c3c;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c0392b;
        }
        
        .btn-warning {
            background: #f39c12;
            color: white;
        }
        
        .btn-warning:hover {
            background: #e67e22;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #ddd;
        }
        
        @media (max-width: 768px) {
            .controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .time-table {
                display: block;
                overflow-x: auto;
            }
            
            .time-table th:nth-child(4),
            .time-table td:nth-child(4) {
                display: none;
            }
        }
    </style>


    <style>    
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
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Yakuniylar royhati
                    </a>
                </li>
            </ol>
        </nav>
    </div>



    <div class="container-bot">
        <div class="card-up-header">
            <h1 class="text-white"><i class="fas fa-clock text-white"></i> Vaqt Jadvali bo'yicha Test Sessiyalari</h1>
            <p>Test sessiyalari vaqt bo'yicha tartiblangan ko'rinishi</p>
        </div>
        
        <div class="controls" style="display: flex; justify-content: flex-end; align-items: center; ">
            <a href="{{ route('examSession.all') }}">
                <button class="btn btn-primary" >
                    Hamma yakuniylar
                </button>
            </a>

            <a href="{{ route('examSession.create') }}">
                <button class="btn btn-success">
                    Yaratish
                </button>
            </a>
        </div>
        
        <div class="content">
            <table class="time-table">
                <thead>
                    <tr>
                        <th>Vaqt</th>
                        <!-- <th>Nomi</th> -->
                        <th>Fan & Guruh</th>
                        <th>Xona</th>
                        <th>Holati</th>
                        <th>Harakatlar</th>
                    </tr>
                </thead>
                <tbody id="sessionsBody">
                    @forelse($sessions as $date => $daySessions)
                        <tr class="time-row">
                            <td colspan="6">
                                {{ \Carbon\Carbon::parse($date)->translatedFormat('d-F, Y') }}
                            </td>
                        </tr>

                        @foreach($daySessions as $session)
                            <tr class="session-row">
                                <td>
                                    {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}
                                </td>
                                <!-- <td>
                                    {{-- Bir nechta testni chiqarish --}}
                                    @foreach($session->tests as $test)
                                        <div>{{ $test->name }}</div>
                                    @endforeach
                                </td> -->
                                <td>
                                    <div class="subject-group-container">
                                        @foreach($session->tests as $test)
                                            @php
                                                // Shu test va guruh uchun hech bo‘lmasa bitta talaba ruxsat olganmi?
                                                $hasAccess = \App\Models\ExamSessionStudentAccess::where('test_id', $test->id)
                                                    ->whereHas('student', function ($q) use ($test) {
                                                        $q->where('group_id', $test->groupSubject->group_id);
                                                    })
                                                    ->where('is_allowed', true)
                                                    ->exists();

                                                // Rangi: yashil yoki qizil
                                                $badgeClass = $hasAccess ? 'bg-success' : 'bg-danger';
                                            @endphp

                                            <span class="subject-group-badge badge {{ $badgeClass }}">
                                                <a href="{{ route('exam.groupSubject.students', [$session->id, $test->id, $test->groupSubject->id]) }}" class="text-white text-decoration-none">
                                                    {{ $test->groupSubject->subject->{'name_'.app()->getLocale()} }}
                                                    - {{ $test->groupSubject->group->group_name }}
                                                </a>
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td>{{ $session->room ?? '-' }}</td>
                                <td>
                                    @php
                                        $now = now();
                                        if ($session->start_time > $now) {
                                            $status = ['class' => 'status-planned', 'text' => 'Rejalashtirilgan'];
                                        } elseif ($session->end_time < $now) {
                                            $status = ['class' => 'status-completed', 'text' => 'Yakunlangan'];
                                        } else {
                                            $status = ['class' => 'status-ongoing', 'text' => 'Davom etmoqda'];
                                        }
                                    @endphp
                                    <span class="status-badge {{ $status['class'] }}">
                                        {{ $status['text'] }}
                                    </span>
                                </td>
                                <td class="action-buttons">
                                    <a href="" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fas fa-calendar-times"></i>
                                <p>Hali imtihon sessiyalari yaratilmagan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');
            const filterBtn = document.getElementById('filterBtn');
            const sessionsBody = document.getElementById('sessionsBody');
            
            // Joriy sanani o'rnatish
            const today = new Date();
            startDateInput.value = formatDate(today);
            endDateInput.value = formatDate(new Date(today.setDate(today.getDate() + 7)));
            
            // Filtrlash funksiyasi
            filterBtn.addEventListener('click', function() {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);
                
                if (startDate > endDate) {
                    alert('Boshlanish sanasi tugash sanasidan keyin bo\'lishi mumkin emas!');
                    return;
                }
                
                // Bu yerda haqiqiy loyihada backendga so'rov yuboriladi
                // Demo uchun faqat konsolga chiqaramiz
                console.log('Filter qilish:', startDateInput.value, 'dan', endDateInput.value, 'gacha');
                alert('Filter qo\'llandi: ' + startDateInput.value + ' - ' + endDateInput.value);
            });
            
            // Sana formatlash funksiyasi
            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }
            
            // Vaqt bo'yicha saralash funksiyasi (agar backenddan ma'lumot kelmasa)
            function sortSessionsByTime() {
                // Bu funksiya frontendda vaqt bo'yicha saralash uchun
                // Haqiqiy loyihada backenddan saralab olish maqsadga muvofiq
                console.log('Sessiyalar vaqt boʻyicha saralandi');
            }
            
            // Dastlabki saralash
            sortSessionsByTime();
        });
    </script>
    </x-layout.app>