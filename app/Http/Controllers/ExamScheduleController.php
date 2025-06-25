<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamScheduleController extends Controller
{
    public function list()
    {
        $data['header_title'] = "Exam Schedule";

        $exams = Exam::all();
        $classes = ClassModel::all();
        return view('admin.exam_schedule.list', compact('exams', 'classes'), $data);
    }

    public function getSubjects($class_id, Request $request)
{
    $exam_id = $request->query('exam_id'); // dari URL

    $subjects = SubjectModel::whereIn('id', function ($q) use ($class_id) {
        $q->select('subject_id')
            ->from('class_subject')
            ->where('class_id', $class_id);
    })->get();

    $schedules = ExamSchedule::where('exam_id', $exam_id)
        ->where('class_id', $class_id)
        ->get()
        ->keyBy('subject_id');

    $result = $subjects->map(function ($subject) use ($schedules) {
        $schedule = $schedules[$subject->id] ?? null;
        return [
            'id'            => $subject->id,
            'name'          => $subject->name,
            'exam_date'     => $schedule->exam_date ?? '',
            'start_time'    => $schedule->start_time ?? '',
            'end_time'      => $schedule->end_time ?? '',
            'room_number'   => $schedule->room_number ?? '',
            'full_marks'    => $schedule->full_marks ?? '',
            'passing_marks' => $schedule->passing_marks ?? '',
        ];
    });

    return response()->json($result);
}


    public function store(Request $request)
    {
        foreach ($request->subject_id as $key => $subject_id) {
            ExamSchedule::updateOrCreate(
                [
                    'exam_id'   => $request->exam_id,
                    'class_id'  => $request->class_id,
                    'subject_id'=> $subject_id,
                ],
                [
                    'exam_date'    => $request->exam_date[$key],
                    'start_time'   => $request->start_time[$key],
                    'end_time'     => $request->end_time[$key],
                    'room_number'  => $request->room_number[$key],
                    'full_marks'    => $request->full_marks [$key],
                    'passing_marks' => $request->passing_marks[$key],
                    'created_by'    => auth()->id(),

                ]
            );
        }

        return redirect()->back()->with('success', 'Exam Schedule saved successfully!')->with('open_form', true)
        ->withInput(); ;
    }
    
}
