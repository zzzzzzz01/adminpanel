<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MidtermInterval extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_subject_id', 'type', 'status'];

    // Bog‘lanish: MidtermInterval → GroupSubject
    public function groupSubject()
    {
        return $this->belongsTo(GroupSubject::class,);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function midtermManualGrades()
    {
        return $this->hasMany(MidtermManualGrade::class);
    }
}
