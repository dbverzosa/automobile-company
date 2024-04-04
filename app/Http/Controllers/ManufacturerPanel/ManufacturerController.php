<?php

namespace App\Http\Controllers\ManufacturerPanel;

use App\Http\Controllers\Controller;
use App\Models\ModelParts;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManufacturerController extends Controller
{
    // public function index ()
    // {
    //     return view('manufacturer.dashboard');
    // }

    public function index()
    {

        // e fetch tanan model parts
        $modelParts = ModelParts::paginate(9);  
        
        // e pass ang mga model parts data to the view
        return view('manufacturer.dashboard', ['model_parts' => $modelParts]);
    }

    public function search(Request $request): View
    {
        // retrieve  ang search parameters gikan sa request
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
    
        $modelParts = $query->paginate(9);
    
        $modelParts->appends($request->except('page'));
    
        // Return the view with search results
        return view('manufacturer.dashboard', ['model_parts' => $modelParts]);
    }


    public function buyModelPart(Request $request, ModelParts $modelpart)
    {
      
        //e redirect to return a response dayon 
        return redirect()->back()->with('success', 'Model part purchased successfully.');
    }

}
