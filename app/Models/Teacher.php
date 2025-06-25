<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
        use HasFactory;

    protected $table = 'users'; // tetap pakai tabel users

    protected $fillable = [
        'name',
        'last_name',
        'gender',
        'date_of_birth',
        'mobile_number',
        'date_of_joining',
        'profile_pic',
        'marital_status',
        'address',
        'permanent_address',
        'qualification',
        'work_experience',
        'note',
        'status',
        'email',
        'password',
        'user_type',
                'is_delete',

    ];

    protected $hidden = [
        'password',
    ];

    // Scope untuk hanya ambil teacher (user_type = 2)
    public function scopeTeacher($query)
    {
        return $query->where('user_type', 2);
    }

    public function assignedClasses()
    {
        return $this->hasMany(AssignClassTeacher::class, 'teacher_id');
    }

}
