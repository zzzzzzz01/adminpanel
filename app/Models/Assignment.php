<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['midterm_interval_id',  'name', 'title', 'description','max_score', 'attempts', 'due_date', 'due_time', 'file', 'status'];

    public function midtermInterval()
    {
        return $this->belongsTo(MidtermInterval::class,);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'assignment_student', 'assignment_id', 'student_id');
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class,);
    }

    public function groupSubject()
    {
        return $this->hasOneThrough(
            GroupSubject::class,
            MidtermInterval::class,
            'id',                // foreign key in MidtermInterval
            'id',                // foreign key in GroupSubject
            'midterm_interval_id', // local key in Assignment
            'group_subject_id'     // local key in MidtermInterval
        );
    }

    public function grades()
    {
        return $this->hasMany(\App\Models\MidtermGrade::class, 'assignment_submission_id');
    }
}
