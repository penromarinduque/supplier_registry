<?php

namespace App\Http\Controllers;

use App\Models\MSDUserInfo;
use App\Models\PAMOUserInfo;
use App\Models\Task;
use App\Models\TimeEntry;
use App\Models\TSDUserInfo;
use Illuminate\Http\Request;

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
        $division = $request->has('division') && $request->division != '' ? $request->division : null;
        $user_id = $request->has('user_id') ? $request->user_id : null;
        if(!$division) {
            return abort(403, 'DIVISION NOT FOUND');
        }
        
        $user = $this->getUserByTinOrItemNo($user_id, $division);
        if(!$user) {
            return redirect()->back()->with('error', 'User with TIN or Item No. '.''.$user_id.' '.' not found. Make sure you have entered the correct TIN or Item No.');
        }
        $time_entries = TimeEntry::where('user_id', $user->userID)->whereDate('date', now())->first();
        $tasks = Task::where('user_id', $user->userID)->whereDate('date', now())->get();
        return view('timein.show', [
            'user' => $user,
            'division' => $division,
            'time_entries' => $time_entries,
            'tasks' => $tasks
        ]);
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
