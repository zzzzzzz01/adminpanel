<x-layout.app>

<x-slot:title>
  Talabalar royhati
</x-slot:title>


<!-- ========== section start ========== -->





<div class="container">
<a href="{{ route('home.page') }}" class="btn btn-success mb-3 mt-2"> @lang('words.back') </a>
<div class="title-wrapper pt-30">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="title">
            <h2> {{ $group->full_group_name }} ({{$group->name}}) @lang('words.group.students')</h2>
        </div>
      </div>
    </div>


    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-lg-12">
              <div class="card-style mb-30">
                  <table class="table top-selling-table">
                    <thead>
                      <tr>
                        <th></th>
                        <th>
                          <h6 class="text-sm text-medium"></h6>
                        </th>
                        <th>
                          <h6 class="text-sm text-medium">@lang('words.student.name')
                          </h6>
                        </th>
                        <th class="min-width">
                          <h6 class="text-sm text-medium">@lang('words.payment')
                          </h6>
                        </th>
                        <th class="min-width">
                          <h6 class="text-sm text-medium"> @lang('email') </h6>
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
                            <p class="text-sm" >{{ $user->name }}</p>
                          </div>
                          </td>
                          <td>
                            <p class="text-sm">{{ $user->payment->{'name_'.app()->getLocale()} }}</p>
                          </td>
                          <td>
                            <p class="text-sm">{{ $user->email }}</p>
                          </td>
                          <td>
                            <p class="text-sm">{{ $user->phone }}</p>
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

<!-- ========== section end ========== -->

</x-layout.app>