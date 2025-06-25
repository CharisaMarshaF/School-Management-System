<?php

namespace App\Models;
use App\Models\ClassModel;
use App\Models\SubjectModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Homework extends Model
{
    use HasFactory;
        protected $table = 'homework';


    protected $fillable = [
        'class_id','subject_id','homework_date','submission_date','document_file','description','created_by'
    ];



    public function classroom()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
    public function subject()
    {
        return $this->belongsTo(SubjectModel::class);
    }
}

