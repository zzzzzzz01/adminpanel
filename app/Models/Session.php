<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = ['name_uz', 'name_ru', 'name_en'];

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }
}
