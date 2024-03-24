<?php

namespace App\Http\Controllers\DealerPanel;

use App\Http\Controllers\Controller;
use App\Models\DealerInventory;
use App\Models\DealerPurchaseVehicle;
use App\Models\ManufacturerSale;
use Illuminate\Support\Facades\Auth;
use App\Models\ManufacturerVehicle;
use App\Models\ManufacturerVehicleInventory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DealerController extends Controller
{
    // public function index()
    // {
    //     // Fetch all vehicles
    //     $vehicles = ManufacturerVehicle::paginate(9); // Change to the desired number of items per page

    //     // Pass vehicles data to the view
    //     return view('dealer.dashboard', ['vehicles' => $vehicles]);
    // }

    public function index()
    {
        // Retrieve all purchased vehicle IDs from the DealerInventory table
        $purchasedVehicleIds = DealerInventory::pluck('manufacturer_vehicle_id')->toArray();

        // Fetch the vehicles that are not purchased
        $vehicles = ManufacturerVehicle::whereNotIn('id', $purchasedVehicleIds)->paginate(10);

        // Return the dealer dashboard view with the list of available vehicles
        return view('dealer.dashboard', compact('vehicles'));
    }

    public function search(Request $request): View
    {
        // Retrieve search parameters from the request
        $brandName = $request->input('brand_name');
        $modelName = $request->input('model_name');
        $color = $request->input('color');
        $engine = $request->input('engine');
        $transmission = $request->input('transmission');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $manufacturingPlant = $request->input('manufacturing_plant');

        // Start building the query
        $query = ManufacturerVehicle::query();

        // Add conditions based on search parameters
        if ($brandName) {
            $query->where('brand', 'like', '%' . $brandName . '%');
        }
        if ($modelName) {
            $query->where('model', 'like', '%' . $modelName . '%');
        }
        if ($color) {
            $query->where('color', 'like', '%' . $color . '%');
        }
        if ($engine) {
            $query->where('engine', 'like', '%' . $engine . '%');
        }
        if ($transmission) {
            $query->where('transmission', 'like', '%' . $transmission . '%');
        }
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }
        if ($manufacturingPlant) {
            $query->where('manufacturing_plant', 'like', '%' . $manufacturingPlant . '%');
        }

        // Execute the query and paginate the results
        $vehicles = $query->paginate(9);

        // Append search parameters to pagination links
        $vehicles->appends($request->except('page'));

        // Return the view with search results
        return view('dealer.dashboard', ['vehicles' => $vehicles]);
    }


    public function purchase(Request $request)
    {
        // Retrieve the vehicle ID from the request
        $vehicleId = $request->input('vehicle_id');

        // Find the vehicle by ID
        $vehicle = ManufacturerVehicle::find($vehicleId);

        // Check if the vehicle exists
        if (!$vehicle) {
            return redirect()->back()->with('error', 'Vehicle not found.');
        }

        // Check if the vehicle quantity is greater than 0
        if ($vehicle->quantity <= 0) {
            return redirect()->back()->with('error', 'Vehicle is out of stock.');
        }

        $manufacturerSale = new ManufacturerSale();
        $manufacturerSale->vehicle_id = $vehicleId;
        $manufacturerSale->dealer_id = auth()->user()->id;
        $manufacturerSale->manufacturer_id = $vehicle->manufacturer_id;
        $manufacturerSale->date_purchased = now();
        $manufacturerSale->sale_price = $vehicle->price;
        $manufacturerSale->quantity_sold = 1; // Assuming you're purchasing one vehicle at a time
        $manufacturerSale->total_price = $vehicle->price;
        $manufacturerSale->save();

        // Perform the purchase logic here...
        // For example, you can create a new record in the DealerInventory table
        // to add the purchased vehicle to the dealer's inventory
        ////-----------THE ORIGINAL-----------
        // $dealerInventory = new DealerInventory();
        // $dealerInventory->dealer_id = auth()->user()->id; // Assuming you have a dealer_id column in your DealerInventory table
        // $dealerInventory->manufacturer_vehicle_id = $vehicleId; // Assuming you have a manufacturer_vehicle_id column in your DealerInventory table
        // $dealerInventory->date_purchased = now(); // Assuming you want to store the current date as the purchase date
        // $dealerInventory->save();

        $dealerInventory = new DealerInventory();
        $dealerInventory->dealer_id = auth()->user()->id;
        $dealerInventory->manufacturer_vehicle_id = $vehicleId;
        $dealerInventory->post = false; // Default value for post
        $dealerInventory->trend = false; // Default value for trend
        $dealerInventory->new_price = 0; // Default value for new_price
        $dealerInventory->details = null; // Default value for details
        $dealerInventory->save();




        // Create a new record in the dealer_purchase_vehicles table
        $purchaseVehicle = new DealerPurchaseVehicle();
        $purchaseVehicle->manufacturer_vehicle_id = $vehicleId;
        $purchaseVehicle->dealer_id = Auth::user()->id;
        $purchaseVehicle->date_purchased = now();
        $purchaseVehicle->save();

        // Update the is_sold status in ManufacturerVehicleInventory
        $inventoryItem = ManufacturerVehicleInventory::where('vehicle_id', $vehicleId)->first();
        if ($inventoryItem) {
            $inventoryItem->is_sold = true;
            $inventoryItem->save();
        }

        // Decrease the quantity of the purchased vehicle in the manufacturer's inventory
        $vehicle->quantity--;

        // Save the changes to the vehicle
        $vehicle->save();

        // Redirect back to the dealer dashboard with a success message
        return redirect()->route('dealer.dashboard')->with('success', 'Successfully purchased ' . $vehicle->brand . ' ' . $vehicle->model . ' for ' . $vehicle->price . ' Pesos');
    }


    public function purchasedVehicles()
    {
        // Get the authenticated dealer's ID
        $dealerId = auth()->user()->id;

        // Retrieve all purchased vehicles for the specific dealer
        $purchasedVehicles = DealerPurchaseVehicle::where('dealer_id', $dealerId)->get();

        return view('dealer.purchased-vehicles', compact('purchasedVehicles'));
    }

    public function purchasedVehiclesSearch(Request $request)
    {
        // Get the authenticated dealer's ID
        $dealerId = auth()->user()->id;

        // Perform the search query
        $searchTerm = $request->input('search');
        $purchasedVehicles = DealerPurchaseVehicle::where('dealer_id', $dealerId)
            ->whereHas('manufacturerVehicle', function ($query) use ($searchTerm) {
                $query->where('brand', 'like', "%$searchTerm%")
                    ->orWhere('model', 'like', "%$searchTerm%")
                    ->orWhere('vin', 'like', "%$searchTerm%")
                    ->orWhere('manufacturing_plant', 'like', "%$searchTerm%")
                    ->orWhere('color', 'like', "%$searchTerm%")
                    ->orWhere('engine', 'like', "%$searchTerm%")
                    ->orWhere('transmission', 'like', "%$searchTerm%")
                    ->orWhereHas('manufacturer', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', "%$searchTerm%");
                    });
            })
            ->get();

        return view('dealer.purchased-vehicles', compact('purchasedVehicles'));
    }


    public function carInventory()
    {
        // Get the authenticated dealer's ID
        $dealerId = auth()->user()->id;
    
        // Get all vehicles from the dealer's inventory
        $vehicles = DealerInventory::where('dealer_id', $dealerId)->with('vehicle')->get();
    
        // Pass the data to the view
        return view('dealer.car-inventory', compact('vehicles'));
    }

    
    
}
