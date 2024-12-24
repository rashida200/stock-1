<!-- resources/views/factures-avoir/print.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Facture d'Avoir {{ $factureAvoir->numero_facture_avoir }}</title>
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
            padding: 20px 2cm;
            border-bottom: 1px solid #eee;
        }
        .company-logo {
            float: left;
            width: 30%;
        }
        .company-info {
            float: right;
            width: 40%;
            text-align: right;
            font-size: 12px;
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
            margin: 20px 0;
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
            margin: 20px 0;
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
            margin-top: 20px;
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
    <div class="header">
        <div class="company-logo">
            <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="height: 50px;">
        </div>
        <div class="company-info">
          <x-company-header/>
        </div>
    </div>

    <div class="invoice-type">
        FACTURE D'AVOIR N° {{ $factureAvoir->numero_facture_avoir }}
    </div>

    <div class="client-box">
        <h4 style="margin: 0 0 10px 0;">CLIENT:</h4>
        <p><strong>{{ $factureAvoir->bonAvoir->client->nom }}</strong></p>
        <p>ICE: {{ $factureAvoir->bonAvoir->client->ice }}</p>
        <p>{{ $factureAvoir->bonAvoir->client->adresse }}</p>
        <p>Tél: {{ $factureAvoir->bonAvoir->client->telephone }}</p>
    </div>

    <div class="reference-box">
        <table class="document-details">
            <tr>
                <td width="50%"><strong>Date Facture d'Avoir:</strong></td>
                <td>{{ \Carbon\Carbon::parse($factureAvoir->date_facture)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>Bon d'Avoir de référence:</strong></td>
                <td>{{ $factureAvoir->bonAvoir->numero_ba }}</td>
            </tr>
            <tr>
                <td><strong>Bon de Livraison de référence:</strong></td>
                <td>{{ $factureAvoir->bonAvoir->bonLivraison->numero_bl }}</td>
            </tr>
            <tr>
                <td><strong>Motif de l'avoir:</strong></td>
                <td>{{ $factureAvoir->bonAvoir->motif }}</td>
            </tr>
        </table>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th>Réf.</th>
                <th>Désignation</th>
                <th class="text-center">Qté</th>
                <th class="text-right">P.U HT</th>
                <th class="text-center">TVA</th>
                <th class="text-right">Total HT</th>
                <th class="text-right">Total TTC</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factureAvoir->bonAvoir->details as $detail)
            <tr>
                <td>{{ $detail->produit->reference }}</td>
                <td>{{ $detail->produit->designation }}</td>
                <td class="text-center">{{ $detail->quantite }}</td>
                <td class="text-right">{{ number_format($detail->prix_unitaire_ht, 2) }} DH</td>
                <td class="text-center">{{ $detail->tva }}%</td>
                <td class="text-right">{{ number_format($detail->total_ligne_ht, 2) }} DH</td>
                <td class="text-right">{{ number_format($detail->total_ligne_ttc, 2) }} DH</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="clearfix">
        <table class="amounts-table">
            <tr class="bg-gray">
                <td><strong>Montant Original TTC:</strong></td>
                <td class="text-right">{{ number_format($factureAvoir->montant_original_ttc, 2) }} DH</td>
            </tr>
            <tr>
                <td><strong>Montant Avoir TTC:</strong></td>
                <td class="text-right">{{ number_format($factureAvoir->montant_avoir_ttc, 2) }} DH</td>
            </tr>
            <tr class="total">
                <td><strong>Montant Final TTC:</strong></td>
                <td class="text-right">{{ number_format($factureAvoir->montant_final_ttc, 2) }} DH</td>
            </tr>
        </table>
    </div>
    <div class="footer">
       <x-company-footer/>
    </div>
</body>
</html>
