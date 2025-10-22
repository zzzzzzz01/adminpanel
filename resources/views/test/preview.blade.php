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
                    <a href="{{ route('tests.addQuestions', $test->id) }}" class="text-decoration-none">
                        Test yozish
                    </a>
                </li>

                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        Test yaratish
                    </a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page">
                    Mavzular
                </li> -->
            </ol>
        </nav>
    </div>

<div class="container mt-4">
    <form action="{{ route('tests.storeQuestions', $test->id) }}" method="POST">
        @csrf

        <!-- Test statistikasi -->
        <div class="test-info shadow-sm">
            <div class="info-item">
                <div class="info-value">{{ $questionsCount }}</div>
                <div class="info-label">Savollar</div>
            </div>
            <div class="info-item">
                <div class="info-value">{{ $timeLimit }}</div>
                <div class="info-label">Daqiqa</div>
            </div>
            <div class="info-item">
                <div class="info-value">{{ $status }}</div>
                <div class="info-label">Holati</div>
            </div>
        </div>

        <!-- Savollar ro'yxati -->
        <div class="question-list">
            @foreach($questions as $index => $question)
            <div class="question-box">
                <h4>{{ $index + 1 }}. {{ $question['question'] }}</h4>
                <input type="hidden" name="questions[{{ $index }}][question]" value="{{ $question['question'] }}">
                
                @foreach($question['options'] as $optIndex => $option)
                    <div class="option-item {{ $option['correct'] ? 'correct-answer' : '' }}">
                        <input type="hidden" name="questions[{{ $index }}][options][{{ $optIndex }}][text]" value="{{ $option['text'] }}">
                        <input type="hidden" name="questions[{{ $index }}][options][{{ $optIndex }}][correct]" value="{{ $option['correct'] ? 1 : 0 }}">
                        
                        <input class="form-check-input" type="radio" disabled {{ $option['correct'] ? 'checked' : '' }}>
                        <label class="form-check-label ms-2">{{ $option['text'] }}</label>
                        @if($option['correct'])
                            <span class="badge bg-success ms-2">To'g'ri javob</span>
                        @endif
                    </div>
                @endforeach
            </div>
            @endforeach
        </div>

        <!-- Harakatlar tugmalari -->
        <div class="action-buttons">
            <a href="#" class="btn btn-back">
                <i class="fas fa-arrow-left me-2"></i>Ortga qaytish
            </a>
            <button type="submit" class="btn btn-edit">
                <i class="fas fa-save me-2"></i>Saqlash
            </button>
        </div>
    </form>
</div>

</x-layout.app>
