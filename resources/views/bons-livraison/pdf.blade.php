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
    <p><strong>N° BL:</strong>{{ $bonLivraison->numero_bl }}</p>
    <p><strong>Client:</strong>{{ $bonLivraison->client->nom }}</p>
    <p><strong>Date de vente:</strong>{{ $bonLIvraison->date_vente }}</p>

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
                    <td>{{ $detail->reference_produit }}</td>
                    <td>{{ $detail->produit->designation ?? 'N/A' }}</td>
                    <td>{{ $detail->quantite }}</td>
                    <td>{{ number_format($detail->prix_unitaire_ht, 2) }} DH</td>
                    <td>{{ number_format($detail->tva) }} %</td>
                    <td>{{ number_format($detail->total_ligne_ht, 2) }}</td>
                    <td>{{ number_format($detail->total_ligne_ttc, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="text-right"><strong>Total HT:</strong></p>
    <p class="text-right"><strong>Total TTC:</strong>
</body>
</html>