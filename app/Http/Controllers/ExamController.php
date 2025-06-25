<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function list(Request $request)
    {
        $data['header_title'] = "Exam List";

        $query = Exam::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $data['getRecord'] = $query->orderBy('id', 'desc')->get();

        return view('admin.exam.list', $data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $exam = new Exam;
        $exam->name = $request->name;
        $exam->note = $request->note;
        $exam->created_by = Auth::user()->id;
        $exam->created_at = now();
        $exam->save();

        return redirect()->back()->with('success', 'Exam created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $exam = Exam::findOrFail($id);
        $exam->name = $request->name;
        $exam->note = $request->note;
        $exam->updated_at = now();
        $exam->save();

        return redirect()->back()->with('success', 'Exam updated successfully.');
    }

    public function delete($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();

        return redirect()->back()->with('success', 'Exam deleted successfully.');
    }
}
