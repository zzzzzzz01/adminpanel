<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('profil.index', compact('user'));
    }

    public function changePasswordForm(){

        return view('profil.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Joriy parolni tekshirish
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Joriy parol noto\'g\'ri!']);
        }

        // Yangi parolni saqlash
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profil.index')->with('success', 'Parol muvaffaqiyatli yangilandi.');
    }
}
