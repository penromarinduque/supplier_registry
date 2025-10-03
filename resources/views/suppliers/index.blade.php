@extends('layouts.main.master')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        {{-- <th style="width: 10px">#</th> --}}
                        <th>ACTIONS</th>
                        <th>COMPANY NAME</th>
                        <th>AUTHORIZED REPRESENTATIVE</th>
                        <th>LANDLINE NO. </th>
                        <th>MOBILE NUMBER</th>
                        <th>OFFICIAL E-MAIL ADDRESS</th>
                        <th>PHILGEPS REGISTRATION/CERTIFICATE NUMBER</th>
                        <th>VALIDITY OF PHILGEPS CERTIFICATE IF PLATINUM MEMBER</th>
                        <th>BUSINESS/MAYOR'S PERMIT NUMBER</th>
                        <th>VALIDITY OF  BUSINESS/MAYOR'S PERMIT</th>
                        <th>LINE OF BUSINESS</th>
                        <th>AUTHORIZED REPRESENTATIVE ID</th>
                        <th>BIR CERTIFICATE OF REGISTRATION/DTI PERMIT</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                        <tr>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete('{{ route('admin.suppliers.destroy', ['supplier' => $supplier->id])}}', 'Are you sure you want to delete this supplier?')">Delete</button>
                                </div>
                            </td>
                            <td>{{ $supplier->company_name }}</td>
                            <td>{{ $supplier->authorized_representative }}</td>
                            <td>{{ $supplier->landline_no }}</td>
                            <td>{{ $supplier->mobile_no }}</td>
                            <td>{{ $supplier->email }}</td>
                            <td><a href="{{ route('storage.view', ['url' => 'suppliers/philgeps_certs/' . $supplier->philgeps_cert])}}" target="_blank">{{ $supplier->philgeps_reg_no }}</a></td>
                            <td>{{ $supplier->philgeps_validity->format('F j, Y') }}</td>
                            <td><a href="{{ route('storage.view', ['url' => 'suppliers/business_permits/' . $supplier->business_permit])}}" target="_blank">{{ $supplier->business_permit_no }}</a></td>
                            <td>{{ $supplier->business_permit_validity->format('F j, Y') }}</td>
                            <td>{{ $supplier->line_of_business }}</td>
                            <td><a href="{{ route('storage.view', ['url' => 'suppliers/valid_ids/' . $supplier->valid_id])}}" target="_blank">View Valid ID</a></td>
                            <td>
                                <a href="{{ route('storage.view', ['url' => 'suppliers/bir_certs/' . $supplier->bir_cert])}}" target="_blank">View BIR Certificate</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="text-center">No suppliers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $suppliers->links() }}
    </div>
</div>
@endsection

@section('includes')
    @include('components.deleteConfirmationModal')
@endsection