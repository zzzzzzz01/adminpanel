<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $student = auth()->user();

        $results = Result::with('test')
            ->where('student_id', $student->id)
            ->get();

        return view('results.index', compact('results'));
    }

        // Test tugagandan keyin natijani saqlash
        public function store(Request $request)
        {
            $student = auth()->user();
    
            $result = Result::create([
                'test_id'    => $request->test_id,
                'student_id' => $student->id,
                'score'      => $request->score,
                'time_spent' => $request->time_spent,
            ]);
    
            return redirect()->route('results.index')
                ->with('success', 'Natija saqlandi');
        }

        public function show($result)
        {
            $result = Result::with('test')->findOrFail($result);

            return view('results.show', compact('result'));
        }
}
