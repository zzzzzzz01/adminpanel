<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'group_id', 'semester_number', 'start_date', 'end_date', 'academic_year'];

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function weeks()
    {
        return $this->hasMany(Week::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
