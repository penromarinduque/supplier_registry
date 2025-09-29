@extends('layouts.main.master')
@section('content')
<div class="card">
    <div class="card-body">

        <h3 class="h3">User Guide</h3>
        <h4 class="h5">📌 Steps to Use the Online Attendance System</h4>
        <ol>
            <li>Open your browser</li>
            <li>On your laptop or mobile phone, launch a web browser (Google Chrome, Safari, or Microsoft Edge).</li>
            <li>Go to the system link. Visit: 👉 https://aas.penromarinduque.gov.ph/</li>
            <li>Select your Office/Division where you belong.</li>
            <li>Log in with your credentials. For Permanent Officials/Employees: Enter your Plantilla Item Number (e.g., OSEC-DENRB-ADAS2-001-2004). For COS: Enter your TIN (e.g., 000-000-000-0000).</li>
            <li>Log your attendance. Click the button that corresponds to the time of day: AM IN, AM OUT, PM IN, PM OUT.</li>
            <li>Allow permissions. 
            *Grant the system access to your location and camera. Verify your location. Wait for the system to capture your GPS location (visible in the location bar).
            *Capture your photo. When prompted, click Capture to take your photo.
            </li>
            <li>Save your log. Click Save Time Log to record your attendance.</li>
        </ol>
        <h4 class="h5">📌 Adding Tasks and Accomplishments</h4>
        <ol>
            <li>Add tasks. Click Add Task, type the task assigned to you, then click Save Task.</li>
            <li>Add accomplishments. For each task, click Add Accomplishment, type your accomplishment, and upload attachments.</li>
            <li>Click Save Accomplishment when done.</li>
        </ol>
        <h4 class="h5">📌 Viewing Records</h4>
        <ol>
            <li>Generate your DTR. To view or generate your attendance record, click View DTR.</li>
        </ol>
    </div>
</div>
@endsection