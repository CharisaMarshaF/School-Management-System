<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Week;
use App\Models\ClassSubjectModel;
class ExamTimetableController extends Controller
{
    // Method untuk teacher exam timetable
    public function teacherExamTimetable()
    {
        $teacherId = Auth::id();

        // Ambil semua kelas yang diampu teacher dari assign_class_teacher
        $classes = DB::table('assign_class_teacher as act')
            ->join('class as c', 'act.class_id', '=', 'c.id')
            ->where('act.teacher_id', $teacherId)
            ->where('act.status', 0) // aktif
            ->select('c.id', 'c.name')
            ->distinct()
            ->get();

        $data = [];

        foreach ($classes as $class) {
            // Ambil semua exam schedule untuk kelas ini dengan relasi exam, subject, week
            $timetablesRaw = DB::table('exam_schedule_insert as es')
                ->join('exam', 'es.exam_id', '=', 'exam.id')
                ->join('subject', 'es.subject_id', '=', 'subject.id')
                ->where('es.class_id', $class->id)
                ->orderBy('exam.name')
                ->orderBy('subject.name')
                ->select(
                    'exam.name as exam_name',
                    'subject.name as subject_name',
                    'es.exam_date',
                    'es.start_time',
                    'es.end_time',
                    'es.room_number',
                )
                ->get();

            // Struktur data: group by exam name, tiap exam ada array subject schedule
            $timetableByExam = [];
            foreach ($timetablesRaw as $item) {
                $exam = $item->exam_name;

                if (!isset($timetableByExam[$exam])) {
                    $timetableByExam[$exam] = [];
                }

                $timetableByExam[$exam][] = [
                    'subject_name' => $item->subject_name,
                    'exam_date' => $item->exam_date,
                    'start_time' => $item->start_time,
                    'end_time' => $item->end_time,
                    'room_number' => $item->room_number,
                ];
            }

            $data[] = [
                'class_id' => $class->id,
                'class_name' => $class->name,
                'timetable' => $timetableByExam,
            ];
        }

        return view('teacher.exam_timetable.list', [
            'header_title' => 'My Exam Timetable',
            'classes_timetable' => $data,
        ]);
    }

    public function parentStudentExamTimetable($student_id)
    {
        $student = Student::where('id', $student_id)->where('user_type', 3)->first();

        if (!$student || $student->parent_id != auth()->user()->id) {
            return redirect()->back()->with('error', 'Unauthorized or student not found');
        }

        $class_id = $student->class_id;

        // Ambil semua jadwal ujian berdasarkan class_id
        $examSchedules = ExamSchedule::with(['exam', 'subject'])
            ->where('class_id', $class_id)
            ->get();

        // Struktur: [exam_name => [subject_name => [jadwal...]]]
        $timetable = [];

        foreach ($examSchedules as $schedule) {
            $examName = $schedule->exam->name ?? 'Unknown Exam';
            $subjectName = $schedule->subject->name ?? 'Unknown Subject';

            $timetable[$examName][$subjectName][] = [
                'exam_date' => $schedule->exam_date,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'room_number' => $schedule->room_number,
            ];
        }

        return view('parent.student.exam_timetable', [
            'header_title' => 'Exam Timetable',
            'student' => $student,
            'timetable' => $timetable,
        ]);
    }
}
