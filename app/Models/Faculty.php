<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'faculty_type'];

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
