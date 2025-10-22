<x-layout.app>

<x-slot:title>
  Imtihonlar
</x-slot:title>

<div class="container ">
    <div class="row g-5 vh-100 d-flex justify-content-center align-items-center">
        <div class="col-lg-6 wow slideInUp" data-wow-delay="0.3s">
            <form action="{{ route('exams.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                <div class="col-6">
                <a href="{{ route('exams.index') }}" class="btn btn-success ">O'rqaga</a>
                </div>
                    <div class="col-12">
                        <select class="form-select border-primary-subtle px-4 p-2" name="subject" aria-label="select example">
                            <option disabled selected>Fan nomi</option>
                            <option value="Matematika">Matematika</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <input type="text" class="form-control bg-light px-4 border-primary-subtle" name="exam_date" placeholder="Imtihon kuni" style="height: 45px;">
                    </div>
                    <div class="col-12">
                        <select class="form-select border-primary-subtle px-4 p-2" name="start_time" aria-label="select example">
                            <option disabled selected>Imtihon Boshlanish vaqtini tanlang</option>
                            <option value="9:00">9:00</option>
                            <option value="9:30">9:30</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <select class="form-select border-primary-subtle px-4 p-2" name="end_time" aria-label="select example">
                            <option disabled selected>Imtihon Tugash vaqtini tanlang</option>
                            <option value="9:00">9:30</option>
                            <option value="9:30">10:00</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <select class="form-select border-primary-subtle px-4 p-2" name="room" aria-label="select example">
                            <option disabled selected>Xona</option>
                            <option value="4/313">4/313</option>
                            <option value="5/212">5/212</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="">Gruxlar</label>
                        <select class="form-select border-primary-subtle px-4 p-2" size="3" name="groups[]"  aria-label="Size 3 select example" multiple>
                            @foreach($groups as $group)
                            <option value="{{ $group->id }}"> {{ $group->group_name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label >Oqituvchilar</label>
                        <select class="form-select border-primary-subtle px-4 p-2" name="teacher_id" aria-label="select example">
                            <option disabled selected>Oqituvchilar</option>
                            <option value="1">Hilton Oberbrunner</option>
                            <option value="2">Theodora Wisozk</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary w-100 py-3" type="submit">Yuborish</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


</x-layout.app>