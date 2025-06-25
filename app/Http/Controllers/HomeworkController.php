<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Homework;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use Illuminate\Http\Request;
use App\Models\HomeworkSubmit;
use App\Models\ClassSubjectModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeworkController extends Controller
{
    public function index(Request $r)
    {
                $data['header_title'] = 'Homework List';

        $classes = ClassModel::all();
    $subjects = SubjectModel::where('is_delete', 0)->get();
        $homeworks = Homework::with(['classroom', 'subject'])->when(request('class_id'), function($query) {
    $query->where('class_id', request('class_id'));
})->when(request('subject_id'), function($query) {
    $query->where('subject_id', request('subject_id'));
})->get();


return view('admin.homework.list', compact('homeworks', 'classes', 'subjects'), $data);

    }

    public function store(Request $r)
    {
        $r->validate([
            'class_id' => 'required|exists:class,id',
            'subject_id' => 'required|exists:subject,id',
            'homework_date' => 'required|date',
            'submission_date' => 'required|date|after_or_equal:homework_date',
            'document_file' => 'nullable|file|max:7048',
            'description' => 'nullable|string'
        ]);

        $data = $r->only(['class_id', 'subject_id', 'homework_date', 'submission_date', 'description']);

        if ($r->hasFile('document_file') && $r->file('document_file')->isValid()) {
            $filename = $r->file('document_file')->getClientOriginalName();
            $r->file('document_file')->move(public_path('uploads/homework'), $filename);
            $data['document_file'] = $filename;
        }

        $data['created_by'] = Auth::id();
        Homework::create($data);

        return back()->with('success', 'Homework added');
    }

    public function update(Request $r, $id)
    {
        $r->validate([
            'class_id' => 'required|exists:class,id',
            'subject_id' => 'required|exists:subject,id',
            'homework_date' => 'required|date',
            'submission_date' => 'required|date|after_or_equal:homework_date',
            'document_file' => 'nullable|file|max:7048',
            'description' => 'nullable|string'
        ]);

        $homework = Homework::findOrFail($id);
        $data = $r->only(['class_id', 'subject_id', 'homework_date', 'submission_date', 'description']);

        if ($r->hasFile('document_file') && $r->file('document_file')->isValid()) {
            // Hapus file lama jika ada
            $oldPath = public_path('uploads/homework/' . $homework->document_file);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            $filename = $r->file('document_file')->getClientOriginalName();
            $r->file('document_file')->move(public_path('uploads/homework'), $filename);
            $data['document_file'] = $filename;
        }

        $homework->update($data);

        return back()->with('success', 'Homework updated');
    }

    public function destroy($id)
    {
        $homework = Homework::findOrFail($id);

        if ($homework->document_file) {
            $filePath = public_path('uploads/homework/' . $homework->document_file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $homework->delete();

        return back()->with('success', 'Homework deleted');
    }

    public function getSubjectsByClass($class_id)
    {
        $subjectIds = ClassSubjectModel::where('class_id', $class_id)
            ->where('is_delete', 0)
            ->pluck('subject_id');

        $subjects = SubjectModel::whereIn('id', $subjectIds)->get();
        return response()->json($subjects);
    }

    public function parentStudentHomework(Request $request, $student_id)
{
                    $data['header_title'] = 'Homework List';

    $homeworks = Homework::where('class_id', function ($q) use ($student_id) {
        $q->from('users')->select('class_id')->where('id', $student_id);
    });

    if ($request->filled('subject_id')) {
        $homeworks->where('subject_id', $request->subject_id);
    }

    if ($request->filled('homework_date')) {
        $homeworks->whereDate('homework_date', $request->homework_date);
    }

    $homeworks = $homeworks->latest()->get();

    $subjects = ClassSubjectModel::where('class_id', function ($q) use ($student_id) {
        $q->from('users')->select('class_id')->where('id', $student_id);
    })->with('subject')->get();

    return view('parent.homework.index', compact('homeworks', 'student_id', 'subjects'), $data);
}

public function parentStudentSubmittedHomework(Request $request, $student_id)
{
    $data['header_title'] = 'Submitted Homework';

    $query = HomeworkSubmit::where('student_id', $student_id)
        ->with(['homework.subject'])
        ->latest();

    if ($request->subject_id) {
        $query->whereHas('homework', function ($q) use ($request) {
            $q->where('subject_id', $request->subject_id);
        });
    }

    if ($request->homework_date) {
        $query->whereHas('homework', function ($q) use ($request) {
            $q->where('homework_date', $request->homework_date);
        });
    }

    $data['submittedHomeworks'] = $query->get();

    // Ambil subject berdasarkan class_id student
    $student = Student::findOrFail($student_id);
    $data['subjects'] = ClassSubjectModel::with('subject')
        ->where('class_id', $student->class_id)
        ->get();

    $data['student_id'] = $student_id;

    return view('parent.homework.submitted', $data);
}

public function adminStudentHomeworkReport(Request $request)
{
    $students = Student::where('user_type', 3)
        ->where('is_delete', 0)
        ->get();

    $classes = ClassModel::where('is_delete', 0)->get();
    $subjects = SubjectModel::where('is_delete', 0)->get();

    $data['header_title'] = 'Student Homework Report';

    $query = HomeworkSubmit::with(['homework', 'student', 'homework.subject', 'homework.class'])
        ->whereHas('homework', function ($q) {
        });

    if ($request->filled('class_id')) {
        $query->whereHas('homework', function ($q) use ($request) {
            $q->where('class_id', $request->class_id);
        });
    }

    if ($request->filled('subject_id')) {
        $query->whereHas('homework', function ($q) use ($request) {
            $q->where('subject_id', $request->subject_id);
        });
    }

    if ($request->filled('student_name')) {
        $query->whereHas('student', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->student_name . '%');
        });
    }

    $submissions = $query->latest()->get();

    return view('admin.homework.student_homework_report', compact('submissions', 'classes', 'subjects', 'students'), $data);
}


}
