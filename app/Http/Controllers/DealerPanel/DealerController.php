<?php

namespace App\Http\Controllers\DealerPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    public function index ()
    {
        return view('dealer.dashboard');
    }
}
