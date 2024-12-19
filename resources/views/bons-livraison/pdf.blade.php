<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bon de Livraison</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px }
        table { width: 100%; border-collapse: collapse; margin-top: 20px }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h1>Bon de Livraison</h1>
    <p><strong>N° BL:</strong> {{ $bonLivraison->numero_bl }}</p>
    <p><strong>Client:</strong> {{ $bonLivraison->client->nom }}</p>
    <p><strong>Date de Vente:</strong> {{ $bonLivraison->date_vente }}</p>
    <p><strong>Date de Livraison:</strong> {{ $bonLivraison->date_livraison }}</p>

    <table>
        <thead>
            <tr>
                <th>Référence</th>
                <th>Désignation</th>
                <th>Quantité</th>
                <th>Prix HT</th>
                <th>TVA (%)</th>
                <th>Total HT</th>
                <th>Total TTC</th>
            </tr>
        </thead>
        <tbody>
    @foreach ($bonLivraison->details as $detail)
        <tr>
            <td>{{ $detail->produit->reference ?? 'N/A' }}</td> <!-- Corrected reference -->
            <td>{{ $detail->produit->designation ?? 'N/A' }}</td>
            <td>{{ $detail->quantite }}</td>
            <td>{{ number_format($detail->prix_unitaire_ht, 2) }} DH</td>
            <td>{{ number_format($detail->tva, 2) }} %</td>
            <td>{{ number_format($detail->total_ligne_ht, 2) }} DH</td>
            <td>{{ number_format($detail->total_ligne_ttc, 2) }} DH</td>
        </tr>
    @endforeach
</tbody>

    </table>

    <p class="text-right"><strong>Total HT:</strong> {{ number_format($bonLivraison->total_ht, 2) }} DH</p>
    <p class="text-right"><strong>Total TTC:</strong> {{ number_format($bonLivraison->total_ttc, 2) }} DH</p>
</body>
</html>