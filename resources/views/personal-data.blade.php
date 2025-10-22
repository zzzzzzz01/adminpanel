<x-layout.app>

<x-slot:title>
  Shaxsiy malumotlar
</x-slot:title>


<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            @lang('words.person.info')
        </div>
        <div class="card-body">
            <table class="table ">
                <tr>
                    <th> @lang('words.address') </th>
                    <td>{{ $user->address ?? '--' }}</td>
                </tr>
                <tr>
                    <th> @lang('words.phone.number') </th>
                    <td>{{ $user->phone ?? '--' }}</td>
                </tr>
                <tr>
                    <th> @lang('words.email') </th>
                    <td>{{ $user->email ?? '--' }}</td>
                </tr>
                <tr>
                    <th>@lang('words.name')</th>
                    <td>{{ $user->name ?? '--' }}</td>
                </tr>
                <tr>
                    <th> @lang('words.last.name') </th>
                    <td>{{ $user->last_name ?? '--' }}</td>
                </tr>
                <tr>
                    <th> @lang('words.middle.name') </th>
                    <td>{{ $user->middle_name ?? '--' }}</td>
                </tr>
                <tr>
                    <th> @lang('words.birth.day') </th>
                    <td>{{ $user->birth_data ?? '--' }}</td>
                </tr>
            </table>
        </div>
    </div>

    @if($user->hasRole('teacher'))
    <div class="card mt-5">
        <div class="card-header bg-primary text-white">
            Kasbiy ma'lumoti
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Mutaxassislik</th>
                    <td>{{ $user->specialization ?? '--' }}</td>
                </tr>
                <tr>
                    <th>Ta'lim Darajasi</th>
                    <td>{{ $user->degree ?? '--' }}</td>
                </tr>
                <tr>
                    <th>Sertifikatlar</th>
                    <td>{{ $user->certificate ?? '--' }}</td>
                </tr>
                <tr>
                    <th>Shaxsiy Sayti</th>
                    <td>{{ $user->social_links ?? '--' }}</td>
                </tr>
                <tr>
                    <th>Ish Tajribasi</th>
                    <td>{{ $user->experience ?? '--' }} </td>
                </tr>
                <tr>
                    <th>O'qituvchi haqimda</th>
                    <td>{{ $user->description ?? '--' }}</td>
                </tr>
            </table>
        </div>
    </div>
    @endif
</div>

    

</x-layout.app>