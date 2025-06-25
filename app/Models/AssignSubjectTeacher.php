<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignSubjectTeacher extends Model
{
    protected $table = 'assign_class_teacher';

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // relasi ke class_subject (banyak subject per class)
    public function classSubjects()
    {
        return $this->hasMany(ClassSubjectModel::class, 'class_id', 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }
}

