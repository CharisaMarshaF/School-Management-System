<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AssignSubject;

class AssignSubjectController extends Controller
{
    public function mySubjects()
    {
        $teacher = Auth::user();

        // Ambil semua subject yang diassign ke teacher
        $assignedSubjects = AssignSubject::with(['class', 'subject'])
            ->where('teacher_id', $teacher->id)
            ->get();

        return view('teacher.assignsubject.my_subjects', [
            'header_title' => 'My Class & Subjects',
            'subjects' => $assignedSubjects,
        ]);
    }
}
