@extends('layouts.main.master')
{{-- @section('title', 'Time In') --}}
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active">Time In</li>
    </ol>
@endsection
@section('content')
<div class="mx-auto" style="max-width: 800px">
    <form action="{{ route('timein.show') }}" method="GET">
        <input type="hidden" name="division" value="{{ $division }}">
        <div class="mb-2">
            <label for="timein">DENR Item No. (For J.O. use TIN)</label>
            <input class="form-control" name="user_id" type="text" placeholder="eg. OSEC-DENRB-ADAS2-001-2004 for Item No. or 000-000-000-0000 for TIN" required>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Continue</button>
        </div>
    </form>
</div>
@endsection