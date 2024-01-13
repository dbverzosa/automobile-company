<?php

namespace App\Http\Controllers\ManufacturerPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function index ()
    {
        return view('manufacturer.dashboard');
    }
}
