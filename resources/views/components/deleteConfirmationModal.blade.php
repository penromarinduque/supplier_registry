<div class="modal fade" id="deleteConfirmationModal">
    <div class="modal-dialog">
        <form class="modal-content" action="" method="POST">
            <div class="modal-header">
                <h4 class="modal-title">Delete Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                @method('DELETE')
                <div class="mb-2">
                    <p id="message"></p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-danger btn-submit">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function confirmDelete(url, message) {
        $('#deleteConfirmationModal').modal('show');
        $('#deleteConfirmationModal #message').text(message);
        $('#deleteConfirmationModal form').attr('action', url);
    }
</script>