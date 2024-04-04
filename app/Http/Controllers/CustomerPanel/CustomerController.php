<?php

namespace App\Http\Controllers\CustomerPanel;

use App\Http\Controllers\Controller;
use App\Models\CustomerReservation;
use App\Models\DealerInventory;
use App\Models\ManufacturerVehicle;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;

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
        // return view('dashboard');

        return Redirect::to('/');
    }


    public function buy(Request $request)
    {
        
        $request->validate([
            'gender' => 'required',
            'income' => 'required|numeric',
            'delivery_address' => 'required',
            'details' => 'required',
            'manufacturer_vehicle_id' => 'required|exists:manufacturer_vehicles,id',
        ]);
    
    
        // e get ang customer_id from the authenticated user
        $customer_id = auth()->id();
    
        // e get ang manufacturer_vehicle
        $manufacturer_vehicle = ManufacturerVehicle::findOrFail($request->manufacturer_vehicle_id);
        $dealer_inventory = DealerInventory::where('manufacturer_vehicle_id', $manufacturer_vehicle->id)->firstOrFail();
        // create a new reservation record or data entry which is the buying of vehicle
        $reservation = new CustomerReservation();
        $reservation->customer_id = $customer_id;
        $reservation->gender = $request->gender;
        $reservation->income = $request->income;
        $reservation->date_purchased = now();
        $reservation->delivery_address = $request->delivery_address;
        $reservation->details = $request->details;
        $reservation->vehicle_id = $manufacturer_vehicle->id; // Use the manufacturer_vehicle_id
        $reservation->price = $dealer_inventory->new_price;
        $reservation->dealer_id = $dealer_inventory->dealer_id;
        $reservation->is_pending = true;
        $reservation->save();
    
        // redirect the user back with a success message
        return redirect()->back()->with('success', 'Vehicle purchased successfully. NOTE: Subject for approval!');
    }
    
  

    public function customerPurchased(Request $request)
{
    $customer_id = auth()->id();
    $query = CustomerReservation::where('customer_id', $customer_id);

    // apply search filters
    if ($request->filled('name')) {
        $name = $request->input('name');
        // search for specific brand 
        $query->whereHas('manufacturerVehicle', function($q) use ($name) {
            $q->where('brand', 'like', "%$name%")
            ->orWhere('model', 'like', "%$name%");
        });
    }

    if ($request->filled('status-filter')) {
        $status = $request->input('status-filter');
        if ($status === '1') {
            $query->where('is_pending', true);
        } elseif ($status === '0') {
            $query->where('is_pending', false);
        }
    }

    if ($request->filled('date-filter')) {
        $dateFilter = $request->input('date-filter');
        if ($dateFilter === 'oldest') {
            $query->orderBy('date_purchased');
        } elseif ($dateFilter === 'newest') {
            $query->orderByDesc('date_purchased');
        }
    }
   
    $purchasedVehicles = $query->paginate(10);

    $allVehicles = DealerInventory::where('post', true)
        ->with('vehicle')
        ->paginate(10);

    return view('customer.customer-purchased', compact('allVehicles', 'purchasedVehicles'));
}

    

    
}
