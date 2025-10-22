<x-layout.app>

<x-slot:title>
  Imtihonlar
</x-slot:title>


<div class="container">
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <div class="title">
                    <h2> @lang('words.exam.create') </h2>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center py-2">
        <div class="col-6">
            <div class="signin-wrapper bg-light border border-primary-subtle">
                <div class="form-wrapper ">
                    <form action="{{ route('exams.update', $exam->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-lg-12">
                      <div class="input-style-1">
                          <label for="groups" class="form-label"> @lang('words.groups') </label>
                          <select name="groups[]" id="" class="form-control border-primary-subtle" multiple required>
                            @foreach ($groups as $group)
                              <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach 
                          </select>
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="input-style-1">
                          <label for="user_id" class="form-label"> @lang('words.teacher') </label>
                          <select class="form-select border-primary-subtle px-4 p-2" name="user_id" aria-label="select example">
                          @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $exam ->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                          </select>
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="input-style-1">
                          <label for="subject_id" class="form-label"> @lang('words.subject') </label>
                          <select class="form-select border-primary-subtle px-4 p-2" name="subject_id" aria-label="select example">
                              @foreach($subjects as $subject)
                                  <option value="{{ $subject->id }}" {{ $exam->subject_id == $subject->id ? 'selected' : '' }}>
                                  {{ $subject->{'name_' . app()->getLocale()} }}
                                  </option>
                              @endforeach
                          </select>
                      </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label> @lang('words.exam.data') </label>
                            @if($exam->date)
                            <input type="date" class="form-control bg-light px-3 border border-primary-subtle"  value="{{ date('Y-m-d', strtotime($exam->date)) }}" id="date" name="date" required> 
                            @else
                            <input type="date" class="form-control bg-light px-3 border border-primary-subtle"  value="--" id="date" name="date" required> 
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label> @lang('words.exam.time') </label>
                            <input type="time" class="form-control bg-light px-3 border border-primary-subtle" value="{{ $exam->time }}" id="time" name="time" required> 
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label> @lang('words.exam.place') </label>
                            <input type="room" class="form-control bg-light px-3 border border-primary-subtle" value="{{ $exam->room }}" id="room" name="room" placeholder="@lang('words.exam.place')" required> 
                        </div>
                    </div>
        
                    <a href="{{ route('exams.index') }}"class="btn btn-primary"> @lang('words.back') </a>
                    <button type="submit" class="btn btn-success"> @lang('words.submit') </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</x-layout.app>