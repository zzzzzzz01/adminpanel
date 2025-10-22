<x-layout.app>
    <x-slot:title>
        Yakuniylar savollar
    </x-slot:title>

    <style>    
        /* Default switch ranglarini o‘zgartirish */
        .form-check-input.switch-active {
            background-color: #28a745 !important; /* Yashil */
            border-color: #28a745 !important;
        }
        .form-check-input.switch-inactive {
            background-color: #adb5bd !important; /* Kulrang */
            border-color: #adb5bd !important;
        }

        /* Disabled holatda ham rang saqlansin */
        .form-check-input:disabled.switch-active {
            opacity: 0.7 !important;
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }
        .form-check-input:disabled.switch-inactive {
            opacity: 0.7 !important;
            background-color: #adb5bd !important;
            border-color: #adb5bd !important;
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
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ $test->groupSubject->group->group_name }} | {{ $test->groupSubject->subject->{'name_'.app()->getLocale()} }}
                    </a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page">
                    Mavzular
                </li> -->
            </ol>
        </nav>
    </div>



    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 20px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">Savollar Jadvali</h3>
                        
                        
                        <div class="plus d-flex justify-content-between align-items-center">
                            <div class="info-item pe-3">
                                <i class="fas fa-file-alt"></i>
                                <span>{{ $test->questions->count() }} ta savol</span>
                            </div>

                            <div class="plus d-flex justify-content-between align-items-center">
                            <form action="{{ route('tests.search', $test) }}" method="GET" class="d-flex">
                                <div class="input-group">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        value="{{ request('search') }}" 
                                        class="form-control" 
                                        placeholder="Testni qidirish..."
                                    >
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                            @php
                                $now = \Carbon\Carbon::now();
                                $semester = $test->groupSubject->semester ?? null;
                            @endphp

                            @if($semester && $now->between($semester->start_date, $semester->end_date))
                                <a href="{{ route('tests.addQuestions', $test->id) }}" class="btn btn-primary ms-2">
                                    Savol qo'shish
                                </a>
                            @endif
                        </div>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <table class="table table-hover" style="font-size: 15px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Savol </th>
                                    <th>Variantlar </th>
                                    <th>To'g'ri javob </th>
                                    <th>Holati </th>
                                    <th>Amallar</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($questions as $question)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="question-text">
                                                <span class="badge" style="background-color: #483D8B; color: white; font-size: 12px;">
                                                    <a href="{{ route('questions.edit', [$test->id, $question->id]) }}" style="color: white; text-decoration: none;">
                                                        {{ $question->question }}
                                                    </a>
                                                </span>
                                            </div>
                                            <div class="options-preview" style="font-size: 14px;">
                                                @foreach($question->options as $index => $option)
                                                    <strong >{{ $loop->iteration }})</strong> {{ $option->text }}@if(!$loop->last), @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>{{ $question->options->count() }}</td>
                                        <td>
                                            @foreach($question->options->where('is_correct', 1) as $index => $option)
                                                <span class="badge bg-success me-1">{{ $option->text }}</span>
                                            @endforeach
                                        </td>
                                        @php
                                            $semester = $test->groupSubject->semester ?? null;
                                            $today = \Carbon\Carbon::now()->toDateString();
                                            $isDisabled = $semester && $today > $semester->end_date; // semester tugaganmi?

                                            $isDisabledTrash = true; // default holatda disable

                                            if ($semester && $now->between($semester->start_date, $semester->end_date)) {
                                                $isDisabledTrash = false; // agar hozirgi sana semester oralig‘ida bo‘lsa — aktiv
                                            }
                                        @endphp

                                        <td>
                                            <form action="{{ route('test.question-status', $question->id) }}" method="POST">
        @csrf
        <div class="form-check form-switch">
            <input 
                class="form-check-input {{ $isDisabled ? 'opacity-50 cursor-not-allowed' : '' }}" 
                type="checkbox" 
                id="questionSwitch{{ $question->id }}" 
                {{ $question->is_active ? 'checked' : '' }}
                {{ $isDisabled ? 'disabled' : '' }}
                onchange="this.form.submit()"
            >
        </div>
    </form>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <form action="{{ route('questions.destroy', [$test->id, $question->id]) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button 
                                                        type="submit" 
                                                        class="btn btn-sm btn-delete"
                                                        style="{{ $isDisabled ? 'pointer-events:none; opacity:0.5; background:none; border:none;' : '' }}"
                                                    >
                                                        <i class="fas fa-trash text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
















</x-layout.app>