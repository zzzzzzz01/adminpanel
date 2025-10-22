<x-layout.app>

<x-slot:title>
  Talaba
</x-slot:title>


<style>
        
        .teacher-details {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            text-align: center;
        }
        .teacher-details img {
            /* border-radius: 50%; */
            width: 250px;
            height: 300px;
            margin-bottom: 20px;
        }
        .teacher-details p {
            margin: 10px 0;
            font-size: 1.1em;
            color: #555;
        }
        .teacher-details .contact-info {
            margin-top: 20px;
            padding: 15px;
            border-top: 1px solid #ddd;
        }
        .teacher-details a {
            color: #007BFF;
            text-decoration: none;
        }
        .teacher-details a:hover {
            text-decoration: underline;
        }
</style>
</head>
<body>

    <div class="container pt-2">
        <div class="row">
            <div class="teacher-details border border-primary-subtle">
                <img src="{{ asset('storage/'.$user->photo) }}" class="border border-primary-subtle rounded" alt="O'quvchi Rasm">
                <h2> @lang('words.student'): {{ $user->name }}. {{ $user->last_name }}. {{ $user->middle_name }}</h2>
                <p><strong class="pe-2"> @lang('words.payment'):</strong>{{ $user->payment->{'name_'.app()->getLocale()} ?? '--' }}</p>
                <p><strong class="pe-2"> @lang('words.student.group'):</strong>{{ $user->group->name ?? '--' }}</p>
                <p><strong class="pe-2"> @lang('words.specialization'):</strong>{{ $user->group->full_group_name ?? '--' }}</p>
                <div class="contact-info">
                    <p><strong class="pe-2"> @lang('words.email'):</strong> <a href="">{{ $user->email }}</a></p>
                    <p><strong class="pe-2"> @lang('words.phone.number'):</strong>{{ $user->phone ?? '--' }}</p>
                </div>
                    <p><strong class="pe-2"> @lang('words.birth.day'):</strong>{{ $user->birth_date  ?? '--' }}</p>
                    <p><strong class="pe-2"> @lang('words.address'):</strong>{{ $user->address ?? '--'  }} </p>
                    
                    <a href="{{ url()->previous() }}">
                        <button type="button" class="btn btn-primary"> @lang('words.back') </button>
                    </a>
            </div>
        </div>
    </div>



</x-layout.app>