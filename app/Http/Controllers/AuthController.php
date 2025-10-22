<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{

    public function login(){
        return view('auth.login');
    }

    public function authanticate(Request $request){
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/')->with('success', 'Siz tizimga muvaffaqiyatli kirdingiz');
        }
 
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Parol yoki email noto\'g\'ri!',
            ])->onlyInput('email');
        }
    }

    public function registerStudent(Group $group){
        
        $groups = Group::all();
        $payments = Payment::all();
        
        return view('auth.register-student', compact('groups', 'payments', 'group'));           
    }

    public function registerStudent_store(Request $request){
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'birth_date' => 'required',
            'email' => ['required', 'email', 'unique:users', function ($attribute, $value, $fail) {
                if (!str_ends_with($value, '@gmail.com')) {
                    $fail('Email @gmail.com bilan tugashi kerak');
                }
            }],
            'payment_id' => 'required',
            'phone' => ['required', 'regex:/^\+[1-9]\d{1,14}$/'], // E.164 format
            'address' => 'required',
            'photo' => 'nullable',
            'password' => 'required|min:8|confirmed',
            'group_id' => 'required|exists:groups,id',
        ]);

        // dd($request);

        if($request->hasFile('photo')){
            $name = $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->storeAs('imageStudents', $name,'public'); 
        }

        $user = User::create([
            'name'=>$request->name,
            'last_name'=>$request->last_name,
            'middle_name'=>$request->middle_name,
            'birth_date'=>$request->birth_date,
            'email' => $request->email,
            'payment_id'=>$request->payment_id,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'group_id'=>$request->group_id,
            'photo'=>$path ?? null,
            'password' => Hash::make($request->password),
        ]);


        $user->roles()->attach([2]);

        return redirect()->route('groups.show',['group' => $request->group_id])->with('studentCreate', __('words.student.create.success'));
    }

    public function studentUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date', // 'date' qo'shildi
            'payment_id' => 'nullable|string|max:255|exists:payment,id',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable',
            'group_id' => 'nullable|string|max:255|exists:groups,id',
        ]);

        // Faqat o'zgartirilgan maydonlarni ajratib olish
        $updateData = [];
        foreach ($validated as $key => $value) {
            if ($value !== null && $value !== $user->$key) {
                $updateData[$key] = $value;
            }
        }
    
        // Rasmni alohida ishlov berish
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete($user->photo);
            }
            $path = $request->file('photo')->store('teachers', 'public');
            $updateData['photo'] = $path;
        }
    
        // Faqat o'zgartirilgan maydonlarni yangilash
        if (!empty($updateData)) {
            $user->update($updateData);
        }

        return redirect()->route('groups.show', ['group' => $user->group_id])->with('success', __('words.student.update.success'));



    }

    public function studentDestroy(User $user)
    {
        $user->roles()->detach();
    
        Storage::delete($user->photo);
    
        $user->delete();

        $group = $user->group;
    
        return redirect()->route('groups.show', ['group' => $group->id])->with('trash', __('words.student.delete.success'));
    }


    



    public function registerTeacher(){
        return view('auth.register-teacher');
    }

    public function registerTeacher_store(Request $request){
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'photo' => 'nullable',
            'birth_date' => 'required',
            'phone' => ['required', 'regex:/^\+[1-9]\d{1,14}$/'], // E.164 format
            'specialization' => 'required',
            'degree' => 'required',
            'experience' => 'required',
            'certificate' => 'required',
            'social_links' => 'required',
            'description' => 'required',
            
            'email' => ['required', 'email', 'unique:users', function ($attribute, $value, $fail) {
                if (!str_ends_with($value, '@gmail.com')) {
                    $fail('Email @gmail.com bilan tugashi kerak');
                }
            }],
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);

        // dd($request);

        if($request->hasFile('photo')){
            $name = $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->storeAs('imageTeachers', $name,'public'); 
        }

        $user = User::create([
            'name'=>$request->name,
            'last_name'=>$request->last_name,
            'middle_name'=>$request->middle_name,
            'birth_date'=>$request->birth_date,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'specialization'=>$request->specialization,
            'degree'=>$request->degree,
            'experience'=>$request->experience,
            'certificate'=>$request->certificate,
            'social_links'=>$request->social_links,
            'description'=>$request->description,
            'photo'=>$path ?? null,

            'email'=>$request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach([3]);

        return redirect()->route('teachers.index')->with('createSuccess', __('words.teacher.create.success'));
    }

    public function teacherEdit(User $user)
    {
        return view('teachers.edit')->with(['user' => $user]);
    }
    

    public function teacherUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'birth_date' => 'nullable|date',
            'phone' => ['required', 'regex:/^\+[1-9]\d{1,14}$/'], // E.164 format
            'specialization' => 'nullable|string|max:255',
            'degree' => 'nullable|string|max:255',
            'experience' => 'nullable|integer',
            'certificate' => 'nullable|string',
            'social_links' => 'nullable',
            'description' => 'nullable|string',
            
        ]);

        // dd($validated);
    
        // Faqat o'zgartirilgan maydonlarni ajratib olish
        $updateData = [];
        foreach ($validated as $key => $value) {
            if ($value !== null && $value !== $user->$key) {
                $updateData[$key] = $value;
            }
        }
    
        // Rasmni alohida ishlov berish
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete($user->photo);
            }
            $path = $request->file('photo')->store('teachers', 'public');
            $updateData['photo'] = $path;
        }
    
        // Faqat o'zgartirilgan maydonlarni yangilash
        if (!empty($updateData)) {
            $user->update($updateData);
        }
    
        return redirect()->route('teachers.index')->with('success', __('words.teacher.update.success'));
    }

    public function teacherDestroy(User $user)
    {
        $user->roles()->detach();
    
        Storage::delete($user->photo);
    
        $user->delete();
    
        return redirect()->route('teachers.index')->with('trash', "O'qituvchi muvaffaqiyatli o'chirildi.");
    }





    public function registerAdmin()
    {
        // $users = User::role('admin')->get();

        $users = User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->get();

        return view('auth.register-admin', compact('users'));
    }

    public function registerAdmin_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'email' => ['required', 'email', 'unique:users', 
            function ($attribute, $value, $fail) {
                if (!str_ends_with($value, '@gmail.com')) {
                    $fail('Email @gmail.com bilan tugashi kerak');
                }
            }],
            'phone' => ['required', 'regex:/^\+[1-9]\d{1,14}$/'], // E.164 format
            'photo' => 'nullable|image|max:2048', // optional validation
            'password' => 'required|min:8|confirmed',
        ]);

        // Faylni yuklash
        $path = null;
        if ($request->hasFile('photo')) {
            $name = $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->storeAs('imageAdmins', $name, 'public');
        }

        // Foydalanuvchini yaratish
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'photo' => $path,
            'password' => Hash::make($request->password),
        ]);

        // Admin rolini biriktirish (1-id)
        $user->roles()->attach([1]);

        return redirect()->route('all.admins')->with('addAdmin', __('words.admin.create.success'));
    }
    

    public function adminDestroy(User $user)
    {
        $user->roles()->detach();
    
        Storage::disk('public')->delete($user->photo ?? '');
    
        $user->delete();
    
        return redirect()->route('all.admins')->with('adminDelete', __('words.admin.delete.success'));
    }


    public function adminUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => ['required', 'regex:/^\+[1-9]\d{1,14}$/'], // E.164 format
        ]);
        
    
        // Faqat o'zgartirilgan maydonlarni ajratib olish
        $updateData = [];
        foreach ($validated as $key => $value) {
            if ($value !== null && $value !== $user->$key) {
                $updateData[$key] = $value;
            }
        }
    
        // Rasmni alohida ishlov berish
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete($user->photo);
            }
            $path = $request->file('photo')->store('teachers', 'public');
            $updateData['photo'] = $path;
        }
    
        // Faqat o'zgartirilgan maydonlarni yangilash
        if (!empty($updateData)) {
            $user->update($updateData);
        }
    
        return redirect()->route('all.admins')->with('success', __('words.admin.update.success'));

        
    }
         




    public function logout(Request $request){

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
