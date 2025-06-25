<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use Illuminate\Http\Request;
use App\Models\HomeworkSubmit;
use App\Models\ClassSubjectModel;
use Illuminate\Support\Facades\Auth;

class StudenHomeworkController extends Controller
{
    public function index(Request $request)
{
    $student = Auth::user();
    $classId = $student->class_id;
    $data['header_title'] = "My Homework";

    $subjectId = $request->subject_id;
    $homeworkDate = $request->homework_date;

    $submittedHomeworkIds = HomeworkSubmit::where('student_id', $student->id)
        ->pluck('homework_id')
        ->toArray();

    $homeworks = Homework::where('class_id', $classId)
        ->when($subjectId, fn($q) => $q->where('subject_id', $subjectId))
        ->when($homeworkDate, fn($q) => $q->whereDate('homework_date', $homeworkDate))
        ->whereNotIn('id', $submittedHomeworkIds)
        ->with(['subject'])
        ->latest()
        ->get();

    $subjects = ClassSubjectModel::where('class_id', $classId)
        ->with('subject')
        ->get()
        ->pluck('subject.name', 'subject.id');

    return view('student.homework.index', compact('homeworks', 'subjects', 'subjectId', 'homeworkDate'), $data);
}

public function submitted(Request $request)
{
    $student = Auth::user();
    $classId = $student->class_id;
    $data['header_title'] = "My Submitted Homework";

    $subjectId = $request->subject_id;
    $homeworkDate = $request->homework_date;

    $submissions = HomeworkSubmit::with(['homework.subject'])
        ->where('student_id', $student->id)
        ->whereHas('homework', function ($query) use ($classId, $subjectId, $homeworkDate) {
            $query->where('class_id', $classId);

            if ($subjectId) {
                $query->where('subject_id', $subjectId);
            }

            if ($homeworkDate) {
                $query->whereDate('homework_date', $homeworkDate);
            }
        })
        ->latest()
        ->get();

    $subjects = ClassSubjectModel::where('class_id', $classId)
        ->with('subject')
        ->get()
        ->pluck('subject.name', 'subject.id');

    return view('student.homework.submitted', compact('submissions', 'subjects', 'subjectId', 'homeworkDate'), $data);
}

}

