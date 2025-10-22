<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function store(Request $request, Schedule $schedule)
    {
        foreach ($request->grades as $studentId => $gradeData) {
            foreach ($gradeData as $type => $value) {
                Grade::updateOrCreate(
                    [
                        'schedule_id' => $schedule->id,
                        'student_id' => $studentId,
                        'grade_type' => $type,
                    ],
                    ['grade' => $value]
                );
            }
        }

        return back()->with('success', 'Baholar saqlandi!');
    }
}
