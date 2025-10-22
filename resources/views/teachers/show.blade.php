<x-layout.app>

<x-slot:title>
  O'qituvchilar
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
                <img src="{{ asset('storage/'.$user->photo) }}" class="border border-primary-subtle rounded" alt="O'qituvchi Rasm">
                <h2>O'qituvchi: {{ $user->name }}. {{ $user->last_name }}. {{ $user->middle_name }}</h2>
                <p><strong class="pe-2">Mutaxassislik:</strong>{{ $user->specialization ?? '--' }}</p>
                <p><strong class="pe-2">Ta'lim Darajasi:</strong>{{ $user->degree ?? '--'  }} </p>
                <p><strong class="pe-2">Ish Tajribasi:</strong>{{ $user->experience ?? '--' }} yil</p>
                <div class="contact-info">
                    <p><strong class="pe-2">Email:</strong> <a href="">{{ $user->email }}</a></p>
                    <p><strong class="pe-2">Telefon:</strong>{{ $user->phone ?? '--' }}</p>
                </div>
                    <p><strong class="pe-2">O'zim haqimda:</strong>{{ $user->description  ?? '--' }}</p>
                    <p><strong class="pe-2">Sertifikatlar:</strong>{{ $user->certificate }}</p>
                    <p><strong class="pe-2">Shaxsiy Sayti:</strong> <a href="{{ $user->social_links}}">{{ $user->social_links ?? '--' }}</a></p>
                    
                    <a href="{{ route('teachers.index') }}">
                        <button type="button" class="btn btn-primary">Orqaga</button>
                    </a>
            </div>
        </div>
    </div>



</x-layout.app>