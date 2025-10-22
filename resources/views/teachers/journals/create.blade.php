<x-layout.app>
    <x-slot:title>
         Kuniga baholash
    </x-slot:title>

    <div class="container mt-4">
        <h4 class="mb-3">
            {{ $group->group_name }} guruhi — 
            <span class="badge bg-success">
                {{ \Carbon\Carbon::parse($schedule->date)->format('d.m.Y') }} —
                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - 
                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
            </span>
        </h4>

        <form action="" method="POST">
            @csrf
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Talaba</th>
                        <th>Baho</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $index => $student)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $student->name }}</td>
                            <td>
                                <input 
                                    type="number" 
                                    name="grades[{{ $student->id }}]" 
                                    class="form-control" 
                                    min="0" 
                                    max="100" 
                                    placeholder="Baho"
                                    value="{{ $grades[$student->id]->grade ?? '' }}"
                                >
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end mt-3">
                <button type="submit" class="btn btn-success">Saqlash</button>
            </div>
        </form>
    </div>
</x-layout.app>
