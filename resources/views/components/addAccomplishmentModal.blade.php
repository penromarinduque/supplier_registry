<div class="modal fade" id="addAccomplishmentModal">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('accomplishments.store') }}" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title">Add Accomplishment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->addAccomplishment->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                @csrf
                <input type="hidden" name="task_id" id="task_id" value="{{ old('task_id') }}">
                <input type="hidden" name="user_id" value="{{ $user->userID }}">
                <input type="hidden" name="user_no" value="{{ $user->status == 'COS' ? $user->tin : $user->SSN }}">
                <input type="hidden" name="division" value="{{ $division }}">
                <div class="mb2">
                    <h5 class="text-center" id="time"></h5>
                </div>
                <div class="mb-2">
                    <label for="date">Accomplishment</label>
                    <textarea class="form-control" name="accomplishment">{{ old('accomplishment') }}</textarea>
                    @error('accomplishment', 'addAccomplishment')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="date">Attachment</label>
                    <input type="file" class="form-control-file" name="attachment" accept="image/*,application/pdf">
                    @error('attachment', 'addAccomplishment')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-submit">Save Accomplishment</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        @if ($errors->addAccomplishment->any())
            showAddAccomplishmentModal();
        @endif
    })

    function showAddAccomplishmentModal(task_id){
        $('#addAccomplishmentModal #time').text(new Date().toLocaleTimeString());
        $('#addAccomplishmentModal #task_id').val(task_id);
        $('#addAccomplishmentModal').modal('show');
    }
</script>