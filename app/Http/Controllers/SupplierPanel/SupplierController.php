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

        // fetch all model parts with pagination
        $modelParts = ModelParts::paginate(9);  
        
        // return dayon sa view with passed model parts data 
        return view('supplier.supplier-dashboard', ['model_parts' => $modelParts]);
    }
    
    public function search(Request $request): View
    {
        // retrieve search parameters gikan sa request
        $search = $request->input('search');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $availability = $request->input('availability');
    
        // start sa query
        $query = ModelParts::query();
    
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
    
        // execute dayon sa query then paginate ang results
        $modelParts = $query->paginate(9);
    
        // append dayon ang search parameters to pagination links
        $modelParts->appends($request->except('page'));
    
        // return the view with search results
        return view('supplier.supplier-dashboard', ['model_parts' => $modelParts]);
    }




     // public function index ()
    // {
    //     return view('supplier.supplier-dashboard');
    // } 
}
