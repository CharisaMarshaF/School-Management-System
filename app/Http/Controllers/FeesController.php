<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Models\StudentAddFees;
use Illuminate\Support\Facades\Auth;

class FeesController extends Controller
{

public function index(Request $request)
{
    $dataa['header_title'] = 'Fees List';
    $query = Student::with(['class', 'fees'])
        ->where('user_type', 3) // hanya siswa
        ->whereNotNull('class_id')
        ->where('is_delete', 0);

    // Filter berdasarkan class_id (dropdown)
    if ($request->filled('class_name')) {
        $query->where('class_id', $request->class_name);
    }

    // Filter berdasarkan nama siswa
    if ($request->filled('student_name')) {
        $query->where('name', 'like', '%' . $request->student_name . '%');
    }

    $data = $query->get();
    $classes = ClassModel::where('is_delete', 0)->pluck('name', 'id');

    return view('admin.fees.list', compact('data', 'classes'), $dataa);
}



   public function collectFees($student_id)
{
            $data['header_title'] = 'Collect Fees';

    $student = Student::with('class')->where('user_type', 3)->findOrFail($student_id);
    $classAmount = $student->class->amount ?? 0;

    $feeLogs = StudentAddFees::with('creator')
        ->where('student_id', $student_id)
        ->orderBy('created_at', 'desc')
        ->get();

    $totalPaid = $feeLogs->sum('paid_amount');
    $remaining = $classAmount - $totalPaid;

    return view('admin.fees.collect', [
        'student' => $student,
        'totalAmount' => $classAmount,
        'paidAmount' => $totalPaid,
        'remainingAmount' => $remaining,
        'feeLogs' => $feeLogs
    ], $data);
}

public function storePayment(Request $request)
{

   $request->validate([
        'student_id' => 'required|exists:users,id',
        'class_id' => 'required|exists:class,id',
        'total_amount' => 'required|numeric|min:0',
        'paid_amount' => 'required|numeric|min:1',
        'payment_type' => 'required|in:Cash,Transfer,Bank',
    ]);

    $studentId = $request->student_id;
    $classId = $request->class_id;
    $paid = $request->paid_amount;

    // Hitung ulang total & paid
    $total = (float) $request->total_amount;
    $paidSoFar = StudentAddFees::where('student_id', $studentId)->sum('paid_amount');
    $remaining = $total - $paidSoFar;

    if ($paid > $remaining) {
        return back()->with('error', 'Paid amount cannot exceed remaining balance.');
    }

    // Insert ke student_add_fees (atau sesuai model kamu)
    StudentAddFees::create([
        'student_id' => $studentId,
        'class_id' => $classId,
        'total_amount' => $total,
        'paid_amount' => $paid,
        'remaning_amount' => $remaining - $paid,
        'payment_type' => $request->payment_type,
        'remark' => $request->remark,
        'created_by' => auth()->id(),
    ]);

    return redirect()->back()->with('success', 'Payment successfully recorded.');
}
public function studentFees()
{
    $data['header_title'] = 'My Fees';
    $student = auth()->user();

    if ($student->user_type != 3) {
        abort(403, 'Unauthorized');
    }

    // Ambil data class dan total biaya
    $class = ClassModel::find($student->class_id);
    $totalAmount = $class?->amount ?? 0;

    // Hitung jumlah yang sudah dibayar oleh student
    $paidAmount = StudentAddFees::where('student_id', $student->id)->sum('paid_amount');
    $remainingAmount = $totalAmount - $paidAmount;

    // Ambil riwayat pembayaran
    $feeLogs = StudentAddFees::where('student_id', $student->id)->orderBy('created_at', 'desc')->get();

    return view('student.fees.index', compact(
        'student',
        'class',
        'totalAmount',
        'paidAmount',
        'remainingAmount',
        'feeLogs'
    ), $data);
}
public function parentStudentFees($student_id)
{
    $data['header_title'] = 'Student Fees';
    // Ambil data student
    $student = Student::where('id', $student_id)
        ->where('user_type', 3) // student
        ->where('parent_id', auth()->user()->id) // hanya anak milik parent
        ->with('class')
        ->firstOrFail();

    // Ambil data fees berdasarkan student
    $totalAmount = \DB::table('class')
        ->where('id', $student->class_id)
        ->where('is_delete', 0)
        ->value('amount') ?? 0;

    $paidAmount = \DB::table('student_add_fees')
        ->where('student_id', $student->id)
        ->sum('paid_amount');

    $remainingAmount = $totalAmount - $paidAmount;

    $feeLogs = \DB::table('student_add_fees')
        ->where('student_id', $student->id)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('parent.fees.student_fees', compact('student', 'totalAmount', 'paidAmount', 'remainingAmount', 'feeLogs'), $data);
}
    public function studentDashboard()
        {
            $studentId = Auth::id();

            $student = Student::find($studentId);

            if (!$student) {
                abort(404, 'Student not found');
            }

            $classId = $student->class_id;

            $totalPaid = StudentAddFees::where('student_id', $studentId)
                ->sum('paid_amount');

            $subjectCount = SubjectModel::where('class_id', $classId)
                ->where('is_delete', 0)
                ->count();

            $noticeCount = NoticeBoardMessage::where('message_to', 3)
                ->where('is_delete', 0)
                ->count();

            $homeworkCount = Homework::where('class_id', $classId)
                ->count();

            $submittedHomeworkCount = HomeworkSubmit::where('student_id', $studentId)
                ->count();

            $attendanceCount = StudentAttendance::where('student_id', $studentId)
                ->count();

            return view('student.dashboard', compact(
                'totalPaid',
                'subjectCount',
                'noticeCount',
                'homeworkCount',
                'submittedHomeworkCount',
                'attendanceCount'
            ));
        }

public function feesCollectionReport(Request $request)
{
    $data = Student::with(['class', 'fees'])
        ->where('user_type', 3) // student
        ->when($request->class_name, function ($query, $classId) {
            $query->where('class_id', $classId);
        })
        ->when($request->student_name, function ($query, $name) {
            $query->where(function ($q) use ($name) {
                $q->where('name', 'like', "%{$name}%")
                  ->orWhere('last_name', 'like', "%{$name}%");
            });
        })
        ->whereHas('fees', function ($query) use ($request) {
            if ($request->payment_type) {
                $query->where('payment_type', $request->payment_type);
            }
        })
        ->get();

    $classes = ClassModel::pluck('name', 'id');

    return view('admin.fees.collection_report', [
        'header_title' => 'Fees Collection',
        'data' => $data,
        'classes' => $classes
    ]);
}


}