<x-layout.app>
    <x-slot:title>
        {{ $user->name }} — Ozlashtirish
    </x-slot:title>

    <div class="container mt-4">


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
                    <a href="{{ route('students.performance', ['user' => $user->id, 'semester_id' => $semester->id]) }}"
                        class="btn btn-sm {{ $semesterId == $semester->id ? 'btn-primary' : 'btn-outline-primary' }}">
                        {{ $semester->semester_number }}
                    </a>
                @endforeach
            </div>
        </div>



        <div class="row">
            <div class="col-12">
                <div class="card p-3 shadow-sm">
                {{-- Semestr tanlash --}}
                <!-- <div class="mb-3">
                    @foreach($semesters as $semester)
                        <a href="{{ route('students.performance', ['user' => $user->id, 'semester_id' => $semester->id]) }}"
                        class="btn btn-sm {{ $semesterId == $semester->id ? 'btn-primary' : 'btn-outline-primary' }}">
                            {{ $semester->name }}
                        </a>
                    @endforeach
                </div> -->


                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Fan</th>
                            <th>Joriy</th>
                            <th>Oraliq</th>
                            <th>Yakuniy</th>
                            <th>Umumiy</th>
                        </tr>
                    </thead>
                        {{-- Natijalar --}}
                        @if($subjectsWithScores->isNotEmpty())
                        <tbody>
                            @foreach($subjectsWithScores as $subject)
                            <tr>
                                    <td>{{ $subject['subject_name'] }}</td>
                                    <td>
                                        {{ $subject['score'] }} 
                                        <a href="" style="color: #483D8B; font-size: 14px;"><i class="fa-solid fa-eye-slash ps-1"></i></a>
                                    </td>
                                    
                                    <td>
                                    {{ $subject['midterm_grade'] }}
                                        <a href="" style="color: #483D8B; font-size: 14px;"><i class="fa-solid fa-eye-slash ps-1"></i></a>
                                    </td>
                                    <td>
                                    {{ $subject['final_grade'] }}
                                        <a href="" style="color: #483D8B; font-size: 14px;"><i class="fa-solid fa-eye-slash ps-1"></i></a>
                                    </td>
                                    <td>
                                    {{ $subject['total'] }}
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                        @endif
                    </table>
                    <!-- <div class="alert alert-info text-center">
                        Ushbu semestr uchun ma’lumot topilmadi
                    </div> -->
                
            </div>
        </div>
    </div>
</div>

</x-layout.app>
