 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>Bon de Livraison</title>
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
             padding-bottom: 80px; /* Adjusted for footer and signatures */
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
             border: 1px solid #ddd;
             padding: 10px;
             background-color: #f8fafc;

         }

         .header-info p {
             margin: 3px 0;
             color: black;
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
         @media print {
         body {
             page-break-inside: avoid;
         }

         .signature-section,
         .total-section,
         .header-info,
         table {
             page-break-inside: avoid; /* Empêche les coupures internes */
         }
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

         .signature-section {
             margin-top: 40px;
             display: flex;
             justify-content: space-between;
             align-items: flex-start;
             padding: 20px 0;
         }

         .signature-box {
             width: 45%;
             text-align: center;
             border: 1px solid #ddd;
             padding: 20px;
             background-color: #f9f9f9;
         }

         .signature-box h3 {
             margin: 0 0 10px;
             font-size: 16px;
         }

         .signature-box p {
             margin: 20px 0;
             font-style: italic;
             color: #555;
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

             .signature-section {
                 flex-direction: column;
                 align-items: center;
             }

             .signature-box {
                 width: 100%;
                 margin-bottom: 20px;
             }
         }
         .signature-section {
         margin-top: 40px;
         display: flex;
         justify-content: space-between;
     }

     .signature-box {
         width: 45%;
         border: 1px solid #ddd;
         padding: 10px;
         text-align: left;
         background-color: #fff;
     }

     .signature-box p {
         margin: 8px 0;
     }

     .signature-box .signature-line {
         margin-top: 20px;
         border-top: 1px solid #333;
         width: 70%;
     }
     </style>
 </head>
 <body>
     <div class="header">
         <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="height: 50px;">
         <h1>Bon de Livraison</h1>
         <p><strong>N° BL:</strong> {{ $bonLivraison->numero_bl }}</p>
     </div>
     <div class="header-logo">
         <x-company-header />
     </div>

     <div class="header-info">
         <p><strong>Client:</strong> {{ $bonLivraison->client->nom }}</p>
         <p><strong>Adresse:</strong> {{ $bonLivraison->client->adresse }}</p>
         <p><strong>Téléphone:</strong> {{ $bonLivraison->client->telephone }}</p>
         <p><strong>Date de Vente:</strong> {{ $bonLivraison->date_vente }}</p>
         <p><strong>Date de Livraison:</strong> {{ $bonLivraison->date_livraison }}</p>
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
             @foreach ($bonLivraison->details as $detail)
             <tr>
                 <td>{{ $detail->produit->reference ?? 'N/A' }}</td>
                 <td>{{ $detail->produit->designation ?? 'N/A' }}</td>
                 <td>{{ $detail->quantite }}</td>
                 <td>{{ number_format($detail->prix_unitaire_ht, 2) }} DH</td>
                 <td>{{ number_format($detail->tva, 2) }} %</td>
                 <td>{{ number_format($detail->total_ligne_ht, 2) }} DH</td>
                 <td>{{ number_format($detail->total_ligne_ttc, 2) }} DH</td>
             </tr>
             @endforeach
         </tbody>
     </table>

     <div class="total-section">
         <p><strong>Total HT:</strong> {{ number_format($bonLivraison->total_ht, 2) }} DH</p>
         <p><strong>Total TTC:</strong> {{ number_format($bonLivraison->total_ttc, 2) }} DH</p>
     </div>

     <div class="signature-section">
         <div class="signature-box">
             <h3>Signature de l'Entreprise</h3>
             <p></p>
         </div>
         <div class="signature-box">
             <h3>Signature du Client</h3>
             <p></p>
         </div>
     </div>

     <div class="footer">
         <x-company-footer />
     </div>
 </body>
 </html>
