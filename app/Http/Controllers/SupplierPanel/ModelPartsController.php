<?php

namespace App\Http\Controllers\SupplierPanel;
use App\Models\ModelParts;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModelPartsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     
public function index(Request $request): View
{
    $modelparts = ModelParts::paginate(5); // Change 10 to the desired number of items per page

    return view('supplier/modelparts.index', ['model_parts' => $modelparts]);
}

public function search(Request $request): View
{
    // Retrieve search parameters from the request
    $search = $request->input('search');
    $minPrice = $request->input('min_price');
    $maxPrice = $request->input('max_price');
    $availability = $request->input('availability'); // Assuming availability is a boolean value

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
        $query->where('is_available', (bool)$availability);
    }

    // Execute the query and paginate the results
    $modelparts = $query->paginate(5);

    // Append search parameters to pagination links
    $modelparts->appends($request->except('page'));

    // Debugging: Output the generated SQL query
    // dd(DB::getQueryLog());

    // Return the view with search results
    return view('supplier/modelparts.index', ['model_parts' => $modelparts]);
}


/**
     * Search for model parts with pagination
     */


// public function search(Request $request): View
// {
//     $search = $request->get('search');

//     // Perform the search query
//     $modelparts = ModelParts::where('model_name', 'like', '%' . $search . '%')
//         ->paginate(5)
//         ->appends(['search' => $search]); // Append search parameter to pagination links

//     return view('supplier/modelparts.index', ['model_parts' => $modelparts]);
// }


 /**
     * Search for model parts only.
     */

     
    // public function search(Request $request): View
    // {
    //     $search = $request->get('search');

    //     // Perform the search query
    //     $modelparts = ModelParts::where('model_name', 'like', '%' . $search . '%')
    //         ->paginate(5); // Change 5 to the desired number of items per page

    //     return view('supplier/modelparts.index', ['model_parts' => $modelparts]);
    // }

    /**
     * Search for all model parts .
     */
    // public function index(): View
    // {
    //     $modelparts = ModelParts::all();

    //     return view('supplier/modelparts.index', ['model_parts' => $modelparts]);
    // }
    
    // public function index(): View
    // {
    //     return view('supplier/modelparts.index');
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function addmodelparts(Request $request)
    {
        $validatedData = $request->validate([
            'model_name' => 'required|string|max:100',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'quantity' => 'required',
            'date_supplied' => 'required|date',
            'is_available' => 'required|boolean'
        ]);

          // Handle the file upload
          if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $file->storeAs('public/modelparts_images', $filename);

            $validatedData['image'] = $filename;

            ModelParts::create($validatedData);

            // return redirect()->route('supplier.modelparts.addmodelparts')->with('Success', 'Model Part is added successfully');
            
            // Redirect to a different route after successful addition
        return redirect()->route('supplier.modelparts.index')->with('success', 'Model Part added successfully');
    }

     // Handle the case where image upload fails
     return redirect()->route('supplier.modelparts.addmodelparts')->with('error', 'Failed to upload image');

    
}
}

    /**
     * Store a newly created resource in storage.
     */
//     public function store(Request $request): RedirectResponse
//     {
//         $validated = $request->validate([
//             'model_name' => 'required|string|max:100',
//             'image' => 'required|image|max:2048', // Assuming it's an image file with a maximum size of 2MB
//             'price' => 'required|numeric',
//             'quantity' => 'required|numeric',
//             'date_supplied' => 'required|date',
//             'is_available' => 'required|boolean',

//         ]);
 
//         $request->user()->modelparts()->create($validated);
 
//         return redirect(route('supplier/modelparts.index'));
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(string $id)
//     {
//         //
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(string $id)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, string $id)
//     {
//         //
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(string $id)
//     {
//         //
//     }
// }
