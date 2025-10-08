<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use App\Notifications\UserRegisteredNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    //
    public function create()
    {
        return view('suppliers.register');
    }

    public function store(Request $request)
    {
        $request->validateWithBag('store', [
            'email' => 'required|email|unique:suppliers,email',
            'company_name' => 'required|max:100',
            'authorized_representative' => 'required|max:100',
            'landline_no' => 'required|max:50',
            'mobile_no' => 'required|max:15',
            'philgeps_reg_no' => 'required|max:50',
            'philgeps_validity' => 'required|date',
            'business_permit_no' => 'required|max:50',
            'business_permit_validity' => 'required|date',
            'line_of_business' => 'required|max:200',
            'valid_id' => 'required|file|max:100000',
            'philgeps_cert' => 'required|file|mimes:jpg,jpeg,png|max:100000',
            'business_permit' => 'required|file|max:100000',
            'bir_cert' => 'required|file|max:100000',
            'dti_permit' => 'required|file|max:100000',
            'authorization' => 'nullable|file|max:100000',
            'company_profile' => 'required|file|max:100000',
            'company_address' => 'required|string|max:255',
            'company_facade' => 'required|file|max:100000',
            'dti_permit_validity' => 'required|date',
        ]);

        if(User::where('email', $request->email)->exists()){
            return redirect()->back()->withInput()->withErrors(['email' => 'The email has already been taken.'], 'store');
        }

        return DB::transaction(function () use ($request) {
            $valid_id_name = uniqid() . '_.' . $request->file('valid_id')->getClientOriginalExtension();
            $request->file('valid_id')->storeAs('suppliers/valid_ids', $valid_id_name, 'public');
            $philgeps_cert_name = uniqid() . '_.' . $request->file('philgeps_cert')->getClientOriginalExtension();
            $request->file('philgeps_cert')->storeAs('suppliers/philgeps_certs', $philgeps_cert_name, 'public');
            $business_permit_name = uniqid() . '_.' . $request->file('business_permit')->getClientOriginalExtension();
            $request->file('business_permit')->storeAs('suppliers/business_permits', $business_permit_name, 'public');
            $bir_cert_name = uniqid() . '_.' . $request->file('bir_cert')->getClientOriginalExtension();
            $request->file('bir_cert')->storeAs('suppliers/bir_certs', $bir_cert_name, 'public');
            $dti_permit_name = uniqid() . '_.' . $request->file('dti_permit')->getClientOriginalExtension();
            $request->file('dti_permit')->storeAs('suppliers/dti_permits', $dti_permit_name, 'public');
            $authorization_name = $request->hasFile('authorization') ? uniqid() . '_.' . $request->file('authorization')->getClientOriginalExtension() : null;
            $company_profile_name = uniqid() . '_.' . $request->file('company_profile')->getClientOriginalExtension();
            $request->file('company_profile')->storeAs('suppliers/company_profiles', $company_profile_name, 'public');
            if($authorization_name){
                $request->file('authorization')->storeAs('suppliers/authorizations', $authorization_name, 'public');
            } 
            $company_facade_name = uniqid() . '_.' . $request->file('company_facade')->getClientOriginalExtension();
            $request->file('company_facade')->storeAs('suppliers/company_facades', $company_facade_name, 'public');
            DB::table('suppliers')->insert([
                'email' => $request->email,
                'company_name' => $request->company_name,
                'authorized_representative' => $request->authorized_representative,
                'landline_no' => $request->landline_no,
                'mobile_no' => $request->mobile_no,
                'philgeps_reg_no' => $request->philgeps_reg_no,
                'philgeps_validity' => $request->philgeps_validity,
                'business_permit_no' => $request->business_permit_no,
                'business_permit_validity' => $request->business_permit_validity,
                'line_of_business' => $request->line_of_business,
                'valid_id' => $valid_id_name,
                'philgeps_cert' => $philgeps_cert_name,
                'business_permit' => $business_permit_name,
                'bir_cert' => $bir_cert_name,
                'dti_permit' => $dti_permit_name,
                'authorization' => $authorization_name,
                'company_profile' => $company_profile_name,
                'company_address' => $request->company_address,
                'facade' => $company_facade_name,
                'dti_permit_validity' => $request->dti_permit_validity,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $password = Str::random(8); 
            User::create([
                'name' => $request->authorized_representative,
                'email' => $request->email,
                'password' => bcrypt($password), 
            ])->roles()->create([
                'role_type_id' => 2, 
            ]);
            $user = User::where('email', $request->email)->first();
            Log::info('Password for user ' . $user->email . ': ' . $password);
            Notification::send($user, new UserRegisteredNotification($password));
            return redirect()->route('suppliers.register')->with('success', 'Supplier registered successfully.');
        });
    }

    public function index(Request $request)
    {
        Gate::authorize('viewAny', Supplier::class);
        $suppliers_query = Supplier::query();
        $search = $request->has('search') ? $request->search : null;
        $eligible = $request->has('type') && $request->type === 'eligible' ? true : false;
        if($eligible){
            $suppliers_query->where(function($query) {
                $query->whereDate('philgeps_validity', '>=', now())
                      ->whereDate('business_permit_validity', '>=', now())
                      ->whereDate('dti_permit_validity', '>=', now());
            });
            request('type', 'eligible');
        }
        else {
            $suppliers_query->where(function($query) {
                $query->whereDate('philgeps_validity', '<', now())
                      ->orWhereDate('business_permit_validity', '<', now())
                      ->orWhereDate('dti_permit_validity', '<', now());
            });
            request('type', 'ineligible');
        }
        if ($search) {
            $suppliers_query->where('company_name', 'like', '%' . $search . '%')
                ->orWhere('authorized_representative', 'like', '%' . $search
                . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        }
        $suppliers = $suppliers_query->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    public function destroy(Supplier $supplier)
    {
        // Delete associated files
        $files = [
            'suppliers/valid_ids/' . $supplier->valid_id,
            'suppliers/philgeps_certs/' . $supplier->philgeps_cert,
            'suppliers/business_permits/' . $supplier->business_permit,
            'suppliers/bir_certs/' . $supplier->bir_cert,
        ];

        foreach ($files as $file) {
            $filePath = storage_path('app/public/' . $file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        return DB::transaction(function () use ($supplier) {
            // Delete the supplier record
            User::find($supplier->user_id)?->delete();
            Role::where('user_id', $supplier->user_id)->delete();
            $supplier->delete();
            return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted successfully.');
        });
    }

    public function profile()
    {
        $supplier = auth()->user()->supplier;
        return view('suppliers.profile', compact('supplier'));
    }

    public function update(Request $request, $id) {
        $supplier = Supplier::findOrFail($id);

        Gate::authorize('update', $supplier);

        $request->validateWithBag('updateProfile', [
            'company_name' => 'required|max:100',
            'authorized_representative' => 'required|max:100',
            'landline_no' => 'required|max:50',
            'mobile_no' => 'required|max:15',
            'philgeps_reg_no' => 'required|max:50',
            'philgeps_validity' => 'required|date',
            'business_permit_no' => 'required|max:50',
            'business_permit_validity' => 'required|date',
            'line_of_business' => 'required|max:200',
            'valid_id' => 'nullable|file|max:100000',
            'philgeps_cert' => 'nullable|file|max:100000',
            'business_permit' => 'nullable|file|max:100000',
            'bir_cert' => 'nullable|file|max:100000',
            'dti_permit' => 'nullable|file|max:100000',
            'authorization' => 'nullable|file|max:100000',
            'company_profile' => 'nullable|file|max:100000',
            'company_address' => 'required|string|max:255',
            'facade' => 'nullable|file|max:100000',
            'dti_permit_validity' => 'required|date',
        ]);

        return DB::transaction(function () use ($request, $supplier) {
            if ($request->hasFile('valid_id')) {
                $valid_id_name = uniqid() . '_.' . $request->file('valid_id')->getClientOriginalExtension();
                $request->file('valid_id')->storeAs('suppliers/valid_ids', $valid_id_name, 'public');
                // Delete old file
                if ($supplier->valid_id) {
                    $oldFilePath = storage_path('app/public/suppliers/valid_ids/' . $supplier->valid_id);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $supplier->valid_id = $valid_id_name;
            }

            if ($request->hasFile('philgeps_cert')) {
                $philgeps_cert_name = uniqid() . '_.' . $request->file('philgeps_cert')->getClientOriginalExtension();
                $request->file('philgeps_cert')->storeAs('suppliers/philgeps_certs', $philgeps_cert_name, 'public');
                // Delete old file
                if ($supplier->philgeps_cert) {
                    $oldFilePath = storage_path('app/public/suppliers/philgeps_certs/' . $supplier->philgeps_cert);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $supplier->philgeps_cert = $philgeps_cert_name;
            }

            if ($request->hasFile('business_permit')) {
                $business_permit_name = uniqid() . '_.' . $request->file('business_permit')->getClientOriginalExtension();
                $request->file('business_permit')->storeAs('suppliers/business_permits', $business_permit_name, 'public');
                // Delete old file
                if ($supplier->business_permit) {
                    $oldFilePath = storage_path('app/public/suppliers/business_permits/' . $supplier->business_permit);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $supplier->business_permit = $business_permit_name;
            }

            if ($request->hasFile('bir_cert')) {
                $bir_cert_name = uniqid() . '_.' . $request->file('bir_cert')->getClientOriginalExtension();
                $request->file('bir_cert')->storeAs('suppliers/bir_certs', $bir_cert_name, 'public');
                // Delete old file
                if ($supplier->bir_cert) {
                    $oldFilePath = storage_path('app/public/suppliers/bir_certs/' . $supplier->bir_cert);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);                    
                    }
                }
                $supplier->bir_cert = $bir_cert_name;
            }

            if ($request->hasFile('dti_permit')) {
                $dti_permit_name = uniqid() . '_.' . $request->file('dti_permit')->getClientOriginalExtension();
                $request->file('dti_permit')->storeAs('suppliers/dti_permits', $dti_permit_name, 'public');
                // Delete old file
                if ($supplier->dti_permit) {
                    $oldFilePath = storage_path('app/public/suppliers/dti_permits/' . $supplier->dti_permit);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $supplier->dti_permit = $dti_permit_name;
            }
            if ($request->hasFile('authorization')) {
                $authorization_name = uniqid() . '_.' . $request->file('authorization')->getClientOriginalExtension();
                $request->file('authorization')->storeAs('suppliers/authorizations', $authorization_name, 'public');
                // Delete old file
                if ($supplier->authorization) {
                    $oldFilePath = storage_path('app/public/suppliers/authorizations/' . $supplier->authorization);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $supplier->authorization = $authorization_name;
            }
            if ($request->hasFile('company_facade')) {
                $company_facade_name = uniqid() . '_.' . $request->file('company_facade')->getClientOriginalExtension();
                $request->file('company_facade')->storeAs('suppliers/company_facades', $company_facade_name, 'public');
                // Delete old file
                if ($supplier->facade) {
                    $oldFilePath = storage_path('app/public/suppliers/company_facades/' . $supplier->facade);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $supplier->facade = $company_facade_name;
            }
            if ($request->hasFile('company_profile')) {
                $company_profile_name = uniqid() . '_.' . $request->file('company_profile')->getClientOriginalExtension();
                $request->file('company_profile')->storeAs('suppliers/company_profiles', $company_profile_name, 'public');
                // Delete old file
                if ($supplier->company_profile) {
                    $oldFilePath = storage_path('app/public/suppliers/company_profiles/' . $supplier->company_profile);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $supplier->company_profile = $company_profile_name;
            }

            $supplier->email = $request->email;
            $supplier->company_name = $request->company_name;
            $supplier->authorized_representative = $request->authorized_representative;
            $supplier->landline_no = $request->landline_no;
            $supplier->mobile_no = $request->mobile_no;
            $supplier->philgeps_reg_no = $request->philgeps_reg_no;
            $supplier->philgeps_validity = $request->philgeps_validity;
            $supplier->business_permit_no = $request->business_permit_no;
            $supplier->business_permit_validity = $request->business_permit_validity;
            $supplier->line_of_business = $request->line_of_business;
            $supplier->company_address = $request->company_address;
            $supplier->dti_permit_validity = $request->dti_permit_validity;
            $supplier->updated_at = now();
            $supplier->save();

            return redirect()->route('supplier.profile')->with('success', 'Profile updated successfully.');
        });
    }
}
        
