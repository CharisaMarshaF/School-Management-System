<?php

namespace App\Models;

use App\Models\User;
use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Database\Eloquent\Model;

class StudentAddFees extends Model
{
    protected $table = 'student_add_fees';

    protected $fillable = [
        'student_id', 'class_id', 'total_amount', 'paid_amount', 'remaning_amount',
        'payment_type', 'remark', 'created_by'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
    public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}

}
