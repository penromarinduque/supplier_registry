<?php

namespace App\Http\Controllers;

use App\Models\MSDUserInfo;
use App\Models\PAMOUserInfo;
use App\Models\Task;
use App\Models\TimeEntry;
use App\Models\TSDUserInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class TimeInController extends Controller
{
    //
    public function index(Request $request) {
        $division = $request->has('division') && $request->division != '' ? $request->division : null;
        if(!$division) {
            return abort(403, 'DIVISION NOT FOUND');
        }
        return view('timein.index', [
            'division' => $division
        ]);
    }

    public function show(Request $request) {
        $user = Auth::user();

        // Optional: check division-based restrictions
        $division = $request->division;
        if (!$division) {
            return redirect()->back()->with('error', 'Invalid division.');
        }


        // Fetch records
        $time_entries = TimeEntry::where('user_id', $user->empInfo->userID)
            ->whereDate('date', now())
            ->first();

        $tasks = Task::where('user_id', $user->empInfo->userID)
            ->whereDate('date', now())
            ->get();

        return view('timein.show', [
            'user'        => $user->empInfo,  // load employee info
            'division'    => $division,
            'time_entries'=> $time_entries,
            'tasks'       => $tasks
        ]);
    }

    public function attempt(Request $request) {
        $request->validate([
            'user_id'  => 'required|string',
            'password' => 'required|string',
            'division' => 'required|string'
        ]);

        $credentials = [
            'username' => $request->user_id,
            'password' => $request->password,
        ];

        $user = User::where('username', $request->user_id)->first();

        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        if ($user->empInfo->division != User::DIVISIONS[$request->division]) {
            return back()->with('error', 'User not found on ' . User::DIVISION_LABELS[$request->division] . '.');
        }

        // Try to log in the user
        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Invalid username or password.');
        }

        return redirect()->route('timein.show', ['division' => $request->division]);
    }


    private function getUserByTinOrItemNo($user_id, $division){
        $userClasses = $classes = [
            'pamo' => PAMOUserInfo::class,
            'main' => MSDUserInfo::class,
            'tsd' => TSDUserInfo::class,
        ];
        if(!$user_id || $user_id == '') {
            return false;
        }
        $user = $userClasses[$division]::where('tin', $user_id)->where('is_active', 1)->first();
        if(!$user) {
            $user = $userClasses[$division]::where('SSN', $user_id)->where('is_active', 1)->first();
        }
        if(!$user) {
            return false;
        }
        return $user;
    }

}
