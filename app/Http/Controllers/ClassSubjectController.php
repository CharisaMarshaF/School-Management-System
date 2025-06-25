<?php

namespace App\Http\Controllers;

use App\Models\ClassSubjectModel;
use App\Models\ClassModel;
use App\Models\SubjectModel;
use Illuminate\Http\Request;
use Auth;
use DB;

class ClassSubjectController extends Controller
{
    public function list(Request $request)
    {
        $query = ClassSubjectModel::with(['class', 'subject'])->where('is_delete', 0);

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;

            $query->whereHas('class', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            })->orWhereHas('subject', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }

        $data['getRecord'] = $query->get();
        $data['allSubjects'] = SubjectModel::pluck('name', 'id')->toArray();
        $data['header_title'] = "Assign Subject to Class";
        $data['classes'] = ClassModel::where('is_delete', 0)->get();
        $data['subjects'] = SubjectModel::where('is_delete', 0)->get();

        return view('admin.assign_subject.list', $data);
    }



    public function insert(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'subject_ids' => 'required|array',
        ]);

        // Cek existing subject yang sudah ada
        $existingSubjects = ClassSubjectModel::where('class_id', $request->class_id)
            ->where('is_delete', 0)
            ->pluck('subject_id')
            ->toArray();

        $newSubjects = $request->subject_ids;

        // Cari hanya subject baru yang belum ada
        $subjectsToInsert = array_diff($newSubjects, $existingSubjects);

        foreach ($subjectsToInsert as $subject_id) {
            $classSubject = new ClassSubjectModel();
            $classSubject->class_id = $request->class_id;
            $classSubject->subject_id = $subject_id;
            $classSubject->status = $request->status;
            $classSubject->created_by = Auth::id();
            $classSubject->is_delete = 0;
            $classSubject->save();
        }

        return redirect()->route('admin.assign_subject.list')->with('success', 'Subjects assigned to class successfully!');
    }


    public function update(Request $request, $class_id)
    {
        $request->validate([
            'subject_ids' => 'required|array',
        ]);

        // Ambil semua subject yang sudah ada untuk class ini
        $existingSubjects = ClassSubjectModel::where('class_id', $class_id)
            ->where('is_delete', 0)
            ->pluck('subject_id')
            ->toArray();

        $newSubjects = $request->subject_ids; // Subject baru yang dipilih dari form

        // Cari subject yang perlu di-insert
        $subjectsToInsert = array_diff($newSubjects, $existingSubjects);

        // Cari subject yang perlu di-delete
        $subjectsToDelete = array_diff($existingSubjects, $newSubjects);

        foreach ($subjectsToInsert as $subject_id) {
            $classSubject = new ClassSubjectModel();
            $classSubject->class_id = $class_id;
            $classSubject->subject_id = $subject_id;
            $classSubject->status = $request->status ?? 'active';
            $classSubject->created_by = Auth::id();
            $classSubject->is_delete = 0;
            $classSubject->save();
        }

        if (!empty($subjectsToDelete)) {
            ClassSubjectModel::where('class_id', $class_id)
                ->whereIn('subject_id', $subjectsToDelete)
                ->where('is_delete', 0)
                ->update(['is_delete' => 1]);
        }

        return redirect()->route('admin.assign_subject.list')->with('success', 'Subjects updated successfully!');
    }

    public function delete($id)
{
    $record = ClassSubjectModel::find($id);
    if ($record) {
        $record->is_delete = 1;
        $record->save();

        return redirect()->route('admin.assign_subject.list')->with('success', 'Subject assignment deleted successfully!');
    }

    return redirect()->route('admin.assign_subject.list')->with('error', 'Record not found!');
}


}
