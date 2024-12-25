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
        }

        .header-logo {
            flex: 1;
            text-align: right;
            color: black;
        }

        .header-info {
            flex: 1;
            text-align: right;
            color: rgb(255, 255, 255);

            border: 1px solid #ddd;
            padding: 10px;
            margin: 90px 0;
            background-color: #f8fafc;

        }

        .header-info p {
            margin: 3px 0;
            color: black;
            padding: 10px;

        }

        /* Footer Section */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2cm;
            padding: 20px 2cm;
            text-align: center;
            font-size: 10px;
            background-color: #f8fafc;
            border-top: 1px solid #eee;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(254, 254, 254, 0.842);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2C5282;
            font-weight: bold;
            color: white;
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
                margin-top: 15px;
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
    <div class="signature-section" style="margin-top: 40px;">
        <div style="display: flex; justify-content: space-between; margin-top: 20px;">
            <div style="text-align: left;">
                <p><strong>Préparé par :</strong></p>
                <p>Nom et Prénom :</p>
                <p>Signature :</p>
            </div>
        </div>
    </div>
    <div class="footer">
        <x-company-footer />
    </div>
</body>
</html>
