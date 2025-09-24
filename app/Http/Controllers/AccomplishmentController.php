<?php

namespace App\Http\Controllers;

use App\Models\Accomplishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccomplishmentController extends Controller
{
    //
    public function store(Request $request)
    {
        //
        $request->validateWithBag('addAccomplishment', [
            'accomplishment' => ['required', 'string', 'max:1000'],
            'user_id' => ['required'],
            'task_id' => ['required'],
            'user_no' => ['required'],
            'division' => ['required'],
        ]);

        Accomplishment::create([
            'accomplishment' => $request->input('accomplishment'),
            'user_id' => $request->input('user_id'),
            'task_id' => $request->input('task_id'),
            'user_no' => $request->input('user_no'),
            'division' => $request->input('division'),
            'date' => now(),
        ]);

        return redirect()->back()->with([
            'success' => 'Accomplishment added successfully'
        ]);
    }

    public function edit($id) {
        //
        $accomplishment = Accomplishment::find($id);
        if(!$accomplishment) {
            return redirect()->back()->with([
                'error' => 'Accomplishment not found'
            ]);
        }
        return view('timein.edit-accomplishment', [
            'accomplishment' => $accomplishment
        ]);
    }

    public function update(Request $request, $id) {
        //
        $validator = Validator::make($request->all(), [
            'accomplishment' => ['required', 'string', 'max:1000'],
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'updateAccomplishment')->withInput()->with([
                'url' => route('accomplishments.update', $id)
            ]);
        }

        $accomplishment = Accomplishment::find($id);
        if(!$accomplishment) {
            return redirect()->back()->with([
                'error' => 'Accomplishment not found'
            ]);
        }
        $accomplishment->update([
            'accomplishment' => $request->input('accomplishment')
        ]);

        return redirect()->back()->with([
            'success' => 'Accomplishment updated successfully'
        ]);
    }

    public function delete($id) {
        //
        $accomplishment = Accomplishment::find($id);
        if(!$accomplishment) {
            return redirect()->back()->with([
                'error' => 'Accomplishment not found'
            ]);
        }
        $accomplishment->delete();
        return redirect()->back()->with([
            'success' => 'Accomplishment deleted successfully'
        ]);
    }
}
