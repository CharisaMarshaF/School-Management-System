<?php

namespace App\Models;

use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    protected $table = 'student_attendance';

    protected $fillable = [
        'class_id',
        'attendance_date',
        'student_id',
        'attendance_type',
        'created_by'
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

