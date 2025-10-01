<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function index() {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function resetPassword(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8'],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'resetPassword')->withInput()->with([
                'url' => route('users.resetPassword', $id)
            ]);
        }

        $user = User::find($id);
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->back()->with('success', 'Password reset successfully.');
    }
}
