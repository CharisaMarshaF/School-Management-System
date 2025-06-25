<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;
class AdminController extends Controller
{

    

    public function list(Request $request)
{
    $query = User::where('user_type', 1);

    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%");
        });
    }

    $data['getRecord'] = $query->orderBy('id', 'desc')->get();
    $data['header_title'] = "Admin List";

    return view('admin.admin.list', $data);
}


    public function insert(Request $request){
        request()->validate([
            'email' => 'required|email|unique:users,email',
        ]);
        $user = new User;
        $user->name = trim($request->name);
        $user->last_name = trim($request->las_name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->user_type = 1;
        $user->is_delete = 0;
        $user->save();
        
        return redirect('admin/admin/list')->with('success',"Admin successfully created");
    }

    public function update(Request $request,$id){
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id
        ]);
        $user = User::find($id);
        if (!$user) {
            return redirect('admin/admin/list')->with('error', 'Admin not found.');
        }
        $user->name = trim($request->name);
        $user->last_name = trim($request->last_name);
        $user->email = trim($request->email);
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('admin/admin/list')->with('success', 'Admin successfully updated');

    }


    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect('admin/admin/list')->with('success', 'Admin successfully deleted');
        }

        return redirect('admin/admin/list')->with('error', 'Admin not found');
    }

    
}
