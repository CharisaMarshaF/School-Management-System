<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class StudentExamTimetableController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan user memiliki class_id
        $classId = $user->class_id;

        if (!$classId) {
            return redirect()->back()->with('error', 'Class not assigned to student.');
        }

        // Ambil jadwal exam berdasar class_id student
        // Join exam_schedule, exam, subject, week (hari)
        $timetablesRaw = DB::table('exam_schedule_insert as es')
            ->join('exam', 'es.exam_id', '=', 'exam.id')
            ->join('subject', 'es.subject_id', '=', 'subject.id')
            ->where('es.class_id', $classId)
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

        $timetable = [];

        foreach ($timetablesRaw as $item) {
            $exam = $item->exam_name;

            if (!isset($timetable[$exam])) {
                $timetable[$exam] = [];
            }

            $timetable[$exam][] = [
                'subject_name' => $item->subject_name,
                'exam_date' => $item->exam_date,
                'start_time' => $item->start_time,
                'end_time' => $item->end_time,
                'room_number' => $item->room_number,
            ];
        }


        return view('student.exam-timetable.index', [
            'timetable' => $timetable,
            'header_title' => 'My Exam Timetable'
        ]);
    }
}
