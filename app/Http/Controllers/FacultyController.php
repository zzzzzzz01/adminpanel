<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facultys = Faculty::all();

        return view('facultys.index',compact('facultys'));
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
        $validated =  $request->validate([
            'name'=>'required',
            'faculty_type'=>'required',
        ]);

        // dd($request);

        Faculty::create($validated);

        return back()->with('success', 'Facultet muvaffaqiyatli yaratildi');
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
    public function edit($id)
    {
        $faculty = Faculty::findOrFail($id);
        $facultys = Faculty::all();
        return view('facultys.index', compact('faculty', 'facultys'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'faculty_type' => 'required|in:Mahalliy,Boshqasi'
        ]);
    
        $faculty = Faculty::findOrFail($id);
        $faculty->update([
            'name' => $request->name,
            'faculty_type' => $request->faculty_type
        ]);
    
        return redirect()->route('facultys.index')
                       ->with('success', 'Fakultet muvaffaqiyatli yangilandi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faculty $faculty)
    {
        $faculty->delete();

        return redirect()->route('facultys.index')->with('success', 'Fakultet muvaffaqiyatli o‘chirildi.');
    }
}
