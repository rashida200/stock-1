<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Commande</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 20px;
            background-color: white;
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
            padding: 80px 20px;
            /* background-color: #0056b3; */
            color: black;
            /* font-weight: bold; */
        }

        .header-logo {
            flex: 1;
            text-align: right;
        }

        .header-info {
            flex: 1;
            text-align: right;
        }

        .header-info p {
            margin: 3px 0;
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
            background-color: #2c5282;
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
                margin-top: 10px;
                border: 1px solid #ddd;
            padding: 10px;
            background-color: #f8fafc;
            }
        }
    </style>
</head>
<body>

    <!-- Company Header -->
    <div class="header">
        <h1>Bon de commande</h1>
            <p><strong>N° BC:</strong> {{ $bonCommande->numero_bc }}</p>
        <!-- Right Section: Order Details -->
        <div class="header-info">
            <p><strong>Fournisseur:</strong> {{ $bonCommande->fournisseur->nom }}</p>
            <p><strong>Adresse:</strong>{{$bonCommande->fournisseur->adresse }}</p>
            <p><strong>Téléphone:</strong>{{$bonCommande->fournisseur->telephone }}</p>
            <p><strong>ICE:</strong>{{$bonCommande->fournisseur->lice }}</p>
            <p><strong>Date:</strong>{{ $bonCommande->date_commande }}</p>
        </div>
    </div>

    <table class="print">
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
            @foreach($bonCommande->details as $detail)
                <tr>
                    <td>{{ $detail->reference_produit }}</td>
                    <td>{{ $detail->produit->designation ?? 'N/A' }}</td>
                    <td>{{ $detail->quantite }}</td>
                    <td>{{ number_format($detail->prix_unitaire_ht, 2) }} DH</td>
                    <td>{{ number_format($detail->tva, 2) }}%</td>
                    <td>{{ number_format($detail->total_ligne_ht, 2) }} DH</td>
                    <td>{{ number_format($detail->total_ligne_ttc, 2) }} DH</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <p><strong>Total HT:</strong> {{ number_format($bonCommande->total_ht, 2) }} DH</p>
        <p><strong>Total TTC:</strong> {{ number_format($bonCommande->total_ttc, 2) }} DH</p>
    </div>
    <!-- Signature Section -->
<div class="signature-section" style="margin-top: 40px;">
    <div style="display: flex; justify-content: space-between; margin-top: 20px;">
        <div style="text-align: left;">
            <p><strong>Validé par :</strong></p>
            <p>Nom et Prénom :</p>
            <p>Signature :</p>
        </div>
    </div>
</div>


</body>
</html>
