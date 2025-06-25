<?php

namespace App\Http\Controllers;

use App\Models\Week;
// use App\Models\ClassModel;
// use App\Models\SubjectModel;
use App\Models\Student;
use App\Models\SubjectModel;
use Illuminate\Http\Request;
use App\Models\ClassSubjectModel;
use App\Models\AssignClassTeacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassSubjectTimetable;


    class ClassTimetableController extends Controller
{
    public function list(Request $request)
    {
        $classes = DB::table('class')->where('is_delete', 0)->get();
        $subjects = [];
        $weeks = DB::table('week')->get();
        $timetableData = [];
        $data['header_title'] = "Class Timetable";

        if ($request->has('class_id') && $request->has('subject_id')) {
            $subjects = ClassSubjectModel::where('class_id', $request->class_id)
                ->with('subject')
                ->get()
                ->map(function ($item) {
                    return $item->subject;
                });

            $timetableData = DB::table('class_subject_timetable')
                ->where('class_id', $request->class_id)
                ->where('subject_id', $request->subject_id)
                ->get()
                ->keyBy('week_id');
        }

        return view('admin.class_timetable.list', compact('classes', 'subjects', 'weeks', 'timetableData'), $data);
    }

    public function getSubjectsByClass($class_id)
    {
        $classSubjects = ClassSubjectModel::where('class_id', $class_id)
            ->with('subject')
            ->get();

        $subjects = $classSubjects->filter(fn($cs) => $cs->subject !== null)
            ->map(function ($cs) {
                return [
                    'id' => $cs->subject->id,
                    'name' => $cs->subject->name,
                ];
            })->values();

        return response()->json($subjects);
    }

    public function save(Request $request)
    {
        $class_id = $request->input('class_id');
        $subject_id = $request->input('subject_id');
        $timetable = $request->input('timetable');

        foreach ($timetable as $week_id => $times) {
            DB::table('class_subject_timetable')->updateOrInsert(
                [
                    'class_id' => $class_id,
                    'subject_id' => $subject_id,
                    'week_id' => $week_id
                ],
                [
                    'start_time' => $times['start_time'] ?? null,
                    'end_time' => $times['end_time'] ?? null,
                    'room_number' => $times['room_number'] ?? null,
                    'updated_at' => now(),
                    'created_at' => now()
                ]
            );
        }

        return redirect()->back()->with('success', 'Timetable saved successfully.');
    }
    public function studentTimetable()
    {
        $student = Auth::user();
        $data['header_title'] = "My Timetable";

        if ($student->user_type != 3 || !$student->class_id) {
            abort(403, 'Unauthorized access');
        }

        // Ambil semua subject berdasarkan class_id student
        $classSubjects = ClassSubjectModel::where('class_id', $student->class_id)
            ->with('subject') // pastikan relasi 'subject' ada di model
            ->get();

        // Ambil data week (Senin–Minggu)
        $weeks = Week::all();

        $timetable = [];

        foreach ($classSubjects as $classSubject) {
            $subjectName = $classSubject->subject->name;

            foreach ($weeks as $week) {
                $schedule = ClassSubjectTimetable::where('class_id', $student->class_id)
                    ->where('subject_id', $classSubject->subject_id)
                    ->where('week_id', $week->id)
                    ->first();

                if ($schedule) {
                    $timetable[$subjectName][] = [
                        'week_name' => $week->name,
                        'start_time' => $schedule->start_time,
                        'end_time' => $schedule->end_time,
                        'room_number' => $schedule->room_number,
                    ];
                }
            }
        }

        return view('student.timetable.index', compact('timetable'), $data);
    }

   public function teacherTimetable($class_id, $subject_id)
{
    $header_title = "Class Timetable";

    $weeks = Week::all();
    $subject = SubjectModel::find($subject_id); // Ambil nama subject
    $timetable = [];

    foreach ($weeks as $week) {
        $entry = ClassSubjectTimetable::where('class_id', $class_id)
            ->where('subject_id', $subject_id)
            ->where('week_id', $week->id)
            ->first();

        $timetable[] = [
            'week_name' => $week->name,
            'start_time' => $entry->start_time ?? null,
            'end_time' => $entry->end_time ?? null,
            'room_number' => $entry->room_number ?? null,
        ];
    }

    return view('teacher.class_subject.class_timetable', compact('header_title', 'timetable', 'subject'));
}
public function parentStudentTimetable($student_id, $class_id, $subject_id)
{
    $student = Student::where('id', $student_id)
        ->where('parent_id', auth()->user()->id)
        ->firstOrFail();

    $weeks = Week::all();
    $subject = SubjectModel::find($subject_id);
    $timetable = [];

    foreach ($weeks as $week) {
        $entry = ClassSubjectTimetable::where('class_id', $class_id)
            ->where('subject_id', $subject_id)
            ->where('week_id', $week->id)
            ->first();

        $timetable[] = [
            'week_name' => $week->name,
            'start_time' => $entry->start_time ?? null,
            'end_time' => $entry->end_time ?? null,
            'room_number' => $entry->room_number ?? null,
        ];
    }

    return view('parent.student.student_timetable', [
        'header_title' => 'Timetable for ' . $subject->name,
        'timetable' => $timetable,
        'subject' => $subject,
        'student' => $student
    ]);
}
}