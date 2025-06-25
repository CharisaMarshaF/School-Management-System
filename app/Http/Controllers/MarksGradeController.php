<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarksGrade;
use Auth;

class MarksGradeController extends Controller
{
    public function list(Request $request)
    {
        $data['header_title'] = 'Marks Grade List';

        $query = MarksGrade::query();
        if (!empty($request->get('search'))) {
            $query->where('name', 'like', '%' . $request->get('search') . '%');
        }
        $data['getRecord'] = $query->orderBy('id', 'desc')->get();

        return view('admin.marks_grade.list', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'percent_from' => 'required|numeric',
            'percent_to' => 'required|numeric',
        ]);

        $data = new MarksGrade;
        $data->name = $request->name;
        $data->percent_from = $request->percent_from;
        $data->percent_to = $request->percent_to;
        $data->created_by = Auth::user()->id;
        $data->save();

        return redirect()->back()->with('success', 'Marks grade added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'percent_from' => 'required|numeric',
            'percent_to' => 'required|numeric',
        ]);

        $data = MarksGrade::findOrFail($id);
        $data->name = $request->name;
        $data->percent_from = $request->percent_from;
        $data->percent_to = $request->percent_to;
        $data->save();

        return redirect()->back()->with('success', 'Marks grade updated successfully.');
    }

    public function delete($id)
    {
        MarksGrade::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Marks grade deleted successfully.');
    }
}
