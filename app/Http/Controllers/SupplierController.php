<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'valid_id' => 'required|file|mimes:jpg,jpeg,png|max:100000',
            'philgeps_cert' => 'required|file|mimes:jpg,jpeg,png|max:100000',
            'business_permit' => 'required|file|mimes:jpg,jpeg,png|max:100000',
            'bir_cert' => 'required|file|mimes:jpg,jpeg,png|max:100000'
        ]);

        return DB::transaction(function () use ($request) {
            $valid_id_name = uniqid() . '_.' . $request->file('valid_id')->getClientOriginalExtension();
            $valid_id_path = $request->file('valid_id')->storeAs('suppliers/valid_ids', $valid_id_name, 'public');
            $philgeps_cert_name = uniqid() . '_.' . $request->file('philgeps_cert')->getClientOriginalExtension();
            $philgeps_cert_path = $request->file('philgeps_cert')->storeAs('suppliers/philgeps_certs', $philgeps_cert_name, 'public');
            $business_permit_name = uniqid() . '_.' . $request->file('business_permit')->getClientOriginalExtension();
            $business_permit_path = $request->file('business_permit')->storeAs('suppliers/business_permits', $business_permit_name, 'public');
            $bir_cert_name = uniqid() . '_.' . $request->file('bir_cert')->getClientOriginalExtension();
            $bir_cert_path = $request->file('bir_cert')->storeAs('suppliers/bir_certs', $bir_cert_name, 'public');

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
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('suppliers.register')->with('success', 'Supplier registered successfully.');
        });

    }

    public function index()
    {
        $suppliers = Supplier::query()->paginate(20);
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

        // Delete the supplier record
        $supplier->delete();

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}
        
