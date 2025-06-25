<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectModel;
use Auth;

class SubjectController extends Controller
{
    public function list(Request $request)
    {
        $query = SubjectModel::where('is_delete', 0);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%');
            });
        }

        $data['getRecord'] = $query->get();
        $data['header_title'] = "Subject List";

        return view('admin.subject.list', $data);
    }


    public function insert(Request $request)
    {
        $subject = new SubjectModel;
        $subject->name = trim($request->name);
        $subject->type = trim($request->type);
        $subject->status = $request->status;
        $subject->created_by = Auth::user()->id;
        $subject->is_delete = 0;
        $subject->save();

        return redirect('admin/subject/list')->with('success', 'Subject created successfully.');
    }

    public function update(Request $request, $id)
    {
        $subject = SubjectModel::find($id);
        $subject->name = trim($request->name);
        $subject->type = trim($request->type);
        $subject->status = $request->status;
        $subject->save();

        return redirect('admin/subject/list')->with('success', 'Subject updated successfully.');
    }

    public function delete($id)
    {
        $subject = SubjectModel::find($id);
        $subject->is_delete = 1;
        $subject->save();

        return redirect('admin/subject/list')->with('success', 'Subject deleted successfully.');
    }
}
