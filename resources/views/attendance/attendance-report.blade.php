<x-layout.app>
    <x-slot:title>
        Davomat hisobot
    </x-slot:title>

    @if(auth()->user()->hasRole('student'))
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
                    <a href="{{ route('attendance.report', ['group' => $group->id, 'semester_id' => $semester->id]) }}"
                    class="btn btn-sm {{ $selectedSemesterId == $semester->id ? 'btn-primary' : 'btn-outline-primary' }}">
                        {{ $semester->semester_number }}
                    </a>
                @endforeach
            </div>
        </div>





    <!-- <h5 class="m-3" >{{ $group->group_name }} — {{ $selectedSemester->name }}</h5> -->
    <div class="card p-3 shadow-sm">
        <table class="table table-hover" style="font-size: 13px;">
        <thead>
            <tr>
                <th class="ps-2">#</th>
                <th>Fanlar</th>
                <th>Umumiy aud. soat / Dars</th>
                <th>Qoldirilgan soat(lar)</th>
                <th>Foiz</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subjectReports as $row)
                <tr>
                    <td class="ps-2">{{ $loop->iteration }}</td>
                    <td>{{ $row['subject'] }}</td>
                    <td>{{ $row['audit_hours'] }} / {{ $row['placed_lessons'] }}</td>
                    <td>{{ $row['jami'] }}</td>
                    <td>{{ $row['foiz'] }} %</td>
                </tr>
            @endforeach
        </tbody>
    </div>

</table>


</div>



    </div>


    @else
        <p class="position-absolute top-50 start-50 translate-middle">Sizning rolingiz Teacher emas!</p>
    @endif

    </x-layout.app>
