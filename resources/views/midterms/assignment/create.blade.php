<!-- resources/views/assignments/create.blade.php -->
<x-layout.app>
    <x-slot:title>Vazifa yaratish</x-slot:title>

   

    


    <div class="container" style="font-size: 13px;">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm mt-5">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">{{ $midterm->groupSubject->group->group_name ?? '-' }} guruhiga vazifa yaratish</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('midterms.assignment.store', $midterm->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Vazifa nomi</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Sarlavha</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Tavsif</label>
                                    <textarea name="description" class="form-control"></textarea>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Fayl yuklash</label>
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3  mb-2">
                                    <label class="form-label">Maksimal ball</label>
                                    <input type="number" name="max_score" class="form-control" value="0" required>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Urinishlar soni</label>
                                    <input type="number" name="attempts" class="form-control" value="1" required>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Tugash sanasi</label>
                                    <input type="date"
                                        id="exam_date"
                                        name="due_date"
                                        class="form-control"
                                        @if($min) min="{{ $min }}" @endif
                                        @if($max) max="{{ $max }}" @endif
                                        required>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Tugash vaqti</label>
                                    <input type="time" name="due_time" class="form-control" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary px-4" style="font-size: 13px;">Saqlash</button>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($errors->has('max_score'))
        <div class="alert alert-danger position-fixed bottom-0 end-0 p-3" style="background-color: #B22222; color: white;">
            {{ $errors->first('max_score') }}
        </div>
    @endif














    
</x-layout.app>
