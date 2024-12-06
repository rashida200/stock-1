<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function __construct()
    {
        $this->middleware('cashier');
    }

    public function index()
    {
        return view('cashier.dashboard');
    }
}
