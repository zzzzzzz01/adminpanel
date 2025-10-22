<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonPair extends Model
{
    use HasFactory;

    protected $fillable = ['pair_number', 'start_time', 'end_time'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
