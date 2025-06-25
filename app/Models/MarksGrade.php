<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarksGrade extends Model
{
    protected $table = 'marks_grade';

    protected $fillable = [
        'name',
        'percent_from',
        'percent_to',
        'created_by',
    ];
}
