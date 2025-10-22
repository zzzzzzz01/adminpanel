<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'faculty_id', 'description'];


    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
