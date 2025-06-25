<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{

    public function list(Request $request)
    {
        $query = ClassModel::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%');
        }

        $data['getRecord'] = $query->get();
        $data['header_title'] = "Class List";

        return view('admin.class.list', $data);
    }


    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'amount' => 'nullable|int|min:0',
        ]);

        $class = new ClassModel();
        $class->name = $request->name;
        $class->amount = $request->amount;
        $class->status = $request->status;
        $class->created_by = Auth::id();
        $class->created_at = now();
        $class->updated_at = now();
        $class->save();

        return redirect('admin/class/list')->with('success', 'Class created successfully.');
    }

    public function edit($id)
    {
        $data['editRecord'] = ClassModel::findOrFail($id);
        $data['getRecord'] = ClassModel::all();
        $data['header_title'] = "Edit Class";
        return view('admin.class.list', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'amount' => 'nullable|int|min:0',
        ]);

        $class = ClassModel::findOrFail($id);
        $class->name = $request->name;
        $class->amount = $request->amount;
        $class->status = $request->status;
        $class->updated_at = now();
        $class->save();

        return redirect('admin/class/list')->with('success', 'Class updated successfully.');
    }

    public function delete($id)
    {
        $class = ClassModel::findOrFail($id);
        $class->delete();

        return redirect('admin/class/list')->with('success', 'Class deleted successfully.');
    }
}
