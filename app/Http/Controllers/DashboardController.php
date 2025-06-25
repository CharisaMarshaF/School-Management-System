<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Auth;
use Hash;
use App\Models\Exam;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Homework;
use App\Models\ClassModel;
use App\Models\ParentUser;
use App\Models\NoticeBoard;
use App\Models\SubjectModel;
use Illuminate\Http\Request;
use App\Models\HomeworkSubmit;
use App\Models\StudentAddFees;
use App\Models\ClassSubjectModel;
use App\Models\StudentAttendance;
use App\Models\NoticeBoardMessage;

class DashboardController extends Controller
{
    public function dashboard(){
        $data['header_title'] = 'Dashboard';
        if(Auth::user()->user_type == 1){
            return view('admin.dashboard', $data);
        }
        else if(Auth::user()->user_type == 2){
            return view('teacher.dashboard', $data);
        }
        else if(Auth::user()->user_type == 3){
            return view('student.dashboard', $data);
        }
        else if(Auth::user()->user_type == 4){
            return view('parent.dashboard', $data);
        }        
    }

    public function index()
{
    $data['header_title'] = 'Dashboard';

    $students = Student::where('user_type', 3)
        ->where('is_delete', 0)
        ->count();

    $teachers = Teacher::where('user_type', 2)
        ->where('is_delete', 0)
        ->count();

    $parents = ParentUser::where('user_type', 4)
        ->where('is_delete', 0)
        ->count();

    $admins = User::where('user_type', 1)
        ->where('is_delete', 0)
        ->count();

    $classCount = ClassModel::where('is_delete', 0)->count();
    $examCount = Exam::count();
    $subjectCount = SubjectModel::where('is_delete', 0)->count();

    $totalRevenue = StudentAddFees::sum('paid_amount');
    $todayRevenue = StudentAddFees::whereDate('created_at', today())->sum('paid_amount');

    return view('admin.dashboard', compact(
        'students', 'teachers', 'parents', 'admins',
        'classCount', 'examCount', 'subjectCount',
        'totalRevenue', 'todayRevenue'
    ), $data);
}


    public function teacherDashboard()
    {
        $teacherId = Auth::id();
        $data['header_title'] = 'Teacher Dashboard';

        // Ambil class_id dari assign_class_teacher
        $classIds = \DB::table('assign_class_teacher')
            ->where('teacher_id', $teacherId)
            ->pluck('class_id');

        // Hitung jumlah student (user_type = 3)
        $students = Student::whereIn('class_id', $classIds)
            ->where('user_type', 3)
            ->where('is_delete', 0)
            ->count();

        // Hitung class yang diajar teacher
        $classCount = ClassModel::whereIn('id', $classIds)
            ->where('is_delete', 0)
            ->count();

        // Hitung subject yang terkait dengan kelas yang diajar
        $subjectCount = ClassSubjectModel::whereIn('class_id', $classIds)
            ->where('is_delete', 0)
            ->count();

        // Hitung jumlah notice untuk guru
        $noticeCount = NoticeBoardMessage::where('message_to', 2)
            ->count();

        return view('teacher.dashboard', compact(
            'students',
            'classCount',
            'subjectCount',
            'noticeCount'
        ), $data);
    }

public function studentDashboard()
{
    $studentId = Auth::id();

    // Ambil data student dari tabel users dengan user_type = 3
    $student = Student::where('id', $studentId)
        ->where('user_type', 3)
        ->first();

    if (!$student) {
        abort(404, 'Student not found.');
    }

    $classId = $student->class_id;

    // Total Paid Amount
    $totalPaid = StudentAddFees::where('student_id', $studentId)
        ->sum('paid_amount');

    // Total Subjects (berdasarkan class_id)
    $subjectCount = ClassSubjectModel::where('class_id', $classId)
        ->where('is_delete', 0)
        ->count();

    // Total Notices (umum ke semua siswa)
    $noticeCount = NoticeBoardMessage::where('message_to', 3)
        ->count();

    // Total Homework
    $homeworkCount = Homework::where('class_id', $classId)->count();

    // Total Submitted Homework
    $submittedHomeworkCount = HomeworkSubmit::where('student_id', $studentId)
        ->count();

    // Total Attendance
    $attendanceCount = StudentAttendance::where('student_id', $studentId)
        ->count();

    $data = [
        'header_title' => 'Student Dashboard',
        'totalPaid' => $totalPaid,
        'subjectCount' => $subjectCount,
        'noticeCount' => $noticeCount,
        'homeworkCount' => $homeworkCount,
        'submittedHomeworkCount' => $submittedHomeworkCount,
        'attendanceCount' => $attendanceCount,
    ];

    return view('student.dashboard', $data);
}
public function parentDashboard()
{
    $parentId = Auth::id();
    // Ambil semua anak dari parent
    $students = ParentUser::where('user_type', 3)
        ->where('parent_id', $parentId)
        ->get();

    $studentIds = $students->pluck('id');

    // Total Paid Amount dari semua anak
    $totalPaid = StudentAddFees::whereIn('student_id', $studentIds)->sum('paid_amount');

    // Total Student
    $totalStudent = $students->count();

    // Total Notices (khusus parent)
    $noticeCount = NoticeBoardMessage::where('message_to', 4)
        ->count();

    // Total Attendance semua anak
    $attendanceCount = StudentAttendance::whereIn('student_id', $studentIds)->count();

    // Total Submitted Homework semua anak
    $submittedHomeworkCount = HomeworkSubmit::whereIn('student_id', $studentIds)->count();

    $data = [
        'totalPaid' => $totalPaid,
        'totalStudent' => $totalStudent,
        'noticeCount' => $noticeCount,
        'attendanceCount' => $attendanceCount,
        'submittedHomeworkCount' => $submittedHomeworkCount,
        'header_title' => 'Parent Dashboard',
    ];

    return view('parent.dashboard', $data);
}

}
