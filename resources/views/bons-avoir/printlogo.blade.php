<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bon d'Avoir</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin-top: -50px;
        }



        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #2c5282;
            color: white;
        }

        .totals {
            margin-top: 10px;
            text-align: right;
        }

        .signature-section {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .original-bl {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
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
        .company-header{

           flex: 1;
            text-align: center;
            color: black;
            margin-top: -50px;

        }
        .client-info{
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f8fafc;
        }
    </style>
</head>
<body>
        <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="height: 75px; margin-top: 20px;">
        <div class="company-header">
            <x-company-header />
        </div>
        <hr style="color:  #2c5282">
        <div class="header">
            <div>
                <h1>Bon d'Avoir</h1>
                <p>N° BA: {{ $bonAvoir->numero_ba }}</p>
                <p>Date: {{ $bonAvoir->date_avoir }}</p>
            </div>

        </div>

        <div class="client-info">
            <h3>Informations Client</h3>
            <p>Nom: {{ $bonAvoir->client->nom }}</p>
            <p>Adresse: {{ $bonAvoir->client->adresse }}</p>
            <p>Téléphone: {{ $bonAvoir->client->telephone }}</p>
        </div>

        <div class="original-bl">
            <p>Bon de Livraison d'origine: {{ $bonAvoir->bonLivraison->numero_bl }}</p>
            <p>Date de livraison: {{ $bonAvoir->bonLivraison->date_livraison }}</p>
        </div>

        <div class="motif">
            <h3>Motif du retour</h3>
            <p>{{ $bonAvoir->motif }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Désignation</th>
                    <th>Quantité Retournée</th>
                    <th>Prix Unitaire HT</th>
                    <th>TVA</th>
                    <th>Total HT</th>
                    <th>Total TTC</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bonAvoir->details as $detail)
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
            </tbody>
        </table>

        <div class="totals">
            <p><strong>Total HT:</strong> {{ number_format($bonAvoir->total_ht, 2) }} DH</p>
            <p><strong>Total TTC:</strong> {{ number_format($bonAvoir->total_ttc, 2) }} DH</p>
        </div>

        <div class="signature-section">
            <div>
                <h4>Signature de l'Entreprise</h4>
            </div>
            <div>
                <h4>Signature du Client</h4>
            </div>
        </div>


    <div class="footer">
        <x-company-footer />
    </div>
</body>
</html>
