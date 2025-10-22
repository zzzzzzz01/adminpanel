<?php

namespace App\Http\Controllers;

use App\Models\Auditorium;
use Illuminate\Http\Request;

class AuditoriumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auditoriums = Auditorium::orderBy('created_at')->get();
        return view('auditoriums.index', compact('auditoriums'));
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
        $request->validate([
            'name'     => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'building' => 'nullable|string|max:255',
        ]);

        Auditorium::create($request->all());

        return back()->with('success', 'Auditoriya yaratildi!');
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
    public function edit(Auditorium $auditorium)
    {
        $auditoriums = Auditorium::all(); // Jadval uchun hamma auditoriyalarni olish

        return view('auditoriums.index', compact('auditoriums', 'auditorium'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Auditorium $auditorium)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'building' => 'nullable|string|max:255',
        ]);

        $auditorium->update($request->all());

        return redirect()->route('auditoriums.index')
                        ->with('success', 'Auditoriya yangilandi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auditorium $auditorium)
    {
        $auditorium->delete();
        return redirect()->route('auditoriums.index')->with('success', 'Auditoriya o‘chirildi!');
    }
}
