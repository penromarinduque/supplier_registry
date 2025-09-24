<div class="modal fade" id="editTaskModal">
    <div class="modal-dialog">
        <form class="modal-content" action="" method="POST">
            <div class="modal-header">
                <h4 class="modal-title">Edit Task</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($errors->updateTask->any())
                    <ul>
                        @foreach ($errors->updateTask->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                @csrf
                @method('PUT')
                <div class="mb2">
                    <h5 class="text-center" id="time"></h5>
                </div>
                <div class="mb-2">
                    <label for="date">Task</label>
                    <textarea class="form-control" name="task" id="task" placeholder="Task">{{ old('task') }}</textarea>
                    @error('task', 'updateTask')
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
        @if($errors->updateTask->any())
            $('#editTaskModal').modal('show');
            $('#editTaskModal form').attr('action', '{{ session('url') }}');
        @endif
    })
    function showEditTaskModal(task, url) {
        $('#editTaskModal').modal('show');
        $('#editTaskModal #task').val(task);
        $('#editTaskModal form').attr('action', url);
    }
</script>