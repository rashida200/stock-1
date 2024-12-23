<!-- bons-avoir/pdf.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bon d'Avoir</title>
    <style>
        /* Copy the same styles from bons-livraison.pdf and modify as needed */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
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

        .totals {
            margin-top: 20px;
            text-align: right;
        }

        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .original-bl {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h1>Bon d'Avoir</h1>
            <p>N° BA: {{ $bonAvoir->numero_ba }}</p>
            <p>Date: {{ $bonAvoir->date_avoir }}</p>
        </div>
        <div>
            <x-company-header />
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
            <div class="signature-line"></div>
        </div>
        <div>
            <h4>Signature du Client</h4>
            <div class="signature-line"></div>
        </div>
    </div>

    <div class="footer">
        <x-company-footer />
    </div>
</body>
</html>
