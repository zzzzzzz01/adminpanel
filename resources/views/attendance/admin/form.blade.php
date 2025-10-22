<x-layout.app>

<x-slot:title>
  Davomat
</x-slot:title>

<style>
    .column {
      padding: 15px;
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
                    <a href="{{ route('attendanceAdmin.index') }}" class="text-decoration-none">
                        Guruxlar royhati
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('attendanceAdmin.group', $group->id) }}" class="text-decoration-none">
                        {{ $group->group_name }} guruh fanlari
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('attendanceAdmin.groupSubject', [$group->id, $groupSubject->id]) }}" class="text-decoration-none">
                        {{ $groupSubject->subject->name_uz }}
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="" style="color: #808080;" class="text-decoration-none">
                    {{ \Carbon\Carbon::parse($schedule->date)->format('d.m.Y') }}
                    </a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page">
                    Mavzular
                </li> -->
            </ol>
        </nav>
    </div>


<div class="container mt-4">
    <form action="{{ route('adminAttendance.save', $schedule) }}" method="POST">
        @csrf
        <div class="row">
            <!-- Chap jadval (70%) -->
            <div class="col-md-8">
                <div class="card p-3 shadow-sm">
                    <table class="table " style="font-size: 13px;">
                        <thead class="table">
                            <tr>
                                <th>#</th>
                                <th>Talaba F.I.Sh</th>
                                <th>Tolov turi</th>
                                <th>Mashg‘ulot</th>
                                <th>Davomat (%)</th>
                                <th>Kelmadi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $attendance)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attendance->student->name }}</td>
                                <td>{{ $attendance->student->payment->name_uz }}</td>
                                <td>{{ $attendance->schedule->session->name_uz }}</td>
                                <td>
                                    {{ $studentStats[$attendance->student->id] ?? 0 }} %
                                </td>
                                <td>
                                    <input type="number"
                                        name="students[{{ $attendance->student->id }}]"
                                        value="{{ $attendance->status > 0 ? $attendance->status : '' }}"
                                        class="form-control form-control-sm"
                                        min="0" max="100"
                                        >
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm">
                            Saqlash
                        </button>
                    </div>
                </div>
            </div>

            <!-- O‘ng jadval (30%) -->
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <table class="table " style="font-size: 13px;">
                        <tbody>
                            <tr>
                                <th class="">Fan</th>
                                <td>{{ $schedule->groupSubject->subject->name_uz }}</td>
                            </tr>
                            <tr>
                                <th class="">Mashg‘ulot</th>
                                <td>{{ $schedule->session->name_uz }}</td>
                            </tr>
                            <tr>
                                <th class="">Dars sanasi</th>
                                <td>{{ \Carbon\Carbon::parse($schedule->date)->format('d.m.Y') }}</td>
                            </tr>
                            <tr>
                                <th class="">Guruh</th>
                                <td>{{ $schedule->group->group_name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>




</x-layout.app>