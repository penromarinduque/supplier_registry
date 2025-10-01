@extends('layouts.main.master')
{{-- @section('title', 'Time In') --}}
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active">Settings</li>
    </ol>
@endsection
@section('content')
<div class="mx-auto" style="max-width: 800px">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Change Password</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('settings.updatePassword') }}" method="POST">
                @csrf
                <div class="mb-2">
                    <label for="timein">Current Password</label>
                    <div class="input-group">
                        <input class="form-control" name="current_password" type="password" id="current_password" placeholder="Current Password"  required>
                        <div class="input-group-prepend " type="button" onclick="togglePassword('current_password', this)">
                            <i class="fas fa-eye input-group-text"></i>
                        </div>
                    </div>
                    @error('current_password', 'updatePassword')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="timein">New Password</label>
                    <div class="input-group">
                        <input class="form-control" name="new_password" type="password" id="new_password" placeholder="New Password"  required>
                        <div class="input-group-prepend " type="button" onclick="togglePassword('new_password', this)">
                            <i class="fas fa-eye input-group-text"></i>
                        </div>
                    </div>
                    @error('new_password', 'updatePassword')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="timein">Confirm New Password</label>
                    <div class="input-group">
                        <input class="form-control" name="new_password_confirmation" type="password" id="new_password_confirmation" placeholder="Confirm New Password"  required>
                        <div class="input-group-prepend " type="button" onclick="togglePassword('new_password_confirmation', this)">
                            <i class="fas fa-eye input-group-text"></i>
                        </div>
                    </div>
                    @error('new_password_confirmation', 'updatePassword')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection