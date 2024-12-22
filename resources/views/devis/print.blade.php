<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devis #{{ $devis->id }}</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
            min-height: 100vh;
            position: relative;
            padding-bottom: 60px;
        }

        h1 {
            font-size: 24px;
            margin: 0;
        }

        /* Header Section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            /* background-color: #0056b3; */
            color: black;
            font-weight: bold;
        }

        .header-logo {
            flex: 1;
            text-align: right;
            color: black;
        }

        .header-info {
            flex: 1;
            text-align: right;
            color: black;
        }

        .header-info p {
            margin: 3px 0;
            color: black;
        }

        /* Footer Section */
        .footer {
            text-align: center;
            padding: 10px;
            color: black;
            font-weight: bold;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            box-sizing: border-box;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        td {
            font-size: 13px;
        }

        .total-section {
            text-align: right;
            margin-top: 20px;
        }

        .total-section strong {
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-info {
                text-align: left;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>DEVIS N° {{ $devis->id }}</h2>
        <p>Date : {{ date('d/m/Y', strtotime($devis->date_devis)) }}</p>
    </div>

    <div class="header-logo">
        <x-company-header />
    </div>

    <div class="header-info">
        <p><strong>Client :</strong> {{ $devis->client->nom }}</p>
        <p><strong>Adresse:</strong>{{ $devis->client->adresse ?? '' }}</p>
        <p><strong>Téléphone:</strong> {{ $devis->client->telephone }}</p>
    </div>
    <table class="print">
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
        <tfoot class="total-section">
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
    <div class="footer">
        <x-company-footer />
    </div>
</body>
</html>
