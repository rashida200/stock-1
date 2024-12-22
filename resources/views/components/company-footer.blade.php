<div>
    @if($identification)
    <hr>
        <p><strong>Phone 2:</strong> {{ $identification->phone2 }}
        <strong>Email:</strong> {{ $identification->email }},
        <strong>ICE:</strong> {{ $identification->ice }},
        <strong>RC:</strong> {{ $identification->rc }}</p>
        <p><strong>IF:</strong> {{ $identification->if }},
        <strong>Patente:</strong> {{ $identification->patente }},
        <strong>CNSS:</strong> {{ $identification->cnss }},
        <strong>Bank Account:</strong> {{ $identification->bank_account }}</p>
    @else
        <p>No company details available for the footer.</p>
    @endif
</div>
