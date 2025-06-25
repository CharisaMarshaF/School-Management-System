<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\NoticeBoard;
use Illuminate\Http\Request;
use App\Models\NoticeBoardMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NoticeBoardController extends Controller
{
    public function index(Request $request)
    {
                $data['header_title'] = "Notice Board";

        $notices = NoticeBoard::with('recipients')
            ->when($request->title, fn($q) => $q->where('title', 'like', '%' . $request->title . '%'))
            ->when($request->notice_date, fn($q) => $q->where('notice_date', $request->notice_date))
            ->when($request->publish_date, fn($q) => $q->where('publish_date', $request->publish_date))
            ->get();

        return view('admin.notice_board.list', compact('notices'), $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'notice_date' => 'required|date',
            'publish_date' => 'required|date',
            'message' => 'required',
            'message_to' => 'required|array'
        ]);

        $notice = NoticeBoard::create([
            'title' => $request->title,
            'notice_date' => $request->notice_date,
            'publish_date' => $request->publish_date,
            'message' => $request->message,
            'created_by' => Auth::id(),
        ]);

        foreach ($request->message_to as $to) {
            NoticeBoardMessage::create([
                'notice_board_id' => $notice->id,
                'message_to' => $to
            ]);
        }

        return redirect()->back()->with('success', 'Notice added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'notice_date' => 'required|date',
            'publish_date' => 'required|date',
            'message' => 'required',
            'message_to' => 'required|array',
        ]);

        $notice = NoticeBoard::findOrFail($id);
        $notice->update([
            'title' => $request->title,
            'notice_date' => $request->notice_date,
            'publish_date' => $request->publish_date,
            'message' => $request->message,
        ]);

        NoticeBoardMessage::where('notice_board_id', $id)->delete();

        foreach ($request->message_to as $to) {
            NoticeBoardMessage::create([
                'notice_board_id' => $notice->id,
                'message_to' => $to
            ]);
        }

        return redirect()->route('notice_board.index')->with('success', 'Notice updated successfully.');
    }

    public function destroy($id)
    {
        NoticeBoardMessage::where('notice_board_id', $id)->delete();
        NoticeBoard::destroy($id);

        return redirect()->back()->with('success', 'Notice deleted successfully.');
    }

    public function studentNoticeBoard(Request $request)
    {
        $data['header_title'] = "My Notice Board";

        // Ambil semua notice yang ditujukan ke student (user_type = 3)
        $query = DB::table('notice_board')
            ->join('notice_board_message', 'notice_board.id', '=', 'notice_board_message.notice_board_id')
            ->where('notice_board_message.message_to', 3)
            ->select('notice_board.*');

        // Filter berdasarkan title
        if ($request->filled('title')) {
            $query->where('notice_board.title', 'like', '%' . $request->title . '%');
        }

        // Filter berdasarkan notice_date
        if ($request->filled('notice_date_from')) {
            $query->whereDate('notice_board.notice_date', '>=', $request->notice_date_from);
        }

        if ($request->filled('notice_date_to')) {
            $query->whereDate('notice_board.notice_date', '<=', $request->notice_date_to);
        }

        $notices = $query->orderBy('notice_board.notice_date', 'desc')->get();

        return view('student.notice_board.index', compact('notices'), $data);
    }

    public function teacherNoticeBoard(Request $request)
    {
        $data['header_title'] = "My Notice Board";

        $query = DB::table('notice_board')
            ->join('notice_board_message', 'notice_board.id', '=', 'notice_board_message.notice_board_id')
            ->where('notice_board_message.message_to', 2) // user_type 2 = Teacher
            ->select('notice_board.*');

        // Filter berdasarkan title
        if ($request->filled('title')) {
            $query->where('notice_board.title', 'like', '%' . $request->title . '%');
        }

        // Filter tanggal dari
        if ($request->filled('notice_date_from')) {
            $query->whereDate('notice_board.notice_date', '>=', $request->notice_date_from);
        }

        // Filter tanggal sampai
        if ($request->filled('notice_date_to')) {
            $query->whereDate('notice_board.notice_date', '<=', $request->notice_date_to);
        }

        $notices = $query->orderBy('notice_board.notice_date', 'desc')->get();

        return view('teacher.notice_board.index', compact('notices'), $data);
    }

    public function parentNoticeBoard(Request $request)
    {
        $user = Auth::user();
        $data['header_title'] = "My Notice Board";

        $query = NoticeBoard::whereHas('messages', function ($q) {
            $q->where('message_to', 4); // user_type 4 = parent
        });

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('notice_date_from')) {
            $query->whereDate('notice_date', '>=', $request->notice_date_from);
        }

        if ($request->filled('notice_date_to')) {
            $query->whereDate('notice_date', '<=', $request->notice_date_to);
        }

        $notices = $query->orderBy('notice_date', 'desc')->get();

        return view('parent.notice_board.parent', compact('notices'), $data);
    }
    public function parentStudentNoticeBoard(Request $request)
    {
        $parent_id = Auth::id();
        $data['header_title'] = "Student Notice Board";

        // Ambil semua siswa yang diampu oleh parent ini
        $students = Student::where('parent_id', $parent_id)->pluck('id');

        // Ambil pengumuman yang ditujukan untuk siswa (user_type = 3)
        $query = NoticeBoard::whereHas('messages', function ($q) {
            $q->where('message_to', 3); // untuk siswa
        });

        // Optional filter
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('notice_date_from')) {
            $query->whereDate('notice_date', '>=', $request->notice_date_from);
        }

        if ($request->filled('notice_date_to')) {
            $query->whereDate('notice_date', '<=', $request->notice_date_to);
        }

        $notices = $query->orderBy('notice_date', 'desc')->get();

        return view('parent.notice_board.student', compact('notices'),  $data);
    }

}
