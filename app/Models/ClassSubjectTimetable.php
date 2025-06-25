<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSubjectTimetable extends Model
{
    protected $table = 'class_subject_timetable';
    public $timestamps = false;

    protected $fillable = [
        'class_id',
        'subject_id',
        'week_id',
        'start_time',
        'end_time',
        'room_number',
        'created_at',
        'updated_at',
    ];

    public function week()
    {
        return $this->belongsTo(Week::class, 'week_id');
    }

    public function subject()
    {
        return $this->belongsTo(SubjectModel::class, 'subject_id');
    }
}
