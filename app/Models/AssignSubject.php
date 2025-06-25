<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignSubject extends Model
{
    protected $table = 'assign_class_teacher'; // Sesuaikan jika berbeda

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(SubjectModel::class, 'subject_id');
    }
}
