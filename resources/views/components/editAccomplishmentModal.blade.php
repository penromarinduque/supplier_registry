<div class="modal fade" id="editAccomplishmentModal">
    <div class="modal-dialog">
        <form class="modal-content" action="" method="POST">
            <div class="modal-header">
                <h4 class="modal-title">Edit Accomplishment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($errors->updateAccomplishment->any())
                    <ul>
                        @foreach ($errors->updateAccomplishment->all() as $error)
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
                    <label for="date">Accomplishment</label>
                    <textarea class="form-control" name="accomplishment" id="accomplishment">{{ old('accomplishment') }}</textarea>
                    @error('accomplishment', 'updateAccomplishment')
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
        @if ($errors->updateAccomplishment->any())
            $('#editAccomplishmentModal form').attr('action', '{{ session('url') }}');
            $('#editAccomplishmentModal').modal('show');
        @endif
    })

    function showUpdateAccomplishmentModal(accomplishment, url) {
        $('#editAccomplishmentModal #accomplishment').val(accomplishment);
        $('#editAccomplishmentModal form').attr('action', url);
        $('#editAccomplishmentModal').modal('show');
    }
</script>