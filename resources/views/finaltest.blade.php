<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Yechish</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f0f2f5;
            color: #333;
            line-height: 1.5;
            padding: 10px;
            font-size: 14px;
            overflow: hidden; /* Asosiy scrollni olib tashlash */
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 95vh;
        }
        
        .test-header {
            background: linear-gradient(135deg, #4a6fa5, #2c3e50);
            color: white;
            padding: 12px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }
        
        .test-title {
            font-size: 16px;
            font-weight: 600;
        }
        
        .test-info {
            display: flex;
            gap: 12px;
            font-size: 12px;
        }
        
        .timer-container {
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 8px;
            border-radius: 4px;
            font-weight: 600;
        }
        
        .timer {
            color: #ffeb3b;
        }
        
        .test-content {
            display: flex;
            padding: 0;
            flex-grow: 1;
            overflow: hidden;
        }
        
        /* Savollar paneli - kichikroq qilindi */
        .questions-panel {
            width: 65%;
            padding: 15px;
            overflow-y: auto; /* Faqat savollar uchun scroll */
            display: flex;
            flex-direction: column;
        }
        
        .questions-container {
            flex-grow: 1;
        }
        
        .question-container {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background: #fff;
        }
        
        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .question-number {
            font-size: 14px;
            font-weight: 600;
            color: #4a6fa5;
        }
        
        .question-text {
            font-size: 14px;
            margin-bottom: 12px;
            line-height: 1.4;
        }
        
        .options-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .option {
            display: flex;
            align-items: center;
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 13px;
        }
        
        .option:hover {
            background: #f5f7f9;
            border-color: #4a6fa5;
        }
        
        .option input {
            margin-right: 8px;
            transform: scale(0.9);
        }
        
        .option.selected {
            background: #e3f2fd;
            border-color: #4a6fa5;
        }
        
        /* Navigatsiya paneli - kichikroq qilindi */
        .navigation-panel {
            width: 35%;
            padding: 15px;
            background: #f8f9fa;
            display: flex;
            flex-direction: column;
            border-left: 1px solid #e0e0e0;
            height: 100%;
            overflow: auto;
        }
        
        .answers-header {
            text-align: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #ddd;
        }
        
        .answers-header h2 {
            font-size: 15px;
            color: #2c3e50;
        }
        
        .answers-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 6px;
            margin-bottom: 15px;
            justify-items: center;
            overflow-y: auto; /* Faqat savol raqamlari uchun scroll */
            max-height: calc(100% - 120px); /* Scroll chegarasini belgilash */
            padding: 5px;
        }
        
        .answer-number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border: 1px solid #ddd;
            border-radius: 50%;
            cursor: pointer;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.2s;
            background: white;
        }
        
        .answer-number:hover {
            border-color: #4a6fa5;
            background: #f5f7f9;
        }
        
        .answer-number.current {
            border-color: #4a6fa5;
            background: #4a6fa5;
            color: white;
            transform: scale(1.1);
        }
        
        .answer-number.answered {
            border-color: #4a6fa5;
            background: #4a6fa5;
            color: white;
        }
        
        .test-actions {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .finish-btn {
            padding: 8px;
            background: #2ecc71;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            transition: background 0.2s;
        }
        
        .finish-btn:hover {
            background: #27ae60;
        }
        
        .clear-btn {
            padding: 7px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            font-size: 12px;
            transition: background 0.2s;
        }
        
        .clear-btn:hover {
            background: #c0392b;
        }
        
        /* Modal oynasi */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            border-radius: 8px;
            padding: 20px;
            width: 320px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }
        
        .modal h2 {
            margin-bottom: 12px;
            color: #2c3e50;
            font-size: 16px;
        }
        
        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
        }
        
        .modal-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
        }
        
        .modal-confirm {
            background: #2ecc71;
            color: white;
        }
        
        .modal-cancel {
            background: #e74c3c;
            color: white;
        }
        
        @media (max-width: 768px) {
            .test-content {
                flex-direction: column;
            }
            
            .questions-panel, .navigation-panel {
                width: 100%;
            }
            
            .navigation-panel {
                border-left: none;
                border-top: 1px solid #e0e0e0;
                height: auto;
            }
            
            .answers-grid {
                grid-template-columns: repeat(8, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="test-header">
            <div class="test-title"> {{ $test->name }} ({{ $test->groupSubject->group->group_name ?? '-' }}- {{ $test->groupSubject->subject->name ?? '-' }} ) {{ $test->groupSubject->semester->name ?? '-' }} uchun</div>
            <div class="test-info">
                <span><i class="fas fa-book"></i> {{ $test->questions->count() }} ta savol</span>
                <div class="timer-container">
                    <i class="fas fa-clock"></i> Qolgan: <span class="timer" id="timer">60:00</span>
                </div>
            </div>
        </div>

            <div class="test-content">
                <!-- Savollar paneli -->
                <div class="questions-panel">
                    <form action="{{ route('exam.answer.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="test_id" value="{{ $test->id }}">
                            <div class="questions-container" >
                                @foreach($questions as $index => $question)
                                    <div class="question-container" id="question-{{ $index + 1 }}">
                                        <div class="question-header">
                                            <div class="question-number">Savol {{ $index + 1 }}</div>
                                        </div>
                                        <div class="question-text">{{ $question->question }}</div>
                                        <div class="options-container">
                                            @foreach($question->options as $optionIndex => $option)
                                            <label class="option">
                                            <input type="radio" name="option_id[{{ $question->id }}]" value="{{ $option->id }}">
                                                {{ $option->text }}
                                            </label>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="question_id[{{ $index }}]" value="{{ $question->id }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Navigatsiya paneli -->
                        <div class="navigation-panel">
                            <div class="answers-header">
                                <h2>Savollar</h2>
                            </div>
                            
                            <div class="answers-grid" id="answersGrid">
                                @foreach($questions as $index => $q)
                                    <div class="answer-number" data-id="{{ $index+1 }}">
                                        {{ $index+1 }}
                                    </div>
                                @endforeach
                            </div>

                            
                            <div class="test-actions">
                                <button type="submit" class="finish-btn" >
                                    <i class="fas fa-check-circle"></i> Yakunlash
                                </button>
                                <button type="reset" class="clear-btn" id="clearBtn">
                                    <i class="fas fa-trash"></i> Tozalash
                                </button>
                            </div>
                        </form>
                        </div>
                </div>
            </div>
    
    <!-- Modal oynasi -->
    <div class="modal" id="confirmationModal">
        <div class="modal-content">
            <h2>Testni yakunlashni istaysizmi?</h2>
            <p id="modalMessage">Siz 25 ta savoldan 0 tasiga javob berdingiz.</p>
            <div class="modal-buttons">
                <button class="modal-btn modal-confirm" id="confirmFinish">Ha</button>
                <button class="modal-btn modal-cancel" id="cancelFinish">Yo'q</button>
            </div>
        </div>
    </div>

    <script>
    const totalQuestions = {{ count($questions) }};
    let userAnswers = {};
    let timeLeft = {{ $test->time_limit }} * 60; // 60 daqiqa
    let timerInterval;

    // Javob raqamlarini yangilash
    function updateAnswerNumbers() {
        document.querySelectorAll('.answer-number').forEach(el => {
            const questionId = parseInt(el.getAttribute('data-id'));
            if (userAnswers[questionId]) {
                el.classList.add('answered');
            } else {
                el.classList.remove('answered');
            }
        });
    }

    // Savolga scroll qilish
    function scrollToQuestion(questionNumber) {
        const questionElement = document.getElementById(`question-${questionNumber}`);
        if (questionElement) {
            questionElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            questionElement.style.boxShadow = '0 0 0 2px #4a6fa5';
            setTimeout(() => {
                questionElement.style.boxShadow = 'none';
            }, 1000);
        }
    }

    // Vaqtni hisoblash
    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        document.getElementById('timer').textContent = 
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        if (timeLeft > 0) {
            timeLeft--;
        } else {
            finishTest();
        }
    }

    // Testni yakunlash
    function finishTest() {
        clearInterval(timerInterval);
        const score = Object.keys(userAnswers).length;
        alert(`Test yakunlandi! Siz ${totalQuestions} ta savoldan ${score} tasiga javob berdingiz.`);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Radio tugmalarni tinglash
        document.querySelectorAll('input[type="radio"]').forEach(input => {
            input.addEventListener('change', function() {
                const qId = parseInt(this.name.replace('answer-', ''));
                userAnswers[qId] = this.value;
                updateAnswerNumbers();

                // Variantni belgilash dizayni
                const optionElement = this.closest('.option');
                optionElement.parentElement.querySelectorAll('.option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                optionElement.classList.add('selected');
            });
        });

        // Boshlanishida raqamlarni yangilash
        updateAnswerNumbers();

        // Navigatsiya raqamlari bosilganda savolga scroll
        document.querySelectorAll('.answer-number').forEach(el => {
            el.addEventListener('click', function() {
                const qId = parseInt(this.getAttribute('data-id'));
                scrollToQuestion(qId);
            });
        });

        // Taymer
        timerInterval = setInterval(updateTimer, 1000);

        // Yakunlash tugmasi
        document.getElementById('finishBtn').addEventListener('click', function() {
            const answeredCount = Object.keys(userAnswers).length;
            document.getElementById('modalMessage').textContent = 
                `Siz ${totalQuestions} ta savoldan ${answeredCount} tasiga javob berdingiz.`;
            document.getElementById('confirmationModal').style.display = 'flex';
        });

        // Tozalash tugmasi
        document.getElementById('clearBtn').addEventListener('click', function() {
            if (confirm('Barcha javoblaringizni o\'chirib tashlamoqchimisiz?')) {
                userAnswers = {};
                document.querySelectorAll('input[type="radio"]').forEach(input => input.checked = false);
                document.querySelectorAll('.option').forEach(opt => opt.classList.remove('selected'));
                updateAnswerNumbers();
            }
        });

        // Modal tugmalari
        document.getElementById('confirmFinish').addEventListener('click', finishTest);
        document.getElementById('cancelFinish').addEventListener('click', function() {
            document.getElementById('confirmationModal').style.display = 'none';
        });
    });
</script>

</body>
</html>