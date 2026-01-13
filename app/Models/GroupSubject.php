<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\User;
use App\Models\Subject;
use App\Models\Group;
use App\Models\Semester;
use App\Models\Grade;

class GroupSubject extends Pivot
{
    protected $table = 'group_subjects';

    // Mass assignment uchun ruxsat beriladigan ustunlar
    protected $fillable = [
        'group_id',
        'subject_id',
        'teacher_id',
        'semester_id',
        'audit_hours', 'max_current_score',  'max_midterm_score', 'max_final_score', 'total_max'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function journal()
    {
        return $this->hasOne(Journal::class, 'group_subject_id');
    }

    public function grades()
    {
        return $this->hasManyThrough(
            Grade::class,
            Journal::class,
            'group_subject_id', // Journal jadvalida
            'journal_id',       // Grade jadvalida
            'id',               // GroupSubject jadvalida
            'id'                // Journal jadvalida
        );
    }

    public function midtermIntervals()
    {
        return $this->hasMany(MidtermInterval::class, 'group_subject_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'group_subject_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'group_subject_id', 'id');
    }

    public function topics()
    {
        return $this->hasMany(Topic::class,  'group_subject_id', 'id');
    }

    public function tests()
    {
        return $this->hasMany(Test::class, 'group_subject_id');
    }



    

}
