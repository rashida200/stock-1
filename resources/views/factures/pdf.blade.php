<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px }
        table { width: 100%; border-collapse: collapse; margin-top: 20px }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h1>Facture {{ $facture->numero_facture }}</h1>

    <div>
        <p><strong>Client:</strong> {{ $facture->client->nom }}</p>
        <p><strong>Date:</strong> {{ $facture->date_facture }}</p>
    </div>

    <div>
        <h3>Bons de livraison associés:</h3>
        <ul>
            @foreach($facture->bonsLivraison as $bl)
                <li>{{ $bl->numero_bl }} ({{ $bl->date_livraison }})</li>
            @endforeach
        </ul>
    </div>

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
            @foreach($facture->bonsLivraison as $bl)
                @foreach($bl->details as $detail)
                    <tr>
                        <td>{{ $detail->produit->reference }}</td>
                        <td>{{ $detail->produit->designation }}</td>
                        <td>{{ $detail->quantite }}</td>
                        <td>{{ number_format($detail->prix_unitaire_ht, 2) }} DH</td>
                        <td>{{ $detail->tva }}%</td>
                        <td>{{ number_format($detail->total_ligne_ht, 2) }} DH</td>
                        <td>{{ number_format($detail->total_ligne_ttc, 2) }} DH</td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <div class="totals" style="margin-top: 20px; text-align: right;">
            <p><strong>Total HT:</strong> {{ number_format($facture->total_ht, 2) }} DH</p>
            <p><strong>Total TTC:</strong> {{ number_format($facture->total_ttc, 2) }} DH</p>
        </div>
    </body>
    </html>
