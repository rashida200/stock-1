<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommercialController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:commercial');
    }

    public function index()
    {
        return redirect('/');
    }
}
