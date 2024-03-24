<?php

namespace App\Http\Controllers\ManufacturerPanel;

use App\Http\Controllers\Controller;
use App\Models\ManufacturerSale;
use App\Models\ManufacturerVehicleInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManufacturerSalesController extends Controller
{
    public function index(Request $request)
    {
        // Start building the query
        $query = ManufacturerSale::whereHas('vehicle', function ($q) {
            $q->where('manufacturer_id', Auth::user()->id); // Assuming the manufacturer ID is stored in the 'manufacturer_id' column
        });
    
        // Add conditions based on search parameters
        if ($request->filled('brand_search')) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('brand', 'like', '%' . $request->input('brand_search') . '%');
            });
        }
        if ($request->filled('model_search')) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('model', 'like', '%' . $request->input('model_search') . '%');
            });
        }
        if ($request->filled('month')) {
            $query->whereMonth('date_purchased', $request->input('month'));
        }
        if ($request->filled('year')) {
            $query->whereYear('date_purchased', $request->input('year'));
        }
        if ($request->filled('search_anything')) {
            $searchTerm = $request->input('search_anything');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('date_purchased', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('vehicle', function ($q) use ($searchTerm) {
                        $q->where('vin', 'like', '%' . $searchTerm . '%')
                            ->orWhere('brand', 'like', '%' . $searchTerm . '%')
                            ->orWhere('model', 'like', '%' . $searchTerm . '%')
                            ->orWhere('manufacturing_plant', 'like', '%' . $searchTerm . '%')
                            ->orWhere('details', 'like', '%' . $searchTerm . '%')
                            ->orWhere('color', 'like', '%' . $searchTerm . '%')
                            ->orWhere('engine', 'like', '%' . $searchTerm . '%')
                            ->orWhere('transmission', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhere('sale_price', 'like', '%' . $searchTerm . '%');
            });
        }
         // Apply sorting
    $sort = $request->input('sort', 'oldest_to_latest');
    if ($sort === 'oldest_to_latest') {
        $query->orderBy('date_purchased');
    } elseif ($sort === 'latest_to_oldest') {
        $query->orderByDesc('date_purchased');
    }

        
        // Execute the query and paginate the results
        $sales = $query->paginate(10);
    
        // Append search parameters to pagination links
        $sales->appends($request->except('page'));
    
        // Return the view with filtered results
        return view('manufacturer.sales.index', ['sales' => $sales]);
    }

    public function search(Request $request)
    {
        

        $query = ManufacturerSale::whereHas('vehicle', function ($q) {
            $q->where('manufacturer_id', Auth::id());
        });
        
        $sort = $request->input('sort', 'high_to_low');
    
    
        // Apply sorting
        if ($sort === 'high_to_low') {
            $query->orderByDesc('sale_price');
        } elseif ($sort === 'low_to_high') {
            $query->orderBy('sale_price');
        }
    
        // Add conditions based on search parameters
        if ($request->filled('brand_search')) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('brand', 'like', '%' . $request->input('brand_search') . '%');
            });
        }
        if ($request->filled('model_search')) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('model', 'like', '%' . $request->input('model_search') . '%');
            });
        }
        if ($request->filled('month')) {
            $query->whereMonth('date_purchased', $request->input('month'));
        }
        if ($request->filled('year')) {
            $query->whereYear('date_purchased', $request->input('year'));
        }
        if ($request->filled('search_anything')) {
            $searchTerm = $request->input('search_anything');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('date_purchased', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('vehicle', function ($q) use ($searchTerm) {
                        $q->where('brand', 'like', '%' . $searchTerm . '%')
                            ->orWhere('model', 'like', '%' . $searchTerm . '%')
                            ->orWhere('manufacturing_plant', 'like', '%' . $searchTerm . '%')
                            ->orWhere('details', 'like', '%' . $searchTerm . '%')
                            ->orWhere('color', 'like', '%' . $searchTerm . '%')
                            ->orWhere('engine', 'like', '%' . $searchTerm . '%')
                            ->orWhere('transmission', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhere('sale_price', 'like', '%' . $searchTerm . '%');
            });
        }
    
        // Fetch the sales data with vehicle information
        $sales = $query->with('vehicle')->get();
    
        // Group sales by brand, model, and other fields except VIN
        $groupedSales = $sales->groupBy(function ($sale) {
            return $sale->vehicle->brand . $sale->vehicle->model; // You may need to adjust this based on your actual field names
        });
    
        // Compute the total quantity sold for each group
        $totals = [];
        foreach ($groupedSales as $key => $group) {
            $totalQuantitySold = $group->sum('quantity_sold');
            $totals[$key] = $totalQuantitySold;
        }

        // Fetch the sales data with vehicle information and paginate
    $sales = $query->with('vehicle')->paginate(10); // Change 10 to the number of items you want per page

    
        return view('manufacturer.sales.search', compact('sales', 'totals'));
    }
    
    
    
}
