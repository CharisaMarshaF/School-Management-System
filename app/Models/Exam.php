<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exam';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'note',
        'created_by',
        'created_at',
        'updated_at',
    ];
}
