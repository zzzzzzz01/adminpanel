<x-layout.app>
    <x-slot:title>Guruh fanlarini tahrirlash</x-slot:title>

<h3>Mavzu qo‘shish - {{ $groupSubject->subject->name }}</h3>

<form action="{{ route('topics.store', $groupSubject->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="title">Mavzu nomi</label>
        <input type="text" name="title" id="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="file">Fayl yuklash</label>
        <input type="file" name="file" id="file" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Saqlash</button>
</form>

</x-layout.app>
