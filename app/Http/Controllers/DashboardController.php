<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function dashboard()
    {
        $supplierViewData = auth()->user()->isSupplier() ? [
            'dti_validity' => now()->lessThan(auth()->user()->supplier->dti_permit_validity) ? "Valid" : "Invalid",
            'business_permit_validity' => now()->lessThan(auth()->user()->supplier->business_permit_validity) ? "Valid" : "Invalid",
            'philgeps_validity' => now()->lessThan(auth()->user()->supplier->philgeps_validity) ? "Valid" : "Invalid",
        ] : [];
        $adminViewData = auth()->user()->isAdmin() ? [
            'suppliers_count' => Supplier::all()->count(),
            'eligible_suppliers_count' => Supplier::whereDate('business_permit_validity', '>=', now())
                ->whereDate('dti_permit_validity', '>=', now())
                ->whereDate('philgeps_validity', '>=', now())
                ->count(),
            'ineligible_suppliers_count' => Supplier::where(function ($q) {
                $q->whereDate('business_permit_validity', '<', now())
                ->orWhereDate('dti_permit_validity', '<', now())
                ->orWhereDate('philgeps_validity', '<', now());
            })->count(),
        ] : [];
        return view('dashboard', compact('supplierViewData', 'adminViewData'));
    }

}
