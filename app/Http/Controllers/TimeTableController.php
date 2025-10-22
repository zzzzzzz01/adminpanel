<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Schedule;
use App\Models\Weekday;

class TimeTableController extends Controller
{
    public function groupSchedule($groupId)
    {
        $user = auth()->user();
        
        // Agar foydalanuvchi admin bo'lmasa va group_id null bo'lsa
        $isAdmin = $user->roles->contains('id', 1);
        if (!$isAdmin && !$user->group_id) {
            abort(404, 'Group not found for this user');
        }
    
        // Admin bo'lsa berilgan groupId, oddiy foydalanuvchi bo'lsa o'zining group_id sini ishlatamiz
        $effectiveGroupId = $isAdmin ? $groupId : $user->group_id;
        
        $group = Group::findOrFail($effectiveGroupId);
        $groups = Group::all();
        $weekdays = Weekday::all();
        
        $schedules = [];
        for ($i = 1; $i <= 6; $i++) {
            $schedules[$i] = Schedule::where('weekday_id', $i)
                ->where('group_id', $effectiveGroupId)
                ->with(['subject', 'teacher', 'group'])
                ->orderBy('start_time')
                ->get();
        }
    
        return view('time-table.index', compact('weekdays', 'schedules', 'groups', 'group', 'user'));
    }
}