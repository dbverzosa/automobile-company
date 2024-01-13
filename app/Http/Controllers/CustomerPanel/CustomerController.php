<?php

namespace App\Http\Controllers\CustomerPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;


class CustomerController extends Controller
{
    public function dashboard ()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role === 'supplier') {
            return redirect()->route('supplier.dashboard');
        } elseif (Auth::user()->role === 'manufacturer') {
            return redirect()->route('manufacturer.dashboard');
        } elseif (Auth::user()->role === 'dealer') {
            return redirect()->route('dealer.dashboard');
        }
        return view('dashboard');
    }
}
