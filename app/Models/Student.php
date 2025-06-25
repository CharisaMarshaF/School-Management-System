<?php

namespace App\Models;

use App\Models\StudentAddFees;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name', 'last_name', 'email', 'password', 'user_type', 'is_delete',
        'admission_number', 'role_number', 'class_id', 'address','gender', 'date_of_birth',
         'religion', 'mobile_number', 'admission_date', 'profile_pic',
        'blood_group', 'height', 'weight', 'status'
    ];

    protected $hidden = ['password'];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id'); // asumsikan model SchoolClass sudah ada
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    // app/Models/Student.php

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
    public function scopeStudent($query)
    {
        return $query->where('user_type', 3);
    }

    public function fees()
    {
        return $this->hasOne(StudentAddFees::class, 'student_id');
    }

}
