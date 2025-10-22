<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = Program::all();
        return view('programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $facultys = Faculty::all();

        return view('programs.create', compact('facultys'));
    }

    public function programCreate()
    {
        $facultys = Faculty::all();

        return view('programs.create', compact('facultys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required',
            'faculty_id' => 'required',
            'code' => 'required|unique:programs,code',
            'description' => 'required',
        ]);
        

        // dd($request);

        Program::create($validation);

        return redirect()->route('programs.index')->with('success', 'Yo\'nalish muvaffaqiyatli yaratildi');

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
    public function edit(Program $program)
    {
        $facultys = Faculty::all();

        return view('programs.edit', compact('program', 'facultys'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255',
            'faculty_id' => 'nullable|exists:faculties,id',
            'description' => 'nullable|string',
        ]);

        $program->update($validated);

        return redirect()
            ->route('programs.index')
            ->with('success', 'Yo‘nalish ma’lumotlari muvaffaqiyatli yangilandi!');
    }

    public function programsSearch(Request $request)
    {
        $search = $request->input('search');

        if (empty($search)) {
            return redirect()->route('programs.index');
        }

        $programs = Program::when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
            ->orWhere('code', 'like', "%{$search}%");
        })->get();

        return view('programs.index', compact('programs', 'search'));
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('programs.index')->with('success', 'Yo\'nalish muvaffaqiyatli o‘chirildi.');
    }
}
