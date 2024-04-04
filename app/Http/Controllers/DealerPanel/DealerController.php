<?php

namespace App\Http\Controllers\DealerPanel;

use App\Http\Controllers\Controller;
use App\Models\CustomerReservation;
use App\Models\DealerInventory;
use App\Models\DealerPurchaseVehicle;
use App\Models\ManufacturerSale;
use Illuminate\Support\Facades\Auth;
use App\Models\ManufacturerVehicle;
use App\Models\ManufacturerVehicleInventory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DealerController extends Controller
{


    public function index()
    {
        // e retrieve tanan purchased vehicle IDs gikan sa DealerInventory table
        $purchasedVehicleIds = DealerInventory::pluck('manufacturer_vehicle_id')->toArray();

        // e fetch ang vehicles na wala napalit
        $vehicles = ManufacturerVehicle::whereNotIn('id', $purchasedVehicleIds)->paginate(12);

        // e return sa dealer dashboard view ang list sa mga available vehicles
        return view('dealer.dashboard', compact('vehicles'));
    }

    public function search(Request $request): View
    {
        // e retrieve ang search parameters gikan sa request
        $brandName = $request->input('brand_name');
        $modelName = $request->input('model_name');
        $color = $request->input('color');
        $engine = $request->input('engine');
        $transmission = $request->input('transmission');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $manufacturingPlant = $request->input('manufacturing_plant');

        // Start sa query
        $query = ManufacturerVehicle::query();

        // mga conditions based sa search parameters
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

        // execute sa query ug paginate sa results
        $vehicles = $query->paginate(9);

        // append ang search parameters sa pagination links
        $vehicles->appends($request->except('page'));

        // return sa view
        return view('dealer.dashboard', ['vehicles' => $vehicles]);
    }


    public function purchase(Request $request)
    {
        // e retrieve ang vehicle ID gikan sa request
        $vehicleId = $request->input('vehicle_id');

        // find sa vehicle based sa ID
        $vehicle = ManufacturerVehicle::find($vehicleId);

        // e check if ang vehicle ga exists
        if (!$vehicle) {
            return redirect()->back()->with('error', 'Vehicle not found.');
        }

        // e check if ang vehicle quantity kay greater than 0
        if ($vehicle->quantity <= 0) {
            return redirect()->back()->with('error', 'Vehicle is out of stock.');
        }

        // save and create ug new record or data entry sa sale sa manufacturer
        $manufacturerSale = new ManufacturerSale();
        $manufacturerSale->vehicle_id = $vehicleId;
        $manufacturerSale->dealer_id = auth()->user()->id;
        $manufacturerSale->manufacturer_id = $vehicle->manufacturer_id;
        $manufacturerSale->date_purchased = now();
        $manufacturerSale->sale_price = $vehicle->price;
        $manufacturerSale->quantity_sold = 1;
        $manufacturerSale->total_price = $vehicle->price;
        $manufacturerSale->save();


        // save and create ug new record or data entry sa dealer inventory
        $dealerInventory = new DealerInventory();
        $dealerInventory->dealer_id = auth()->user()->id;
        $dealerInventory->manufacturer_vehicle_id = $vehicleId;
        $dealerInventory->post = false; 
        $dealerInventory->trend = false; 
        $dealerInventory->new_price = 0; 
        $dealerInventory->details = null; 
        $dealerInventory->save();


        // save and create ug new record or data entry sa dealer_purchase_vehicles table
        $purchaseVehicle = new DealerPurchaseVehicle();
        $purchaseVehicle->manufacturer_vehicle_id = $vehicleId;
        $purchaseVehicle->dealer_id = Auth::user()->id;
        $purchaseVehicle->date_purchased = now();
        $purchaseVehicle->save();

        // e update ang is_sold status sa ManufacturerVehicleInventory
        $inventoryItem = ManufacturerVehicleInventory::where('vehicle_id', $vehicleId)->first();
        if ($inventoryItem) {
            $inventoryItem->is_sold = true;
            $inventoryItem->save();
        }

        // e decrease ang quantity sa purchased vehicle sa manufacturer's inventory
        $vehicle->quantity--;

        // e save ang changes didto sa vehicle
        $vehicle->save();

        // then e redirect dayon balik sa dealer dashboard with a success message na
        return redirect()->route('dealer.dashboard')->with('success', 'Successfully purchased ' . $vehicle->brand . ' ' . $vehicle->model . ' for ' . $vehicle->price . ' Pesos');
    }


    public function purchasedVehicles()
    {
        // e get ang authenticated dealer's ID
        $dealerId = auth()->user()->id;

        // e retrieve tanan purchased vehicles sa kana na specific dealer
        $purchasedVehicles = DealerPurchaseVehicle::where('dealer_id', $dealerId)->get();

        //then return sa view sa purchased vehicles
        return view('dealer.purchased-vehicles', compact('purchasedVehicles'));
    }

    public function purchasedVehiclesSearch(Request $request)
    {
        // e get ang authenticated dealer's ID
        $dealerId = auth()->user()->id;

        // mao ni ang sa search query sa purchasedvehicles
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
        //return dayon sa view sa result sa search didto sa purchased-vehicles 
        return view('dealer.purchased-vehicles', compact('purchasedVehicles'));
    }


    public function carInventory()
    {
        // e get ang authenticated dealer's ID
        $dealerId = auth()->user()->id;

        // tas e get ang tanan vehicles gikan sa dealer's inventory
        $vehicles = DealerInventory::where('dealer_id', $dealerId)->with('vehicle')->get();

        // return dayon ang view with where gi pass the data sa car-inventory
        return view('dealer.car-inventory', compact('vehicles'));
    }

    public function edit(Request $request, $id)
    {
        // e find ang specific vehicle by its ID
        $vehicle = DealerInventory::find($id);

        // e check if ang vehicle nag exists
        if (!$vehicle) {
            return redirect()->back()->with('error', 'Vehicle not found.');
        }

        // e check if the authenticated user ang owner sa vehicle
        if ($vehicle->dealer_id !== auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to edit this vehicle.');
        }

        // Validate the request data
        $request->validate([
            'new_price' => 'required|numeric',
            'post' => 'required|boolean',
            'trend' => 'required|boolean',
            'details' => 'nullable|string',
        ]);

        // update the vehicle's details
        $vehicle->new_price = $request->input('new_price');
        $vehicle->post = $request->input('post');
        $vehicle->trend = $request->input('trend');
        $vehicle->details = $request->input('details');
        $vehicle->save();

        //then redirect back dayon sa car inventory with a success message na
        return redirect()->route('dealer.carInventory')->with('success', 'Vehicle details updated successfully.');
    }


    public function carInventorySearch(Request $request)
    {
        $dealerId = auth()->user()->id;

        $searchTerm = $request->input('search-anything');
        $postFilter = $request->input('quantity_filter');
        $trendFilter = $request->input('trend_filter');

        $query = DealerInventory::query()->where('dealer_id', $dealerId);

        if ($searchTerm !== null && $searchTerm !== '') {
            $query->whereHas('vehicle', function ($q) use ($searchTerm) {
                $q->where('vin', 'like', '%' . $searchTerm . '%')
                    ->orWhere('brand', 'like', '%' . $searchTerm . '%')
                    ->orWhere('color', 'like', '%' . $searchTerm . '%')
                    ->orWhere('transmission', 'like', '%' . $searchTerm . '%')
                    ->orWhere('model', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($postFilter !== null && $postFilter !== '') {
            if ($postFilter === '1') {
                $query->where('post', true);
            } elseif ($postFilter === '0') {
                $query->where('post', false);
            }
        }

        if ($trendFilter !== null && $trendFilter !== '') {
            if ($trendFilter === '1') {
                $query->where('trend', true);
            } elseif ($trendFilter === '0') {
                $query->where('trend', false);
            }
        }

        $vehicles = $query->paginate(10);

        return view('dealer.car-inventory', compact('vehicles'));
    }

    public function CarSales()
    {
        $dealerId = auth()->user()->id;

        $purchasedVehicles = CustomerReservation::with('manufacturerVehicle', 'customer')
            ->where('dealer_id', $dealerId)
            ->get();

        return view('dealer.dealer-car-sales', compact('purchasedVehicles'));
    }


    public function SearchCarSales(Request $request)
    {
        $dealerId = auth()->user()->id;

        $query = CustomerReservation::where('dealer_id', $dealerId);

        // Apply search filters
        if ($request->filled('name')) {
            $name = $request->input('name');
            $query->where(function ($q) use ($name) {
                $q->whereHas('customer', function ($q) use ($name) {
                    $q->where('name', 'like', "%$name%")
                        ->orWhere('phone_number', 'like', "%$name%")
                        ->orWhere('delivery_address', 'like', "%$name%")
                        ->orWhere('gender', 'like', "%$name%");
                })
                    ->orWhereHas('manufacturerVehicle', function ($q) use ($name) {
                        $q->where('vin', 'like', "%$name%")
                            ->orWhere('brand', 'like',  "%$name%")
                            ->orWhere('color', 'like', "%$name%")
                            ->orWhere('transmission', 'like', "%$name%")
                            ->orWhere('engine', 'like', "%$name%")
                            ->orWhere('model', 'like', "%$name%");
                    })
                    ->orWhere('date_purchased', 'like', "%$name%")
                    ->orWhere('date_delivered', 'like', "%$name%")
                    ->orWhere('income', 'like', "%$name%")
                    ->orWhere('details', 'like', "%$name%")
                    ->orWhere('price', 'like', "%$name%")
                    ->orWhere('id', 'like', "%$name%")
                    ->orWhere(function ($q) use ($name) {
                        if ($name === 'pending' || $name === 'confirmed') {
                            $q->where('is_pending', $name === 'pending');
                        }
                    });
            });
        }

        if ($request->filled('status-filter')) {
            $query->where('is_pending', $request->input('status-filter'));
        }

        if ($request->filled('gender-filter')) {
            $query->where('gender', $request->input('gender-filter'));
        }

        if ($request->filled('date-filter')) {
            if ($request->input('date-filter') == 'oldest') {
                $query->orderBy('date_purchased', 'asc');
            } elseif ($request->input('date-filter') == 'newest') {
                $query->orderBy('date_purchased', 'desc');
            }
        }

        $purchasedVehicles = $query->get();

        return view('dealer.sales-search', compact('purchasedVehicles'));
    }





    public function update(Request $request, $id)
    {
        $request->validate([
            'is_pending' => 'required|boolean',
            'date_delivered' => 'nullable|date',
        ]);

        //check if the dealer is the user 
        $vehicle = CustomerReservation::where('id', $id)
            ->where('dealer_id', auth()->user()->id)
            ->firstOrFail();


        $vehicle->is_pending = $request->input('is_pending');
        $vehicle->date_delivered = $request->input('date_delivered');
        $vehicle->save();

        return redirect()->back()->with('success', 'Vehicle details updated successfully');
    }


    public function trackCarSales()
    {
        $dealerId = auth()->user()->id;

        $confirmedSales = CustomerReservation::where('dealer_id', $dealerId)
            ->where('is_pending', false)
            ->paginate(12);

        return view('dealer.track-car-sales', compact('confirmedSales'));
    }





    public function SearchtrackCarSales(Request $request)
    {
        $dealerId = auth()->user()->id;

        $confirmedSales = CustomerReservation::where('dealer_id', $dealerId)
            ->where('is_pending', false)
            ->paginate(12);

        
        $query = CustomerReservation::where('is_pending', false);

  
        if ($request->filled('brand_search')) {
            $query->whereHas('manufacturerVehicle', function ($q) use ($request) {
                $q->where('brand', 'like', '%' . $request->input('brand_search') . '%');
            });
        }
        if ($request->filled('model_search')) {
            $query->whereHas('manufacturerVehicle', function ($q) use ($request) {
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
                    ->orWhereHas('manufacturerVehicle', function ($q) use ($searchTerm) {
                        $q->where('brand', 'like', '%' . $searchTerm . '%')
                            ->orWhere('model', 'like', '%' . $searchTerm . '%')
                            ->orWhere('vin', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('customer', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

  
        $sort = $request->input('sort', 'oldest_to_latest');
        if ($sort === 'oldest_to_latest') {
            $query->orderBy('date_purchased');
        } elseif ($sort === 'latest_to_oldest') {
            $query->orderByDesc('date_purchased');
        }

        $confirmedSales = $query->paginate(10);

        $confirmedSales->appends($request->except('page'));



        return view('dealer.track-car-sales-search', compact('confirmedSales'));
    }




    public function TrackingTotalSales()
    {
        $dealerId = auth()->user()->id;

        $confirmedSales = CustomerReservation::where('dealer_id', $dealerId)
            ->where('is_pending', false)
            ->get();


        return view('dealer.tracking-total-sales', compact('confirmedSales'));
    }



    public function SearchTrackingTotalSales(Request $request)
    {
        $dealerId = auth()->user()->id;

        $query = CustomerReservation::where('dealer_id', $dealerId)
            ->where('is_pending', false);

        if ($request->filled('brand_search')) {
            $query->whereHas('manufacturerVehicle', function ($q) use ($request) {
                $q->where('brand', 'like', '%' . $request->input('brand_search') . '%');
            });
        }
        if ($request->filled('model_search')) {
            $query->whereHas('manufacturerVehicle', function ($q) use ($request) {
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
                    ->orWhereHas('manufacturerVehicle', function ($q) use ($searchTerm) {
                        $q->where('brand', 'like', '%' . $searchTerm . '%')
                            ->orWhere('model', 'like', '%' . $searchTerm . '%')
                            ->orWhere('vin', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('customer', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        $confirmedSales = $query->paginate(12);

        // pag calculate sa total quantity sold and total sales price for each brand and model
        $totals = [];
        foreach ($confirmedSales as $sale) {
            $brandModelKey = $sale->manufacturerVehicle->brand . $sale->manufacturerVehicle->model;
            if (!isset($totals[$brandModelKey])) {
                $totals[$brandModelKey] = 0;
            }
            $totals[$brandModelKey]++;
        }

        // e return dayon ang view with filtered results and totals
        return view('dealer.tracking-total-sales-search', compact('confirmedSales', 'totals'));
    }
}
