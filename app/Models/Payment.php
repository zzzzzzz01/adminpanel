<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['name_uz', 'name_ru', 'name_en'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
