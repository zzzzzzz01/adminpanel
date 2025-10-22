<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeJournal extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'student_id',
        'date',       // sana qo‘shildi
        'grade',
    ];
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    
}
