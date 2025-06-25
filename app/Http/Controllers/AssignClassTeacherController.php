<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssignClassTeacher;
use App\Models\ClassModel;
use App\Models\Teacher;
use Auth;

class AssignClassTeacherController extends Controller
{
    public function list(Request $request)
    {
        $search = $request->get('search');
        $getRecord = AssignClassTeacher::with(['class', 'teacher'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('class', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })->orWhereHas('teacher', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        $data['getRecord'] = $getRecord;
        $data['classes'] = ClassModel::where('status', 0)->get();
        $data['teachers'] = Teacher::where('status', 0)->get();
        $data['header_title'] = 'Assign Class to Teacher';
        return view('admin.assignclassteacher.list', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
            'teacher_ids' => 'required|array',
        ]);

        foreach ($request->teacher_ids as $teacher_id) {
            AssignClassTeacher::create([
                'class_id' => $request->class_id,
                'teacher_id' => $teacher_id,
                'status' => $request->status ?? 0,
                'created_by' => Auth::user()->id,
            ]);
        }

        return redirect()->back()->with('success', 'Teacher(s) assigned to class successfully.');
    }

    public function update($id, Request $request)
    {
        $data = AssignClassTeacher::findOrFail($id);
        $data->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Assignment updated successfully.');
    }

    public function delete($id)
    {
        AssignClassTeacher::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Assignment deleted successfully.');
    }
}

