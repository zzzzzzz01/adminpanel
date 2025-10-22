<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MidtermManualGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'midterm_interval_id',
        'group_subject_id',
        'student_id',
        'grade',
    ];

    // 🟢 Bog‘lanishlar
    public function midtermInterval()
    {
        return $this->belongsTo(MidtermInterval::class,);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
