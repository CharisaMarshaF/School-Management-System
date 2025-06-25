<?php

// app/Http/Controllers/HomeworkSubmitController.php
namespace App\Http\Controllers;

use App\Models\Homework;
use Illuminate\Http\Request;
use App\Models\HomeworkSubmit;
use Illuminate\Support\Facades\Auth;

class HomeworkSubmitController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'homework_id' => 'required|exists:homework,id',
            'description' => 'nullable|string',
            'document_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:2048',
        ]);

        $fileName = null;
        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('uploads/homework'), $fileName);
        }

        HomeworkSubmit::updateOrCreate(
            ['homework_id' => $request->homework_id, 'student_id' => Auth::id()],
            ['description' => $request->description, 'document_file' => $fileName]
        );

    return redirect()->back()->with('success', 'Homework submitted successfully!');
    }

    public function viewSubmitted($homework_id, Request $request)
    {
        $search = $request->input('search');
        $data = [
            'header_title' => 'Submitted Homework',
        ];
        $homework = Homework::with(['classroom', 'subject'])->findOrFail($homework_id);

        $submissions = HomeworkSubmit::with('student')
            ->where('homework_id', $homework_id)
            ->when($search, function ($query) use ($search) {
                $query->whereHas('student', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('homework.submitted_list', compact('homework', 'submissions', 'search'), $data);
    }
}

