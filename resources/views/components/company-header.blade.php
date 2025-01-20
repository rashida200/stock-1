<div>
    @if($identification)
        <h1>{{ $identification->company_name }}</h1>
        <p><strong> {{ $identification->company_description }}</strong></p>

    @else
        <p>No company details available for the header.</p>
    @endif
</div>
