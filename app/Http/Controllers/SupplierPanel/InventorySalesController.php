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
        // Get the logged-in user's ID
        $userId = Auth::id();
    
        // Fetch the inventory sales data for the specific user's model parts
        $query = InventorySales::whereHas('modelPart', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });
    
        // Apply sorting based on the request
        if ($request->filled('sort')) {
            if ($request->input('sort') == 'desc') {
                $query->orderBy('total_sales', 'desc');
            } elseif ($request->input('sort') == 'asc') {
                $query->orderBy('total_sales', 'asc');
            }
        }
    
        // Apply sorting based on the top sold quantity request
        if ($request->filled('top_sold')) {
            if ($request->input('top_sold') == 'desc') {
                $query->orderBy('sold_quantity', 'desc');
            } elseif ($request->input('top_sold') == 'asc') {
                $query->orderBy('sold_quantity', 'asc');
            }
        }
    
        $inventorySales = $query->paginate(10); // Change 10 to the desired number of items per page
    
        return view('supplier.inventory-sales', compact('inventorySales'));
    }
    

}
