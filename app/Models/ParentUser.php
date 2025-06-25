<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentUser extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name', 'last_name', 'email', 'password', 'user_type', 'is_delete',
        'mobile_number', 'occupation', 'address', 'gender', 'profile_pic', 'status'
    ];

    protected $hidden = ['password'];

    // Kamu bisa tambahkan relasi jika perlu, misal ke children
    // public function children()
    // {
    //     return $this->hasMany(Student::class, 'parent_id');
    // }
}
