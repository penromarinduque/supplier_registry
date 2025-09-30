<?php

namespace App\Http\Controllers;

use App\Models\Accomplishment;
use App\Models\MSDUserInfo;
use App\Models\PAMOUserInfo;
use App\Models\Task;
use App\Models\TimeEntry;
use App\Models\TSDUserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TimeEntryController extends Controller
{
    //
    public function store(Request $request) {
        $request->validate([
            'location' => 'required',
            // 'user_no' => 'required',
            'entry_type' => 'required|in:pm_in,pm_out,am_in,am_out',
            'photo' => 'nullable'
        ]);
        return DB::transaction(function () use ($request) {
            $divisions = [
                'pamo' => 'pamo',
                'main' => 'msd',
                'tsd' => 'tsd'
            ];
    
            $time_entry = TimeEntry::where('user_id', Auth::user()->empInfo->userID)->whereDate('date', now())->first();
            if(!$time_entry && $request->entry_type != 'am_in') {
                abort(403, 'Invalid entry type.');
            }
            if(!$time_entry){
                $time_entry = TimeEntry::create([
                    'user_id' => Auth::user()->empInfo->userID,
                    'user_no' => Auth::user()->username,
                    'am_in_location' => $request->location,
                    'date' => now(),
                    'am_in' => now(),
                    'division' => $divisions[$request->division]
                ]);
            } else {
                $time_entry->update([
                    $request->entry_type => now(),
                    $request->entry_type . '_location' => $request->location
                ]);
            }
    
            if($request->has('photo') && $request->photo != '') {
                // Remove "data:image/png;base64,"
                $photo = $request->photo;
                $photo = str_replace('data:image/png;base64,', '', $photo);
                $photo = str_replace(' ', '+', $photo);
    
                $fileName = uniqid() . '.png';
                Storage::disk('public')->put('captures/' . $fileName, base64_decode($photo));
                $time_entry->update([
                    $request->entry_type . '_capture' => $fileName
                ]);
            }
            
            return redirect()->back()->with('success', 'Time entry saved.');
        });
    }

    public function printDtr(Request $request) {
        $date = $request->has('date') && $request->date != '' ? $request->date : now();
        $division = $request->has('division') ? $request->division : null;
        if(!$division) {
            return abort(403, 'DIVISION NOT FOUND');
        }
        $user = Auth::user()->empInfo;
        // $user = $this->getUserByTinOrItemNo($user_id, $division);
        $time_entries = TimeEntry::where('user_id', $user->userID)->whereDate('date', $date)->first();
        $tasks = Task::where('user_id', $user->userID)->whereDate('date', $date)->get();
        $accomplishments = Accomplishment::where('user_id', $user->userID)
            ->with('task')
            ->whereDate('date', $date)
            ->orderBy('task_id', 'desc')
            ->get();
        return view('timein.print-dtr', [
            'user' => $user,
            'division' => $division,
            'time_entries' => $time_entries,
            'date' => $date,
            'accomplishments' => $accomplishments,
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
            abort(403, 'USER ID NOT FOUND');
        }
        $user = $userClasses[$division]::where('userID', $user_id)->where('is_active', 1)->first();
        if(!$user) {
            return abort(404, 'USER NOT FOUND');
        }
        return $user;
    }


}
