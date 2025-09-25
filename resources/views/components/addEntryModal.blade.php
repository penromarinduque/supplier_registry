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
                <input type="hidden" name="photo" id="photoInput">
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
                {{-- <div class="mb-2">
                    <label for="photo">Photo</label>
                    <canvas id="snapshot" width="640" height="480" class="border"></canvas>
                    <video id="camera" width="100%" height="auto" autoplay></video>
                    <button id="takePhoto" class="btn btn-primary mt-2">Capture</button>
                </div> --}}
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-submit">Save Time Log</button>
                </div>
            </div>
        </form>
    </div>
</div>

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
        $("#addEntryModal #location").attr('placeholder', 'Fetching Location...');
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
<script>
    const video = document.getElementById('camera');
    const canvas = document.getElementById('snapshot');
    const context = canvas.getContext('2d');
    const takePhotoBtn = document.getElementById('takePhoto');
    const photoInput = document.getElementById('photoInput');

    // Start camera
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(err => {
            alert("Camera access denied: " + err);
        });

    // Capture button
    takePhotoBtn.addEventListener('click', () => {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const photoData = canvas.toDataURL('image/png');
        photoInput.value = photoData; // set to hidden input for form
    });
</script>