<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    //
    public function settings()
    {
        return view('settings.index');
    }

    public function updatePassword(Request $request)
    {
        $request->validateWithBag('updatePassword', [
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        // Check old password
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->with('error', 'Current password is incorrect');
        }

        $user = $request->user();

        // Prevent reusing the same password
        if (Hash::check($request->new_password, $user->password)) {
            return back()->with('error', 'New password cannot be the same as your current password.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // (Optional) Invalidate old sessions for extra security
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('timein', ['division' => User::DIVISIONS_REVERSE[$user->empInfo->division]])->with('success', 'Password updated successfully. Please log in again.');
    }

}
