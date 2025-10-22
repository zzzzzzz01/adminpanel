<x-layout.app>
<x-slot:title>
        Yakuniylar
    </x-slot:title>
    <style>
        /* body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        } */
        
        /* .container {
            max-width: 1200px;
            margin: 0 auto;
        } */
        
        :root {
        --primary-color: #4a6bdf;
        --secondary-color: #32c48d;
        --dark-color: #2c3e50;
        --light-color: #f8f9fa;
    }

        .card-up-header {
            background: linear-gradient(135deg, var(--primary-color), #6c8eff);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            margin-bottom: 20px;
        }
        
        .cards-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .card {
            flex: 1;
            min-width: 300px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
        }
        
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
            padding: 15px 20px;
            font-weight: 600;
            color: #2c3e50;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 10px 10px 0 0 !important;
        }
        
        .card-body {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .question-edit {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ced4da;
            white-space: pre-wrap;
            line-height: 1.8;
            font-size: 15px;
            margin-bottom: 0;
            flex-grow: 1;
            resize: vertical;
            min-height: 250px;
        }
        
        .question-view {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            flex-grow: 1;
        }
        
        .question-text {
            font-size: 18px;
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .options-list {
            margin-left: 10px;
        }
        
        .option-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        .option-item.correct {
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        
        .option-label {
            width: 30px;
            height: 30px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .correct .option-label {
            background-color: #28a745;
            color: white;
        }
        
        .correct-text {
            color: #28a745;
            font-weight: 500;
            margin-left: 10px;
        }
        
        .card-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            padding: 15px 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            border-radius: 0 0 10px 10px;
        }
        
        .btn-action {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            border: none;
            transition: all 0.2s;
        }
        
        .btn-edit {
            background: #3498db;
            color: white;
        }
        
        .btn-edit:hover {
            background: #2980b9;
        }
        
        .btn-delete {
            background: #e74c3c;
            color: white;
        }
        
        .btn-delete:hover {
            background: #c0392b;
        }
        
        .format-info {
            font-size: 12px;
            color: #6c757d;
            margin-top: 10px;
        }
        
        @media (max-width: 992px) {
            .cards-container {
                flex-direction: column;
            }
            
            .card {
                min-width: 100%;
            }
        }
        
        @media (max-width: 576px) {
            .card-actions {
                flex-direction: column;
            }
            
            .btn-action {
                width: 100%;
                justify-content: center;
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
                        <i class="fas fa-home me-1"></i> Asosiy
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('test.index') }}" class="text-decoration-none">
                        Testlar ro'yhati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('questions.show', $test->id) }}"  class="text-decoration-none">
                        {{ $test->groupSubject->group->group_name }} | {{ $test->groupSubject->subject->{'name_'.app()->getLocale()} }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ $question->question }}
                    </a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page">
                    Mavzular
                </li> -->
            </ol>
        </nav>
    </div>




    <div class="container">
        <!-- Header -->
        <div class="card-up-header text-center">
            <h1 class="text-white"><i class="fas fa-question-circle me-2"></i>Savolni Tahrirlash</h1>
            <p class="mb-0">ID: {{ $question->id }} | {{ $test->groupSubject->subject->{'name_'.app()->getLocale()} }} | {{ $test->groupSubject->semester->name }}</p>
        </div>

        <form action="{{ route('questions.update', [$test->id, $question->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="cards-container">
                <!-- Matn formatini tahrirlash kartasi -->
                <div class="card">
                    <div class="card-header">
                        <span><i class="fas fa-code me-2"></i>Matn Formatida Tahrirlash</span>
                        <span class="badge bg-success">Aktiv</span>
                    </div>
                    <div class="card-body">
                    <textarea class="question-edit" name="question_content" id="questionEdit">{{ $formatted }}</textarea>

                        <div class="format-info">
                            <i class="fas fa-info-circle me-1"></i> To'g'ri javobni # belgisi bilan belgilang
                        </div>
                    </div>
                </div>

                <!-- Ko'rish formasi kartasi -->
                <div class="card">
                    <div class="card-header">
                        <span><i class="fas fa-eye me-2"></i>Ko'rinish Formatida</span>
                    </div>
                    <div class="card-body">
                        <div class="question-view">
                            <div class="question-text" id="viewQuestionText">
                                <!-- 1. O'zbekistonda nechta viloyat bor? -->
                            </div>
                            
                            <div class="options-list" id="viewOptionsList">
                                <!-- Options will be generated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Harakatlar tugmalari -->
            <div class="card-actions mt-4">
                <!-- <button class="btn btn-action btn-delete">
                    <i class="fas fa-trash me-2"></i>O'chirish
                </button> -->

                @php
                    $now = \Carbon\Carbon::now();
                    $semester = $question->test->groupSubject->semester ?? null;
                @endphp

                @if($semester && $now->between($semester->start_date, $semester->end_date))
                <button class="btn btn-action btn-edit" id="saveButton">
                    <i class="fas fa-save me-2"></i>Saqlash
                </button>
                @endif
            </div>
        </form>
        <!-- <form action="{{ route('questions.destroy', [$test->id, $question->id]) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-action btn-delete">
                <i class="fas fa-trash me-2"></i>O'chirish
            </button>
        </form> -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questionEdit = document.getElementById('questionEdit');
            const viewQuestionText = document.getElementById('viewQuestionText');
            const viewOptionsList = document.getElementById('viewOptionsList');
            
            // Dastlabki ko'rinishni yuklash
            updatePreview();
            
            // Matn o'zgarganda ko'rinishni yangilash
            questionEdit.addEventListener('input', updatePreview);
            
            // Ko'rinishni yangilash funksiyasi
            function updatePreview() {
                const text = questionEdit.value;
                const lines = text.split('\n');
                
                // Savol matnini topish
                let question = '';
                let options = [];
                
                for (let i = 0; i < lines.length; i++) {
                    const line = lines[i].trim();
                    
                    if (line === '======' || line === '++++++') continue;
                    
                    if (!question && line && i === 0) {
                        question = line;
                    } else if (line && !line.startsWith('======') && !line.startsWith('++++++')) {
                        options.push(line);
                    }
                }
                
                // Savol matnini yangilash
                viewQuestionText.textContent = `1. ${question}`;
                
                // Variantlarni yangilash
                viewOptionsList.innerHTML = '';
                
                options.forEach((option, index) => {
                    const isCorrect = option.startsWith('#');
                    const optionText = isCorrect ? option.substring(1) : option;
                    const optionLetter = String.fromCharCode(65 + index); // A, B, C, ...
                    
                    const optionItem = document.createElement('div');
                    optionItem.className = `option-item ${isCorrect ? 'correct' : ''}`;
                    
                    optionItem.innerHTML = `
                        <div class="option-label">${optionLetter}</div>
                        <div>${optionText}</div>
                        ${isCorrect ? '<div class="correct-text">To\'g\'ri javob</div>' : ''}
                    `;
                    
                    viewOptionsList.appendChild(optionItem);
                });
            }
            
            // O'chirish tugmasi
            document.querySelector('.btn-delete').addEventListener('click', function() {
                if (confirm('Haqiqatan ham bu savolni o\'chirmoqchimisiz?')) {
                    alert('Savol o\'chirildi!');
                    // Bu yerda sahifani qayta yoʻnaltirish yoki boshqa amallar
                }
            });
            
            // Saqlash tugmasi
            // document.getElementById('saveButton').addEventListener('click', function() {
            //     alert('Savol muvaffaqiyatli saqlandi!');
            //     // Bu yerda saqlash logikasi bo'ladi
            // });
        });
    </script>
    </x-layout.app>