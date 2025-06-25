<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\ClassSubjectTimeTable;
use App\Models\ExamSchedule;
use Illuminate\Support\Facades\Log;
use App\Models\AssignClassTeacher;

class CalendarController extends Controller
{
    public function studentCalendar()
    {
        $student = Auth::user();
        return view('student.calendar.index', [
            'header_title' => 'My Academic Calendar',
            'student' => $student
        ]);
    }

public function studentCalendarEvents()
{
    try {
        $student = Auth::user();
        $class_id = $student->class_id;

        $events = [];

        // Ambil jadwal kelas mingguan
        $classSchedules = ClassSubjectTimeTable::with('subject', 'week')
            ->where('class_id', $class_id)
            ->get();

        foreach ($classSchedules as $schedule) {
            for ($i = 0; $i < 4; $i++) {
                $date = now()->startOfWeek()->addWeeks($i)->addDays($schedule->week->id - 1)->format('Y-m-d');
                $events[] = [
                    'title' => '[Class] ' . (optional($schedule->subject)->name ?? 'Civic'),
                    'start' => $date . 'T' . $schedule->start_time,
                    'end'   => $date . 'T' . $schedule->end_time,
                    'backgroundColor' => '#28a745',
                    'textColor' => '#ffffff',
                    'allDay' => false,
                ];
            }
        }

        // Ambil jadwal ujian
        Log::info('Fetching exam schedules for class_id: ' . $class_id);

        $examSchedules = ExamSchedule::with('subject', 'exam')
            ->where('class_id', $class_id)
            ->get();

        foreach ($examSchedules as $exam) {
            $events[] = [
                'title' => '[Exam] ' . 
                    (optional($exam->subject)->name ?? 'Civic') . 
                    ' - ' . (optional($exam->exam)->name ?? 'Civic'),
                'start' => $exam->exam_date . 'T' . $exam->start_time,
                'end'   => $exam->exam_date . 'T' . $exam->end_time,
                'backgroundColor' => '#dc3545',
                'textColor' => '#ffffff',
                'allDay' => false,
            ];
        }

        return response()->json($events);

    } catch (\Exception $e) {
        Log::error('Calendar Event Error: ' . $e->getMessage());
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}


    // --- Parent viewing student's calendar ---
    public function parentStudentCalendar($student_id)
    {
        // Pastikan parent hanya bisa melihat anaknya sendiri
        $parent = Auth::user();
        $student = Student::where('id', $student_id)->where('parent_id', $parent->id)->firstOrFail();

        return view('parent.student.calendar', [
            'header_title' => 'Student Academic Calendar',
            'student' => $student
        ]);
    }

public function parentStudentCalendarEvents($student_id)
{
    try {
        $parent = Auth::user();

        // Pastikan student milik parent yang sedang login
        $student = Student::where('id', $student_id)
            ->where('parent_id', $parent->id)
            ->firstOrFail();

        $class_id = $student->class_id;
        $events = [];

        // Ambil jadwal kelas (Class Timetable)
        $classSchedules = ClassSubjectTimeTable::with('subject', 'week')
            ->where('class_id', $class_id)
            ->get();

        foreach ($classSchedules as $schedule) {
            for ($i = 0; $i < 4; $i++) {
                $date = now()->startOfWeek()->addWeeks($i)->addDays($schedule->week->id - 1)->format('Y-m-d');
                $events[] = [
                    'title' => '[Class] ' . (optional($schedule->subject)->name ?? 'Civic'),
                    'start' => $date . 'T' . $schedule->start_time,
                    'end'   => $date . 'T' . $schedule->end_time,
                    'backgroundColor' => '#28a745',
                    'textColor' => '#ffffff',
                    'allDay' => false,
                ];
            }
        }

        // Ambil jadwal ujian
        $examSchedules = ExamSchedule::with('subject', 'exam')
            ->where('class_id', $class_id)
            ->get();

        foreach ($examSchedules as $exam) {
            $events[] = [
                'title' => '[Exam] ' .
                    (optional($exam->subject)->name ?? 'Civic') .
                    ' - ' . (optional($exam->exam)->name ?? 'Civic'),
                'start' => $exam->exam_date . 'T' . $exam->start_time,
                'end'   => $exam->exam_date . 'T' . $exam->end_time,
                'backgroundColor' => '#dc3545',
                'textColor' => '#ffffff',
                'allDay' => false,
            ];
        }

        return response()->json($events);

    } catch (\Exception $e) {
        Log::error('Parent Student Calendar Events Error: ' . $e->getMessage());
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}

    public function teacherCalendar()
    {
        $teacher = Auth::user();
        return view('teacher.calendar.index', [
            'header_title' => 'My Academic Calendar',
            'teacher' => $teacher
        ]);
    }

public function teacherCalendarEvents()
{
    try {
        $teacher_id = Auth::id(); // User login dengan user_type 2 (teacher)
        $events = [];

        // Ambil semua class yang diajar oleh teacher
        $assignedClasses = AssignClassTeacher::with('class')
            ->where('teacher_id', $teacher_id)
            ->where('status', 0)
            ->get();

        foreach ($assignedClasses as $assignment) {
            $class_id = $assignment->class_id;
            $class_name = optional($assignment->class)->name ?? 'Civic';

            // Class Timetable
            $classSchedules = ClassSubjectTimeTable::with('subject', 'week')
                ->where('class_id', $class_id)
                ->get();

            foreach ($classSchedules as $schedule) {
                for ($i = 0; $i < 4; $i++) {
                    $date = now()->startOfWeek()->addWeeks($i)->addDays($schedule->week->id - 1)->format('Y-m-d');
                    $events[] = [
                        'title' => '[Class] ' . (optional($schedule->subject)->name ?? 'Civic') . ' - ' . $class_name,
                        'start' => $date . 'T' . $schedule->start_time,
                        'end'   => $date . 'T' . $schedule->end_time,
                        'backgroundColor' => '#28a745',
                        'textColor' => '#ffffff',
                        'allDay' => false,
                    ];
                }
            }

            // Exam Timetable
            $examSchedules = ExamSchedule::with('subject', 'exam')
                ->where('class_id', $class_id)
                ->get();

            foreach ($examSchedules as $exam) {
                $events[] = [
                    'title' => '[Exam] ' .
                        (optional($exam->subject)->name ?? 'Civic') .
                        ' - ' . (optional($exam->exam)->name ?? 'Civic') .
                        ' - ' . $class_name,
                    'start' => $exam->exam_date . 'T' . $exam->start_time,
                    'end'   => $exam->exam_date . 'T' . $exam->end_time,
                    'backgroundColor' => '#dc3545',
                    'textColor' => '#ffffff',
                    'allDay' => false,
                ];
            }
        }

        return response()->json($events);

    } catch (\Exception $e) {
        Log::error('Teacher Calendar Event Error: ' . $e->getMessage());
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}

}
