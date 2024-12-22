<div>
    @if($identification)
        <p><strong>{{ $identification->company_name }}</strong></p>
        <p><strong> {{ $identification->company_description }}</strong></p>
        <p><strong>{{ $identification->location }}</strong></p>
        <p><strong>{{ $identification->address }}</strong></p>
        <p><strong>{{ $identification->phone1 }}</strong></p>

    @else
        <p>No company details available for the header.</p>
    @endif
</div>
