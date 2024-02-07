<?php

namespace App\Http\Controllers\SupplierPanel;

use App\Http\Controllers\Controller;
use App\Models\ModelParts;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{

    public function index()
    {

        // Fetch all model parts
        $modelParts = ModelParts::paginate(5);  // Change 10 to the desired number of items per page
        
        // Pass model parts data to the view
        return view('supplier.supplier-dashboard', ['model_parts' => $modelParts]);
    }
    
    public function search(Request $request): View
    {
        // Retrieve search parameters from the request
        $search = $request->input('search');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $availability = $request->input('availability');
    
        // Start building the query
        $query = ModelParts::query();
    
        // Add conditions based on search parameters
        if ($search) {
            $query->where('model_name', 'like', '%' . $search . '%');
        }
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }
        if ($availability !== null) {
            $query->where('is_available', (bool) $availability);
        }
    
        // Execute the query and paginate the results
        $modelParts = $query->paginate(5);
    
        // Append search parameters to pagination links
        $modelParts->appends($request->except('page'));
    
        // Return the view with search results
        return view('supplier.supplier-dashboard', ['model_parts' => $modelParts]);
    }




     // public function index ()
    // {
    //     return view('supplier.supplier-dashboard');
    // } 
}
