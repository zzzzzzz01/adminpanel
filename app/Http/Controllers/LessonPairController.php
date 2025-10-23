<?php

namespace App\Http\Controllers;

use App\Models\LessonPair;
use Illuminate\Http\Request;

class LessonPairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessonPairs = LessonPair::orderBy('pair_number')->get();
        return view('lessonPairs.index', compact('lessonPairs'));
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
        // dd($request);

        $request->validate([
            'pair_number' => 'required|integer|min:1',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
        ]);

        // dd($request);

        LessonPair::create($request->all());

        return back()->with('success', 'Juftlik yaratildi!');
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
    public function edit(LessonPair $lessonPair)
    {
        // dd($lessonPair);

        $lessonPairs = LessonPair::all();

        return view('lessonPairs.index', compact('lessonPair', 'lessonPairs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LessonPair $lessonPair)
    {
        // Validatsiya
        $request->validate([
            'pair_number' => 'nullable',
            'start_time'  => 'nullable',
            'end_time'    => 'nullable',
        ]);

        // dd($request);
    
        // O'zgartirilgan maydonlarni yangilash
        if ($request->has('pair_number')) {
            $lessonPair->pair_number = $request->pair_number;
        }
        if ($request->has('start_time')) {
            $lessonPair->start_time = $request->start_time;
        }
        if ($request->has('end_time')) {
            $lessonPair->end_time = $request->end_time;
        }
    
        
        $lessonPair->save();
    
        return redirect()->route('lessonPairs.index')
                         ->with('success', 'Juftlik yangilandi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LessonPair $lessonPair)
    {
        $lessonPair->delete();
        return redirect()->route('lessonPairs.index')->with('success', 'Juftlik o‘chirildi!');
    }
}
