<div class="modal fade" id="addEntryModal">
    <div class="modal-dialog modal-dialog-lg">
        <form class="modal-content" action="{{ route('timeEntries.store') }}" method="POST" enctype="multipart/form-data">
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
                <input type="hidden" name="photo" id="photoInput" value="">
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
                <div class="mb-2 ">
                    <div class="p-2 bg-light">
                        <label for="photo">Photo</label>
                        <canvas id="snapshot" width="0" height="0" style="width: 100%" class="border"></canvas>
                        <video id="camera" width="100%" height="auto" autoplay></video>
                        <div class="d-flex justify-content-end">
                            {{-- <button id="rotateCamera" onclick="startCamera('back')" type="button" class="btn btn-secondary mt-2">Rotate</button> --}}
                            <button id="takePhoto" type="button" class="btn btn-success mt-2">Capture</button>
                            <button id="retakePhoto" type="button" class="btn btn-outline-success mt-2">Retake</button>
                        </div>
                        <p id="photo-error-msg" class="text-warning"></p>
                    </div>
                </div>
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
    // $(document).ready(function() {
    //     const $video = $("#camera");
    //     const $canvas = $("#snapshot");
    //     const context = $canvas[0].getContext("2d");
    //     const $takePhotoBtn = $("#takePhoto");
    //     const $photoInput = $("#photoInput");
    //     const $retakePhotoBtn = $("#retakePhoto");

    //     $retakePhotoBtn.hide();
    //     $canvas.hide();

    //     // Start camera
    //     navigator.mediaDevices.getUserMedia({ video: true })
    //         .then(function(stream) {
    //             $video[0].srcObject = stream;
    //         })
    //         .catch(function(err) {
    //             alert("Camera access denied: " + err);
    //         });

    //     // Capture button
    //     $takePhotoBtn.on("click", function() {
    //         $canvas.show();
    //         $retakePhotoBtn.show();
    //         $takePhotoBtn.hide();
    //         $canvas[0].width = $video[0].videoWidth;
    //         $canvas[0].height = $video[0].videoHeight;
    //         $video.hide();
    //         context.drawImage($video[0], 0, 0, $canvas[0].width, $canvas[0].height);
            
    //         const photoData = $canvas[0].toDataURL("image/png");
    //         $photoInput.val(photoData); // set hidden input for form
            
    //     });

    //     $retakePhotoBtn.on("click", function() {
    //         $canvas.hide();
    //         $retakePhotoBtn.hide();
    //         $takePhotoBtn.show();
    //         $video.show();
    //     });
    // });

$(document).ready(function() {
    const $video = $("#camera");
    const $canvas = $("#snapshot");
    const context = $canvas[0].getContext("2d");
    const $takePhotoBtn = $("#takePhoto");
    const $photoInput = $("#photoInput");
    const $retakePhotoBtn = $("#retakePhoto");

    takePhoto();

    // Start camera
    // navigator.mediaDevices.getUserMedia({ video: true })
    //     .then(function(stream) {
    //         $video[0].srcObject = stream;

    //         // Ensure video metadata is loaded
    //         $video.on("loadedmetadata", function() {
    //             $video[0].play();
    //         });

    //         $video.css("transform", "scaleX(-1)");
    //     })
    //     .catch(function(err) {
    //         alert("Camera access denied: " + err);
    //         disablePhoto();
    //         $photoInput.val(null);
    //     });
    startCamera();

    // Capture button
    // $takePhotoBtn.on("click", function() {
    //     const width = $video[0].videoWidth;
    //     const height = $video[0].videoHeight;

    //     if (width && height) {
    //         $canvas[0].width = width;
    //         $canvas[0].height = height;

    //         // Draw video frame
    //         context.drawImage($video[0], 0, 0, width, height);

    //         // Add timestamp
    //         const now = new Date();
    //         const formattedDate = now.toLocaleString("en-PH", { 
    //             timeZone: "Asia/Manila" 
    //         });

    //         context.font = "15px Arial";

    //         // Measure text width & height for background box
    //         const textWidth = context.measureText(formattedDate).width;
    //         const padding = 8;
    //         const textHeight = 20; // rough height since canvas doesn’t measure height
    //         const x = 20;
    //         const y = height - 30;

    //         // Draw black background rectangle
    //         context.fillStyle = "black";
    //         context.fillRect(x - padding / 2, y - textHeight, textWidth + padding, textHeight + padding / 2);

    //         // Draw white text
    //         context.fillStyle = "white";
    //         context.fillText(formattedDate, x, y);

    //         savePhoto();
    //     }
    // });

    // $takePhotoBtn.on("click", function() {
    //     const width = $video[0].videoWidth;
    //     const height = $video[0].videoHeight;

    //     if (width && height) {
    //         $canvas[0].width = width;
    //         $canvas[0].height = height;

    //         // Clear previous drawings
    //         context.clearRect(0, 0, width, height);

    //         // Draw video frame
    //         context.save();
    //         context.scale(-1, 1); // flip horizontally to match mirror preview
    //         context.drawImage($video[0], -width, 0, width, height);
    //         context.restore();

    //         // Add timestamp
    //         const now = new Date();
    //         const formattedDate = now.toLocaleString("en-PH", { 
    //             timeZone: "Asia/Manila" 
    //         });

    //         // Default GPS text
    //         let gpsText = "GPS: Fetching...";

    //         // Function to draw overlay text (date + gps)
    //         function drawOverlay() {
    //             context.font = "15px Arial";
    //             context.textBaseline = "top";

    //             const padding = 8;
    //             let lines = [formattedDate, gpsText];
    //             let textHeight = 20;
    //             let boxHeight = lines.length * textHeight + padding;
    //             let boxWidth = Math.max(
    //                 ...lines.map(line => context.measureText(line).width)
    //             ) + padding;

    //             const x = 20;
    //             const y = height - boxHeight - 20;

    //             // Draw background box
    //             context.fillStyle = "black";
    //             context.fillRect(x - padding / 2, y - padding / 2, boxWidth, boxHeight);

    //             // Draw text lines
    //             context.fillStyle = "white";
    //             lines.forEach((line, i) => {
    //                 context.fillText(line, x, y + i * textHeight);
    //             });

    //             savePhoto();
    //         }

    //         // Try to get GPS location
    //         if (navigator.geolocation) {
    //             navigator.geolocation.getCurrentPosition(
    //                 function(position) {
    //                     gpsText = `GPS: ${position.coords.latitude.toFixed(5)}, ${position.coords.longitude.toFixed(5)}`;
    //                     drawOverlay();
    //                 },
    //                 function(error) {
    //                     gpsText = "GPS: Unavailable";
    //                     drawOverlay();
    //                 },
    //                 { enableHighAccuracy: true, timeout: 5000 }
    //             );
    //         } else {
    //             gpsText = "GPS: Not supported";
    //             drawOverlay();
    //         }
    //     }
    // });

    $takePhotoBtn.on("click", async function() {
        $takePhotoBtn.text("Taking photo...");
        $takePhotoBtn.prop("disabled", true);
        const width = $video[0].videoWidth;
        const height = $video[0].videoHeight;

        if (!(width && height)) return;

        $canvas[0].width = width;
        $canvas[0].height = height;

        // Clear previous drawings
        context.clearRect(0, 0, width, height);

        // Draw mirrored video frame
        context.save();
        context.scale(-1, 1);
        context.drawImage($video[0], -width, 0, width, height);
        context.restore();

        // Add timestamp
        const now = new Date();
        const formattedDate = now.toLocaleString("en-PH", { timeZone: "Asia/Manila" });

        // Get GPS location (async with fallback)
        const gpsText = await new Promise((resolve) => {
            if (!navigator.geolocation) return resolve("GPS: Not supported");

            navigator.geolocation.getCurrentPosition(
                (pos) => resolve(`GPS: ${pos.coords.latitude.toFixed(5)}, ${pos.coords.longitude.toFixed(5)}`),
                () => resolve("GPS: Unavailable"),
                { enableHighAccuracy: true, timeout: 5000 }
            );
        });

        const device = navigator.userAgentData?.platform ;

        // Load logo (async)
        const logo = await new Promise((resolve) => {
            const img = new Image();
            img.src = "{{ asset('favico.ico') }}"; // 🔹 set your logo path here
            img.onload = () => resolve(img);
            img.onerror = () => resolve(null); // in case logo not found
        });

        // ---- Draw overlays ----
        context.font = "15px Arial";
        context.textBaseline = "top";

        const padding = 8;
        const lines = [formattedDate, gpsText, device];
        const textHeight = 20;
        const boxHeight = lines.length * textHeight + padding;
        const textBoxWidth = Math.max(...lines.map(line => context.measureText(line).width)) + padding;

        const logoSize = 40;
        const x = 20;
        const y = height - boxHeight - 20;

        // Background box (includes text + logo)
        const boxWidth = textBoxWidth + (logo ? logoSize + padding : 0);

        context.fillStyle = "black";
        context.fillRect(x - padding / 2, y - padding / 2, boxWidth, boxHeight);

        // Draw text
        context.fillStyle = "white";
        lines.forEach((line, i) => {
            context.fillText(line, x, y + i * textHeight);
        });

        // Draw logo if available (beside text)
        // if (logo) {
        //     const logoX = x + textBoxWidth + padding / 2;
        //     const logoY = y + (boxHeight - logoSize) / 2; // vertically centered
        //     context.drawImage(logo, logoX, logoY, logoSize, logoSize);
        // }

        // Save
        savePhoto();
    });




    // Retake button
    $retakePhotoBtn.on("click", function() {
        takePhoto();
    });

    function takePhoto() {
        $takePhotoBtn.text("Capture");
        $takePhotoBtn.prop("disabled", false);
        $canvas.hide();
        $retakePhotoBtn.hide();
        $takePhotoBtn.show();
        $video.show();
    }

    function savePhoto() {
        const photoData = $canvas[0].toDataURL("image/png");
        $photoInput.val(photoData);

        // Toggle visibility
        $video.hide();
        $canvas.show();
        $retakePhotoBtn.show();
        $takePhotoBtn.hide();
    }

    function disablePhoto() {
        $video.hide();
        $canvas.hide();
        $retakePhotoBtn.hide();
        $takePhotoBtn.hide();
        $('#photo-error-msg').text('Camera access denied');
    }

    async function startCamera(facing = "user") {
        try {
            // Stop any existing streams
            if ($video[0].srcObject) {
                $video[0].srcObject.getTracks().forEach(track => track.stop());
            }

            // Request camera with facingMode
            const stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: facing },
                audio: false
            });

            $video[0].srcObject = stream;

            // Flip preview only for front camera
            if (facing === "user") {
                $video.css("transform", "scaleX(-1)");
            } else {
                $video.css("transform", "none");
            }

            await new Promise(resolve => {
                $video.on("loadedmetadata", function() {
                    $video[0].play();
                    resolve();
                });
            });

            console.log(`📷 Camera started: ${facing}`);
        } catch (err) {
            alert("Camera access denied: " + err);
            disablePhoto();
            $photoInput.val(null);
        }
    }

});




</script>