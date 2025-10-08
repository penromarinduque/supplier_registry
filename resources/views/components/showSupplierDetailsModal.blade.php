<div class="modal fade" id="supplierDetailsModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Supplier Details</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="supplierDetailsContent">
                    <!-- Supplier details will be loaded here via JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    function showSupplierDetails(url) {
        $('#supplierDetailsModal').modal('show');
        $.ajax({
            url: url,
            method: 'GET',
            success: function(data) {
                $('#supplierDetailsContent').html(data);
            },
            error: function() {
                $('#supplierDetailsContent').html('<p class="text-danger">Failed to load supplier details.</p>');
            }
        })
    }
</script>