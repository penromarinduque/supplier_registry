@extends('layouts.main.master')
{{-- @section('title', 'Time In') --}}
@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active">Time Logs</li>
    </ol>
@endsection
@section('content')
<div class="mx-auto" style="max-width: 1000px">
    <h4 class="text-center">Hello <span class="text-primary">{{ $user->name }}</span>!</h4>
    <p class="text-muted text-center">These are your time logs for the day</p>
    <div class="table-responsive">
        <table class="table" style="min-width: 800px; width: 100%">
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
                            <div class="p-2 py-3" >
                                <div class="py-1">
                                    <button class="btn btn-sm btn-outline-danger" title="Delete Accomplishment" onclick="confirmDelete('{{ route('accomplishments.delete', $accomplishment->id) }}', 'Are you sure you want to delete this accomplishment?')"><i class="fas fa-trash " style="font-size: 10px "></i></button>
                                    <button class="btn btn-sm btn-outline-secondary" title="Edit Accomplishment" onclick="showUpdateAccomplishmentModal('{{ $accomplishment->accomplishment }}', '{{ route('accomplishments.update', $accomplishment->id) }}')"><i class="fas fa-pencil-alt " style="font-size: 10px"></i></button>
                                    @if ($accomplishment->file)
                                        <a class="btn btn-sm btn-outline-secondary" title="Download Attachment" href="{{ route('accomplishments.downloadFile', $accomplishment->id) }}"><i class="fas fa-paperclip " style="font-size: 10px"></i></a>
                                        <button class="btn btn-outline-danger btn-sm" onclick="confirmDelete('{{ route('accomplishments.deleteFile', $accomplishment->id) }}', 'Are you sure you want to delete this file?')" ><i class="fas fa-unlink " style="font-size: 10px"></i></button>
                                    @endif
                                </div>
                                <p>
                                    {{ $accomplishment->accomplishment }} 
                                </p>
                            </div>
                            @endforeach
                        {{-- </ul> --}}
                    </td>
                    <td align="center" width="250px">
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

@endsection

@section('includes')
    @include('components.addTaskModal')
    @include('components.editTaskModal')
    @include('components.addAccomplishmentModal')
    @include('components.editAccomplishmentModal')
    @include('components.deleteConfirmationModal')
    @include('components.addEntryModal')
@endsection