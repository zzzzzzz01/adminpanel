<?php

namespace App\Http\Controllers;

use App\Models\Week;
use App\Models\Group;
use Illuminate\Http\Request;

class WeekController extends Controller
{
    public function index(Group $group)
    {
        $weeks = $group->weeks()->orderBy('start_date')->get();
        $weekTypes = ['Nazariy ta\'lim', 'Tatil'];

        return view('groups.weeks.index', compact('group', 'weeks', 'weekTypes'));
    }

    public function edit(Group $group, Week $week)
    {
        $weeks = $group->weeks()->orderBy('start_date')->get();
        $weekTypes = ['Nazariy talim', 'Tatil'];

        return view('groups.weeks.index', compact('group', 'weeks', 'week', 'weekTypes'));
    }

    public function update(Request $request, Group $group, Week $week)
    {
        if ($week->group_id !== $group->id) {
            abort(404);
        }

        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'week_type'  => 'nullable|string',
        ]);

        // dd($validated);

        $week->update($validated);

        return redirect()->route('groups.weeks.index', $group)
                         ->with('success', 'Hafta yangilandi');
    }

    public function toggleActive($id)
    {
        $week = Week::findOrFail($id);
        $week->is_active = !$week->is_active; // true ↔ false
        $week->save();

        return back()->with('success', 'Hafta holati o‘zgartirildi.');
    }
}
