<?php

namespace App\Http\Controllers\ManufacturerPanel;

use App\Http\Controllers\Controller;
use App\Models\ManufacturerVehicle;
use App\Models\ManufacturerVehicleInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ManufacturerInventoryController extends Controller
{
    public function index(Request $request)
    {
        // Get the logged-in user's ID
        $manufacturerId = auth()->id();
    
        // Start with the base query
        $query = ManufacturerVehicle::selectRaw('brand, model, price, manufacturing_plant, details, color, engine, transmission, COUNT(*) as total_quantity')
            ->where('manufacturer_id', $manufacturerId)
            ->where('quantity', 1)
            ->whereDoesntHave('inventory', function ($query) {
                $query->where('is_sold', true);
            })
            ->groupBy('brand', 'model', 'price', 'manufacturing_plant', 'details', 'color', 'engine', 'transmission');
    
        // Apply the search filters
        if ($request->has('brand_search')) {
            $query->where('brand', 'like', '%' . $request->input('brand_search') . '%');
        }
    
        if ($request->has('model_search')) {
            $query->where('model', 'like', '%' . $request->input('model_search') . '%');
        }
    
        // Apply the quantity filter
        $query->when($request->input('quantity_filter') === 'high_to_low', function ($query) {
            $query->orderBy('total_quantity', 'desc');
        })->when($request->input('quantity_filter') === 'low_to_high', function ($query) {
            $query->orderBy('total_quantity', 'asc');
        });
    
        // Paginate the results
        $inventory = $query->paginate(10);
    
        return view('manufacturer.inventory.index', compact('inventory'));
    }
    
  
    
}



    