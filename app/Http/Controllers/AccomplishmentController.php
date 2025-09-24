<?php

namespace App\Http\Controllers;

use App\Models\Accomplishment;
use Illuminate\Http\Request;

class AccomplishmentController extends Controller
{
    //
    public function store(Request $request)
    {
        //
        $request->validateWithBag('addAccomplishment', [
            'accomplishment' => ['required', 'string', 'max:1000'],
            'user_id' => ['required'],
            'user_no' => ['required'],
            'division' => ['required'],
        ]);

        Accomplishment::create([
            'accomplishment' => $request->input('accomplishment'),
            'user_id' => $request->input('user_id'),
            'user_no' => $request->input('user_no'),
            'division' => $request->input('division'),
            'date' => now(),
        ]);

        return redirect()->back()->with([
            'success' => 'Accomplishment added successfully'
        ]);
    }
}
