<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\AssignSubjectTeacher;
use App\Models\Student;

class TeacherStudentController extends Controller
{
    public function myStudentList()
{
    $teacherId = Auth::id();

    // Ambil semua class_id yang diajar oleh teacher ini
    $classIds = AssignSubjectTeacher::where('teacher_id', $teacherId)
                    ->pluck('class_id');

    // Ambil siswa yang class_id-nya termasuk dalam class tersebut dan user_type = 3 dan is_delete = 0
    $students = Student::student()
                ->with('class')
                ->whereIn('class_id', $classIds)
                ->where('is_delete', 0)
                ->get();

    return view('teacher.student.list', [
        'header_title' => 'My Student List',

        'students' => $students
    ]);
}

}
