<?php
namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Student;
use App\Models\ExamSchedule;
use App\Models\MarksRegister;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    // Private helper untuk mendapatkan semua grade dan mencari grade berdasarkan percent
    private function gradeLookup($percent)
{
    static $grades = null;
    if ($grades === null) {
        $grades = \DB::table('marks_grade')->get();
    }

    // Bulatkan persen ke bawah atau terdekat
    $percent = round($percent); // atau floor($percent) jika kamu mau lebih ketat

    foreach ($grades as $g) {
        if ($percent >= $g->percent_from && $percent <= $g->percent_to) {
            return $g->name;
        }
    }

    return '-';
}


    public function index()
    {
        $data['header_title'] = "My Exam Result";
        $studentId = auth()->id();
        $classId = auth()->user()->class_id;

        $exams = Exam::whereIn('id', function ($query) use ($classId) {
            $query->select('exam_id')
                ->from('exam_schedule_insert')
                ->where('class_id', $classId);
        })->get();

        $allResults = [];

        foreach ($exams as $exam) {
            $schedules = ExamSchedule::with('subject')
                ->where('exam_id', $exam->id)
                ->where('class_id', $classId)
                ->get();

            $marks = MarksRegister::where('student_id', $studentId)
                ->where('exam_id', $exam->id)
                ->where('class_id', $classId)
                ->get()
                ->keyBy('subject_id');

            $totalScore = $totalFull = 0;
            $overallResult = 'Pass';
            $results = [];

            foreach ($schedules as $sch) {
                $subj = $sch->subject;
                $subjectName = $subj ? $subj->name : 'Unknown Subject';

                $mk = $marks[$sch->subject_id] ?? null;
                $cw = $mk->class_work ?? 0;
                $hw = $mk->home_work ?? 0;
                $tw = $mk->test_work ?? 0;
                $ex = $mk->exam ?? 0;
                $tot = $cw + $hw + $tw + $ex;
                $full = $sch->full_marks;
                $passMark = $sch->passing_marks;

                $res = $tot >= $passMark ? 'Pass' : 'Fail';
                if ($res == 'Fail') $overallResult = 'Fail';

                $percent = $full > 0 ? round(($tot / $full) * 100, 2) : 0; // bulatkan 2 decimal
                $grade = $this->gradeLookup($percent);

                $totalScore += $tot;
                $totalFull += $full;

                $results[] = [
                    'subject_name' => $subjectName,
                    'class_work' => $cw,
                    'test_work' => $tw,
                    'home_work' => $hw,
                    'exam' => $ex,
                    'total' => $tot,
                    'passing_marks' => $passMark,
                    'full_marks' => $full,
                    'percent' => $percent,
                    'grade' => $grade,
                    'result' => $res
                ];
            }

            $percentage = $totalFull > 0 ? round(($totalScore / $totalFull) * 100, 2) : 0; // bulatkan 2 decimal
            $overallGrade = $this->gradeLookup($percentage);

            $allResults[] = [
                'exam' => $exam,
                'results' => $results,
                'totalScore' => $totalScore,
                'totalFullMarks' => $totalFull,
                'percentage' => $percentage,
                'overallResult' => $overallResult,
                'overallGrade' => $overallGrade,
            ];
        }

        return view('student.exam_result.index', compact('exams','allResults'), $data);
    }

    public function parentExamResult($studentId)
    {
        $parentId = auth()->id();
        $student = Student::where('id', $studentId)
            ->where('parent_id', $parentId)
            ->where('is_delete', 0)
            ->firstOrFail();

        $exams = Exam::all();
        $allResults = [];

        foreach ($exams as $exam) {
            $marks = MarksRegister::where('student_id', $student->id)
                         ->where('exam_id', $exam->id)
                         ->get();

            $totalScore = $totalFull = 0;
            $results = [];

            foreach ($marks as $mk) {
                $tot = $mk->class_work + $mk->test_work + $mk->home_work + $mk->exam;
                $full = $mk->full_marks;
                $passMark = $mk->passing_marks;

                $res = $tot >= $passMark ? 'Pass' : 'Fail';
                $percent = $full > 0 ? round(($tot / $full) * 100, 2) : 0; // bulatkan 2 decimal
                $grade = $this->gradeLookup($percent);

                $totalScore += $tot;
                $totalFull += $full;

                $results[] = [
                    'subject_name' => $mk->subject->name ?? 'N/A',
                    'class_work' => $mk->class_work,
                    'test_work' => $mk->test_work,
                    'home_work' => $mk->home_work,
                    'exam' => $mk->exam,
                    'total' => $tot,
                    'passing_marks' => $passMark,
                    'full_marks' => $full,
                    'result' => $res,
                    'percent' => $percent,
                    'grade' => $grade,
                ];
            }

            $percentage = $totalFull > 0 ? round(($totalScore / $totalFull) * 100, 2) : 0; // bulatkan 2 decimal
            $overallGrade = $this->gradeLookup($percentage);
            $overallResult = $percentage >= 50 ? 'Pass' : 'Fail';

            $allResults[] = [
                'exam' => $exam,
                'results' => $results,
                'totalScore' => $totalScore,
                'totalFullMarks' => $totalFull,
                'percentage' => $percentage,
                'overallResult' => $overallResult,
                'overallGrade' => $overallGrade,
            ];
        }

        $header_title = 'Exam Results for: ' . $student->name;
        return view('parent.student.exam_result', compact('exams','allResults','student','header_title'));
    }
}
