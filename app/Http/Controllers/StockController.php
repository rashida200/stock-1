<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $produits = Produit::when($search, function ($query, $search) {
            $query->where('designation', 'like', "%{$search}%")
                ->orWhere('reference', 'like', "%{$search}%");
        })->paginate(10);

        return view('stock.index', compact('produits', 'search'));
    }
}
