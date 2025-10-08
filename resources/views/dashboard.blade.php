@extends('layouts.main.master')
@section('content')
    @if (auth()->user()->isAdmin())
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ number_format($adminViewData['suppliers_count'], 0, ',', ',') }}</h3>
                    <p>Registered Suppliers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($adminViewData['eligible_suppliers_count'], 0, ',', ',') }}</h3>
                    <p>Eligible Bidders/Suppliers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format($adminViewData['ineligible_suppliers_count'], 0, ',', ',') }}</h3>
                    <p>Not Eligible Biddlers/Suppliers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if (auth()->user()->isSupplier())
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-{{ $supplierViewData['business_permit_validity'] === 'Valid' ? 'success' : 'danger' }}">
                <div class="inner">
                    <h3>{{ $supplierViewData['business_permit_validity'] }}</h3>
                    <p>Business Permit Status</p>
                </div>
                <div class="icon">
                    @if ($supplierViewData['business_permit_validity'] === 'Valid')
                        <i class="fas fa-check-double"></i>
                    @else
                        <i class="fas fa-exclamation-triangle"></i>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-{{ $supplierViewData['dti_validity'] === 'Valid' ? 'success' : 'danger' }}">
                <div class="inner">
                    <h3>{{ $supplierViewData['dti_validity'] }}</h3>
                    <p>DTI Permit Status</p>
                </div>
                <div class="icon">
                    @if ($supplierViewData['dti_validity'] === 'Valid')
                        <i class="fas fa-check-double"></i>
                    @else
                        <i class="fas fa-exclamation-triangle"></i>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-{{ $supplierViewData['philgeps_validity'] === 'Valid' ? 'success' : 'danger' }}">
                <div class="inner">
                    <h3>{{ $supplierViewData['philgeps_validity'] }}</h3>
                    <p>PhilGEPS Status</p>
                </div>
                <div class="icon">
                    @if ($supplierViewData['philgeps_validity'] === 'Valid')
                        <i class="fas fa-check-double"></i>
                    @else
                        <i class="fas fa-exclamation-triangle"></i>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

