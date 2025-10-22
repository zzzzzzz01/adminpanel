<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_subject_id',
        'title',
        'file_path',
        'user_id',
    ];

    public function groupSubject()
    {
        return $this->belongsTo(GroupSubject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
