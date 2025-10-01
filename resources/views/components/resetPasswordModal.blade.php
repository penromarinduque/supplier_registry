<div class="modal fade" id="resetPasswordModal">
    <div class="modal-dialog">
        <form class="modal-content" action="" method="POST">
            <div class="modal-header">
                <h4 class="modal-title">Reset Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($errors->resetPassword->any())
                    <ul>
                        @foreach ($errors->resetPassword->all() as $error)
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
                    <label for="date">Password</label>
                    <input type="text" class="form-control" name="password" placeholder="Password">
                    @error('password', 'resetPassword')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-submit">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        @if($errors->resetPassword->any())
            $('#resetPasswordModal').modal('show');
            $('#resetPasswordModal form').attr('action', '{{ session('url') }}');
        @endif
    })
    function showEditPasswordModal(url) {
        $('#resetPasswordModal').modal('show');
        $('#resetPasswordModal form').attr('action', url);
    }
</script>