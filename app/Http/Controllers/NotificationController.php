<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification as Notification;  
class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Notification::all();

        return view('notifications.index')->with([
            'notifications' => auth()->user()->notifications()->paginate(50),
        ]);
    }

    public function read(Notification $notification)
    {
        $notification->markAsRead();

        return redirect()->route('notifications.index')->with('read', __('words.read'));
    }

    public function readAndRedirectToPost(Notification $notification)
    {
        // 1. Foydalanuvchi tekshiruvi
        if ($notification->notifiable_id !== auth()->id()) {
            abort(403, 'Ushbu xabarnoma sizga tegishli emas');
        }
    
        // 2. Notificationni o'qilgan deb belgilash
        $notification->markAsRead();

        // dd($notification->data);
    
        // 3. Post ID ni olish
        $postId = $notification->data['id'] ?? null;

        // dd($postId);
    
        // 4. Agar post_id topilmasa
        if (!$postId) {
            return redirect()->route('notifications.index')
                   ->with('error', 'Post topilmadi');
        }
    
        // 5. Post sahifasiga yo'naltirish
        return redirect()->route('posts.show', $postId);
    }

    public function markAllAsRead()
    {
        $user = auth()->user();
    
        // O'qilmagan xabarlar sonini tekshiramiz
        if ($user->unreadNotifications->isEmpty()) {
            return redirect()->route('notifications.index')
                             ->with('info', __('words.no.unread.messages'));
        }
    
        // Agar kamida bitta bo‘lsa, o'qilgan deb belgilaymiz
        $user->unreadNotifications->markAsRead();
    
        return redirect()->route('notifications.index')
                         ->with('success', __('words.all.as.read'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
