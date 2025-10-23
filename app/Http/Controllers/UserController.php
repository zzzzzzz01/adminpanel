<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;

class UserController extends Controller
{
    

    public function index(){

        $users = User::all();

        return view('teachers.index', compact('users'));
    }


    public function show($id)
    {
        $group = Group::findOrFail($id);

        $users = User::where('group_id', $id)->get();

        return view('groups.show', compact('users', 'group'));
    }

    public function groupStudents($groupId)
    {
    
        $group = Group::find($groupId);
        if (!$group) {
            abort(404, 'Group not found');
        }
    
        $users = User::where('group_id', $groupId)->get();
    
        return view('students.index', compact('users', 'group'));
    }

    public function teacherSearch(Request $request)
    {
        $data = $request->q;

        if (empty($data)) {
            return redirect()->route('teachers.index');
        }
    

        $users = User::whereHas('roles', function ($query) {
            $query->where('roles.id', 3); 
        })
        ->where(function ($query) use ($data) {
            $query->where('name', 'like', '%' . $data . '%')
                ->orWhere('last_name', 'like', '%' . $data . '%')
                ->orWhere('middle_name', 'like', '%' . $data . '%');
        })
        ->get();

        // dd($teachers);

        if ($users->isEmpty()) {
            $message = "Sizning so'rovingiz natijasida o'qituvchi topilmadi.";
        } else {
            $message = "Sizning so'rovingiz natijasida " . $users->count() . " ta o'qituvchi topildi.";
        }

        return view('teachers.index', compact('users', 'message'));
    }
    
}
