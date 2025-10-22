<x-layout.app>

<x-slot:title>
  Talabalar royhati
</x-slot:title>

<div class="container py-2 wow fadeInUp" data-wow-delay="0.1s">  
    <div class="row g-5">
        <div class="col-lg-4">
            <a class="btn btn-primary" href="{{ route('groups.index') }}" role="button"> @lang('words.back') </a>
            <a class="btn btn-success" href="{{ route('register.student', $group) }}" role="button"> @lang('words.student.create') </a>
        </div>
    </div>
</div>

<div class="container">
  <div class="title-wrapper pt-30">
    <div class="row align-items-center">
      <div class="col-md-12">
        <div class="title">
            <h2> {{ $group->full_group_name }} ({{$group->name}}) @lang('words.group.students')</h2>
        </div>
      </div>
    </div>


    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-lg-12">
              <div class="card-style mb-30">
                <div class="table-responsive">
                    <table class="table top-selling-table">
                      <thead>
                        <tr>
                          <th></th>
                          <th>
                            <h6 class="text-sm text-medium"></h6>
                          </th>
                          <th>
                            <h6 class="text-sm text-medium"> @lang('words.student.full.name') 
                              <a href="?sort=name&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}">
                                <!-- <i class="fa-solid fa-chevron-{{ request('sort') == 'name' && request('order') == 'asc' ? 'up' : 'down' }}"></i> -->
                              </a>
                            </h6>
                          </th>
                          <th class="min-width">
                            <h6 class="text-sm text-medium"> @lang('words.payment')
                              <a href="?sort=payment">
                                <!-- <i class="fa-solid fa-chevron-down"></i> -->
                              </a>
                            </h6>
                          </th>
                          <th class="min-width">
                            <h6 class="text-sm text-medium"> @lang('words.email') </h6>
                          </th>
                          <th class="min-width">
                            <h6 class="text-sm text-medium"> @lang('words.phone.number') </h6>
                          </th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>

                      @foreach($users as $user)
                        <tr>
                          <td>
                          <div class="check-input-primary">
                          <td>{{ $loop->iteration }}</td>
                            </div>
                          </td>
                          <td>
                            <div class="product">
                              <div class="image d-flex align-items-center justify-content-center">
                                <img src="{{ asset('storage/'. $user->photo) }}" alt=""  />
                              </div>
                              <p class="text-sm" ><a href="{{ route('student.show', $user) }}"> {{ $user->last_name }}. {{ $user->name }}</a></p>
                            </div>
                            </td>
                            <td>
                            <p class="text-sm">{{ $user->payment->{'name_'.app()->getLocale()}  }}</p>
                            </td>
                            <td>
                              <p class="text-sm">{{ $user->email }}</p>
                            </td>
                            <td>
                              <p class="text-sm">{{ $user->phone }}</p>
                            </td>
                        
                          <td>
                            
                      <div class="icons d-flex ">
                        <div class="action">
                          <button type="submit" class="btn btn-link p-0">
                            <a href="" data-toggle="modal" data-target="#deleteModal-{{ $user->id }}">
                                <i class="lni lni-trash-can p-0 me-3 text-danger"></i>
                            </a>
                          </button>
                        </div>

                        <div class="modal fade" id="deleteModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel"> @lang('words.delete.student') </h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                @if (App::getLocale() == 'uz')
                                  Siz talaba "{{ $user->name }}" ni o'chirishni tasdiqlaysizmi?
                                @elseif (App::getLocale() == 'ru')
                                  Вы уверены, что хотите удалить студента "{{ $user->name }}"?
                                @elseif (App::getLocale() == 'en')
                                  Are you sure you want to delete student "{{ $user->name }}"?
                                @endif
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal"> @lang('words.close') </button>
                                <form action="{{ route('student.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"> @lang('words.delete') </button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                            <a href="{{ route('student.edit', $user) }}"><i class="fa-solid fa-repeat text-success"></i></a>
                        </div>
                      </div>

                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                    <!-- End Table -->
                  </div>
              </div>
            </div>
        </div>
    </div>
</div>

      @if(session('success'))
      <div class="alert alert-success  position-fixed bottom-0 end-0 p-3" style="background-color: #5cb85c; color: white;">
        {{ session('success') }}
      </div>
      @endif

      @if(session('trash'))
      <div class="alert alert-success  position-fixed bottom-0 end-0 p-3" style="background-color: #B22222; color: white;">
        {{ session('trash') }}
      </div>
      @endif

      @if(session('studentCreate'))
      <div class="alert alert-success  position-fixed bottom-0 end-0 p-3" style="background-color: #5cb85c; color: white;">
        {{ session('studentCreate') }}
      </div>
      @endif

      <script>
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.remove();
            });
        }, 5000); // 5 sekunddan keyin barcha alertlar yo'qoladi
    </script>      

<!-- ========== section end ========== -->

</x-layout.app>