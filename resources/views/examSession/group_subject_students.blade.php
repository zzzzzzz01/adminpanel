<x-layout.app>
    <x-slot:title>
        {{ $groupSubject->group->group_name }} talabalari — {{ $groupSubject->subject->name }}
    </x-slot:title>

    <!-- <div class="container mt-4">
        <h4>{{ $groupSubject->group->group_name }} — Talabalarga ruxsat berish</h4>

        <form action="{{ route('exam.groupSubject.giveAccess', [$sessionId, $testId, $groupSubject->id]) }}" method="POST">
            @csrf

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ism Familya</th>
                        <th>Ruxsat berish</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $index => $student)
                        
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $student->name }}</td>
                            <td>
                            <input type="checkbox" 
                                name="student_ids[]" 
                                value="{{ $student->id }}"
                                @if(isset($accessList[$student->id]) && $accessList[$student->id]) checked @endif>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Saqlash</button>
        </form>
    </div> -->


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
                    <a href="{{ route('examSession.index') }}" class="text-decoration-none">
                        Yakuniylar royhati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                        {{ $groupSubject->group->group_name }} | {{ $groupSubject->subject->{'name_'.app()->getLocale()} }}
                    </a>
                </li>
            </ol>
        </nav>
    </div>


    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #2c3e50; color: #fff; padding: 20px 15px; min-height: 70px;">
                        <h3 class="mb-0 text-white" style="font-size: 20px;">{{ $groupSubject->group->full_group_name }}  ({{$groupSubject->group->group_name}}) guruhi talabalari</h3>
                    </div>

                    <div class="card-body p-3">
                        <form action="{{ route('exam.groupSubject.giveAccess', [$sessionId, $testId, $groupSubject->id]) }}" method="POST">
                            @csrf
                            <table class="table table-hover" style="font-size: 15px;">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Talabaning I.F.Sh </th>
                                    <th scope="col">To'lov shakli</th>
                                    @php
                                        // Barcha talabalar soni
                                        $totalStudents = count($students);
                                        // Ruxsat berilganlar soni
                                        $allowedCount = count(array_filter($accessList));
                                        // Agar hamma talabaga ruxsat berilgan bo‘lsa
                                        $allChecked = $totalStudents > 0 && $totalStudents === $allowedCount;
                                    @endphp

                                    <th scope="col">
                                        <input 
                                            type="checkbox" 
                                            id="checkAll" 
                                            class="ms-2" 
                                            style="transform: scale(1.3); cursor: pointer;" 
                                            @if($allChecked) checked @endif
                                        >
                                    </th>
                                    <th scope="col"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td>
                                    {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <p class="text-sm" >
                                        {{ $student->last_name }}. {{ $student->name }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-sm">{{ $student->payment->{'name_'.app()->getLocale()} }}</p>
                                    </td>
                                    <td class="ps-2">
                                        <input 
                                            type="checkbox" 
                                            name="student_ids[]" 
                                            value="{{ $student->id }}"
                                            class="student-checkbox"
                                            style="transform: scale(1.3); cursor: pointer;"
                                            @if(isset($accessList[$student->id]) && $accessList[$student->id]) checked @endif
                                        >
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary">Saqlash</button>
                         </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script>
    // Barchasini tanlash yoki olib tashlash
    document.getElementById('checkAll').addEventListener('change', function() {
        const allCheckboxes = document.querySelectorAll('.student-checkbox');
        allCheckboxes.forEach(cb => cb.checked = this.checked);
    });
</script>



</x-layout.app>
