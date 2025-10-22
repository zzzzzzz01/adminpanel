<x-layout.app>
    <x-slot:title>Davomat</x-slot:title>

    <div class="container mt-5">

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
                    <a href="{{ route('attendance.all', ['group' => $group->id, 'semester_id' => $semester->id]) }}"
                    class="btn btn-sm {{ $selectedSemesterId == $semester->id ? 'btn-primary' : 'btn-outline-primary' }}">
                        {{ $semester->semester_number }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="card p-3 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-2">#</th>
                            <th>Sana</th>
                            <th>Fan</th>
                            <th>Guruh</th>
                            <th>Soatlar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as  $attendance)
                        <tr >
                            <td class="ps-2">{{ $loop->iteration }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($attendance->schedule->date)->format('d.m.Y') }} - {{   \Carbon\Carbon::parse($attendance->schedule->lessonPair->start_time)->format('H:i') }}
                            </td>
                            <td>{{ $attendance->schedule->groupSubject->subject->{'name_'.app()->getLocale()} ?? '-' }}</td>
                            <td>{{ $attendance->schedule->group->group_name ?? '-' }}</td>
                            <td>{{ $attendance->status ?? '-' }}</td>
                            <td>
                                @if($attendance->status == '0')
                                    <span class="badge bg-success">Keldi</span>
                                @elseif($attendance->status == '2')
                                    <span class="badge bg-danger">Kelmagan</span>
                                @elseif($attendance->status == '1')
                                    <span class="badge bg-danger">Kelmagan</span>
                                @else
                                    <span class="badge bg-secondary">Noma’lum</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout.app>
