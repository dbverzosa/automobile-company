<?php

namespace App\Http\Controllers\SupplierPanel;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::with('modelPart')->get();
        return view('supplier.inventory', compact('inventories'));
    }
}
