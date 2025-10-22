<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class journal extends Model
{
    use HasFactory;

    protected $fillable = ['group_subject_id', 'semester_id', 'current_max', 'midterm_max', 'final_max'];

    public function groupSubject()
    {
        return $this->belongsTo(GroupSubject::class, 'group_subject_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
