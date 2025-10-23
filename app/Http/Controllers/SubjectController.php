<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();

        return view('subject.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subject.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_uz'=>'required',
            'name_ru'=>'required',
            'name_en'=>'required',
        ]);

        // dd($request);

        $subject = Subject::create([
            'name_uz'=>$request->name_uz,
            'name_ru'=>$request->name_ru,
            'name_en'=>$request->name_en,
        ]);

        return redirect()->route('subject.index')->with('success', __('words.create.subject.success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Subject $subject)
    {
        // dd($subject->id);

        $subjects = Subject::all();

        return view('subject.index', compact('subject', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name_uz' => 'nullable',
            'name_ru' => 'nullable',
            'name_en' => 'nullable',
        ]);

        $subject->update([
            'name_uz' => $request->name_uz,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
        ]);

        return redirect()->back()->with('success', __('words.update.subject.success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id); // Fan topiladi
        $subject->delete(); // Fan o'chiriladi

        return redirect()->route('subject.index')->with('subjectTrash', __('words.subject.trash'));
    }

    public function subjectSearch(Request $request)
    {
        $search = trim($request->input('search'));

        if (empty($search)) {
            return redirect()->route('subject.index');
        }

        $subjects = Subject::when($search, function($q) use ($search) {
            $q->where('name_uz', 'like', "%{$search}%")
            ->orWhere('name_ru', 'like', "%{$search}%")
            ->orWhere('name_en', 'like', "%{$search}%");
        })->get();

        return view('subject.index', compact('subjects', 'search'));
    }
}
