@extends('layouts.main.master')
@section('content')
<div class="container">
    <form action="{{ route('supplier.update', ['id' => $supplier->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <ul>
            @foreach ($errors->updateProfile->all() as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
        <div class="card">
            <div class="card-body">
                <h4>Company Profile</h4>
                <div class="form-group">
                    <label for="company_name">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name', $supplier->company_name) }}" >
                    @error('company_name', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="company_profile">Update Company Profile</label>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <input type="file" accept="image/*,application/pdf" placeholder="Update Company Profile" class="form-control-file" id="company_profile" name="company_profile" >
                        </div>
                        <div class="col-12 col-md-6">
                            @if ($supplier->company_profile)
                                <a href="{{ route('storage.view', ['url' => '/suppliers/company_profiles/' . $supplier->company_profile]) }}" target="_blank">View Current Profile</a>
                            @else
                                <span>No profile uploaded.</span>
                            @endif
                        </div>
                    </div>
                    @error('company_profile', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="facade">Update Company Building/Office Facade (showing company logo, if any)</label>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <input type="file" accept="image/*,application/pdf"  class="form-control-file" id="facade" name="facade" >
                        </div>
                        <div class="col-12 col-md-6">
                            @if ($supplier->facade)
                                <a href="{{ route('storage.view', ['url' => '/suppliers/company_facades/' . $supplier->facade]) }}" target="_blank">View Current Facade</a>
                            @else
                                <span>No facade uploaded.</span>
                            @endif
                        </div>
                    </div>
                    @error('facade', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="company_address">Company Address</label>
                    <input type="text" class="form-control" id="company_address" name="company_address" value="{{ old('company_address', $supplier->company_address) }}" >
                    @error('company_address', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="line_of_business">Line of Business</label>
                    <input type="text" class="form-control" id="line_of_business" name="line_of_business" value="{{ old('line_of_business', $supplier->line_of_business) }}" >
                    @error('line_of_business', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <hr>
                <div class="form-group">
                    <label for="philgeps_reg_no">PHILGEPS Registration/Certificate Number</label>
                    <input type="text" class="form-control" id="philgeps_reg_no" name="philgeps_reg_no" value="{{ old('philgeps_reg_no', $supplier->philgeps_reg_no) }}" >
                    @error('philgeps_reg_no', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="philgeps_validity">PHILGEPS Validity</label>
                    <input type="date" class="form-control" id="philgeps_validity" name="philgeps_validity" value="{{ old('philgeps_validity', $supplier->philgeps_validity->format('Y-m-d')) }}" >
                    @error('philgeps_validity', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="philgeps_cert">Update PHILGEPS Registration Certificate</label>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <input type="file" accept="image/*,application/pdf"  class="form-control-file" id="philgeps_cert" name="philgeps_cert" >
                        </div>
                        <div class="col-12 col-md-6">
                            @if ($supplier->philgeps_cert)
                                <a href="{{ route('storage.view', ['url' => '/suppliers/philgeps_certs/' . $supplier->philgeps_cert]) }}" target="_blank">View Current PHILGEPS Certificate</a>
                            @else
                                <span>No PHILGEPS Registration Certificate uploaded.</span>
                            @endif
                        </div>
                    </div>
                    @error('philgeps_cert', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <hr>
                <div class="form-group">
                    <label for="business_permit_no">Business/Mayor's Permit Number</label>
                    <input type="text" class="form-control" id="business_permit_no" name="business_permit_no" value="{{ old('business_permit_no', $supplier->business_permit_no) }}" >
                    @error('business_permit_no', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="business_permit_validity">Validity of Business/Mayor's Permit</label>
                    <input type="date" class="form-control" id="business_permit_validity" name="business_permit_validity" value="{{ old('business_permit_validity', $supplier->business_permit_validity->format('Y-m-d')) }}" >
                    @error('business_permit_validity', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="business_permit">Update Current Business/Mayor's Permit</label>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <input type="file" accept="image/*,application/pdf"  class="form-control-file" id="business_permit" name="business_permit" >
                        </div>
                        <div class="col-12 col-md-6">
                            @if ($supplier->business_permit)
                                <a href="{{ route('storage.view', ['url' => '/suppliers/business_permits/' . $supplier->business_permit]) }}" target="_blank">View Current Business/Mayor's Permit</a>
                            @else
                                <span>No Business/Mayor's Permit uploaded.</span>
                            @endif
                        </div>
                    </div>
                    @error('business_permit', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <hr>
                <div class="form-group">
                    <label for="bir_cert">Update BIR Certificate of Registration</label>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <input type="file" accept="image/*,application/pdf"  class="form-control-file" id="bir_cert" name="bir_cert" >
                        </div>
                        <div class="col-12 col-md-6">
                            @if ($supplier->bir_cert)
                                <a href="{{ route('storage.view', ['url' => '/suppliers/bir_certs/' . $supplier->bir_cert]) }}" target="_blank">View Current BIR Certificate</a>
                            @else
                                <span>No BIR Certificate uploaded.</span>
                            @endif
                        </div>
                    </div>
                    @error('bir_cert', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="dti_permit">Update DTI Permit</label>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <input type="file" accept="image/*,application/pdf"  class="form-control-file" id="dti_permit" name="dti_permit" >
                        </div>
                        <div class="col-12 col-md-6">
                            @if ($supplier->dti_permit)
                                <a href="{{ route('storage.view', ['url' => '/suppliers/dti_permits/' . $supplier->dti_permit]) }}" target="_blank">View Current DTI Permit</a>
                            @else
                                <span>No DTI Permit uploaded.</span>
                            @endif
                        </div>
                    </div>
                    @error('dti_permit', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="dti_permit_validity">Validity of DTI Permit</label>
                    <input type="date" class="form-control" id="dti_permit_validity" name="dti_permit_validity" value="{{ old('dti_permit_validity', $supplier->dti_permit_validity->format('Y-m-d')) }}" >
                    @error('dti_permit_validity', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4>Authorized Representative</h4>
                <div class="form-group">
                    <label for="authorized_representative">Authorized Representative</label>
                    <input type="text" class="form-control" id="authorized_representative" name="authorized_representative" value="{{ old('authorized_representative', $supplier->authorized_representative) }}" >
                    @error('authorized_representative', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="landline_no">Landline No.</label>
                    <input type="text" class="form-control" id="landline_no" name="landline_no" value="{{ old('landline_no', $supplier->landline_no) }}" >
                    @error('landline_no', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="mobile_no">Mobile No.</label>
                    <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="{{ old('mobile_no', $supplier->mobile_no) }}" >
                    @error('mobile_no', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="valid_id">Update Valid ID of Authorized Representative</label>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <input type="file" accept="image/*,application/pdf"  class="form-control-file" id="valid_id" name="valid_id" >
                        </div>
                        <div class="col-12 col-md-6">
                            @if ($supplier->valid_id)
                                <a href="{{ route('storage.view', ['url' => '/suppliers/valid_ids/' . $supplier->valid_id]) }}" target="_blank">View Current Valid ID</a>
                            @else
                                <span>No Valid ID uploaded.</span>
                            @endif
                        </div>
                    </div>
                    @error('valid_id', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="valid_id">Update Valid ID of Authorized Representative</label>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <input type="file" accept="image/*,application/pdf"  class="form-control-file" id="valid_id" name="valid_id" >
                        </div>
                        <div class="col-12 col-md-6">
                            @if ($supplier->valid_id)
                                <a href="{{ route('storage.view', ['url' => '/suppliers/valid_ids/' . $supplier->valid_id]) }}" target="_blank">View Current Valid ID</a>
                            @else
                                <span>No Valid ID uploaded.</span>
                            @endif
                        </div>
                    </div>
                    @error('valid_id', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="authorization">Update Notarized Special Power of Attorney/Board Resolution/Authorization as authorize representative valid for six (6) months</label>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <input type="file" accept="image/*,application/pdf"  class="form-control-file" id="authorization" name="authorization" >
                        </div>
                        <div class="col-12 col-md-6">
                            @if ($supplier->authorization)
                                <a href="{{ route('storage.view', ['url' => '/suppliers/authorizations/' . $supplier->authorization]) }}" target="_blank">View Current Authorization</a>
                            @else
                                <span>No Authorization uploaded.</span>
                            @endif
                        </div>
                    </div>
                    @error('authorization', 'updateProfile')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary btn-submit">
                <i class="fas fa-save me-2"></i>
                Save
            </button>
        </div>
    </form>
</div>
@endsection
