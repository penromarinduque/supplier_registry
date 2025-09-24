@extends('layouts.main.master')
{{-- @section('title', 'Time In') --}}
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active">Time Logs</li>
    </ol>
@endsection
@section('content')
<div class="mx-auto" style="max-width: 800px">
    <h4 class="text-center">Welcome back <span class="text-primary">{{ $user->name }}</span>!</h4>
    <p class="text-muted text-center">These are your time logs for the day</p>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>AM IN</th>
                    <th>AM OUT</th>
                    <th>PM IN</th>
                    <th>PM OUT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ date('F d, Y') }}</td>
                    <td>
                        @if (!$time_entries)
                            <button class="btn btn-sm btn-outline-primary" onclick="showAddEntryModal('am_in')">AM IN</button>
                        @endif
                        @if ($time_entries && $time_entries->am_in)
                            {{ $time_entries->am_in->format('h:i A') }}
                        @endif
                    </td>
                    <td>
                        @if ($time_entries && $time_entries->am_in && !$time_entries->am_out)
                            <button class="btn btn-sm btn-outline-secondary" onclick="showAddEntryModal('am_out')">AM OUT</button>
                        @endif
                        @if ($time_entries && $time_entries->am_out)
                            {{ $time_entries->am_out->format('h:i A') }}
                        @endif
                    </td>
                    <td>
                        @if ($time_entries && $time_entries->am_out && !$time_entries->pm_in)
                            <button class="btn btn-sm btn-outline-primary" onclick="showAddEntryModal('pm_in')">PM IN</button>
                        @endif
                        @if ($time_entries && $time_entries->pm_in)
                            {{ $time_entries->pm_in->format('h:i A') }}
                        @endif
                    </td>
                    <td>
                        @if ($time_entries && $time_entries->pm_in && !$time_entries->pm_out)
                            <button class="btn btn-sm btn-outline-secondary" onclick="showAddEntryModal('pm_out')">PM OUT</button>
                        @endif
                        @if ($time_entries && $time_entries->pm_out)
                            {{ $time_entries->pm_out->format('h:i A') }}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end">
        {{-- <button class="btn btn-primary" onclick="showAddAccomplishmentModal()">
            <i class="fas fa-plus"></i> Add Accomplishment
        </button> --}}
        <button class="btn btn-primary" onclick="showAddTaskModal()">
            <i class="fas fa-plus"></i> Add Task
        </button>
    </div>
    <hr>
    <form action="{{ route('timeEntries.printDtr') }}" method="GET">
        <input type="hidden" name="division" value="{{ $division }}">
        <input type="hidden" name="user_id" value="{{ $user->userID }}">
        <div class="mb-2">
            <label for="timein">Select DTR Date</label>
            <input class="form-control" name="date" value="{{ date('Y-m-d') }}" type="date" max="{{ date('Y-m-d') }}" placeholder="Select Date">
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">View DTR</button>
        </div>
    </form>
    <br>
    <hr>
    <h5>Tasks</h5>
    <div class="table-responsive">
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Accomplishments</th>
                    <th>Actions</th>
                </tr>
            </thead>
            @forelse ($tasks as $task)
                <tr>
                    <td>{{ $task->task }}</td>
                    <td>
                        {{-- <ul> --}}
                            @foreach ($task->accomplishments as $accomplishment)
                                <div class="py-1">
                                    <button class="btn btn-sm btn-outline-danger" title="Delete Accomplishment" onclick="confirmDelete('{{ route('accomplishments.delete', $accomplishment->id) }}', 'Are you sure you want to delete this accomplishment?')"><i class="fas fa-trash " style="font-size: 10px "></i></button>
                                    <button class="btn btn-sm btn-outline-secondary" title="Edit Accomplishment" onclick="showUpdateAccomplishmentModal('{{ $accomplishment->accomplishment }}', '{{ route('accomplishments.update', $accomplishment->id) }}')"><i class="fas fa-pencil-alt " style="font-size: 10px"></i></button>
                                    &nbsp;&nbsp;&nbsp;{{ $accomplishment->accomplishment }} 
                                </div>
                            @endforeach
                        {{-- </ul> --}}
                    </td>
                    <td align="center">
                        <button class="btn btn-sm btn-outline-primary" onclick="showAddAccomplishmentModal('{{ $task->id }}')">Add Accomplishment</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete('{{ route('tasks.delete', $task->id) }}', 'Are you sure you want to delete this task?')"><i class="fas fa-trash"></i></button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="showEditTaskModal('{{ $task->task }}', '{{ route('tasks.update', $task->id) }}')"><i class="fas fa-pencil-alt"></i></button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No Tasks</td>
                </tr>
            @endforelse
        </table>
    </div>
</div>

<div class="modal fade" id="addEntryModal">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('timeEntries.store') }}" method="POST">
            <div class="modal-header">
                <h4 class="modal-title">Log Time</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->userID }}">
                <input type="hidden" name="user_no" value="{{ $user->status == 'COS' ? $user->tin : $user->SSN }}">
                <input type="hidden" name="division" value="{{ $division }}">
                <input type="hidden" name="entry_type" id="entry_type" value="{{ old('entry_type') }}">
                <input type="hidden" name="location" id="location" value="{{ old('location') }}">
                <div class="mb2">
                    <h5 class="text-center" id="time"></h5>
                </div>
                <div class="mb-2">
                    <label for="date">Location</label>
                    <input class="form-control" id="location" disabled value="{{ old('location') }}">
                    @error('location')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-submit">Save Time Log</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
    <script>
        $(function(){
            @if ($errors->any())
                showAddEntryModal('{{ old('entry_type') }}');
            @endif
        })
        function showAddEntryModal(entryType){
            getLocation();
            $('#addEntryModal #entry_type').val(entryType);
            $('#addEntryModal #time').text(new Date().toLocaleTimeString());
            $('#addEntryModal').modal('show');
        }
        
        function getLocation() {
            console.log("asd")
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else { 
                $("#addEntryModal #location").val("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            $("#addEntryModal #location").val(
                position.coords.latitude + "," + position.coords.longitude
            );
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    $("#addEntryModal #location").val("Work from home (GPS denied)");
                    break;
                case error.POSITION_UNAVAILABLE:
                    $("#addEntryModal #location").val("Work from home (GPS unavailable)");
                    break;
                case error.TIMEOUT:
                    $("#addEntryModal #location").val("Work from home (GPS timed out)");
                    break;
                case error.UNKNOWN_ERROR:
                    $("#addEntryModal #location").val("Work from home (no GPS)");
                    break;
            }
        }

    </script>
@endsection

@section('includes')
    @include('components.addTaskModal')
    @include('components.editTaskModal')
    @include('components.addAccomplishmentModal')
    @include('components.editAccomplishmentModal')
    @include('components.deleteConfirmationModal')
@endsection