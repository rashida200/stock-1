<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:manager');
    }

    public function index()
    {
        return view('manager.dashboard');
    }
}
