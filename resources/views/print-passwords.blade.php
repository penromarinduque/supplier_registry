@extends('layouts.print.master')
@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{ asset('adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('adminlte3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('adminlte3/dist/css/adminlte.min.css') }}">
@endsection
@section('content')

<section>
    @include('components.loader')
    <div class="row w-100 mx-auto">
        @foreach ($passwords as $password)
            <div class=" col-4 p-1" style="page-break-inside: avoid">
                <div class="m-0 border p-1">
                    <h5 class="text-center" id="time">Online Attendance System for Alternative Working Arrangement</h5>
                    <p class="mb-0"><span class="font-weight-bold">URL:</span> https://aas.penromarinduque.gov.ph/</p>
                    <p class="mb-0"><span class="font-weight-bold">Name:</span> {{ $password->name }}</p>
                    <p class="mb-0"><span class="font-weight-bold">TIN/Item No.:</span> {{ $password->username }}</p>
                    <p class="mb-0"><span class="font-weight-bold">Password:</span> {{ $password->password }}</p>
                </div>
            </div>
        @endforeach
    </div>
    
</section>
@endsection

@section('script')

@endsection