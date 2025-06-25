<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ClassSubjectModel;
use App\Models\AssignClassTeacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
 
class TeacherController extends Controller
{
    public function list(Request $request)
    {
        $data['header_title'] = 'Teacher List';

    $query = Teacher::where('user_type', 2)->where('is_delete', 0);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $data['getRecord'] = $query->orderBy('id', 'desc')->get();

        return view('admin.teacher.list', $data);
    }

    public function insert(Request $request)
{


    $user = new Teacher();
    $user->user_type = 2;
    $user->name = $request->name;
    $user->last_name = $request->last_name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->mobile_number = $request->mobile_number;
    $user->occupation = $request->occupation;
    $user->address = $request->address;
    $user->permanent_address = $request->permanent_address;
    $user->gender = $request->gender;
    $user->date_of_birth = $request->date_of_birth;
    $user->date_of_joining = $request->date_of_joining;
    $user->marital_status = $request->marital_status;
    $user->qualification = $request->qualification;
    $user->work_experience = $request->work_experience;
    $user->note = $request->note;
    $user->status = $request->status;
    $user->is_delete = 0;

    if ($request->hasFile('profile_pic')) {
        $file = $request->file('profile_pic');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/teacher'), $filename);
        $user->profile_pic = $filename;
    }

    $user->save();

    return redirect()->back()->with('success', 'Teacher created successfully!');
}


public function update($id, Request $request)
{
    $user = Teacher::where('id', $id)->where('user_type', 2)->firstOrFail();

    $request->validate([
        'name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
    ]);

    $user->name = $request->name;
    $user->last_name = $request->last_name;
    $user->email = $request->email;

    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    $user->mobile_number = $request->mobile_number;
    $user->occupation = $request->occupation;
    $user->address = $request->address;
    $user->permanent_address = $request->permanent_address;
    $user->gender = $request->gender;
    $user->date_of_birth = $request->date_of_birth;
    $user->date_of_joining = $request->date_of_joining;
    $user->marital_status = $request->marital_status;
    $user->qualification = $request->qualification;
    $user->work_experience = $request->work_experience;
    $user->note = $request->note;
    $user->status = $request->status;

    if ($request->hasFile('profile_pic')) {
        $file = $request->file('profile_pic');
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/teacher'), $filename);
        $user->profile_pic = $filename;
    }

    $user->save();

    return redirect()->back()->with('success', 'Teacher updated successfully!');
}

public function edit($id)
{
    $teacher = Teacher::where('id', $id)->where('user_type', 2)->firstOrFail();
    return response()->json($teacher);
}

   public function delete($id)
{
    $user = Teacher::where('id', $id)->where('user_type', 2)->firstOrFail();
    $user->is_delete = 1;
    $user->save();

    return redirect()->back()->with('success', 'Teacher deleted successfully!');
}

public function myClassSubject()
    {
        // Ambil data guru dari Auth dan pastikan user_type = 2
        $teacher = Teacher::where('id', Auth::id())
                          ->where('user_type', 2)
                          ->where('is_delete', 0)
                          ->first();

        if (!$teacher) {
            abort(403, 'Unauthorized');
        }

        // Ambil semua class_id yang diberikan ke guru
        $assignedClassIds = AssignClassTeacher::where('teacher_id', $teacher->id)
            ->pluck('class_id');

        // Ambil subject dari class tersebut via table class_subject
        $subjects = ClassSubjectModel::with(['subject', 'class'])
            ->whereIn('class_id', $assignedClassIds)
            ->get();

        return view('teacher.assignsubject.my_subject', [
            'header_title' => 'My Class & Subject',
            'subjects' => $subjects,
        ]);
    }

}
