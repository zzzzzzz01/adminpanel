<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_id', 'student_id', 'status'];

    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function schedule() {
        return $this->belongsTo(Schedule::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
