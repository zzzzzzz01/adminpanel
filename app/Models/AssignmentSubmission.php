<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = ['assignment_id', 'student_id', 'file_path', 'comment'];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function midtermGrade()
    {
        return $this->hasOne(MidtermGrade::class, 'assignment_submission_id'); 
        // foreign key submission_id, default emas
    }

    public function grades()
    {
        return $this->hasMany(\App\Models\MidtermGrade::class, 'assignment_submission_id');
    }
}
