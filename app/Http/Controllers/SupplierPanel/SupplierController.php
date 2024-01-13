<?php

namespace App\Http\Controllers\SupplierPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index ()
    {
        return view('supplier.dashboard');
    }
}
