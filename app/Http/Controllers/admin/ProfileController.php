<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function profile($id)
    {
        $id = Auth::id();
        $profile = User::findOrFail($id);
        return view('admin.users.show-profile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $this->validate(
            $request,
            [
                'username' => 'required|string|max:255|min:3|unique:users,username,' . $request->user_id,
                'email' => 'required|unique:users,email,' . $request->user_id,
                'phone' => 'nullable|unique:users,phone,' . $request->user_id,
                'password' => 'nullable|min:6'
            ],
        );

        $user = User::findOrFail($request->user_id);
        $array = [];

        if ($request->username != $user->username) {
            $array['username'] = $request->username;
        }

        if ($request->email != $user->email) {
            $array['email'] = $request->email;
        }

        if ($request->phone != $user->phone) {
            $array['phone'] = $request->phone;
        }

        if ($request->password != '') {
            $array['password'] = Hash::make($request->password);
        }

        if (!empty($array)) {
            $user->update($array);
        }
        return response()->json(['status' => 1, "msg" => "Profile  \"$user->username\" Updated"]);

    }
}
