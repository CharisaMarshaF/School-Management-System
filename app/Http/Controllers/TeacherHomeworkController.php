<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use Illuminate\Http\Request;
use App\Models\ClassSubjectModel;
use App\Models\AssignClassTeacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class TeacherHomeworkController extends Controller
{
    public function index(Request $request)
    {
                $data['header_title'] = "Homework List";

        $teacherId = Auth::user()->id;

        $classIds = AssignClassTeacher::where('teacher_id', $teacherId)->pluck('class_id');
        $classes = ClassModel::whereIn('id', $classIds)->get();

        $subjects = collect();
        if ($request->class_id) {
            $subjectIds = ClassSubjectModel::where('class_id', $request->class_id)->pluck('subject_id');
            $subjects = SubjectModel::whereIn('id', $subjectIds)->get();
        }

        $homeworks = Homework::with('class', 'subject')
            ->whereIn('class_id', $classIds)
            ->when($request->class_id, fn($q) => $q->where('class_id', $request->class_id))
            ->when($request->subject_id, fn($q) => $q->where('subject_id', $request->subject_id))
            ->orderBy('homework_date', 'desc')
            ->get();

        return view('teacher.homework.index', compact('classes', 'subjects', 'homeworks'), $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'subject_id' => 'required',
            'homework_date' => 'required|date',
            'submission_date' => 'required|date|after_or_equal:homework_date',
            'description' => 'required',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,zip,jpg,png,jpeg|max:2048',
        ]);

        $fileName = null;
        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/homework'), $fileName);
        }

        Homework::create([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'homework_date' => $request->homework_date,
            'submission_date' => $request->submission_date,
            'document_file' => $fileName,
            'description' => $request->description,
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Homework created successfully.');
    }

    public function update(Request $request, $id)
    {
        $homework = Homework::findOrFail($id);

        $request->validate([
            'class_id' => 'required',
            'subject_id' => 'required',
            'homework_date' => 'required|date',
            'submission_date' => 'required|date|after_or_equal:homework_date',
            'description' => 'required',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,zip,jpg,png,jpeg|max:2048',
        ]);

        $fileName = $homework->document_file;

        if ($request->hasFile('document_file')) {
            // delete old file
            if ($fileName && File::exists(public_path('uploads/homework/' . $fileName))) {
                File::delete(public_path('uploads/homework/' . $fileName));
            }

            $file = $request->file('document_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/homework'), $fileName);
        }

        $homework->update([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'homework_date' => $request->homework_date,
            'submission_date' => $request->submission_date,
            'document_file' => $fileName,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Homework updated successfully.');
    }

    public function destroy($id)
    {
        $homework = Homework::findOrFail($id);

        // Delete file
        if ($homework->document_file && File::exists(public_path('uploads/homework/' . $homework->document_file))) {
            File::delete(public_path('uploads/homework/' . $homework->document_file));
        }

        $homework->delete();

        return redirect()->back()->with('success', 'Homework deleted successfully.');
    }
public function getSubjects($class_id)
{
    $subjects = DB::table('class_subject')
        ->join('subject', 'class_subject.subject_id', '=', 'subject.id')
        ->where('class_subject.class_id', $class_id)
        ->select('subject.id', 'subject.name')
        ->get();

    return response()->json($subjects);
}

}
