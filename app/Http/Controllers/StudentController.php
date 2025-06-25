<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function list(Request $request)
    {
        $data['header_title'] = "Student List";
        $query = Student::with('class')
            ->where('user_type', 3)
            ->where('is_delete', 0);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('admission_number', 'like', '%' . $search . '%')
                ->orWhere('mobile_number', 'like', '%' . $search . '%');
            });
        }

        $data['getRecord'] = $query->get();

        return view('admin.student.list', $data);
    }

    public function insert(Request $request)
    {
        $student = new Student;
        $student->name = $request->name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->address = $request->address;
        $student->password = Hash::make($request->password);
        $student->user_type = 3;
        $student->admission_number = $request->admission_number;
        $student->role_number = $request->role_number;
        $student->class_id = $request->class_id;
        $student->gender = $request->gender;
        $student->date_of_birth = $request->date_of_birth;
        $student->religion = $request->religion;
        $student->mobile_number = $request->mobile_number;
        $student->admission_date = $request->admission_date;
        $student->blood_group = $request->blood_group;
        $student->height = $request->height;
        $student->weight = $request->weight;
        $student->status = $request->status;
        $student->is_delete = 0;
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/students'), $filename);
            $student->profile_pic = $filename;
        }
        $student->save();

        return redirect()->back()->with('success', 'Student successfully added');
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) return redirect()->back()->with('error', 'Student not found');

        $student->name = $request->name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;

        if (!empty($request->password)) {
            $student->password = Hash::make($request->password);
        }

        $student->admission_number = $request->admission_number;
        $student->role_number = $request->role_number;
        $student->class_id = $request->class_id;
        $student->gender = $request->gender;
        $student->address = $request->address;
        $student->date_of_birth = $request->date_of_birth;
        $student->religion = $request->religion;
        $student->mobile_number = $request->mobile_number;
        $student->admission_date = $request->admission_date;
        $student->blood_group = $request->blood_group;
        $student->height = $request->height;
        $student->weight = $request->weight;
        $student->status = $request->status;
        if ($request->hasFile('profile_pic')) {
            // Hapus gambar lama jika ada
            if ($student->profile_pic && file_exists(public_path('uploads/students/' . $student->profile_pic))) {
                File::delete(public_path('uploads/students/' . $student->profile_pic));
            }

            $file = $request->file('profile_pic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/students'), $filename);
            $student->profile_pic = $filename;
        }

        $student->save();

        return redirect()->back()->with('success', 'Student successfully updated');
    }

    public function delete($id)
    {
        $student = Student::find($id);
        if ($student) {
            $student->is_delete = 1;
            $student->save();
        }
        return redirect()->back()->with('success', 'Student deleted');
    }
}
