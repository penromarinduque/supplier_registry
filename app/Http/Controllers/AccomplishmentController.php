<?php

namespace App\Http\Controllers;

use App\Models\Accomplishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AccomplishmentController extends Controller
{
    //
    public function store(Request $request)
    {
        //
        $request->validateWithBag('addAccomplishment', [
            'accomplishment' => ['required', 'string', 'max:1000'],
            'task_id' => ['required'],
            'user_no' => ['required'],
            'division' => ['required'],
            'attachment' => ['nullable', 'file', 'max:10000']
        ]);

        return DB::transaction(function () use ($request) {
            $accomplishment = Accomplishment::create([
                'accomplishment' => $request->input('accomplishment'),
                'user_id' => Auth::user()->empInfo->userID,
                'task_id' => $request->input('task_id'),
                'user_no' => Auth::user()->username,
                'division' => Auth::user()->empInfo->division,
                'date' => now(),
            ]);
            if($request->hasFile('attachment')) {
                $file_name = $accomplishment->id . '.' . $request->file('attachment')->getClientOriginalExtension();
                $request->file('attachment')->storeAs('accomplishments', $file_name);
                $accomplishment->update([
                    'file' => $file_name
                ]);
            }
    
            return redirect()->back()->with([
                'success' => 'Accomplishment added successfully'
            ]);
        });

    }

    public function edit($id) {
        //
        $accomplishment = Accomplishment::find($id);
        if(!$accomplishment) {
            return redirect()->back()->with([
                'error' => 'Accomplishment not found'
            ]);
        }
        Gate::authorize('update', $accomplishment);
        return view('timein.edit-accomplishment', [
            'accomplishment' => $accomplishment
        ]);
    }

    public function update(Request $request, $id) {
        //
        $validator = Validator::make($request->all(), [
            'accomplishment' => ['required', 'string', 'max:1000'],
            'attachment' => ['nullable', 'file', 'max:10000']
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'updateAccomplishment')->withInput()->with([
                'url' => route('accomplishments.update', $id)
            ]);
        }
        
        return DB::transaction(function () use ($request, $id) {
            $accomplishment = Accomplishment::find($id);
            if(!$accomplishment) {
                return redirect()->back()->with([
                    'error' => 'Accomplishment not found'
                ]);
            }
            Gate::authorize('update', $accomplishment);
            $accomplishment->update([
                'accomplishment' => $request->input('accomplishment')
            ]);
            if($request->hasFile('attachment')) {
                $file_name = $accomplishment->id . '.' . $request->file('attachment')->getClientOriginalExtension();
                $request->file('attachment')->storeAs('accomplishments', $file_name);
                $accomplishment->update([
                    'file' => $file_name ?? $accomplishment->file
                ]);
            }
    
            return redirect()->back()->with([
                'success' => 'Accomplishment updated successfully'
            ]);
        });

    }

    public function delete($id) {
        //
        $accomplishment = Accomplishment::find($id);
        if(!$accomplishment) {
            return redirect()->back()->with([
                'error' => 'Accomplishment not found'
            ]);
        }
        Gate::authorize('delete', $accomplishment);
        $accomplishment->delete();
        return redirect()->back()->with([
            'success' => 'Accomplishment deleted successfully'
        ]);
    }

    public function downloadFile($id) {
        //
        $accomplishment = Accomplishment::find($id);
        Gate::authorize('update', $accomplishment);
        if(!$accomplishment) {
            return redirect()->back()->with([
                'error' => 'Accomplishment not found'
            ]);
        }
        return Storage::download('accomplishments/' . $accomplishment->file);

    }

    public function deleteFile($id) {
        //
        $accomplishment = Accomplishment::find($id);
        if(!$accomplishment) {
            return redirect()->back()->with([
                'error' => 'Accomplishment not found'
            ]);
        }
        Gate::authorize('delete', $accomplishment);
        Storage::delete('accomplishments/' . $accomplishment->file);
        $accomplishment->update([
            'file' => null
        ]);
        return redirect()->back()->with([
            'success' => 'File deleted successfully'
        ]);
    }

    public function viewImage($filename)
    {
        $path = 'captures/' . $filename;
        if (!Storage::disk('public')->exists($path)) {
            return redirect()->back()->with('error', 'Image file not found');
        }

        // This automatically sets the correct Content-Type
        return Storage::disk('public')->response($path);
    }

}
