<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin-top: 30px;
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
            padding: 10px 20px;
            margin-top: 30px;
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


        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: ;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
                margin-top: 20px;
                margin-bottom: 20px;
             border: 1px solid #ddd;
            padding: 10px;
            background-color: #f8fafc;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Facture N° {{ $facture->numero_facture }}</h1>
    </div>



    <div class="header-info">
        <p><strong>Client:</strong> {{ $facture->client->nom }}</p>
        <p><strong>Adresse:</strong>{{ $facture->client->adresse }}</p>
        <p><strong>Téléphone:</strong>{{ $facture->client->telephone }}</p>
        <p><strong>Date:</strong> {{ $facture->date_facture }}</p>
    </div>

    <div>
        <h3 style="color: black">Bons de livraison associés:</h3>
        <ul>
            @foreach($facture->bonsLivraison as $bl)
                <li>{{ $bl->numero_bl }} ({{ $bl->date_livraison }})</li>
            @endforeach
        </ul>
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

        <div class="total-section">
            <p><strong>Total HT:</strong> {{ number_format($facture->total_ht, 2) }} DH</p>
            <p><strong>Total TTC:</strong> {{ number_format($facture->total_ttc, 2) }} DH</p>
        </div>
        <div class="signature-section" >
            <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                <div style="text-align: left;">
                    <p><strong>Signature Entreprise :</strong>___________________</p><br><br>
                    <p><strong>Signature Client :</strong>___________________</p>
                </div>
            </div>
        </div>

    </body>
    </html>
