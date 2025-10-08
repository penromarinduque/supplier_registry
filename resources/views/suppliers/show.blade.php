<div class="card mb-4">
    <div class="card-body">
        <h4>Company Profile</h4>

        <p><strong>Company Name:</strong> {{ $supplier->company_name }}</p>

        <p><strong>Company Profile:</strong>
            @if ($supplier->company_profile)
                <a href="{{ route('storage.view', ['url' => '/suppliers/company_profiles/' . $supplier->company_profile]) }}" target="_blank">View Profile</a>
            @else
                <span>No profile uploaded.</span>
            @endif
        </p>

        <p><strong>Company Facade:</strong>
            @if ($supplier->facade)
                <a href="{{ route('storage.view', ['url' => '/suppliers/company_facades/' . $supplier->facade]) }}" target="_blank">View Facade</a>
            @else
                <span>No facade uploaded.</span>
            @endif
        </p>

        <p><strong>Company Address:</strong> {{ $supplier->company_address }}</p>
        <p><strong>Line of Business:</strong> {{ $supplier->line_of_business }}</p>

        <hr>
        <p><strong>PHILGEPS Registration/Certificate Number:</strong> {{ $supplier->philgeps_reg_no }}</p>
        <p><strong>PHILGEPS Validity:</strong> {{ $supplier->philgeps_validity?->format('F d, Y') }}</p>
        <p><strong>PHILGEPS Certificate:</strong>
            @if ($supplier->philgeps_cert)
                <a href="{{ route('storage.view', ['url' => '/suppliers/philgeps_certs/' . $supplier->philgeps_cert]) }}" target="_blank">View Certificate</a>
            @else
                <span>No PHILGEPS Certificate uploaded.</span>
            @endif
        </p>

        <hr>
        <p><strong>Business/Mayor’s Permit Number:</strong> {{ $supplier->business_permit_no }}</p>
        <p><strong>Permit Validity:</strong> {{ $supplier->business_permit_validity?->format('F d, Y') }}</p>
        <p><strong>Business/Mayor’s Permit:</strong>
            @if ($supplier->business_permit)
                <a href="{{ route('storage.view', ['url' => '/suppliers/business_permits/' . $supplier->business_permit]) }}" target="_blank">View Permit</a>
            @else
                <span>No Business Permit uploaded.</span>
            @endif
        </p>

        <hr>
        <p><strong>BIR Certificate:</strong>
            @if ($supplier->bir_cert)
                <a href="{{ route('storage.view', ['url' => '/suppliers/bir_certs/' . $supplier->bir_cert]) }}" target="_blank">View BIR Certificate</a>
            @else
                <span>No BIR Certificate uploaded.</span>
            @endif
        </p>

        <p><strong>DTI Permit:</strong>
            @if ($supplier->dti_permit)
                <a href="{{ route('storage.view', ['url' => '/suppliers/dti_permits/' . $supplier->dti_permit]) }}" target="_blank">View DTI Permit</a>
            @else
                <span>No DTI Permit uploaded.</span>
            @endif
        </p>

        <p><strong>DTI Permit Validity:</strong> {{ $supplier->dti_permit_validity?->format('F d, Y') }}</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4>Authorized Representative</h4>

        <p><strong>Name:</strong> {{ $supplier->authorized_representative }}</p>
        <p><strong>Landline No.:</strong> {{ $supplier->landline_no }}</p>
        <p><strong>Mobile No.:</strong> {{ $supplier->mobile_no }}</p>

        <p><strong>Valid ID:</strong>
            @if ($supplier->valid_id)
                <a href="{{ route('storage.view', ['url' => '/suppliers/valid_ids/' . $supplier->valid_id]) }}" target="_blank">View Valid ID</a>
            @else
                <span>No Valid ID uploaded.</span>
            @endif
        </p>

        <p><strong>Authorization Document:</strong>
            @if ($supplier->authorization)
                <a href="{{ route('storage.view', ['url' => '/suppliers/authorizations/' . $supplier->authorization]) }}" target="_blank">View Authorization</a>
            @else
                <span>No Authorization uploaded.</span>
            @endif
        </p>
    </div>
</div>