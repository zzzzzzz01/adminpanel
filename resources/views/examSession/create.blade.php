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
        }
        
        .card-up-header {
            background: #2c3e50;
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .content {
            padding: 30px;
        }
        
        .card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .card h2 {
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ddd;
            display: flex;
            align-items: center;
            font-size: 20px;
        }
        
        .card h2 i {
            margin-right: 10px;
            color: #3498db;
            font-size: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        input:focus, select:focus, textarea:focus {
            border-color: #3498db;
            outline: none;
        }
        
        button {
            padding: 10px 20px;
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
        
        .btn-success {
            background: #27ae60;
            color: white;
        }
        
        .btn-success:hover {
            background: #219653;
        }
        
        .btn-danger {
            background: #e74c3c;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c0392b;
        }
        
        .test-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 12px;
            margin-top: 15px;
        }
        
        .test-item {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .test-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-color: #3498db;
        }
        
        .test-item.selected {
            border-color: #27ae60;
            background: #e8f5e9;
        }
        
        .test-item h3 {
            color: #2c3e50;
            margin-bottom: 6px;
            font-size: 14px;
        }
        
        .test-item p {
            color: #7f8c8d;
            margin-bottom: 5px;
            font-size: 12px;
        }
        
        .group-badge {
            display: inline-block;
            padding: 2px 6px;
            background: #e6f3ff;
            color: #3498db;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 4px;
            margin-right: 4px;
        }
        
        .datetime-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        
        .selected-tests {
            background: #e8f5e9;
            border-radius: 8px;
            padding: 12px;
            margin-top: 12px;
        }
        
        .selected-test {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background: white;
            border-radius: 6px;
            margin-bottom: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        
        .selected-test-info {
            flex: 1;
        }
        
        .selected-test-info h3 {
            font-size: 14px;
            margin-bottom: 4px;
            color: #2c3e50;
        }
        
        .selected-test-info p {
            font-size: 12px;
            color: #7f8c8d;
            margin-bottom: 2px;
        }
        
        .selected-test-actions {
            display: flex;
            gap: 6px;
        }
        
        .remove-test {
            padding: 6px 10px;
            font-size: 12px;
        }
        
        .notification {
            position: fixed;
            top: 15px;
            right: 15px;
            padding: 12px 20px;
            background: #27ae60;
            color: white;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transform: translateX(100%);
            transition: transform 0.3s;
            z-index: 1000;
            font-size: 14px;
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification.error {
            background: #e74c3c;
        }
        
        .instruction-text {
            font-size: 13px;
            color: #666;
            margin-bottom: 10px;
            line-height: 1.4;
        }
        
        @media (max-width: 768px) {
            .datetime-container {
                grid-template-columns: 1fr;
            }
            
            .test-list {
                grid-template-columns: 1fr;
            }
            
            .content {
                padding: 20px;
            }
            
            .card {
                padding: 15px;
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
                    <a href="{{ route('examSession.index') }}"  class="text-decoration-none">
                        Yakuniylar royhati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Yakuniylar yaratish
                    </a>
                </li>
            </ol>
        </nav>
    </div>






    <div class="container-bot">
        <div class="card-up-header">
            <h1><i class="fas fa-graduation-cap"></i> Yakuniy Nazorat Testini Tashkil Qilish</h1>
            <p>Testlarni tanlang, vaqt va xonani belgilang, va yakuniy nazoratni tashkil qiling</p>
        </div>
        
        <div class="content">
            <form action="{{ route('examSession.store') }}" method="POST"> <!-- Form action -->
                @csrf <!-- CSRF token -->
                <input type="hidden" name="test_ids" id="testIds">

                <div class="card">
                    <h2><i class="fas fa-list"></i> Mavjud Testlar</h2>
                    <p class="instruction-text">Quyidagi testlardan bir yoki bir nechtasini tanlang:</p>
                    
                    <div class="test-list" id="testList">
                        @foreach($tests as $test)
                        <div class="test-item" data-id="{{ $test->id }}"> <!-- ID ni to'g'ri o'rnatish -->
                            <h3>{{ $test->groupSubject->subject->name }}</h3> 
                            <p><i class="fas fa-book"></i> Test nomi: {{ $test->name }}</p>
                            <p><i class="fas fa-question-circle"></i> Savollar: {{ $test->questions->count() }} ta</p>
                            <div>
                                <span class="group-badge"> {{ $test->groupSubject->group->group_name }} </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="card">
                    <h2><i class="fas fa-check-circle"></i> Tanlangan Testlar</h2>
                    <div id="selectedTestsContainer">
                        <p id="noTestsMessage" class="instruction-text">Hali testlar tanlanmagan. Yuqoridan testlarni tanlang.</p>
                        <div id="selectedTestsList" class="selected-tests" style="display: none;">
                            <!-- Tanlangan testlar shu yerda ko'rsatiladi -->
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <h2><i class="fas fa-cog"></i> Test Parametrlari</h2>
                    
                    <div class="datetime-container">
                        <div class="form-group">
                            <label for="startTime">Boshlanish Vaqti</label>
                            <input type="datetime-local" name="start_time" id="startTime">
                        </div>
                        
                        <div class="form-group">
                            <label for="endTime">Tugash Vaqti</label>
                            <input type="datetime-local" name="end_time" id="endTime">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="room">Xona</label>
                        <select id="room" name="room">
                            <option value="">Xonani tanlang</option>
                            <option value="101">101 - Katta xona</option>
                            <option value="202">202 - Kompyuter xonasi</option>
                            <option value="305">305 - Auditoriya</option>
                            <option value="404">404 - Seminar xonasi</option>
                            <option value="507">507 - Labaratoriya</option>
                        </select>
                    </div>
                    
                    <!-- <div class="form-group">
                        <label for="instructions">Qo'shimcha Ko'rsatmalar</label>
                        <textarea id="instructions" rows="2" placeholder="Test uchun qo'shimcha ko'rsatmalar..."></textarea>
                    </div> -->
                    
                    <button id="organizeBtn" class="btn-success">
                        <i class="fas fa-calendar-check"></i> Yakuniy Nazoratni Tashkil Qilish
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="notification" id="notification">
        <i class="fas fa-check-circle"></i> <span id="notificationText"></span>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const testItems = document.querySelectorAll('.test-item');
            const selectedTestsList = document.getElementById('selectedTestsList');
            const noTestsMessage = document.getElementById('noTestsMessage');
            const organizeBtn = document.getElementById('organizeBtn');
            const notification = document.getElementById('notification');
            const notificationText = document.getElementById('notificationText');
            
            let selectedTests = [];
            
            // Testlarni tanlash funksiyasi
            testItems.forEach(item => {
                item.addEventListener('click', function() {
                    const testId = this.getAttribute('data-id');
                    const testTitle = this.querySelector('h3').textContent;
                    const testInfo = this.querySelectorAll('p');
                    const groupName = this.querySelector('.group-badge').textContent.trim();


                    // Test allaqachon tanlanganligini tekshirish
                    const index = selectedTests.findIndex(test => test.id === testId);
                    
                    if (index === -1) {
                        // Testni tanlash
                        this.classList.add('selected');
                        selectedTests.push({
                            id: testId,
                            title: testTitle,
                            group: groupName,
                            subject: testInfo[0].textContent.replace('Fan: ', ''),
                            questions: testInfo[1].textContent.replace('Savollar: ', '')
                        });
                    } else {
                        // Testni tanlovdan olib tashlash
                        this.classList.remove('selected');
                        selectedTests.splice(index, 1);
                    }
                    
                    updateSelectedTestsList();
                });
            });
            
            // Tanlangan testlar ro'yxatini yangilash
            function updateSelectedTestsList() {
                const testIdsInput = document.getElementById('testIds');

                if (selectedTests.length > 0) {
                    noTestsMessage.style.display = 'none';
                    selectedTestsList.style.display = 'block';

                    selectedTestsList.innerHTML = '';

                    selectedTests.forEach(test => {
                        const testElement = document.createElement('div');
                        testElement.className = 'selected-test';
                        testElement.innerHTML = `
                            <div class="selected-test-info">
                                <h3>${test.title}</h3>
                                <p>${test.group} | ${test.questions}</p>
                            </div>
                            <div class="selected-test-actions">
                                <button class="btn-danger remove-test" data-id="${test.id}">
                                    <i class="fas fa-times"></i> O'chirish
                                </button>
                            </div>
                        `;
                        selectedTestsList.appendChild(testElement);
                    });

                    // ✅ Tanlangan test_id larni inputga yozamiz
                    // ✅ Tanlangan test_id larni inputga yozamiz
                        testIdsInput.innerHTML = '';
                        selectedTests.forEach(test => {
                            let hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = 'test_id[]'; // array bo‘lib ketadi
                            hiddenInput.value = test.id;
                            testIdsInput.appendChild(hiddenInput);
                        });

                    // O‘chirish tugmasi eventlari
                    document.querySelectorAll('.remove-test').forEach(btn => {
                        btn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            const testId = this.getAttribute('data-id');

                            // Testni ro'yxatdan olib tashlash
                            const index = selectedTests.findIndex(test => test.id === testId);
                            if (index !== -1) {
                                selectedTests.splice(index, 1);
                            }

                            // Test elementidan tanlangan klassini olib tashlash
                            const testItem = document.querySelector(`.test-item[data-id="${testId}"]`);
                            if (testItem) {
                                testItem.classList.remove('selected');
                            }

                            updateSelectedTestsList();
                        });
                    });
                } else {
                    noTestsMessage.style.display = 'block';
                    selectedTestsList.style.display = 'none';
                    testIdsInput.value = ''; // ✅ agar tanlov bo‘shaysa inputni tozalaymiz
                }
            }
            
            // Yakuniy nazoratni tashkil qilish
            organizeBtn.addEventListener('click', function() {
                const startTime = document.getElementById('startTime').value;
                const endTime = document.getElementById('endTime').value;
                const room = document.getElementById('room').value;
                
                // Validatsiya
                if (selectedTests.length === 0) {
                    showNotification('Iltimos, kamida bitta test tanlang!', 'error');
                    return;
                }
                
                if (!startTime || !endTime) {
                    showNotification('Iltimos, boshlanish va tugash vaqtini kiriting!', 'error');
                    return;
                }
                
                if (!room) {
                    showNotification('Iltimos, xonani tanlang!', 'error');
                    return;
                }
                
                if (new Date(startTime) >= new Date(endTime)) {
                    showNotification('Tugash vaqti boshlanish vaqtidan keyin boʻlishi kerak!', 'error');
                    return;
                }
                
                // Ma'lumotlarni yig'ish
                const finalExam = {
                    tests: selectedTests,
                    startTime: startTime,
                    endTime: endTime,
                    room: room,
                    instructions: document.getElementById('instructions').value
                };
                
                console.log('Yakuniy nazorat ma\'lumotlari:', finalExam);
                
                // Bu yerda backendga so'rov yuboriladi
                /*
                fetch('/api/final-exams', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(finalExam)
                })
                .then(response => response.json())
                .then(data => {
                    showNotification('Yakuniy nazorat muvaffaqiyatli tashkil qilindi!');
                    // Qo'shimcha harakatlar...
                })
                .catch(error => {
                    showNotification('Xatolik yuz berdi: ' + error.message, 'error');
                });
                */
                
                // Simulyatsiya
                showNotification('Yakuniy nazorat muvaffaqiyatli tashkil qilindi!');
            });
            
            // Bildirishnoma ko'rsatish
            function showNotification(message, type = 'success') {
                notificationText.textContent = message;
                
                if (type === 'error') {
                    notification.classList.add('error');
                } else {
                    notification.classList.remove('error');
                }
                
                notification.classList.add('show');
                
                setTimeout(() => {
                    notification.classList.remove('show');
                }, 3000);
            }
            
            // Boshlanish va tugash vaqtlarini sozlash
            const now = new Date();
            const startTimeInput = document.getElementById('startTime');
            const endTimeInput = document.getElementById('endTime');
            
            // Hozirgi vaqtni boshlang'ich qiymat sifatida o'rnatish
            const formatDateTime = (date) => {
                const year = date.getFullYear();
                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                const day = date.getDate().toString().padStart(2, '0');
                const hours = date.getHours().toString().padStart(2, '0');
                const minutes = date.getMinutes().toString().padStart(2, '0');
                
                return `${year}-${month}-${day}T${hours}:${minutes}`;
            };
            
            const startDateTime = formatDateTime(now);
            const endDateTime = formatDateTime(new Date(now.getTime() + 2 * 60 * 60 * 1000)); // 2 soat keyin
            
            startTimeInput.value = startDateTime;
            endTimeInput.value = endDateTime;
        });
    </script>
    </x-layout.app>
