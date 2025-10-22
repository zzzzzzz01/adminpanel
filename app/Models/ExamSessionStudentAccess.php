<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSessionStudentAccess extends Model
{
    use HasFactory;

    protected $table = 'exam_session_student_access';

    protected $fillable = [
        'exam_session_id',
        'test_id',
        'student_id',
        'is_allowed',
    ];

    public function examSession()
    {
        return $this->belongsTo(ExamSession::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
