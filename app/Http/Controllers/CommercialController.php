<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommercialController extends Controller
{
    public function __construct()
    {
        $this->middleware('commercial');
    }

    public function index()
    {
        return view('commercial.dashboard');
    }
}
