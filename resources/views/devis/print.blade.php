<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devis #{{ $devis->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            font-size: 14px;
        }

        .header {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
        }

        th {
            background: #f0f0f0;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>DEVIS N° {{ $devis->id }}</h2>
        <p>Date : {{ date('d/m/Y', strtotime($devis->date_devis)) }}</p>
        <p>Client : {{ $devis->client->nom }}</p>
        <p>{{ $devis->client->adresse ?? '' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Référence</th>
                <th>Description</th>
                <th>Quantité</th>
                <th>Prix U. HT</th>
                <th>TVA</th>
                <th>Total HT</th>
                <th>Total TTC</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($devis->details as $detail)
            <tr>
                <td>{{ $detail->produit->reference }}</td>
                <td>{{ $detail->produit->designation }}</td>
                <td class="text-right">{{ $detail->quantite }}</td>
                <td class="text-right">{{ number_format($detail->prix_unitaire_ht, 2, ',', ' ') }} DH</td>
                <td class="text-right">{{ $detail->tva }}%</td>
                <td class="text-right">{{ number_format($detail->total_ligne_ht, 2, ',', ' ') }} DH</td>
                <td class="text-right">{{ number_format($detail->total_ligne_ttc, 2, ',', ' ') }} DH</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Total HT</th>
                <td colspan="2" class="text-right">{{ number_format($totalHt, 2, ',', ' ') }} DH</td>
            </tr>
            <tr>
                <th colspan="5" class="text-right">Total TTC</th>
                <td colspan="2" class="text-right">{{ number_format($totalTtc, 2, ',', ' ') }} DH</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
