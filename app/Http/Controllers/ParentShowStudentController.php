<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class ParentShowStudentController extends Controller
{
    public function myStudents()
    {
        $parent = Auth::user();

        // Ambil semua siswa yang parent_id-nya sesuai user login
        $students = Student::with('class')
            ->where('parent_id', $parent->id)
            ->get();

        return view('parent.student.my_student', [
            'header_title' => 'My Students',
            'students' => $students,
        ]);
    }

    public function showStudentSubjects($id)
    {
        $student = \App\Models\Student::with('class')->findOrFail($id);

        $class_id = $student->class_id;

        $subjects = \App\Models\ClassSubjectModel::with('subject')
            ->where('class_id', $class_id)
            ->where('is_delete', 0)
            ->get();

        return view('parent.student.subjects', [
            'header_title' => 'Subjects for ' . $student->name,
            'student' => $student,
            'subjects' => $subjects,
        ]);
    }

}
