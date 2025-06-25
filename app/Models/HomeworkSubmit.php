<?php

// app/Models/HomeworkSubmit.php
namespace App\Models;

use App\Models\Student;
use App\Models\Homework;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeworkSubmit extends Model
{
    use HasFactory;

    protected $table = 'homework_submit';

    protected $fillable = [
        'homework_id',
        'student_id',
        'description',
        'document_file',
    ];

    public function homework()
    {
        return $this->belongsTo(Homework::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}

