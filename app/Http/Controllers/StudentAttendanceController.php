<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Models\StudentAttendance;
use App\Models\AssignClassTeacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StudentAttendanceController extends Controller
{
    public function list()
    {
        $data['header_title'] = "Student Attendance";
        $classes = DB::table('class')->where('is_delete', 0)->get();
        return view('admin.attendance.list', compact('classes'), $data);
    }

    public function getStudents($class_id, Request $request)
    {
        $date = $request->query('date') ?? date('Y-m-d');

        $students = Student::where('user_type', 3)
            ->where('is_delete', 0)
            ->where('class_id', $class_id)
            ->get();

        $attendances = StudentAttendance::where('class_id', $class_id)
            ->where('attendance_date', $date)
            ->get()
            ->keyBy('student_id');

        $result = $students->map(function ($student) use ($attendances) {
            $attendance = $attendances[$student->id] ?? null;
            return [
                'id' => $student->id,
                'name' => $student->name,
                'attendance_type' => $attendance->attendance_type ?? null,
            ];
        });

        return response()->json($result);
    }

    public function store(Request $request)
    {
        foreach ($request->student_id as $student_id) {
            StudentAttendance::updateOrCreate(
                [
                    'class_id' => $request->class_id,
                    'attendance_date' => $request->attendance_date,
                    'student_id' => $student_id,
                ],
                [
                    'attendance_type' => $request->attendance_type[$student_id] ?? null,
                    'created_by' => Auth::id(),
                ]
            );
        }

        return redirect()->back()->with('success', 'Attendance saved successfully!')->with('open_form', true)->withInput();
    }

    public function saveSingle(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|integer',
            'student_id' => 'required|integer',
            'attendance_type' => 'required|in:1,2,3,4',
            'attendance_date' => 'required|date',
        ]);

        $attendance = StudentAttendance::updateOrCreate(
            [
                'class_id' => $validated['class_id'],
                'student_id' => $validated['student_id'],
                'attendance_date' => $validated['attendance_date'],
            ],
            [
                'attendance_type' => $validated['attendance_type'],
                'created_by' => auth()->id(),
            ]
        );

        return response()->json(['status' => 'success']);
    }

    public function attendanceReport(Request $request)
    {
                $data['header_title'] = "Report Attendance";

        $classes =  ClassModel::all();

        $query = StudentAttendance::with(['student', 'class', 'creator'])
            ->join('users as u', 'student_attendance.student_id', '=', 'u.id')
            ->select('student_attendance.*');

        if ($request->student_id) {
            $query->where('student_attendance.student_id', $request->student_id);
        }

        if ($request->student_name) {
            $query->where('u.name', 'like', '%' . $request->student_name . '%');
        }

        if ($request->student_last_name) {
            $query->where('u.last_name', 'like', '%' . $request->student_last_name . '%');
        }

        if ($request->class_id) {
            $query->where('student_attendance.class_id', $request->class_id);
        }

        if ($request->attendance_date) {
            $query->whereDate('student_attendance.attendance_date', $request->attendance_date);
        }

        if ($request->attendance_type != '') {
            $query->where('student_attendance.attendance_type', $request->attendance_type);
        }

        $attendances = $query->orderBy('student_attendance.attendance_date', 'desc')->get();

        return view('admin.attendance.report', compact('attendances', 'classes', 'request'),   $data);
    }

    public function TeacherIndex()
    {
        $teacherId = Auth::user()->id;

        // Ambil class_id dari tabel assign_class_teacher
        $classIds = AssignClassTeacher::where('teacher_id', $teacherId)->pluck('class_id')->toArray();

        // Ambil data class untuk dropdown
        $classes = ClassModel::whereIn('id', $classIds)->get();

        return view('teacher.attendance.list', [
            'classes' => $classes,
            'header_title' => 'Student Attendance',
        ]);
    }

    public function TeacherGetStudents($class_id)
    {
        $date = request()->query('date');

        if (!$date) {
            return response()->json([], 400);
        }

        $students = Student::where('user_type', 3)
            ->where('class_id', $class_id)
            ->where('is_delete', 0) // Tambahkan kondisi ini
            ->get();

        foreach ($students as $student) {
            $attendance = StudentAttendance::where('class_id', $class_id)
                ->where('student_id', $student->id)
                ->whereDate('attendance_date', $date)
                ->first();

            $student->attendance_type = $attendance->attendance_type ?? null;
        }

        return response()->json($students);
    }


    public function TeacherSaveSingle(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class,id',
            'student_id' => 'required|exists:users,id',
            'attendance_type' => 'required|in:1,2,3,4',
            'attendance_date' => 'required|date',
        ]);

        $attendance = StudentAttendance::where('class_id', $request->class_id)
            ->where('student_id', $request->student_id)
            ->whereDate('attendance_date', $request->attendance_date)
            ->first();

        if ($attendance) {
            $attendance->attendance_type = $request->attendance_type;
            $attendance->save();
        } else {
            StudentAttendance::create([
                'class_id' => $request->class_id,
                'student_id' => $request->student_id,
                'attendance_type' => $request->attendance_type,
                'attendance_date' => $request->attendance_date,
                'created_by' => Auth::user()->id,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function TeacherAttendanceReport(Request $request)
{
    $teacherId = Auth::user()->id;

    // Ambil class yang diajar guru
    $classIds = AssignClassTeacher::where('teacher_id', $teacherId)->pluck('class_id')->toArray();
    $classes = ClassModel::whereIn('id', $classIds)->get();

    // Query attendance
    $query = StudentAttendance::with(['student', 'class', 'creator'])
        ->whereIn('class_id', $classIds);

    if ($request->student_id) {
        $query->where('student_id', $request->student_id);
    }

    if ($request->student_name || $request->student_last_name) {
        $query->whereHas('student', function ($q) use ($request) {
            if ($request->student_name) {
                $q->where('name', 'like', '%' . $request->student_name . '%');
            }
            if ($request->student_last_name) {
                $q->where('last_name', 'like', '%' . $request->student_last_name . '%');
            }
        });
    }

    if ($request->class_id) {
        $query->where('class_id', $request->class_id);
    }

    if ($request->attendance_date) {
        $query->whereDate('attendance_date', $request->attendance_date);
    }

    if ($request->attendance_type) {
        $query->where('attendance_type', $request->attendance_type);
    }

    $attendances = $query->orderBy('attendance_date', 'desc')->get();

    return view('teacher.attendance.report', [
        'header_title' => 'Student Attendance Report',
        'classes' => $classes,
        'attendances' => $attendances,
        'request' => $request
    ]);
}

public function studentAttendance(Request $request)
    {
        $student = Auth::user();
        $data['header_title'] = "My Attendance";

        // Pastikan hanya student yang bisa akses
        if ($student->user_type != 3) {
            abort(403);
        }

        $query = StudentAttendance::where('student_id', $student->id)
            ->where('class_id', $student->class_id);

        if ($request->attendance_date) {
            $query->whereDate('attendance_date', $request->attendance_date);
        }

        if ($request->attendance_type) {
            $query->where('attendance_type', $request->attendance_type);
        }

        $attendanceData = $query->orderBy('attendance_date', 'desc')->get();

        return view('student.attendance.index', [
            'attendanceData' => $attendanceData,
            'class_name' => optional(ClassModel::find($student->class_id))->name,
            'filters' => $request->only(['attendance_date', 'attendance_type']),
            'header_title' => $data['header_title']
        ]);
    }

    public function ParentIndex()
    {
        $parent_id = Auth::id(); // user_type = 4
        $students = User::where('user_type', 3)
                        ->where('parent_id', $parent_id)
                        ->with('class')
                        ->get();

        return view('parent.student.my_student', compact('students'));
    }

    public function ParentAttendanceDetail(Request $request, $student_id)
    {
                $data['header_title'] = " Attendance";

        $query = StudentAttendance::where('student_id', $student_id)->with('class');

        // Optional filter
        if ($request->filled('attendance_type')) {
            $query->where('attendance_type', $request->attendance_type);
        }
        if ($request->filled('attendance_date')) {
            $query->whereDate('attendance_date', $request->attendance_date);
        }

        $attendances = $query->orderBy('attendance_date', 'desc')->get();
        $student = Student::with('class')->findOrFail($student_id);

        return view('parent.student.student_attendance', compact('attendances', 'student'), $data);
    }
}
