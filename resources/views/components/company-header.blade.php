<div>
    @if($identification)
        <h2 style="color: #198754">{{ $identification->company_name }}</h2>
        <p style="color:  #437bc1"><strong> {{ $identification->company_description }}</strong></p>

    @else
        <p>No company details available for the header.</p>
    @endif
</div>
