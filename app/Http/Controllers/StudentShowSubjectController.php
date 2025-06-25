<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassSubjectModel;

class StudentShowSubjectController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        // Pastikan hanya untuk student
        if ($student->user_type != 3) {
            abort(403, 'Unauthorized');
        }

        // Ambil class_id siswa
        $classId = $student->class_id;

        // Ambil subject berdasarkan class_id
        $subjects = ClassSubjectModel::with('subject')
            ->where('class_id', $classId)
            ->where('is_delete', 0)
            ->get();

        return view('student.assignsubject.mysubject', [
            'subjects' => $subjects,
            'header_title' => 'My Subjects',
        ]);
    }
}

