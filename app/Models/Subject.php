<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name_uz', 'name_ru', 'name_en'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'group_subject_id', 'id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_subjects')
                    ->withPivot(['semester_id', 'academic_year','audit_hours'])
                    ->withTimestamps();
    }

    public function groupSubjects()
    {
        return $this->hasMany(GroupSubject::class); // yoki hasOne, agar bitta bog'lanish bo'lsa
    }
}
