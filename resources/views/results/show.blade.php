<x-layout.app>
    <x-slot:title>
        Natija
    </x-slot:title>

    <div class="container mt-4">
        <div class="card p-3 shadow-sm">
            <h4>{{ $result->test->name }}</h4>
            <p><strong>Ball:</strong> {{ $result->score }}</p>
            <p><strong>Sarflangan vaqt:</strong> {{ gmdate('i:s', $result->time_spent) }} daqiqa</p>
        </div>
    </div>
</x-layout.app>
