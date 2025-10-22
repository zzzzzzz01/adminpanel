<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['group_name','full_group_name', 'education_type', 'academic_year_id', 'start_year', 'end_year', 'study_duration', 
    'total_semesters', 'current_semester', 'is_graduated', 'program_id'];

    public function students(){
        return $this->hasMany(User::class);
    }

    public function exams(){
        return $this->belongToMany(Exam::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Group.php
    // public function getAcademicYearAttribute()
    // {
    //     if (!$this->start_year || !$this->end_year) return null;

    //     $yearOffset = floor(($this->current_semester - 1) / 2);
    //     $academicStart = $this->start_year + $yearOffset;
    //     $academicEnd = $academicStart + 1;

    //     return $academicStart . '-' . $academicEnd;
    // }

    public function getComputedAcademicYearAttribute()
    {
        if (!$this->start_year || !$this->end_year) return null;

        $yearOffset = floor(($this->current_semester - 1) / 2);
        $academicStart = $this->start_year + $yearOffset;
        $academicEnd = $academicStart + 1;

        return $academicStart . '-' . $academicEnd;
    }

    public function weeks()
    {
        return $this->hasMany(Week::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'group_subjects')
                    ->using(\App\Models\GroupSubject::class)
                    ->withPivot('id', 'semester_id', 'teacher_id', 'audit_hours',)
                
                
                    ->withTimestamps();
    }

    public function groupSubjects()
    {
        return $this->hasMany(GroupSubject::class);
    }

    public function midtermIntervals()
    {
        return $this->hasMany(MidtermInterval::class,);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
}
