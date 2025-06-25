<?php

namespace App\Models;

use App\Models\ClassModel;
use App\Models\SubjectModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassSubjectModel extends Model
{
    use HasFactory;

    protected $table = 'class_subject';

    protected $fillable = ['created_by', 'status', 'is_delete','class_id', 'subject_id'];

    // Relasi dengan ClassModel
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // ClassSubjectModel.php
    public function subject()
    {
        return $this->belongsTo(SubjectModel::class, 'subject_id');
    }


}
