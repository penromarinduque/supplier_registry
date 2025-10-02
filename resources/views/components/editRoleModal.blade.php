<div class="modal fade" id="editRoleModal">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('users.updateRole', $user->id) }}" method="POST">
            <div class="modal-header">
                <h4 class="modal-title">Edit Role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($errors->updateRole->any())
                    <ul>
                        @foreach ($errors->updateRole->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                @csrf
                @method('PUT')
                <div class="mb2">
                    <label for="date">Roles</label>
                    <div class="">
                        <select name="roles[]" id="roles" class="form-control select2" multiple style="d-block" data-width="100%" data-theme="classic">
                            <option value="">-Select Role-</option>
                            @foreach ($role_types as $role_type)
                                <option value="{{ $role_type->id }}">{{ $role_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        @if($errors->updateRole->any())
            $('#editRoleModal').modal('show');
            $('#editRoleModal form').attr('action', '{{ session('url') }}');
        @endif

        $('.select2').select2();
    })
    function showEditRoleModal(roles, url) {
        $('#editRoleModal').modal('show');
        $('#editRoleModal #roles').val(roles.map(r => r.role_type_id)).trigger('change');
        console.log(roles.map(r => r.role_type_id));
        $('#editRoleModal form').attr('action', url);
    }
</script>