<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\FeesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\MarksGradeController;
use App\Http\Controllers\NoticeBoardController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\ExamScheduleController;
use App\Http\Controllers\AssignSubjectController;
use App\Http\Controllers\ExamTimetableController;
use App\Http\Controllers\MarksRegisterController;
use App\Http\Controllers\ClassTimetableController;
use App\Http\Controllers\HomeworkSubmitController;
use App\Http\Controllers\StudenHomeworkController;
use App\Http\Controllers\TeacherStudentController;
use App\Http\Controllers\TeacherHomeworkController;
use App\Http\Controllers\ParentShowStudentController;
use App\Http\Controllers\StudentAttendanceController;
use App\Http\Controllers\AssignClassTeacherController;
use App\Http\Controllers\StudentShowSubjectController;
use App\Http\Controllers\TeacherClassSubjectController;
use App\Http\Controllers\StudentExamTimetableController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[AuthController::class, 'login']);
Route::post('login',[AuthController::class, 'AuthLogin']);
Route::get('logout',[AuthController::class, 'logout']);
Route::get('forgot-password',[AuthController::class, 'forgotpassword']);
Route::post('forgot-password',[AuthController::class, 'PostForgotPassword']);

// My Account route (accessible for all roles)
Route::middleware(['auth'])->group(function () {
    Route::get('/my-account', [ProfileController::class, 'editProfile'])->name('myAccount');
    Route::post('/my-account', [ProfileController::class, 'updateProfile'])->name('updateMyAccount');
    Route::post('/my-account/change-password', [ProfileController::class, 'updatePassword'])->name('changeMyPassword'); // ⬅️ ini ditambahkan

});


Route::get('admin/admin/list', function() {
    return view('admin.admin.list');
});

Route::group(['middleware' => 'admin'], function () {
    Route::resource('admin/homework', HomeworkController::class)->except(['create', 'edit', 'show']);

    // Get subjects by class
    Route::get('admin/get-subjects-by-class/{class_id}', [HomeworkController::class, 'getSubjectsByClass']);

    // Custom delete route (sudah di-cover oleh resource, tapi jika ingin manual)
    Route::delete('admin/homework/{homework}', [HomeworkController::class, 'destroy']);
    //route notice board
    Route::get('admin/notice-board', [NoticeBoardController::class, 'index'])->name('notice_board.index');
    Route::post('admin/notice-board', [NoticeBoardController::class, 'store'])->name('notice_board.store');
    Route::put('admin/notice-board/{id}', [NoticeBoardController::class, 'update'])->name('notice_board.update');
    // Route::delete('admin/notice-board/{id}', [NoticeBoardController::class, 'destroy'])->name('notice_board.destroy');
    Route::delete('notice-board/{id}', [NoticeBoardController::class, 'destroy'])->name('notice_board.destroy');

    //route student attendance
    Route::get('admin/student-attendance', [StudentAttendanceController::class, 'list'])->name('student.attendance');
    Route::get('admin/student-attendance/get-students/{class_id}', [StudentAttendanceController::class, 'getStudents'])->name('student.attendance.get_students');
    Route::post('admin/student-attendance/save', [StudentAttendanceController::class, 'store'])->name('student.attendance.save');
    Route::post('admin/student-attendance/save-single', [StudentAttendanceController::class, 'saveSingle'])->name('student.attendance.save.single');
    //route Attendance Report
    Route::get('admin/student-attendance-report', [StudentAttendanceController::class, 'attendanceReport'])->name('student.attendance.report');

    //route marks grade
    Route::get('admin/marks-grade/list', [MarksGradeController::class, 'list']);
    Route::post('admin/marks-grade/list', [MarksGradeController::class, 'insert']);
    Route::post('admin/marks-grade/update/{id}', [MarksGradeController::class, 'update']);
    Route::get('admin/marks-grade/delete/{id}', [MarksGradeController::class, 'delete']);
    
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('admin/admin/list', [AdminController::class, 'list']);
    Route::post('admin/admin/list', [AdminController::class, 'insert']);
    Route::post('admin/admin/list/{id}', [AdminController::class, 'edit']);
    Route::post('admin/admin/update/{id}', [AdminController::class, 'update']);
    Route::delete('admin/admin/delete/{id}', [AdminController::class, 'delete']);
    //exam schedule route
    Route::get('admin/exam-schedule/list', [ExamScheduleController::class, 'list'])->name('exam.schedule');
    Route::post('admin/exam-schedule/store', [ExamScheduleController::class, 'store'])->name('exam.schedule.store');
    Route::get('admin/get-subjects/{class_id}', [ExamScheduleController::class, 'getSubjects']);    
    Route::get('admin/get-subjects/{class_id}', [ExamScheduleController::class, 'getSubjects']);

    // exam route
    Route::get('admin/exam/list', [ExamController::class, 'list'])->name('admin.exam.list');
    Route::post('admin/exam/insert', [ExamController::class, 'insert'])->name('admin.exam.insert');
    Route::post('admin/exam/update/{id}', [ExamController::class, 'update'])->name('admin.exam.update');
    Route::get('admin/exam/delete/{id}', [ExamController::class, 'delete'])->name('admin.exam.delete');
    // Parent route
    Route::get('admin/parent/list', [ParentController::class, 'list']);
    Route::post('admin/parent/insert', [ParentController::class, 'insert']);
    Route::post('admin/parent/update/{id}', [ParentController::class, 'update']); // update pakai ID dari form
    Route::get('admin/parent/delete/{id}', [ParentController::class, 'delete']); // pakai GET, sudah sesuai tombol di view
    Route::get('admin/parent/add-child/{parent_id}', [ParentController::class, 'addChild']);
    Route::get('admin/parent/assign-child/{student_id}/{parent_id}', [ParentController::class, 'assignChild']);
    Route::get('admin/parent/remove-child/{student_id}', [ParentController::class, 'removeChild']);
    //Teacher route
    Route::get('admin/teacher/list', [TeacherController::class, 'list']);
    Route::post('admin/teacher/insert', [TeacherController::class, 'insert']);
    Route::post('admin/teacher/update/{id}', [TeacherController::class, 'update']);
    Route::get('admin/teacher/delete/{id}', [TeacherController::class, 'delete']);
    Route::get('admin/teacher/{id}/edit', [TeacherController::class, 'edit']);


    //Student route
    Route::get('admin/student/list', [StudentController::class, 'list']);
    Route::post('admin/student/add', [StudentController::class, 'insert']);
    Route::post('admin/student/update/{id}', [StudentController::class, 'update']);
    Route::get('admin/student/delete/{id}', [StudentController::class, 'delete']);

    // Class route
    Route::get('admin/class/list', [ClassController::class, 'list']);
    Route::post('admin/class/list', [ClassController::class, 'insert']);
    Route::post('admin/class/update/{id}', [ClassController::class, 'update']);
    Route::get('admin/class/delete/{id}', [ClassController::class, 'delete']);

    // Subject route
    Route::get('admin/subject/list', [SubjectController::class, 'list']);
    Route::post('admin/subject/list', [SubjectController::class, 'insert']);
    Route::post('admin/subject/update/{id}', [SubjectController::class, 'update']);
    Route::get('admin/subject/delete/{id}', [SubjectController::class, 'delete']);

    // Class subject route
    Route::get('admin/assign_subject/list', [ClassSubjectController::class, 'list'])->name('admin.assign_subject.list');
    Route::post('admin/assign_subject/insert', [ClassSubjectController::class, 'insert'])->name('admin.assign_subject.insert');
    Route::post('admin/assign_subject/update/{id}', [ClassSubjectController::class, 'update'])->name('admin.assign_subject.update');
    Route::delete('admin/assign_subject/delete/{id}', [ClassSubjectController::class, 'delete'])->name('admin.assign_subject.delete');

    // Assign Class Teacher route
    Route::get('admin/assign_class_teacher/list', [AssignClassTeacherController::class, 'list']);
    Route::post('admin/assign_class_teacher/insert', [AssignClassTeacherController::class, 'insert'])->name('admin.assign_class_teacher.insert');
    Route::post('admin/assign_class_teacher/update/{id}', [AssignClassTeacherController::class, 'update']);
    Route::delete('admin/assign_class_teacher/delete/{id}', [AssignClassTeacherController::class, 'delete']);
    // Class Timetable to Class route
   Route::get('admin/class_timetable/list', [ClassTimetableController::class, 'list']);
    Route::post('admin/class_timetable/save', [ClassTimetableController::class, 'save']);
    Route::get('admin/get-subject-by-class/{class_id}', [ClassTimetableController::class, 'getSubjectsByClass']);
    //route marks register
    Route::get('admin/register', [MarksRegisterController::class, 'index'])->name('marks.register.index');
    Route::post('admin/register/save', [MarksRegisterController::class, 'save'])->name('marks.register.save');
    Route::post('admin/register/save-subject', [MarksRegisterController::class, 'saveSubject'])->name('marks.register.subject.save');

    Route::get('admin/homework/{homework_id}/submitted', [HomeworkSubmitController::class, 'viewSubmitted'])
    ->name('homework.submitted.admin');
    Route::get('admin/homework-report', [HomeworkController::class, 'adminStudentHomeworkReport'])->name('admin.homework.report');

    // fees route
    Route::get('fees', [FeesController::class, 'index'])->name('admin.fees.index');
    Route::get('fees/collect/{student_id}', [FeesController::class, 'collectFees'])->name('admin.fees.collect');
    Route::post('fees/store', [FeesController::class, 'storePayment'])->name('admin.fees.store');
        Route::get('fees/collection-report', [FeesController::class, 'feesCollectionReport'])->name('fees.collection_report');

});


Route::group(['middleware' => 'teacher'], function () {
    Route::get('teacher/dashboard',[DashboardController::class, 'dashboard']);
Route::get('teacher/dashboard', [DashboardController::class, 'teacherDashboard'])->name('teacher.dashboard');

    Route::get('teacher/my-class-subject', [TeacherClassSubjectController::class, 'myClassSubject'])->name('teacher.class.subject');
    Route::get('teacher/students', [TeacherStudentController::class, 'myStudentList'])->name('teacher.students');
    Route::get('teacher/class-subject-timetable/{class_id}/{subject_id}', [ClassTimetableController::class, 'teacherTimetable'])->name('teacher.class.subject.timetable');
    Route::get('teacher/my-exam-timetable', [ExamTimetableController::class, 'teacherExamTimetable'])->name('teacher.exam.timetable');
    Route::get('teacher/calendar', [CalendarController::class, 'teacherCalendar'])->name('teacher.calendar');
    Route::get('teacher/calendar/events', [CalendarController::class, 'teacherCalendarEvents'])->name('teacher.calendar.events');
      // Teacher marks register
    Route::get('teacher/marks/register', [MarksRegisterController::class, 'teacherIndex'])->name('teacher.marks.register.index');
    Route::post('teacher/marks/register/save', [MarksRegisterController::class, 'teacherSaveAll'])->name('teacher.marks.register.save');
    Route::post('teacher/marks/register/save-subject', [MarksRegisterController::class, 'teacherSaveSubject'])->name('teacher.marks.register.subject.save');
    //route Teacher Student Attendance
    Route::get('teacher/student-attendance', [StudentAttendanceController::class, 'TeacherIndex'])->name('teacher.student.attendance');
    Route::get('teacher/student-attendance/get-students/{class_id}', [StudentAttendanceController::class, 'TeacherGetStudents']);
    Route::post('teacher/student-attendance/save-single', [StudentAttendanceController::class, 'TeacherSaveSingle'])->name('student.attendance.save.single');
    //teacer report attendance
    Route::get('teacher/student-attendance-report', [StudentAttendanceController::class, 'TeacherAttendanceReport'])->name('teacher.student.attendance.report');
    //route teacher notice board
    Route::get('teacher/notice-board', [NoticeBoardController::class, 'teacherNoticeBoard'])->name('teacher.notice_board');
    Route::get('homework', [TeacherHomeworkController::class, 'index'])->name('teacher.homework.index');
    Route::post('homework', [TeacherHomeworkController::class, 'store'])->name('teacher.homework.store');
    Route::put('homework/{id}', [TeacherHomeworkController::class, 'update'])->name('teacher.homework.update');
    Route::delete('homework/{id}', [TeacherHomeworkController::class, 'destroy'])->name('teacher.homework.destroy');

    // Dynamic subjects by class_id
    Route::get('teacher/get-subjects/{class_id}', [TeacherHomeworkController::class, 'getSubjects']);

    Route::get('teacher/homework/{homework_id}/submitted', [HomeworkSubmitController::class, 'viewSubmitted'])
    ->name('homework.submitted.teacher');
});




Route::group(['middleware' => 'student'], function () {

    Route::get('student/dashboard',[DashboardController::class, 'dashboard']);
        Route::get('student/dashboard', [DashboardController::class, 'studentDashboard'])->name('student.dashboard');

    Route::get('student/my-subject', [StudentShowSubjectController::class, 'index']);
    Route::get('student/my-class-timetable', [ClassTimetableController::class, 'studentTimetable']);
    Route::get('student/my-exam-timetable', [StudentExamTimetableController::class, 'index'])->name('student.exam-timetable');
    Route::get('student/my-calendar', [CalendarController::class, 'studentCalendar'])->name('student.calendar');
    Route::get('student/calendar/events', [CalendarController::class, 'studentCalendarEvents'])->name('student.calendar.events');
    // route result marks
    Route::get('student/my-exam-result', [ExamResultController::class, 'index'])->name('student.exam.result');
    //route student attendance
    Route::get('student/attendance', [StudentAttendanceController::class, 'studentAttendance'])->name('student.attendance');
    //route student notice board
    Route::get('student/notice-board', [NoticeBoardController::class, 'studentNoticeBoard'])->name('student.notice_board');
    Route::get('student/my-homework', [StudenHomeworkController::class, 'index'])->name('student.my_homework');
    Route::post('student/homework-submit', [HomeworkSubmitController::class, 'store'])->name('student.homework.submit');
    Route::get('student/homework/submitted', [StudenHomeworkController::class, 'submitted'])->name('student.homework.submitted');
        Route::get('student/fees-collection', [FeesController::class, 'studentFees'])->name('fees.collection');

});

Route::group(['middleware' => 'parent'], function () {
    Route::get('parent/dashboard',[DashboardController::class, 'dashboard']);
        Route::get('parent/dashboard', [DashboardController::class, 'parentDashboard'])->name('parent.dashboard');

    Route::get('parent/exam_result/{studentId}', [ExamResultController::class, 'parentExamResult'])->name('parent.exam_result');
    Route::get('parent/my-students', [ParentShowStudentController::class, 'myStudents']);
    Route::get('parent/student/{id}/subjects', [ParentShowStudentController::class, 'showStudentSubjects'])->name('parent.student.subjects');
    Route::get('parent/student/{student_id}/class/{class_id}/subject/{subject_id}/timetable', [ClassTimetableController::class, 'parentStudentTimetable'])->name('parent.student.timetable');
    Route::get('parent/student/{student_id}/exam-timetable', [ExamTimetableController::class, 'parentStudentExamTimetable'])->name('parent.student.exam.timetable');
     Route::get('parent/student/{student_id}/calendar', [CalendarController::class, 'parentStudentCalendar'])->name('parent.student.calendar');
    Route::get('parent/student/{student_id}/calendar/events', [CalendarController::class, 'parentStudentCalendarEvents'])->name('parent.student.calendar.events');
    //route student attendance
    Route::get('parent/student-attendance', [StudentAttendanceController::class, 'ParentIndex'])->name('parent.student.attendance');
    Route::get('parent/student-attendance/{student_id}', [StudentAttendanceController::class, 'ParentAttendanceDetail'])->name('parent.student.attendance.detail');
    //route parent notice board
   Route::get('parent/notice-board', [NoticeBoardController::class, 'parentNoticeBoard'])->name('parent.notice_board');
    Route::get('parent/student-notice-board', [NoticeBoardController::class, 'parentStudentNoticeBoard'])->name('parent.student.notice_board');
    Route::get('student/{student_id}/homework', [HomeworkController::class, 'parentStudentHomework'])->name('parent.student.homework');
    Route::get('student/{student_id}/homework/submitted', [HomeworkController::class, 'parentStudentSubmittedHomework'])->name('parent.student.homework.submitted');
    Route::get('parent/student/fees/{student_id}', [FeesController::class, 'parentStudentFees'])->name('parent.student.fees');

});