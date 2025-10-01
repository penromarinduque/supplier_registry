@extends('layouts.main.master')
{{-- @section('title', 'Time In') --}}
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active">Users</li>
    </ol>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">Users List</div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-outline-primary" title="Reset Password" onclick="showEditPasswordModal('{{route('users.resetPassword', $user->id)}}')"><i class="fas fa-key"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@section('includes')
    @include('components.resetPasswordModal')
@endsection