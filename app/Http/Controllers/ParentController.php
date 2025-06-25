<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParentUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\Student;

class ParentController extends Controller
{
    public function list(Request $request)
    {
        $data['header_title'] = "Parent List";

        $query = ParentUser::where('user_type', 4)
            ->where('is_delete', 0);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('mobile_number', 'like', '%' . $search . '%');
            });
        }

        $data['getRecord'] = $query->get();

        return view('admin.parent.list', $data);
    }

    public function insert(Request $request)
    {
       
        $parent = new ParentUser;
        $parent->name = $request->name;
        $parent->last_name = $request->last_name;
        $parent->email = $request->email;
        $parent->password = Hash::make($request->password);
        $parent->user_type = 4; // parent
        $parent->mobile_number = $request->mobile_number;
        $parent->occupation = $request->occupation;
        $parent->address = $request->address;
        $parent->gender = $request->gender;
        $parent->status = $request->status;
        $parent->is_delete = 0;

        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/parent'), $filename);
            $parent->profile_pic = $filename;
        }

        $parent->save();

        return redirect()->back()->with('success', 'Parent successfully added');
    }

    public function update(Request $request, $id)
    {
        $parent = ParentUser::find($id);
        if (!$parent) {
            return redirect()->back()->with('error', 'Parent not found');
        }

        $parent->name = $request->name;
        $parent->last_name = $request->last_name;
        $parent->email = $request->email;

        if (!empty($request->password)) {
            $parent->password = Hash::make($request->password);
        }

        $parent->mobile_number = $request->mobile_number;
        $parent->occupation = $request->occupation;
        $parent->address = $request->address;
        $parent->gender = $request->gender;
        $parent->status = $request->status;

        if ($request->hasFile('profile_pic')) {
            // Hapus gambar lama jika ada
            if ($parent->profile_pic && file_exists(public_path('uploads/parent/' . $parent->profile_pic))) {
                File::delete(public_path('uploads/parent/' . $parent->profile_pic));
            }

            $file = $request->file('profile_pic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/parent'), $filename);
            $parent->profile_pic = $filename;
        }

        $parent->save();

        return redirect()->back()->with('success', 'Parent successfully updated');
    }

    public function delete($id)
    {
        $parent = ParentUser::find($id);
        if ($parent) {
            $parent->is_delete = 1;
            $parent->save();
        }
        return redirect()->back()->with('success', 'Parent deleted');
    }


    //asign student to parent
    public function addChild($parent_id)
    {
        $data['header_title'] = "Assign Student to Parent";
        $data['parent_id'] = $parent_id;

        // Ambil student yang belum punya parent dan user_type = 3
        $data['availableStudents'] = Student::whereNull('parent_id')
            ->where('is_delete', 0)
            ->whereHas('user', function ($q) {
                $q->where('user_type', 3);
            })
            ->get();

        // Ambil student yang sudah punya parent dan user_type = 3
        $data['assignedStudents'] = Student::where('parent_id', $parent_id)
            ->where('is_delete', 0)
            ->whereHas('user', function ($q) {
                $q->where('user_type', 3);
            })
            ->get();

        return view('admin.parent.add_child', $data);
    }


    public function assignChild(Request $request, $student_id, $parent_id)
    {
        $student = Student::findOrFail($student_id);
        $student->parent_id = $parent_id;
        $student->save();

        return redirect()->back()->with('success', 'Student assigned to parent.');
    }

    public function removeChild($student_id)
{
    $student = Student::findOrFail($student_id);
    $student->parent_id = null;
    $student->save();

    return back()->with('success', 'Student removed from parent successfully.');
}

}
