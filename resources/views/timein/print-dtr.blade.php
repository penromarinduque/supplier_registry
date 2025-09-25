@extends('layouts.print.master')
@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<style type="text/css">
    * {
        font-family: Arial, sans-serif !important;
    }

    .employee-summary {
        width: 100%;
        max-width: 1000px;
    }

    body {
        font-size: 14px;
    }

    p {
        margin: 0px;
        padding: 0px;
        font-size: 16px;
    }

    input, a {
        text-align: center;
        width: 80px;
        border: none;
        font-size: 15px;
    }

    .time-input {
        text-align: center;
    }
    
    .time-revised {
        background-color:rgb(248, 248, 130) !important;
        /* Light yellow background for edited fields */
    }

    .time-input.edited {
        background-color: #ffffe0;
        /* Light yellow background for edited fields */
    }

    select {
        border: none;
    }

    .header {
        margin: 0px;
        padding: 0px;
        font-size: 16px;
        font-weight: bold;
    }

    .green {
        color: #00b050;
    }

    .blue {
        color: #0070c0;
    }

    .footer span {
        font-size: 12px;
        color: gray;
    }

    .break {
        page-break-before: always;
        min-height: 500px;
    }

    @media screen {

        .footer,
        .header {
            display: none;
        }

        .print-view {
            display: none;
        }
    }

    @media print {
        .hr {
            display: none;
        }

        .print-buttons {
            display: none;
        }

        .print-view {
            display: block;
            font-size: 16px;
            text-align: center;
        }

        .screen-view {
            display: none;
        }

        .footer {
            position: fixed;
            bottom: 0px;
            width: 100%;
        }

        .break {
            margin-top: 110px;
            /* Adjust this value to move the break */
        }

        .header {
            position: fixed;
            top: -18px;
            /* Adjust this value to move the header */
            width: 100%;
        }

        .supervisor {
            margin-top: -45px;
            /* Adjust this value to move the supervisor's name and position */
        }

        table {
            font-size: 12px;
        }

        input, a {
            font-size: 12px;
        }
    }
</style>
@endsection
@section('content')
@php
    function formatHoursAndMinutes($decimal)
	{
		if ($decimal <= 0)
			return '';

		$hours = floor($decimal);
		$minutes = round(($decimal - $hours) * 60);

		if ($hours == 0) {
			if($minutes == 0) {
				return "";
			}
			return "{$minutes} minute" . ($minutes == 1 ? '' : 's');
		} else {
			return "{$hours} hour" . ($hours == 1 ? '' : 's') . ($minutes > 0 ? " and {$minutes} minute" . ($minutes == 1 ? '' : 's') : "");
		}
	}
    // Function to format total late minutes for the month
	function formatTotalMonthLate($minutes)
	{
		if ($minutes <= 0)
			return '';

		$days = floor($minutes / 480); // 8 hours * 60 minutes = 480 minutes per day
		$hours = floor(($minutes % 480) / 60);
		$mins = floor($minutes % 60);

		$result = '';
		if ($days > 0) {
			$result .= "{$days} day" . ($days == 1 ? '' : 's');
		}
		if ($hours > 0) {
			$result .= ($result ? ', ' : '') . "{$hours} hour" . ($hours == 1 ? '' : 's');
		}
		if ($mins > 0) {
			$result .= ($result ? ', ' : '') . "{$mins} minute" . ($mins == 1 ? '' : 's');
		}

		return $result;
	}
    function calculateSummaryCos($user, $time_entries) {
        $dateNow = $time_entries->date;
        $a = $time_entries->am_in ? Illuminate\Support\Carbon::parse($time_entries->am_in)->format('g:i A') : '&nbsp;'; 
        $b = $time_entries->am_out ? Illuminate\Support\Carbon::parse($time_entries->am_out)->format('g:i A') : '&nbsp;';
        $c = $time_entries->pm_in ? Illuminate\Support\Carbon::parse($time_entries->pm_in)->format('g:i A') : '&nbsp;';
        $d = $time_entries->pm_out ? Illuminate\Support\Carbon::parse($time_entries->pm_out)->format('g:i A') : '&nbsp;';

        $total_hours = 0;
        $undertime = 0;
        $overtime = 0;
        $late_minutes = 0;

        $morning_in = strtotime($dateNow . " " . $a);
        $morning_out = strtotime($dateNow . " " . $b);
        $afternoon_in = strtotime($dateNow . " " . $c);
        $afternoon_out = strtotime($dateNow . " " . $d);

        // Standard times
        $standard_morning_in = strtotime($dateNow . " 8:00 AM");
        $standard_morning_out = strtotime($dateNow . " 12:00 PM");
        $standard_afternoon_in = strtotime($dateNow . " 1:00 PM");
        $standard_afternoon_out = strtotime($dateNow . " 5:00 PM");

        // Calculate morning hours if both morning in and out are not empty
        $morning_hours = 0;
        if ($a != "&nbsp;" && $b != "&nbsp;") {
            if ($morning_in > $standard_morning_in) {
                $late_minutes += round(($morning_in - $standard_morning_in) / 60);
            }
            $morning_hours = 4;
            if ($morning_in > $standard_morning_in) {
                $morning_hours -= ($morning_in - $standard_morning_in) / 3600;
            }
            if ($morning_out < $standard_morning_out) {
                $morning_hours -= ($standard_morning_out - $morning_out) / 3600;
            }
            if ($morning_hours < 0) {
                $morning_hours = 0;
            }
        }

        // Calculate afternoon hours if both afternoon in and out are not empty
        $afternoon_hours = 0;
        if ($c != "&nbsp;" && $d != "&nbsp;") {
            if ($afternoon_in > $standard_afternoon_in) {
                $late_minutes += round(($afternoon_in - $standard_afternoon_in) / 60);
            }
            $afternoon_hours = 4;
            if ($afternoon_in > $standard_afternoon_in) {
                $afternoon_hours -= ($afternoon_in - $standard_afternoon_in) / 3600;
            }
            if ($afternoon_out < $standard_afternoon_out) {
                $afternoon_hours -= ($standard_afternoon_out - $afternoon_out) / 3600;
            }
            if ($afternoon_hours < 0) {
                $afternoon_hours = 0;
            }

            // Calculate overtime (only if afternoon out is after standard time and no undertime)
            if ($afternoon_out > $standard_afternoon_out) {
                $overtime = ($afternoon_out - $standard_afternoon_out) / 3600;
            }
        }

        // Total worked hours is the sum of morning and afternoon hours
        $total_hours = $morning_hours + $afternoon_hours;

        // Calculate undertime if total hours is less than 8
        $undertime = 0;
        if ($total_hours < 8) {
            $undertime = 8 - ($total_hours + ($late_minutes / 60));
        }
        if ($undertime < 0) {
            $undertime = 0;
        }

        // Ensure no negative values
        if ($late_minutes < 0) {
            $late_minutes = 0;
        }
        if ($overtime < 0) {
            $overtime = 0;
        }

        return [
            'total_hours' => $total_hours,
            'undertime' => $undertime,
            'overtime' => $overtime,
            'late_minutes' => $late_minutes
        ];
    }
@endphp

<section>
    @include('components.loader')
	
    <div style="position: absolute; right: 10px;" class="print-buttons">
        
        <input type="button" value="Print" onclick=" window.print()" style="padding: 8px;" />
        <a href="{{ route('timein.show', ['division' => request('division'), 'user_id' => $user->status == 'COS' ? $user->tin : $user->SSN]) }}" style="padding: 8px;">Close</a>
    </div>
    <div id="previewArea" style="margin-top: 40px;"></div>
    <div class="break">
        <p align="center" style="font-size: 18px;"><strong>DAILY TIME RECORD </strong></p>
        <table width="720" align="center">
            <tr>
                <td>
                    <p>Attendance ID: <strong>{{ $user->userID }}</strong></p>
                    <p>Employee ID: <strong>{{ $user->SSN }}</strong></p>
                    <p>Employee: <strong>{{ $user->name }}</strong></p>
                    <p>Position/Designation: <strong>{{ $user->position }}</strong></p>
                </td>
                <td>
                    <p>Status: <strong>{{ $user->status }}</strong></p>
                    <p>Date : <strong>{{ date('F j, Y', strtotime($date)) }}</strong></p>
                </td>
            </tr>
        </table>

        <table class="employee-summary" border="1" style="border-collapse: collapse;" align="center" cellspacing="0" cellpadding="0">
            <tr>
                <th rowspan="2" width="120" >Date</th>
                <th colspan="2">AM</th>
                <th colspan="2">PM</th>
                <th rowspan="2" width="90">Total Hours</th>
                <th rowspan="2" width="90">Late</th>
                <th rowspan="2" width="90">Undertime</th>
                <th rowspan="2" width="90">Overtime</th>
            </tr>
            <tr>
                <th width="90">IN</th>
                <th width="90">OUT</th>
                <th width="90">IN</th>
                <th width="90">OUT</th>
            </tr>
            @if ($time_entries)
                <tr>
                    <td rowspan="2" width="120" align="center">{{ $time_entries->date->format('m-d-Y') }}</td>
                    <td width="90" align="center" >{{ $time_entries->am_in ? $time_entries->am_in->format('h:i A') : '' }}</td>
                    <td width="90" align="center" >{{ $time_entries->am_out ? $time_entries->am_out->format('h:i A') : '' }}</td>
                    <td width="90" align="center" >{{ $time_entries->pm_in ? $time_entries->pm_in->format('h:i A') : '' }}</td>
                    <td width="90" align="center" >{{ $time_entries->pm_out ? $time_entries->pm_out->format('h:i A') : '' }}</td>
                    @php
                        $summary = calculateSummaryCos($user, $time_entries);
                    @endphp
                    <td align="center" ></td>
                    <td align="center" ></td>
                    <td align="center" ></td>
                    <td align="center" ></td>
                    {{-- <td align="center" > {{ formatHoursAndMinutes($summary['total_hours']) }}</td>
                    <td align="center" >{{ ($summary['late_minutes'] > 0 ? formatTotalMonthLate($summary['late_minutes']) : '') }}</td>
                    <td align="center" > {{ formatHoursAndMinutes($summary['undertime']) }}</td>
                    <td align="center" > {{ formatHoursAndMinutes($summary['overtime']) }}</td> --}}
                </tr>
            @else
            <tr>
                <td colspan="9" class="text-center">No Time Logs</td>
            </tr>
            @endif

        </table>
        <br><br><br><br>
        <!-- Supervisor's Signature -->
        <table width="720" align="center" style="margin-top: -20px; border-collapse: collapse;">
            <tr>
                <!-- style="border-top: 1px solid #ccc; padding: 15px;" -->
                <td align="center" width="340">
                    <div style="margin-bottom: 15px;">
                        <p style="margin-bottom: 40px; font-size: 13px;">I certify that the entries on this record which
                            were made by myself daily at the time of arrival and departure from the office are true and
                            correct.
                        </p>
                        <div style="margin-top: 10px;">
                            <span
                                style="font-weight: bold; font-size: 14px;">{{ $user->name }}</span><br />
                            <div style="width: 80%; margin: 5px auto; border-top: 1px solid #000;"></div>
                            <span style="font-size: 13px;">{{ $user->position }}</span>
                        </div>
                    </div>
                </td>
                <td width="40">&nbsp;</td>
                <!-- style="border-top: 1px solid #ccc; padding: 15px;" -->
                <td width="340">
                    <div style="text-align: center;">
                        <p style="margin-bottom: 55px; font-size: 13px;">Verified as to the prescribed office hours.</p>
                        <div style="margin-top: 10px;">
                            <div class="screen-view">
                                <select class="name" id="name{{ $user->badgeNumber }}"
                                    style="width: 280px; text-align: center; text-transform: uppercase; font-weight: bold;">
                                    <option value="IMELDA M. DIAZ" >IMELDA M. DIAZ</option>
                                    <option value="GEMMA P. DELOS REYES" {{ $division == 'main' ? 'selected' : '' }}>GEMMA P. DELOS REYES</option>
                                    <option value="CYNTHIA U. LOZANO" {{ $division == 'tsd' ? 'selected' : '' }}>CYNTHIA U. LOZANO</option>
                                    <option value="NANNETTE M. JOVEN" {{ $division == 'pamo' ? 'selected' : '' }}>NANNETTE M. JOVEN</option>
                                </select>
                                <div style="width: 80%; margin: 5px auto; border-top: 1px solid #000;"></div>
                                <select class="position" id="pstn{{ $user->badgeNumber }}"
                                    style="width: 280px; text-align: center;">
                                    <option value="OIC, PENR Officer">PENR Officer</option>
                                    <option value="In-Charge, Management Services Division" {{ $division == 'main' ? 'selected' : '' }}>In-Charge, Management Services Division</option>
                                    <option value="Chief, Technical Services Division" {{ $division == 'tsd' ? 'selected' : '' }}>Chief, Technical Services Division</option>
                                    <option value="Forester III/PASu, MWS" {{ $division == 'pamo' ? 'selected' : '' }}>Forester III/PASu, MWS</option>
                                </select>
                            </div>
                            <div class="print-view">
                                <span class="print-super" style="font-weight: bold; font-size: 14px;"
                                    id="print_name{{ $user->badgeNumber }}"></span>
                                <div style="width: 80%; margin: 5px auto; border-top: 1px solid #000;"></div>
                                <span class="print-position" style="font-size: 13px;"
                                    id="print_position{{ $user->badgeNumber }}"></span>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div style="font-size: 10px; margin-top: 30px;">
            <i>
                <p style="font-size: 10px; opacity: 0.5;"><span> <strong>Reminder: </strong></span> Please return within
                    5 days together with the required
                    supporting
                    documents (i.e. Special Order, Travel Orders, Notice of Meeting, etc.)
                </p>
            </i>
        </div>
            <br>
        <table class="employee-summary" border="1" style="border-collapse: collapse;" align="center" cellspacing="0" cellpadding="0">
            <tr>
                <th style="padding:5px" width="120" >Date</th>
                <th style="padding:5px" >Task</th>
                <th style="padding:5px" >Accomplishment</th>
            </tr>
            @forelse ($accomplishments as $accomplishment => $item)
                <tr>
                    <td style="padding:5px">{{ $item->date->format('m-d-Y') }}</td>
                    <td style="padding:5px">{{ $item->task->task }}</td>
                    <td style="padding:5px">{{ $item->accomplishment }}</td>
                </tr>
            @empty
                <tr>
                    <td style="padding:5px" colspan="3">No Accomplishments</td>
                </tr>
            @endforelse
        </table>

        <div class="" style="page-break-before: always" style="margin: 5rem auto;">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <h3 style="margin-top: 1rem;">Attachments</h3>
            <table style="width: 100%;">
                <tr>
                    <td align="center">
                        @if ($time_entries->am_in_capture)
                            <img width="250" src="{{ route('storage.viewImage', $time_entries->am_in_capture)}}" alt="">
                        @else
                            <div class="" style="width: 250px; height: 250px; background-color: #ccc; display: flex; align-items: center; justify-content: center">
                                <p>No Captured image</p>
                            </div>
                        @endif
                        <p>AM IN Capture</p>
                    </td>
                    <td align="center">
                        @if ($time_entries->am_out_capture)
                            <img width="250" src="{{ route('storage.viewImage', $time_entries->am_out_capture)}}" alt="">
                        @else
                            <div class="" style="width: 250px; height: 250px; background-color: #ccc; display: flex; align-items: center; justify-content: center">
                                <p>No Captured image</p>
                            </div>
                        @endif
                        <p>AM OUT Capture</p>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center">
                        @if ($time_entries->pm_in_capture)
                            <img width="250" src="{{ route('storage.viewImage', $time_entries->pm_in_capture)}}" alt="">
                        @else
                            <div class="" style="width: 250px; height: 250px; background-color: #ccc; display: flex; align-items: center; justify-content: center">
                                <p>No Captured image</p>
                            </div>
                        @endif
                        <p>PM IN Capture</p>
                    </td>
                    <td align="center">
                        @if ($time_entries->pm_in_capture)
                            <img width="250" src="{{ route('storage.viewImage', $time_entries->pm_in_capture)}}" alt="">
                        @else
                            <div class="" style="width: 250px; height: 250px; background-color: #ccc; display: flex; align-items: center; justify-content: center">
                                <p>No Captured image</p>
                            </div>
                        @endif
                        <p>PM OUT Capture</p>
                    </td>
                </tr>
            </table>
        </div>


    </div>
	
	<div class="header">
		<table width="720" class="title-header" cellpadding="0" cellspacing="0">
			<img width="740" src="{{ asset('header.png')}}" alt="">
		</table>
	</div>
</section>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $(".name").change(function () {
            var newID = ($(this).attr("id").slice(4, $(this).val().length));
            $("#pstn" + newID).prop("selectedIndex", $(this).prop("selectedIndex"));
            $("#print_name" + newID).html($(this).val());
            $("#print_position" + newID).html($("#pstn" + newID).val());
        })
        .change();

        $(".position").change(function () {
            var newID = ($(this).attr("id").slice(4, $(this).val().length));
            $("#name" + newID).prop("selectedIndex", $(this).prop("selectedIndex"));
            $("#print_name" + newID).html($("#name" + newID).val());
            $("#print_position" + newID).html($(this).val());
        })
        .change();
    })
</script>
@endsection