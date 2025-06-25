<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ExamSchedule;
use App\Models\MarksRegister;
use App\Models\AssignClassTeacher;

class MarksRegisterController extends Controller
{
    public function index(Request $request)
    {
        $data['header_title'] = "Exam Register";
        $exams = \DB::table('exam')->get();
        $classes = \DB::table('class')->get();

        // Ambil semua grades (berisi name, percent_from, percent_to)
        $grades = \DB::table('marks_grade')->get();
            $gradesByMark = [];   // <- pastikan variabel ini dibuat awal

        $students = [];
        $schedules = [];
        $marks = [];
        $exam_id = $request->exam_id;
        $class_id = $request->class_id;

        if ($exam_id && $class_id) {
            $students = Student::where('user_type', 3)
                ->where('class_id', $class_id)
                ->where('is_delete', 0)
                ->get();

            $schedules = ExamSchedule::with('subject')
                ->where('exam_id', $exam_id)
                ->where('class_id', $class_id)
                ->get();

            $marks = MarksRegister::whereIn('student_id', $students->pluck('id'))
                ->where('exam_id', $exam_id)
                ->where('class_id', $class_id)
                ->get()
                ->keyBy(function ($item) {
                    return $item->student_id . '_' . $item->subject_id;
                });

            // Buat helper grade lookup: 
            // function untuk cari grade sesuai percent
            $gradeLookup = function($percent) use ($grades) {
                foreach ($grades as $grade) {
                    if ($percent >= $grade->percent_from && $percent <= $grade->percent_to) {
                        return $grade->name;
                    }
                }
                return '-';
            };

            // Buat array grade per student-subject
            $gradesByMark = [];
            foreach ($marks as $key => $mark) {
                $total_mark = $mark->class_work + $mark->home_work + $mark->test_work + $mark->exam;
                $percent = $mark->full_marks > 0 ? round(($total_mark / $mark->full_marks) * 100) : 0;
                $gradesByMark[$key] = $gradeLookup($percent);
            }
        }

        return view('admin.marks.register', compact(
            'exams', 'classes', 'students', 'schedules',
            'exam_id', 'class_id', 'marks', 'grades', 'gradesByMark',
        ), $data);
    }


    public function save(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer',
            'exam_id' => 'required|integer',
            'class_id' => 'required|integer',
            'marks' => 'required|array',
        ]);
       

        $student_id = $request->student_id;
        $exam_id = $request->exam_id;
        $class_id = $request->class_id;
        $subjects = $request->marks;

        foreach ($subjects as $subject_id => $data) {
            // Hitung total nilai
            $total = ($data['class_work'] ?? 0) + ($data['home_work'] ?? 0) + ($data['test_work'] ?? 0) + ($data['exam'] ?? 0);
            if ($total > 100) {
                return back()->withErrors(["marks.$subject_id" => "Total marks for subject $subject_id cannot exceed 100."])->withInput();
            }

            $sched = \DB::table('exam_schedule_insert')
                ->where('exam_id', $exam_id)
                ->where('class_id', $class_id)
                ->where('subject_id', $subject_id)
                ->first();

            MarksRegister::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'exam_id' => $exam_id,
                    'class_id' => $class_id,
                    'subject_id' => $subject_id,
                ],
                [
                    'class_work' => $data['class_work'],
                    'home_work' => $data['home_work'],
                    'test_work' => $data['test_work'],
                    'exam' => $data['exam'],
                    'full_marks' => $sched->full_marks ?? 0,
                    'passing_marks' => $sched->passing_marks ?? 0,
                    'created_by' => auth()->id(),
                ]
            );
        }

        return back()->with('success', 'Marks saved for student.');
    }

    public function saveSubject(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer',
            'exam_id' => 'required|integer',
            'class_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'class_work' => 'required|numeric',
            'home_work' => 'required|numeric',
            'test_work' => 'required|numeric',
            'exam' => 'required|numeric',
        ]);

        // Hitung total nilai
        $total = ($request->class_work ?? 0) + ($request->home_work ?? 0) + ($request->test_work ?? 0) + ($request->exam ?? 0);
        if ($total > 100) {
            return response()->json([
                'success' => false,
                'message' => 'Total marks cannot exceed 100.'
            ], 422);
        }

        $sched = \DB::table('exam_schedule_insert')
            ->where('exam_id', $request->exam_id)
            ->where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->first();

        MarksRegister::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'exam_id' => $request->exam_id,
                'class_id' => $request->class_id,
                'subject_id' => $request->subject_id,
            ],
            [
                'class_work' => $request->class_work,
                'home_work' => $request->home_work,
                'test_work' => $request->test_work,
                'exam' => $request->exam,
                'full_marks' => $sched->full_marks ?? 0,
                'passing_marks' => $sched->passing_marks ?? 0,
                'created_by' => auth()->id(),
            ]
        );

        return response()->json(['success' => true]);
    }

public function teacherIndex(Request $request) 
{
    $teacherId = auth()->id();
    $data['header_title'] = "Marks Register";

    $assigned = AssignClassTeacher::where('teacher_id', $teacherId)->pluck('class_id')->toArray();
    $exams = \DB::table('exam')->get();
    $classes = \DB::table('class')->whereIn('id', $assigned)->get();

    $students = $schedules = $marks = collect();
    $grades = \DB::table('marks_grade')->get();
    $gradesByMark = [];

    $exam_id = $request->exam_id;
    $class_id = $request->class_id;

    if ($exam_id && $class_id && in_array($class_id, $assigned)) {
        $students = Student::where('user_type', 3)
            ->where('class_id', $class_id)
            ->where('is_delete', 0)
            ->get();

        $schedules = ExamSchedule::with('subject')
            ->where('exam_id', $exam_id)
            ->where('class_id', $class_id)
            ->get();

        $marks = MarksRegister::whereIn('student_id', $students->pluck('id'))
            ->where('exam_id', $exam_id)
            ->where('class_id', $class_id)
            ->get()
            ->keyBy(fn($item) => $item->student_id . '_' . $item->subject_id);

        // Grade Lookup Helper
        $gradeLookup = function($percent) use ($grades) {
            foreach ($grades as $grade) {
                if ($percent >= $grade->percent_from && $percent <= $grade->percent_to) {
                    return $grade->name;
                }
            }
            return '-';
        };

        foreach ($marks as $key => $mark) {
            $total = ($mark->class_work + $mark->home_work + $mark->test_work + $mark->exam);
            $percent = $mark->full_marks > 0 ? round(($total / $mark->full_marks) * 100) : 0;
            $gradesByMark[$key] = $gradeLookup($percent);
        }
    }

    return view('teacher.marks.register', compact(
        'exams', 'classes', 'students', 'schedules', 'marks', 'exam_id', 'class_id', 'gradesByMark'
    ), $data);
}


    public function teacherSaveAll(Request $request)
    {
        $this->validate($request, [
            'exam_id' => 'required|integer',
            'class_id' => 'required|integer',
            'student_id' => 'required|integer',
            'marks' => 'required|array'
        ]);

        foreach ($request->marks as $subjId => $data) {
            // Hitung total nilai
            $total = ($data['class_work'] ?? 0) + ($data['home_work'] ?? 0) + ($data['test_work'] ?? 0) + ($data['exam'] ?? 0);
            if ($total > 100) {
                return back()->withErrors(["marks.$subjId" => "Total marks for subject $subjId cannot exceed 100."])->withInput();
            }

            $sched = \DB::table('exam_schedule_insert')
                ->where('exam_id', $request->exam_id)
                ->where('class_id', $request->class_id)
                ->where('subject_id', $subjId)
                ->first();

            MarksRegister::updateOrCreate(
                [
                    'student_id' => $request->student_id,
                    'exam_id' => $request->exam_id,
                    'class_id' => $request->class_id,
                    'subject_id' => $subjId,
                ],
                [
                    'class_work' => $data['class_work'],
                    'home_work' => $data['home_work'],
                    'test_work' => $data['test_work'],
                    'exam' => $data['exam'],
                    'full_marks' => $sched->full_marks ?? 0,
                    'passing_marks' => $sched->passing_marks ?? 0,
                    'created_by' => auth()->id(),
                ]
            );
        }

        return back()->with('success', 'Marks saved for student.');
    }

    public function teacherSaveSubject(Request $request)
    {
        $this->validate($request, [
            'exam_id' => 'required|integer',
            'class_id' => 'required|integer',
            'student_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'class_work' => 'required|numeric',
            'home_work' => 'required|numeric',
            'test_work' => 'required|numeric',
            'exam' => 'required|numeric',
        ]);

        // Hitung total nilai
        $total = ($request->class_work ?? 0) + ($request->home_work ?? 0) + ($request->test_work ?? 0) + ($request->exam ?? 0);
        if ($total > 100) {
            return response()->json([
                'success' => false,
                'message' => 'Total marks cannot exceed 100.'
            ], 422);
        }

        $sched = \DB::table('exam_schedule_insert')
            ->where('exam_id', $request->exam_id)
            ->where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->first();

        MarksRegister::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'exam_id' => $request->exam_id,
                'class_id' => $request->class_id,
                'subject_id' => $request->subject_id,
            ],
            [
                'class_work' => $request->class_work,
                'home_work' => $request->home_work,
                'test_work' => $request->test_work,
                'exam' => $request->exam,
                'full_marks' => $sched->full_marks ?? 0,
                'passing_marks' => $sched->passing_marks ?? 0,
                'created_by' => auth()->id(),
            ]
        );

        return response()->json(['success' => true]);
    }
}
