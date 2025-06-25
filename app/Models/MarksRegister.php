<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarksRegister extends Model
{
    protected $table = 'marks_register';
    protected $fillable = [
        'student_id', 'exam_id', 'class_id', 'subject_id',
        'class_work', 'home_work', 'test_work', 'exam',
        'created_by', 'created_at', 'updated_at', 'full_marks', 'passing_marks'
    ];

    public function subject()
{
    return $this->belongsTo(SubjectModel::class, 'subject_id');
}
}

