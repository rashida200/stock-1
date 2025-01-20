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
        }
        .header {
    display: flex;
    align-items: center; /* Aligne verticalement l'image et le contenu */
    gap: 0; /* Supprime tout espace entre les enfants */
    margin: 20px 0; /* Supprime les marges latérales indésirables */
    padding-bottom: 10px;
    border-bottom: 2px solid #2c5282;
}

    .header-logo {
        flex-shrink: 0;
        /* Facultatif : pour contrôler l'espacement horizontal */
    }

    .header-logo img {
        height: 95px;
        display: block; /* Évite les espaces indésirables autour de l'image */
    }

        .header-content {
            text-align: center;
            flex: 1;
            margin: 0; 
        }

        .header-content h1 {
            font-size: 18px;
            margin: 0;
            color: #28932d;
        }

        .header-content p {
            font-size: 12px;
            margin: 0;
            color: #3740ad;
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
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-logo">
            <img src="{{ public_path('images/logo.png') }}" alt="Logo">
        </div>
        <div class="header-content">
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
