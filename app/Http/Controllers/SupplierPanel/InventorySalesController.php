<?php

namespace App\Http\Controllers\SupplierPanel;

use App\Http\Controllers\Controller;
use App\Models\InventorySales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventorySalesController extends Controller
{

    public function index(Request $request)
    {
        // get ang logged-in user's ID which sa kani na case kay supplier
        $userId = Auth::id();
    
        // e fetch ang inventory sales data for the specific user's model parts
        $query = InventorySales::whereHas('modelPart', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });
    
        if ($request->filled('sort')) {
            if ($request->input('sort') == 'desc') {
                $query->orderBy('total_sales', 'desc');
            } elseif ($request->input('sort') == 'asc') {
                $query->orderBy('total_sales', 'asc');
            }
        }
    
        if ($request->filled('top_sold')) {
            if ($request->input('top_sold') == 'desc') {
                $query->orderBy('sold_quantity', 'desc');
            } elseif ($request->input('top_sold') == 'asc') {
                $query->orderBy('sold_quantity', 'asc');
            }
        }
    
        $inventorySales = $query->paginate(10); 
    
        return view('supplier.inventory-sales', compact('inventorySales'));
    }
    

}
