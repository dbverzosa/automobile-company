<?php

namespace App\Http\Controllers\ManufacturerPanel;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\ManufacturerVehicle;
use App\Models\ManufacturerVehicleInventory;
use Illuminate\Http\Request;

class ManufacturerVehicleController extends Controller
{

    public function index(Request $request)
{
    $query = ManufacturerVehicle::where('manufacturer_id', auth()->id());

    // e exclude ang vehicles nga na purchased na sa dealers
    $query->whereDoesntHave('dealerInventories');

    if ($request->filled('brand')) {
        $query->where('brand', 'like', '%' . $request->brand . '%');
    }

    if ($request->filled('model')) {
        $query->where('model', 'like', '%' . $request->model . '%');
    }

    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->where(function ($q) use ($searchTerm) {
            $q->where('brand', 'like', '%' . $searchTerm . '%')
              ->orWhere('model', 'like', '%' . $searchTerm . '%')
              ->orWhere('price', 'like', '%' . $searchTerm . '%')
              ->orWhere('manufacturing_plant', 'like', '%' . $searchTerm . '%')
              ->orWhere('details', 'like', '%' . $searchTerm . '%')
              ->orWhere('color', 'like', '%' . $searchTerm . '%')
              ->orWhere('engine', 'like', '%' . $searchTerm . '%')
              ->orWhere('vin', 'like', '%' . $searchTerm . '%')
              ->orWhere('transmission', 'like', '%' . $searchTerm . '%');
        });
    }

    $vehicles = $query->paginate(10);

    // e filter ang distinct brands and models based sa user's vehicles
    $brands = $query->distinct()->pluck('brand');
    $models = $query->distinct()->pluck('model');

    // e check if any vehicles were found
    $message = $vehicles->isEmpty() ? 'No results found.' : '';

    //return dayon sa view
    return view('manufacturer.vehicles.index', ['vehicles' => $vehicles, 'brands' => $brands, 'models' => $models, 'message' => $message]);
}

public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'brand' => 'required|string',
        'model' => 'required|string',
        'price' => 'required|numeric',
        'quantity' => 'required|integer|min:1',
        'manufacturing_plant' => 'string|nullable',
        'details' => 'string|nullable',
        'color' => 'string|nullable',
        'engine' => 'string|nullable',
        'transmission' => 'string|nullable',
        'image' => 'required|image', 
    ]);

    // create vehicles with unique VINs based sa quantity
    $vehicles = [];
    $user = auth()->user();
    for ($i = 0; $i < $request->quantity; $i++) {
        $vin = $this->generateUniqueVin();
        $vehicle = new ManufacturerVehicle();
        $vehicle->vin = $vin;
        $vehicle->brand = $request->brand;
        $vehicle->model = $request->model;
        $vehicle->price = $request->price;
        $vehicle->manufacturing_plant = $request->manufacturing_plant;
        $vehicle->details = $request->details;
        $vehicle->color = $request->color;
        $vehicle->engine = $request->engine;
        $vehicle->transmission = $request->transmission;

        // upload and store the image
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/vehicles_images', $imageName);
        $vehicle->image = $imageName;

        $vehicle->manufacturer_id = $user->id;
        $vehicle->save();
        $vehicles[] = $vehicle;

      // create a corresponding new record or data entry in the inventory too
        $inventory = new ManufacturerVehicleInventory();
        $inventory->vehicle_id = $vehicle->id;
        $inventory->is_sold = false; 
        $inventory->save();

    }

    return redirect()->back()->with('success', 'Successfully added '.$request->quantity.' vehicles');
}





    private function generateUniqueVin()
    {
        // generate a unique VIN 
        return Str::random(5);
    }

    public function editVehicle($id)
    {
        $vehicle = ManufacturerVehicle::findOrFail($id);

        return view('manufacturer.vehicles.edit', compact('vehicle'));
    }

    public function updateVehicle(Request $request, $id)
    {
        $validatedData = $request->validate([
            'edit_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'edit_brand' => 'required|string',
            'edit_model' => 'required|string',
            'edit_price' => 'required|numeric',
            'edit_manufacturing_plant' => 'nullable|string',
            'edit_details' => 'nullable|string',
            'edit_color' => 'nullable|string',
            'edit_engine' => 'nullable|string',
            'edit_transmission' => 'nullable|string',
        ]);

        $vehicle = ManufacturerVehicle::findOrFail($id);

        if ($request->hasFile('edit_image')) {
            $image = $request->file('edit_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/vehicles_images', $imageName);
            $vehicle->image = $imageName;
        }

        $vehicle->brand = $request->edit_brand;
        $vehicle->model = $request->edit_model;
        $vehicle->price = $request->edit_price;
        $vehicle->manufacturing_plant = $request->edit_manufacturing_plant;
        $vehicle->details = $request->edit_details;
        $vehicle->color = $request->edit_color;
        $vehicle->engine = $request->edit_engine;
        $vehicle->transmission = $request->edit_transmission;
        $vehicle->save();

        return redirect()->route('manufacturer.vehicles.index')->with('success', 'Vehicle '.$vehicle->brand.' '.$vehicle->model.' updated successfully');    }

        public function destroy($id)
    {
        $vehicle = ManufacturerVehicle::findOrFail($id);
        $vehicle->delete();

        return redirect()->route('manufacturer.vehicles.index')->with('success', 'Vehicle '.$vehicle->brand.' '.$vehicle->model.' is deleted successfully');
    }

}



//public function store(Request $request)
// {
//     // Validate the request data
//     $request->validate([
//         'brand' => 'required|string',
//         'model' => 'required|string',
//         'price' => 'required|numeric',
//         'quantity' => 'required|integer|min:1',
//         'manufacturing_plant' => 'string|nullable',
//         'details' => 'string|nullable',
//         'color' => 'string|nullable',
//         'engine' => 'string|nullable',
//         'transmission' => 'string|nullable',
//         'image' => 'required|image', // Validate the image upload
//     ]);

//     // Create vehicles with unique VINs based on the quantity
//     $vehicles = [];
//     $user = auth()->user();
//     for ($i = 0; $i < $request->quantity; $i++) {
//         $vin = $this->generateUniqueVin();
//         $vehicle = new ManufacturerVehicle();
//         $vehicle->vin = $vin;
//         $vehicle->brand = $request->brand;
//         $vehicle->model = $request->model;
//         $vehicle->price = $request->price;
//         $vehicle->manufacturing_plant = $request->manufacturing_plant;
//         $vehicle->details = $request->details;
//         $vehicle->color = $request->color;
//         $vehicle->engine = $request->engine;
//         $vehicle->transmission = $request->transmission;

//         // Upload and store the image
//         $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
//         $request->file('image')->storeAs('public/vehicles_images', $imageName);
//         $vehicle->image = $imageName;

//         $vehicle->manufacturer_id = $user->id;
//         $vehicle->save();
//         $vehicles[] = $vehicle;
        

//         // Create a corresponding entry in the inventory
//         $inventory = new ManufacturerVehicleInventory();
//         $inventory->vehicle_id = $vehicle->id;
//         $inventory->quantity_sold = 0; // Set initial quantity sold to 0
//         $inventory->quantity_unsold = $request->quantity; // Set initial quantity unsold to the inputted quantity
//         $inventory->save();
//     }

//     return redirect()->back()->with('success', 'Successfully added '.$request->quantity.' vehicles');
// }




// //original store
// public function store(Request $request)
// {
//     // Validate the request data
//     $request->validate([
//         'brand' => 'required|string',
//         'model' => 'required|string',
//         'price' => 'required|numeric',
//         'quantity' => 'required|integer|min:1',
//         'manufacturing_plant' => 'string|nullable',
//         'details' => 'string|nullable',
//         'color' => 'string|nullable',
//         'engine' => 'string|nullable',
//         'transmission' => 'string|nullable',
//         'image' => 'required|image', // Validate the image upload
//     ]);

//     // Create vehicles with unique VINs based on the quantity
//     $vehicles = [];
//     $user = auth()->user();
//     for ($i = 0; $i < $request->quantity; $i++) {
//         $vin = $this->generateUniqueVin();
//         $vehicle = new ManufacturerVehicle();
//         $vehicle->vin = $vin;
//         $vehicle->brand = $request->brand;
//         $vehicle->model = $request->model;
//         $vehicle->price = $request->price;
//         $vehicle->manufacturing_plant = $request->manufacturing_plant;
//         $vehicle->details = $request->details;
//         $vehicle->color = $request->color;
//         $vehicle->engine = $request->engine;
//         $vehicle->transmission = $request->transmission;

//         // Upload and store the image
//         $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
//         $request->file('image')->storeAs('public/vehicles_images', $imageName);
//         $vehicle->image = $imageName;

//         $vehicle->manufacturer_id = $user->id;
//         $vehicle->save();
//         $vehicles[] = $vehicle;


//         // Create a corresponding entry in the inventory
//         $inventory = new ManufacturerVehicleInventory();
//         $inventory->vehicle_id = $vehicle->id;
//         $inventory->is_sold = false; // Set as unsold
//         $inventory->save();

//     }

//     return redirect()->back()->with('success', 'Successfully added '.$request->quantity.' vehicles');
// }





























/////--------------------daan------------
//     public function index(Request $request)
// {
//     $query = ManufacturerVehicle::query();

//     if ($request->filled('brand')) {
//         $query->where('brand', 'like', '%' . $request->brand . '%');
//     }

//     if ($request->filled('model')) {
//         $query->where('model', 'like', '%' . $request->model . '%');
//     }

//     if ($request->filled('search')) {
//         $searchTerm = $request->search;
//         $query->where(function ($q) use ($searchTerm) {
//             $q->where('brand', 'like', '%' . $searchTerm . '%')
//               ->orWhere('model', 'like', '%' . $searchTerm . '%')
//               ->orWhere('price', 'like', '%' . $searchTerm . '%')
//               ->orWhere('manufacturing_plant', 'like', '%' . $searchTerm . '%')
//               ->orWhere('details', 'like', '%' . $searchTerm . '%')
//               ->orWhere('color', 'like', '%' . $searchTerm . '%')
//               ->orWhere('engine', 'like', '%' . $searchTerm . '%')
//               ->orWhere('vin', 'like', '%' . $searchTerm . '%')
//               ->orWhere('transmission', 'like', '%' . $searchTerm . '%');
//         });
//     }

//     // Paginate the results with 10 items per page (adjust as needed)
//     $vehicles = $query->paginate(10);

//     $brands = ManufacturerVehicle::distinct()->pluck('brand');
//     $models = ManufacturerVehicle::distinct()->pluck('model');

//     // Check if any vehicles were found
//     $message = $vehicles->isEmpty() ? 'No results found.' : '';

//     return view('manufacturer.vehicles.index', ['vehicles' => $vehicles, 'brands' => $brands, 'models' => $models, 'message' => $message]);
// }
    
//     public function index(Request $request)
// {
//     $query = ManufacturerVehicle::query();

//     if ($request->filled('brand')) {
//         $query->where('brand', 'like', '%' . $request->brand . '%');
//     }

//     if ($request->filled('model')) {
//         $query->where('model', 'like', '%' . $request->model . '%');
//     }

//     if ($request->filled('search')) {
//         $searchTerm = $request->search;
//         $query->where(function ($q) use ($searchTerm) {
//             $q->where('brand', 'like', '%' . $searchTerm . '%')
//               ->orWhere('model', 'like', '%' . $searchTerm . '%')
//               ->orWhere('price', 'like', '%' . $searchTerm . '%')
//               ->orWhere('manufacturing_plant', 'like', '%' . $searchTerm . '%')
//               ->orWhere('details', 'like', '%' . $searchTerm . '%')
//               ->orWhere('color', 'like', '%' . $searchTerm . '%')
//               ->orWhere('engine', 'like', '%' . $searchTerm . '%')
//               ->orWhere('vin', 'like', '%' . $searchTerm . '%')
//               ->orWhere('transmission', 'like', '%' . $searchTerm . '%');
//         });
//     }

//     $vehicles = $query->get();

//     $brands = ManufacturerVehicle::distinct()->pluck('brand');
//     $models = ManufacturerVehicle::distinct()->pluck('model');

//     // Check if any vehicles were found
//     $message = $vehicles->isEmpty() ? 'No results found.' : '';

//     return view('manufacturer.vehicles.index', ['vehicles' => $vehicles, 'brands' => $brands, 'models' => $models, 'message' => $message]);

//    }
    // public function index()
    // {
    //     $vehicles = ManufacturerVehicle::all();
    // return view('manufacturer.vehicles.index', ['vehicles' => $vehicles]);
    //     // return view('manufacturer.vehicles.index');
    // }


// //this is the v2
// public function index(Request $request)
// {
//     $query = ManufacturerVehicle::query();

//     // Apply filters if provided in the request
//     if ($request->filled('brand')) {
//         $query->where('brand', 'like', '%' . $request->brand . '%');
//     }

//     if ($request->filled('model')) {
//         $query->where('model', 'like', '%' . $request->model . '%');
//     }

//     if ($request->filled('search')) {
//         $searchTerm = $request->search;
//         $query->where(function ($q) use ($searchTerm) {
//             $q->where('brand', 'like', '%' . $searchTerm . '%')
//                 ->orWhere('model', 'like', '%' . $searchTerm . '%')
//                 ->orWhere('price', 'like', '%' . $searchTerm . '%')
//                 ->orWhere('manufacturing_plant', 'like', '%' . $searchTerm . '%')
//                 ->orWhere('details', 'like', '%' . $searchTerm . '%')
//                 ->orWhere('color', 'like', '%' . $searchTerm . '%')
//                 ->orWhere('engine', 'like', '%' . $searchTerm . '%')
//                 ->orWhere('vin', 'like', '%' . $searchTerm . '%')
//                 ->orWhere('transmission', 'like', '%' . $searchTerm . '%');
//         });
//     }

//     // Paginate the results
//     $vehicles = $query->paginate(10);

//     $brands = ManufacturerVehicle::distinct()->pluck('brand');
//     $models = ManufacturerVehicle::distinct()->pluck('model');

//     // Check if any vehicles were found
//     $message = $vehicles->isEmpty() ? 'No results found.' : '';

//     // Append search parameters to pagination links
//     $vehicles->appends($request->except('page'));

//     // Return the view with the paginated data
//     return view('manufacturer.vehicles.index', compact('vehicles', 'brands', 'models', 'message'));
// }

// public function store(Request $request)
// {
//     // Validate the request data
//     $request->validate([
//         'brand' => 'required|string',
//         'model' => 'required|string',
//         'price' => 'required|numeric',
//         'quantity' => 'required|integer|min:1',
//         'manufacturing_plant' => 'string|nullable',
//         'details' => 'string|nullable',
//         'color' => 'string|nullable',
//         'engine' => 'string|nullable',
//         'transmission' => 'string|nullable',
//         'image' => 'required|image', // Validate the image upload
//     ]);

//     // Create vehicles with unique VINs based on the quantity
//     $vehicles = [];
//     $user = auth()->user();
//     for ($i = 0; $i < $request->quantity; $i++) {
//         $vin = $this->generateUniqueVin();
//         $vehicle = new ManufacturerVehicle();
//         $vehicle->vin = $vin;
//         $vehicle->brand = $request->brand;
//         $vehicle->model = $request->model;
//         $vehicle->price = $request->price;
//         $vehicle->manufacturing_plant = $request->manufacturing_plant;
//         $vehicle->details = $request->details;
//         $vehicle->color = $request->color;
//         $vehicle->engine = $request->engine;
//         $vehicle->transmission = $request->transmission;

//         // Upload and store the image
//         $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
//         $request->file('image')->storeAs('public/vehicles_images', $imageName);
//         $vehicle->image = $imageName;

//         $vehicle->manufacturer_id = $user->id;
//         $vehicle->save();
//         $vehicles[] = $vehicle;
//     }

//     return redirect()->back()->with('success', 'Successfully added ' . $request->quantity . ' vehicles');
// }

// private function generateUniqueVin()
// {
//     // Generate a unique VIN (you can use a more sophisticated logic here)
//     return Str::random(5);
// }

// public function edit($id)
// {
//     $vehicle = ManufacturerVehicle::findOrFail($id);

//     return view('manufacturer.vehicles.edit', compact('vehicle'));
// }

// public function update(Request $request, $id)
// {
//     $vehicle = ManufacturerVehicle::findOrFail($id);

//     // Update the vehicle with the new data
//     $vehicle->brand = $request->edit_brand;
//     $vehicle->model = $request->edit_model;
//     $vehicle->price = $request->edit_price;
//     $vehicle->manufacturing_plant = $request->edit_manufacturing_plant;
//     $vehicle->details = $request->edit_details;
//     $vehicle->color = $request->edit_color;
//     $vehicle->engine = $request->edit_engine;
//     $vehicle->transmission = $request->edit_transmission;

//     // Save the updated vehicle
//     $vehicle->save();

//     // Redirect back to the index page with a success message
//     return redirect()->route('manufacturer.vehicles.index')->with('success', 'Vehicle ' . $vehicle->brand . ' ' . $vehicle->model . ' updated successfully');
// }
// public function destroy($id)
// {
//     $vehicle = ManufacturerVehicle::findOrFail($id);
//     $vehicle->delete();

//     return redirect()->route('manufacturer.vehicles.index')->with('success', 'Vehicle ' . $vehicle->brand . ' ' . $vehicle->model . ' is deleted successfully');
// }
// }
