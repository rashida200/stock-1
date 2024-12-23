<div>
    @if($identification)
    <hr>
        <p><strong>Téléphone 2:</strong> {{ $identification->phone2 }}
        <strong>Email:</strong> {{ $identification->email }},
        <strong>ICE:</strong> {{ $identification->ice }},
        <strong>R.C:</strong> {{ $identification->rc }}</p>
        <p><strong>I.F:</strong> {{ $identification->if }},
        <strong>Patente:</strong> {{ $identification->patente }},
        <strong>CNSS:</strong> {{ $identification->cnss }},
        <strong>Compte N°:</strong> {{ $identification->bank_account }}</p>
    @else
        <p>No company details available for the footer.</p>
    @endif
</div>
