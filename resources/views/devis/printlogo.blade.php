<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devis N° {{ $devis->id }}</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }
        body {
            font-family: Arial, sans-serif;
            margin-top: 3cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
            font-size: 14px;
            color: #333;
        }
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 3cm;
            padding: 10px 2cm; /* Réduit le padding à 10px */
            border-bottom: none;
            line-height: 1.2; /* Réduit l'espacement vertical entre les lignes */
        }
        .company-logo {
            float: left;
            width: 30%;
        }
        .company-info {
    float: right;
    width: 40%;
    text-align: left;
    font-size: 12px;
    line-height: 1.2; /* Réduit l'espacement vertical entre les lignes */
}
        .company-logo img {
            height: 40px; /* Réduit la taille du logo */
            margin-bottom: 5px; /* Ajoute un petit espacement sous le logo */
}
.company-logo h2 {
    margin: 5px 0; /* Réduit les marges autour du titre */
    font-size: 18px; /* Ajuste la taille du texte */
}
.company-logo p {
    margin: 2px 0; /* Réduit les marges autour des paragraphes */
    font-size: 12px; /* Diminue légèrement la taille des textes */
}
        .invoice-type {
            text-align: center;
            color: #2c5282;
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
            border: 2px solid #2c5282;
            padding: 10px;
            background-color: #f8fafc;
        }
        .document-details {
            width: 100%;
            margin: 20px 0;
        }
        .document-details td {
            padding: 5px;
            border: none;
        }
        .client-box {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 90px 0;
            background-color: #f8fafc;
        }
        .reference-box {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 20px 0;
            background-color: #f8fafc;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0px ;
        }
        table.items th {
            background-color: #2c5282;
            color: white;
            padding: 10px;
            font-size: 12px;
        }
        table.items td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 12px;
        }
        .amounts-table {
            width: 350px;
            float: right;
            margin-top: 10px;
        }
        .amounts-table td {
            padding: 5px 10px;
        }
        .amounts-table tr.total {
            background-color: #f8fafc;
            font-weight: bold;
        }
        .payment-info {
            clear: both;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
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
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .small-text {
            font-size: 11px;
        }
        .bg-gray {
            background-color: #f8fafc;
        }
    </style>
</head>
<body>
    <div class="header clearfix">
        <div class="company-logo">
            <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="height: 50px;">
            <h2>DEVIS N° {{ $devis->id }}</h2>
            <p>Date : {{ date('d/m/Y', strtotime($devis->date_devis)) }}</p>
        </div>

        <div class="company-info">
            <x-company-header />
        </div>
    </div>

    <div class="client-box">
        <p><strong>Client :</strong> {{ $devis->client->nom }}</p>
        <p><strong>Adresse:</strong> {{ $devis->client->adresse ?? '' }}</p>
        <p><strong>Téléphone:</strong> {{ $devis->client->telephone }}</p>
    </div>

    <table class="items">
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

    <div class="payment-info">
        <p><strong>Préparé par :</strong></p>
        <p>Nom et Prénom :</p>
        <p>Signature :</p>
    </div>

    <div class="footer">
        <x-company-footer />
    </div>
</body>
</html>
