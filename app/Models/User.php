<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'last_name', 'middle_name', 'birth_date', 'email', 'password', 'photo', 'phone', 'address', 'payment_id', 'group_id', 'specialization', 'degree', 'experience', 'certificate', 'social_links', 'description'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    
    public function roles()
    {
        return $this->belongsToMany(Role::class,);
    }

    
    public function hasRole($roleName){
        foreach($this->roles as $role){
            if($role->name == $roleName){
                return true;
            }
        }
        return false;
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class,  'student_id',);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
