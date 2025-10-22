<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'start_time',
        'end_time',
        'room',
    ];

    // Aloqalar
    public function tests()
    {
        return $this->belongsToMany(Test::class, 'exam_session_test', 'exam_session_id', 'test_id');
    }
    
}
