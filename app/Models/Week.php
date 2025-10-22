<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    use HasFactory;

    protected $fillable = ['start_date', 'end_date', 'group_id', 'semester_id', 'academic_year', 'week_number', 'week_type', 'is_active' ];

    public function getFormattedRangeAttribute()
    {
        return Carbon::parse($this->start_date)->translatedFormat('d M') . ' / ' .
               Carbon::parse($this->end_date)->translatedFormat('d M');
    }

    public static function getCurrentWeekId()
    {
        $today = now()->format('Y-m-d');
        $week = self::where('start_date', '<=', $today)
                    ->where('end_date', '>=', $today)
                    ->first();

        return $week ? $week->id : null;
    }

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
