<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MidtermGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'assignment_submission_id',
        'group_subject_id',
        'grade',
    ];

    public function student()
    {
        return $this->belongsTo(User::class);
    }

    public function groupSubject()
    {
        return $this->belongsTo(GroupSubject::class);
    }

    public function assignments()
    {
        return $this->hasMany(\App\Models\Assignment::class, 'midterm_interval_id');
    }

    public function submission()
    {
        return $this->belongsTo(AssignmentSubmission::class, 'assignment_submission_id');
    }  
     
}
