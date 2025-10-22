<x-layout.app>
<x-slot:title>
    Testni Ko'rish
</x-slot:title>

<style>
    :root {
        --primary-color: #4a6bdf;
        --secondary-color: #32c48d;
        --dark-color: #2c3e50;
        --light-color: #f8f9fa;
    }
    
    body {
        background-color: #f5f7fb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    /* .container {
        max-width: 1000px;
        margin: 0 auto;
    } */
    
    .test-header {
        background: linear-gradient(135deg, var(--primary-color), #6c8eff);
        color: white;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .question-box {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }
    
    .option-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 10px;
        transition: background-color 0.2s;
    }
    
    .correct-answer {
        background-color: #e8f5e9;
        border-left: 4px solid var(--secondary-color);
    }
    
    .test-info {
        display: flex;
        justify-content: space-between;
        background-color: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    .info-item {
        text-align: center;
    }
    
    .info-value {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--primary-color);
    }
    
    .info-label {
        font-size: 0.9rem;
        color: #6c757d;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
    
    .btn-edit {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    
    .btn-edit:hover {
        background-color: #3a56c4;
        color: white;
    }
    
    .btn-back {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    
    .btn-back:hover {
        background-color: #5a6268;
        color: white;
    }
    
    .card {
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
        border: none;
    }
    
    .card-header {
        background-color: var(--primary-color);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        font-weight: 600;
        padding: 15px 20px;
    }
    
    .format-example {
        background-color: #f0f4ff;
        padding: 15px;
        border-radius: 8px;
        font-family: monospace;
        white-space: pre-wrap;
        margin-bottom: 20px;
    }
    
    .instructions {
        background-color: #fff8e1;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
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
                        <i class="fas fa-home me-1"></i> Asosiy
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('test.index') }}" class="text-decoration-none">
                        Testlar ro'yhati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('questions.show', $test->id) }}" class="text-decoration-none">
                        {{ $test->groupSubject->group->group_name }} | {{ $test->groupSubject->subject->{'name_'.app()->getLocale()} }}
                    </a>
                </li>

                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Yest yaratish
                    </a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page">
                    Mavzular
                </li> -->
            </ol>
        </nav>
    </div>

<div class="container mt-4">
    <!-- Test yaratish formasi -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-upload me-2"></i>Test Matnini Yuklash
                </div>
                <div class="card-body">
                    <form action="{{ route('tests.preview', $test->id) }}" method="GET">
                        <div class="instructions">
                            <h5>Format Ko'rsatmalari:</h5>
                            <ul>
                                <li>Savol matni birinchi qatorda</li>
                                <li><code>======</code> - savol va variantlarni ajratish</li>
                                <li>Variantlar keyingi qatorlarda</li>
                                <li><code>#</code> - to'g'ri javobni belgilash</li>
                                <li><code>++++++</code> - savollarni bir-biridan ajratish</li>
                            </ul>
                        </div>
                        
                        <div class="mb-3">
                            <label for="testContent" class="form-label">Test Matni</label>
                            <textarea class="form-control" id="testContent" name="test_content" rows="12" placeholder="Test matnini bu yerga kiriting..." required>{{ old('test_content', $testContent ?? '') }}</textarea>

                        </div>
                        
                        <label for="testContent" class="form-label">Test yaratish uchun misol</label>
                        <div class="format-example">
O'zbekistonda nechta viloyat bor?
======
10
======
#12
======
8
======
6
++++++

O'zbekiston davlatining poytaxti
======
Samarqand
======
Sirdaryo
======
Andijon
======
#Toshkent
++++++
                        </div>
                        
                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-eye me-2"></i>Testni Ko'rish
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Dastlabki test matnini qo'yish
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('testContent').value = ;
        
        // URL parametrlarini tekshirish
        const urlParams = new URLSearchParams(window.location.search);
        const testContent = urlParams.get('test_content');
        const testName = urlParams.get('test_name');
        
        if (testContent) {
            // Agar URLda test kontenti bo'lsa, uni ko'rsatish
            document.getElementById('testContent').value = decodeURIComponent(testContent);
            if (testName) {
                document.getElementById('testName').value = decodeURIComponent(testName);
            }
            // Testni tahlil qilish
            parseTest(decodeURIComponent(testContent));
        }
    });
    
    function parseTest(testContent) {
        if (!testContent.trim()) {
            return;
        }
        
        // Savollarni ajratib olish
        const questions = testContent.split('++++++').map(q => q.trim()).filter(q => q);
        const previewContainer = document.getElementById('previewContainer');
        previewContainer.innerHTML = '';
        
        if (questions.length === 0) {
            previewContainer.innerHTML = '<p class="text-center text-danger">Hech qanday savol topilmadi!</p>';
            return;
        }
        
        // Savollar sonini yangilash
        document.getElementById('questionsCount').textContent = questions.length;
        
        // Har bir savolni tahlil qilish
        questions.forEach((questionBlock, index) => {
            const lines = questionBlock.split('\n').map(line => line.trim()).filter(line => line);
            
            if (lines.length < 2) {
                return; // Noto'g'ri format
            }
            
            const questionText = lines[0];
            const options = [];
            let correctAnswerIndex = -1;
            
            // Variantlarni tahlil qilish
            for (let i = 1; i < lines.length; i++) {
                if (lines[i] === '======') continue;
                
                let optionText = lines[i];
                let isCorrect = false;
                
                // To'g'ri javobni tekshirish
                if (optionText.startsWith('#')) {
                    isCorrect = true;
                    optionText = optionText.substring(1);
                    correctAnswerIndex = options.length;
                }
                
                options.push({
                    text: optionText,
                    correct: isCorrect
                });
            }
            
            // Savol qutisini yaratish
            const questionBox = document.createElement('div');
            questionBox.className = 'question-box';
            questionBox.innerHTML = `
                <h4>${index + 1}. ${questionText}</h4>
                ${options.map((opt, optIndex) => `
                    <div class="option-item ${opt.correct ? 'correct-answer' : ''}">
                        <input class="form-check-input" type="radio" disabled ${opt.correct ? 'checked' : ''}>
                        <label class="form-check-label ms-2">${opt.text}</label>
                        ${opt.correct ? '<span class="badge bg-success ms-2">To\'g\'ri javob</span>' : ''}
                    </div>
                `).join('')}
            `;
            
            previewContainer.appendChild(questionBox);
        });
    }
    
    function saveTest() {
        const testContent = document.getElementById('testContent').value;
        const testName = document.getElementById('testName').value;
        
        if (!testContent.trim()) {
            alert('Iltimos, test matnini kiriting!');
            return;
        }
        
        if (!testName.trim()) {
            alert('Iltimos, test nomini kiriting!');
            return;
        }
        
        // Backendga so'rov yuborish
        alert('Test saqlandi! Backendga yuborish logikasi qoʻshilishi kerak.');
        // Bu yerda backendga so'rov yuborish kodi bo'ladi
    }
</script>
</x-layout.app>