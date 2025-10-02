<?php

namespace App\Http\Controllers;

use App\Models\EmpInfo;
use App\Models\Role;
use App\Models\RoleType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function index() {
        $users = User::paginate(20);
        $roles = Role::all();
        $role_types = RoleType::all();
        return view('admin.users.index', compact('users', 'roles', 'role_types'));
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

    public function updateRole(Request $request, $id) {
        $request->validateWithBag('updateRole', [
            'roles' =>  ['required', 'array'],
            'roles.*' => ['required', 'exists:role_types,id'],
        ]);

        return DB::transaction(function () use ($request, $id) {
            
            foreach ($request->roles as $role) {
                if(!Role::where('user_id', $id)->where('role_type_id', $role)->exists()) {
                    Role::create([
                        'user_id' => $id,
                        'role_type_id' => $role,
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Role updated successfully.');
            
        });
        
    }

    public function create() {
        return view('admin.users.create');
    }

    public function store(Request $request) {
        $request->validateWithBag('addUser', [
            'name' => ['required', 'string', 'max:255'],
            'dtr_user_id' => ['required', 'numeric', 'unique:emp_infos,userID'],
            'dtr_badge_number' => ['required', 'numeric', 'unique:emp_infos,badgeNumber'],
            'division' => ['required', 'in:pamo,msd,tsd'],
            'ssn' => ['nullable', 'required_if:employment_status,Permanent', 'unique:emp_infos,SSN'],
            'gender' => ['required', 'in:M,F'],
            'position' => ['required', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:255'],
            'birthdate' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:255'],
            'tin' => ['nullable', 'required_if:employment_status,COS', 'string', 'max:255'],
            'employment_status' => ['required', 'in:Permanent,COS,SPES,GIP,OJT'],
            'password' => ['required', 'string', 'min:8'],
            'username' => ['required', 'string', 'max:20', 'unique:users,username'],
        ]);

        return DB::transaction(function () use ($request) {
            $user = User::create([
               'name' => $request->name,
               'username' => $request->username,
               'password' => bcrypt($request->password),
            ]);

            EmpInfo::create([
                'name' => $request->name,
                'user_id' => $user->id,
                'userID' => $request->dtr_user_id,
                'badgeNumber' => $request->dtr_badge_number,
                'SSN' => $request->ssn,
                'gender' => $request->gender,
                'position' => $request->position,
                'contact' => $request->contact_number,
                'birthday' => $request->birthdate,
                'address' => $request->address,
                'TIN' => $request->tin,
                'status' => $request->employment_status,
                'division' => $request->division        
            ]);
        });

        return redirect()->route('users.index')->with('success', 'User created successfully.');

    }
}
