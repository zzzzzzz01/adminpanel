<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function index()
    {
        $academicYears = AcademicYear::all();

        return view('academicYears.index', compact('academicYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required',
        ]);

        // dd($request);

        AcademicYear::create($request->all());

        return redirect()->route('academicYear.index')->with('success', 'O\'quv yili muvaffaqiyatli yaratildi');
    }

    public function edit(AcademicYear $academicYear)
    {
        $academicYears = AcademicYear::all();

        return view('academicYears.index', compact('academicYears', 'academicYear'));
    }

    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();

        return redirect()->route('academicYear.index')
                        ->with('success', "O‘quv yili muvaffaqiyatli o‘chirildi!");
    }
}
