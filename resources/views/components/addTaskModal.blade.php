<div class="modal fade" id="addTaskModal">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('tasks.store') }}" method="POST">
            <div class="modal-header">
                <h4 class="modal-title">Add Task</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($errors->addTask->any())
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
                <div class="mb2">
                    <h5 class="text-center" id="time"></h5>
                </div>
                <div class="mb-2">
                    <label for="date">Task</label>
                    <textarea class="form-control" name="task" placeholder="Task">{{ old('task') }}</textarea>
                    @error('task', 'addTask')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-submit">Save Task</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        @if($errors->addTask->any())
            $('#addTaskModal').modal('show');
        @endif
    })
    function showAddTaskModal() {
        $('#addTaskModal').modal('show');
    }
</script>