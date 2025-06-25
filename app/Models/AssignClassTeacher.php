<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignClassTeacher extends Model
{
    protected $table = 'assign_class_teacher';

    protected $fillable = [
        'class_id', 'teacher_id', 'status', 'created_by'
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}

