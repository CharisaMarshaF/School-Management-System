<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ParentUser;

class ProfileController extends Controller
{
    public function editProfile()
    {
        $user = Auth::user();

        // Ambil data user berdasarkan role
        switch ($user->user_type) {
            case 1:
                $data['user'] = User::find($user->id);
                break;
            case 2:
                $data['user'] = Teacher::find($user->id);
                break;
            case 3:
                $data['user'] = Student::find($user->id);
                break;
            case 4:
                $data['user'] = ParentUser::find($user->id);
                break;
        }

        $data['header_title'] = 'My Account';

        return view('profile.my_account', $data);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        switch ($user->user_type) {
            case 1:
                $data = User::find($user->id);
                $data->name = $request->name;
                break;

            case 2:
                $data = Teacher::find($user->id);
                $data->name = $request->name;
                $data->last_name = $request->last_name;
                $data->mobile_number = $request->mobile_number;
                $data->address = $request->address;
                $data->gender = $request->gender;
                $data->qualification = $request->qualification;
                break;

            case 3:
                $data = Student::find($user->id);
                $data->name = $request->name;
                $data->last_name = $request->last_name;
                $data->mobile_number = $request->mobile_number;
                $data->address = $request->address;
                $data->gender = $request->gender;
                break;

            case 4:
                $data = ParentUser::find($user->id);
                $data->name = $request->name;
                $data->last_name = $request->last_name;
                $data->mobile_number = $request->mobile_number;
                $data->occupation = $request->occupation;
                $data->address = $request->address;
                $data->gender = $request->gender;
                break;
        }

        // Update foto jika ada
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $folder = match ($user->user_type) {
                1 => 'admin',
                2 => 'teacher',
                3 => 'students',
                4 => 'parent',
            };
            $file->move(public_path('uploads/' . $folder), $filename);
            $data->profile_pic = $filename;
        }

        // Jika user mengganti password
        if (!empty($request->password)) {
            $data->password = Hash::make($request->password);
        }

        $data->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

   


}
