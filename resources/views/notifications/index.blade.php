<x-layout.app>

<x-slot:title>
  Bildirishnomalar
</x-slot:title>

<div class="notification-wrapper">
    <div class="container-fluid">
        <!-- Title -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2> @lang('words.notification') </h2>
                        <div class="col-6">
                            <div class="title mt-30 mb-30">                       
                            <form action="{{ route('notifications.markAllAsRead') }}"  method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    @lang('words.read.all.notifications')  <i class="fa-solid fa-check-double ms-2"></i>
                                </button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Notifications -->
         @if($notifications->isEmpty())
            <div class="text-center py-3">
                <h5>Bu yerda bildirishnoma yo'q.</h5>
            </div>
        @else
            @foreach($notifications as $notification)
                <div class="card-style mb-2">
                    <div class="single-notification">
                        <div class="notification">
                            <div class="image ">
                            @foreach($posts as $post)
                                <img class="img-fluid " style="width: 50px; height: 50px;" src="{{ $notification->data['image_url'] }}"  alt="">
                            @endforeach
                            </div>
                            <a href="{{ route('notifications.read-and-redirect-to-post', ['notification' => $notification->id]) }}" class="content">
                                <h6>{{ $notification->data['title_' . app()->getLocale()] ?? 'Sarlavha' }}</h6>
                                <p class="text-sm text-gray">
                                    {{ $notification->data['content_' . app()->getLocale()] ?? 'Kontent' }}   
                                </p>
                                <span class="text-sm text-medium text-gray">
                                {{ str_replace(['аввал', 'сония', 'дақиқа', 'соат', 'кун',], ['avval', 'soniya', 'daqiqa', 'soat', 'kun'], \Carbon\Carbon::parse($notification->data['created_at'])->diffForHumans()) }}
                                </span>
                            </a>
                        </div>
                        <div class="action">

                        @if ($notification->read_at == null)
                            <!-- Hali o‘qilmagan -->
                            <button>
                                <a href="{{ route('notification.read', ['notification' => $notification->id]) }}"><i class="fa-solid fa-check"></i></a>
                            </button>
                            @else
                            <!-- O‘qilgan -->
                            <button>
                                <a href=""><i class="fa-solid fa-check-double text-success"></i></a>
                            </button>
                        @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>


@if(session('success'))
  <div class="alert alert-success position-fixed bottom-0 end-0 p-3" style="background-color: #5cb85c; color: white;">
    {{ session('success') }}
  </div>
  @endif

  @if(session('read'))
  <div class="alert alert-success position-fixed bottom-0 end-0 p-3" style="background-color: #5cb85c; color: white;">
    {{ session('read') }}
  </div>
  @endif

  @if(session('info'))
  <div class="alert alert-warning position-fixed bottom-0 end-0 p-3" style="background-color: #FFA500; color: black;">
    {{ session('info') }}
  </div>
  @endif

  <script>
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.remove();
            });
        }, 5000); // 5 sekunddan keyin barcha alertlar yo'qoladi
    </script>    

</x-layout.app>
