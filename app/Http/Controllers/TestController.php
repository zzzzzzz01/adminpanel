<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
public function testCreate()
{
    $teacherId = auth()->id();

    $groupSubjects = GroupSubject::with(['group', 'subject'])
        ->where('teacher_id', $teacherId)
        ->whereDoesntHave('tests') 
        ->get();

    return view('test.create', compact('groupSubjects'));
}

}
