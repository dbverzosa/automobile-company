<?php

namespace App\Http\Controllers;

use App\Models\DealerInventory;
use App\Models\ManufacturerVehicle;
use Illuminate\Http\Request;

class PublicController extends Controller
{


    public function browseAllVehicles()
    {
        $featuredVehicles = DealerInventory::where('post', true)
            ->where('trend', true)
            ->with('vehicle')
            ->get();

        $allVehicles = DealerInventory::where('post', true)
            ->with('vehicle')
            ->paginate(9);



        return view('customer.dashboard', compact('featuredVehicles', 'allVehicles'));
    }


    public function layout()
    {

        $allVehicles = DealerInventory::where('post', true)
            ->with('vehicle')
            ->paginate(9);


        return view('customer.layout', compact('allVehicles'));
    }


    // public function featuredCars()
    // {

    //      $allVehicles = DealerInventory::where('post', true)
    //     ->with('vehicle')
    //     ->paginate(9);

    //     $featuredCars = DealerInventory::where('post', true)
    //         ->where('trend', true)
    //         ->with('vehicle')
    //         ->get();

    //     return view('customer.featured-cars', compact('allVehicles', 'featuredCars'));
    // }


    public function featuredCars(Request $request)
    {
        $allVehiclesQuery = DealerInventory::query()->where('post', true)->with('vehicle');

        // Check if a search query is provided
        if ($request->filled('search_query')) {
            $searchQuery = $request->input('search_query');
            $allVehiclesQuery->whereHas('vehicle', function ($query) use ($searchQuery) {
                $query->where('brand', 'like', '%' . $searchQuery . '%')
                    ->orWhere('model', 'like', '%' . $searchQuery . '%')
                    ->orWhere('color', 'like', '%' . $searchQuery . '%')
                    ->orWhere('transmission', 'like', '%' . $searchQuery . '%')
                    ->orWhere('price', 'like', '%' . $searchQuery . '%')
                    ->orWhere('engine', 'like', '%' . $searchQuery . '%');
            });
        }

        $allVehicles = $allVehiclesQuery->paginate(9);

        $featuredCars = $allVehiclesQuery->where('trend', true)->get();
        $featuredCars = $allVehiclesQuery->paginate(9);

   

        return view('customer.featured-cars', compact('allVehicles', 'featuredCars'));
    }



    public function vehicles(Request $request)
    {
        $query = DealerInventory::where('post', true)->with('vehicle');
        
        if ($request->filled('model')) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('model', 'like', '%' . $request->input('model') . '%');
            });
        }
    
        if ($request->filled('brand')) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('brand', 'like', '%' . $request->input('brand') . '%');
            });
        }
    
        if ($request->filled('transmission')) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('transmission', 'like', '%' . $request->input('transmission') . '%');
            });
        }
    
        if ($request->filled('engine')) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('engine', 'like', '%' . $request->input('engine') . '%');
            });
        }
        if ($request->filled('price_min')) {
            $query->where('new_price', '>=', $request->input('price_min'));
        }
    
        if ($request->filled('price_max')) {
            $query->where('new_price', '<=', $request->input('price_max'));
        }
    
    
        if ($request->filled('color')) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('color', 'like', '%' . $request->input('color') . '%');
            });
        }
    
        if ($request->filled('manufacturing_plant')) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('manufacturing_plant', 'like', '%' . $request->input('manufacturing_plant') . '%');
            });
        }
    
        $allVehicles = $query->paginate(12);
    
        // Retrieve unique values for dropdowns
        $brands = ManufacturerVehicle::distinct()->pluck('brand')->unique();
        $models = ManufacturerVehicle::distinct()->pluck('model')->unique();
        $transmissions = ManufacturerVehicle::distinct()->pluck('transmission')->unique();
        $engines = ManufacturerVehicle::distinct()->pluck('engine')->unique();
        $colors = ManufacturerVehicle::distinct()->pluck('color')->unique();
        $manufacturing_plants = ManufacturerVehicle::distinct()->pluck('manufacturing_plant')->unique();
    
        return view('customer.all-vehicles', compact('allVehicles', 'brands', 'models', 'transmissions', 'engines', 'colors', 'manufacturing_plants'));
    }


    // public function findDealer()
    // {


    //     return view('customer.find-dealer');
    // }

    
    public function findDealer()
    {

         $allVehicles = DealerInventory::where('post', true)
        ->with('vehicle')
        ->paginate(9);


        return view('customer.find-dealer', compact('allVehicles'));
    }

    




    
}
