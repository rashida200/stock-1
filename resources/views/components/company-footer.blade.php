<div>
    @if($identification)
    <hr>
        <p>{{ $identification->address}}-{{ $identification->location}}
        <strong>Tél/Fax:</strong> {{ $identification->phone2 }}-
        <strong>E-mail:</strong> {{ $identification->email }}-
        <strong>Patente:</strong> {{ $identification->patente }}-
        <strong>R.C:</strong> {{ $identification->rc }}-
        <strong>I.F:</strong> {{ $identification->if }}-
       <strong>ICE:</strong> {{ $identification->ice }}</p>
    @else
        <p>No company details available for the footer.</p>
    @endif
</div>
