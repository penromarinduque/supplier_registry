@extends('layouts.main.master')
{{-- @section('title', 'Time In') --}}
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item "><a href="{{ route('users.index', ['division' => request('division')]) }}">Users</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                Create User
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="mb-2 col-12 col-lg-4 col-md-6">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input class="form-control" name="name" id="name" type="text" placeholder="Name" value="{{ old('name') }}" required>
                        @error('name', 'addUser')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2 col-12 col-lg-4 col-md-6">
                        <label for="dtr_user_id">DTR User Id <span class="text-danger">*</span></label>
                        <input class="form-control" name="dtr_user_id" id="dtr_user_id" type="text" placeholder="Dtr User Id" value="{{ old('dtr_user_id') }}" required>
                        @error('dtr_user_id', 'addUser')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2 col-12 col-lg-4 col-md-6">
                        <label for="dtr_badge_number">DTR Badge Number <span class="text-danger">*</span></label>
                        <input class="form-control" name="dtr_badge_number" id="dtr_badge_number" type="text" placeholder="Dtr Badge Number" value="{{ old('dtr_badge_number') }}" required>
                        @error('dtr_badge_number', 'addUser')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2 col-12 col-lg-4 col-md-6">
                        <label for="division">Division <span class="text-danger">*</span></label>
                        <select name="division" class="form-control" id="division">
                            <option value="">-Select Division-</option>
                            <option value="msd">Management Services Division/Office of the PENRO</option>
                            <option value="tsd">Technical Services Division</option>
                            <option value="pamo">Protected Area Management Office</option>
                        </select>
                        @error('division', 'addUser')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2 col-12 col-lg-4 col-md-6">
                        <label for="ssn">SSN <span class="text-muted font-italic font-weight-normal">For Permanent Employee</span></label>
                        <input class="form-control" name="ssn" id="ssn" type="text" placeholder="SSN" value="{{ old('ssn') }}" >
                        @error('ssn', 'addUser')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2 col-12 col-lg-4 col-md-6">
                        <label for="gender">Gender <span class="text-danger">*</span></label>
                        <select name="gender" class="form-control" id="gender">
                            <option value="">-Select Gender-</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                        @error('gender', 'addUser')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2 col-12 col-lg-4 col-md-6">
                        <label for="position">Position <span class="text-danger">*</span></label>
                        <input class="form-control" name="position" id="position" type="text" placeholder="Position" value="{{ old('position') }}" required>
                        @error('position', 'addUser')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2 col-12 col-lg-4 col-md-6">
                        <label for="contact_number">Contact Number</label>
                        <input class="form-control" name="contact_number" id="contact_number" type="text" placeholder="Position" value="{{ old('contact_number') }}" >
                        @error('contact_number', 'addUser')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2 col-12 col-lg-4 col-md-6">
                        <label for="birthdate">Birthdate</label>
                        <input class="form-control" name="birthdate" id="birthdate" type="date" placeholder="Birtdate" value="{{ old('birthdate') }}" >
                        @error('birthdate', 'addUser')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2 col-12 col-lg-4 col-md-6">
                        <label for="address">Address</label>
                        <input class="form-control" name="address" id="address" type="date" placeholder="Address" value="{{ old('address') }}" >
                        @error('address', 'addUser')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2 col-12 col-lg-4 col-md-6">
                        <label for="tin">TIN</label>
                        <input class="form-control" name="tin" id="tin" type="text" placeholder="TIN" value="{{ old('tin') }}" >
                        @error('tin', 'addUser')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2 col-12 col-lg-4 col-md-6">
                        <label for="employment_status">Employment Status <span class="text-danger">*</span></label>
                        <select name="employment_status" class="form-control" id="employment_status">
                            <option value="">-Select Employment Status-</option>
                            <option value="COS">COS</option>
                            <option value="Permanent">Permanent</option>
                            <option value="SPES">SPES</option>
                            <option value="OJT">OJT</option>
                            <option value="GIP">GIP</option>
                        </select>
                        @error('employment_status', 'addUser')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4 col-md-6 mb-2">
                        <label for="username">Username <span class="text-danger">*</span></label>
                        <input class="form-control" name="username" id="username" type="text" placeholder="Username" value="{{ old('username') }}" required>
                        @error('username', 'addUser')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 col-lg-4 col-md-6 mb-2">
                        <label for="password">Temporary Password <span class="text-danger">*</span></label>
                        <input class="form-control" name="password" id="password" type="text" placeholder="Temporary Password" value="{{ old('password') }}" required>
                        @error('password', 'addUser')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-sm btn-primary btn-submit"><i class="fas fa-save mr-2"></i>Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('includes')

@endsection