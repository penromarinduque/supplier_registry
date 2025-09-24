<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Accomplishment;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    //
    public function store(Request $request){
        $request->validateWithBag('addTask', [
            'task' => ['required', 'string', 'max:1000'],
            'user_id' => ['required'],
            'user_no' => ['required'],
            'division' => ['required'],
        ]);
        Task::create([
            'task' => $request->input('task'),
            'user_id' => $request->input('user_id'),
            'user_no' => $request->input('user_no'),
            'division' => User::DIVISIONS[$request->input('division')],
            'date' => now(),
        ]);
        return redirect()->back()->with('success', 'Task added successfully.');
    }

    public function edit($id){
        $task = Task::find($id);
        if(!$task){
            return redirect()->back()->with('error', 'Task not found.');
        }
        return view('tasks.edit', [
            'task' => $task
        ]);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'task' => ['required', 'string', 'max:1000']
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'updateTask')->withInput()->with([
                'url' => route('tasks.update', $id)
            ]);
        }
        $task = Task::find($id);
        if(!$task){
            return redirect()->back()->with('error', 'Task not found.');
        }
        $task->update([
            'task' => $request->input('task')
        ]);
        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    public function delete($id){
        return DB::transaction(function () use ($id) {
            $task = Task::find($id);
            if(!$task){
                return redirect()->back()->with('error', 'Task not found.');
            }
            $task->delete();
            Accomplishment::where('task_id', $id)->delete();
            return redirect()->back()->with('success', 'Task deleted successfully.');
        });
    }
}
