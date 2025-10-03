@extends('layouts.full.master')
@section('content')
<div class="container">
    <br>
    <br>
    @include('components.header1')
    @include('components.title1')
    <div class="card">
        <div class="card-body">
            <h3 class="text-center">Supplier Registry Form</h3>
            <form action="{{ route('suppliers.store') }}" method="post" enctype="multipart/form-data">
                {{-- @foreach ($errors->store->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong> {{ $error }}
                    </div>
                @endforeach --}}
                <div class="row align-items-end">
                    @csrf
                    <div class="col col-md-6 col-lg-4 mb-2">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                        @error('email', 'store')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col col-md-6 col-lg-4 mb-2">
                        <label for="company_name">Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="company_name" id="company_name" class="form-control" value="{{ old('company_name') }}" required>
                        @error('company_name', 'store')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col col-md-6 col-lg-4 mb-2">
                        <label for="authorized_representative">Authorized Representative <span class="text-danger">*</span></label>
                        <input type="text" name="authorized_representative" id="authorized_representative" class="form-control" value="{{ old('authorized_representative') }}" required>
                        @error('authorized_representative', 'store')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col col-md-6 col-lg-4 mb-2">
                        <label for="landline_no">Landline No. <span class="text-danger">*</span></label>
                        <input type="text" name="landline_no" id="landline_no" class="form-control" value="{{ old('landline_no') }}" required>
                        @error('landline_no', 'store')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col col-md-6 col-lg-4 mb-2">
                        <label for="mobile_no">Mobile No. <span class="text-danger">*</span></label>
                        <input type="text" name="mobile_no" id="mobile_no" class="form-control" value="{{ old('mobile_no') }}" required>
                        @error('mobile_no', 'store')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col col-md-6 col-lg-4 mb-2">
                        <label for="philgeps_reg_no">PHILGEPS Registration/Certificate Number <span class="text-danger">*</span></label>
                        <input type="text" name="philgeps_reg_no" id="philgeps_reg_no" class="form-control" value="{{ old('philgeps_reg_no') }}" required>
                        @error('philgeps_reg_no', 'store')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col col-md-6 col-lg-4 mb-2">
                        <label for="philgeps_validity">Validity of PHILGEPS Certificate if Platinum Member <span class="text-danger">*</span></label>
                        <input type="date" name="philgeps_validity" id="philgeps_validity" class="form-control" value="{{ old('philgeps_validity') }}" required>
                        @error('philgeps_validity', 'store')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col col-md-6 col-lg-4 mb-2">
                        <label for="business_permit_no">Business/Mayor's Permit Number <span class="text-danger">*</span></label>
                        <input type="text" name="business_permit_no" id="business_permit_no" class="form-control" value="{{ old('business_permit_no') }}" required>
                        @error('business_permit_no', 'store')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col col-md-6 col-lg-4 mb-2">
                        <label for="business_permit_validity">Validity of Business/Mayor's Permit <span class="text-danger">*</span></label>
                        <input type="date" name="business_permit_validity" id="business_permit_validity" class="form-control" value="{{ old('business_permit_validity') }}" required>
                        @error('business_permit_validity', 'store')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col col-md-6 col-lg-4 mb-2">
                        <label for="line_of_business">Line of Business <span class="text-danger">*</span></label>
                        <input type="text" name="line_of_business" id="line_of_business" class="form-control" value="{{ old('line_of_business') }}" required>
                        @error('line_of_business', 'store')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col col-md-6 col-lg-4 mb-2">
                        <label for="valid_id">Upload Valid ID of Authorized Representative <span class="text-danger">*</span></label>
                        <input type="file" accept="image/*" name="valid_id" id="valid_id" class="form-control-file" required>
                        @error('valid_id', 'store')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col col-md-6 col-lg-4 mb-2">
                        <label for="philgeps_cert">Upload PHILGEPS Registration Certificate <span class="text-danger">*</span></label>
                        <input type="file" accept="image/*" name="philgeps_cert" id="philgeps_cert" class="form-control-file" required>
                        @error('philgeps_cert', 'store')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col col-md-6 col-lg-4 mb-2">
                        <label for="business_permit">Upload Valid and Current Business/Mayor's Permit <span class="text-danger">*</span></label>
                        <input type="file" accept="image/*" name="business_permit" id="business_permit" class="form-control-file" required>
                        @error('business_permit', 'store')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col col-md-6 col-lg-4 mb-2">
                        <label for="bir_cert">Upload BIR Certificate of Registration/DTI Permit <span class="text-danger">*</span></label>
                        <input type="file" accept="image/*" name="bir_cert" id="bir_cert" class="form-control-file" required>
                        @error('bir_cert', 'store')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary btn-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection