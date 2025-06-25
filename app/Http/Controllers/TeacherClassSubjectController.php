<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AssignSubjectTeacher;

class TeacherClassSubjectController extends Controller
{
    public function myClassSubject()
    {
        $teacherId = Auth::id();

        $records = AssignSubjectTeacher::with(['class', 'classSubjects.subject'])
                    ->where('teacher_id', $teacherId)
                    ->get();

        return view('teacher.class_subject.index', [
            'header_title' => 'My Class & Subjects',
            'records' => $records,
        ]);
    }
}

