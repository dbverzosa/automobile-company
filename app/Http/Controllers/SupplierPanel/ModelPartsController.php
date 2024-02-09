<?php

namespace App\Http\Controllers\SupplierPanel;
use App\Models\ModelParts;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


    class ModelPartsController extends Controller
    {
    
        /**
         * Display all the listing of the modelname.
        */ 

    public function index()
    {
        // Fetch model parts associated with the authenticated user
        $user = Auth::user();
        $modelParts = ModelParts::where('user_id', $user->id)->paginate(5);

        // Pass model parts data to the view
        return view('supplier.modelparts.index', ['model_parts' => $modelParts]);
    }

    
    
public function search(Request $request): View
{
    // Retrieve search parameters from the request
    $search = $request->input('search');
    $minPrice = $request->input('min_price');
    $maxPrice = $request->input('max_price');
    $availability = $request->input('availability');

    // Get the authenticated user
    $user = Auth::user();

    // Start building the query
    $query = ModelParts::where('user_id', $user->id);

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
        $query->where('is_available', (bool) $availability);
    }

    // Execute the query and paginate the results
    $modelParts = $query->paginate(5);

    // Append search parameters to pagination links
    $modelParts->appends($request->except('page'));

    // Return the view with search results
    return view('supplier.modelparts.index', ['model_parts' => $modelParts]);
}



public function store(Request $request)
{
    // Validate the form data
    $validatedData = $request->validate([
        'model_name' => 'required|string',
        'image' => 'required|image',
        'price' => 'required|numeric',
        'quantity' => 'required|numeric',
        'date_supplied' => 'required|date',
        'is_available' => 'boolean',
    ]);

    // Store the uploaded image
    $imageFileName = $request->file('image')->getClientOriginalName(); // Get the original filename
    $imagePath = 'modelparts_images/' . $imageFileName; // Construct the desired image path

    $request->file('image')->storeAs('public', $imagePath); // Store the image in the desired path

    // Create a new model part instance
    $modelPart = new ModelParts();
    $modelPart->model_name = $validatedData['model_name'];
    $modelPart->image = $imagePath;
    $modelPart->price = $validatedData['price'];
    $modelPart->quantity = $validatedData['quantity'];
    $modelPart->date_supplied = $validatedData['date_supplied'];
    $modelPart->is_available = $request->has('is_available');
    $modelPart->user_id = auth()->id(); // Assuming you have user_id field in model_parts table

    // Save the model part
    $modelPart->save();

      // Redirect back with success message
      return redirect()->back()->with('success', 'Model part created successfully.');
}


public function update(Request $request, $id)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'model_name' => 'required|string',
            'image' => 'image',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'date_supplied' => 'required|date',
            'is_available' => 'boolean',
        ]);

        // Find the model part by id
        $modelPart = ModelParts::findOrFail($id);

        // Update the model part with validated data
        $modelPart->model_name = $validatedData['model_name'];
        $modelPart->price = $validatedData['price'];
        $modelPart->quantity = $validatedData['quantity'];
        $modelPart->date_supplied = $validatedData['date_supplied'];
        $modelPart->is_available = $request->has('is_available');

        // Update the image if provided
        if ($request->hasFile('image')) {
            // Store the new image
            $imageFileName = $request->file('image')->getClientOriginalName();
            $imagePath = 'modelparts_images/' . $imageFileName;
            $request->file('image')->storeAs('public', $imagePath);
            $modelPart->image = $imagePath;
        }

        // Save the updated model part
        $modelPart->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Model part updated successfully.');
    }


    public function destroy($id)
    {
        // Find the model part by ID
        $modelPart = ModelParts::findOrFail($id);
    
        // Delete the model part
        $modelPart->delete();
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Model part deleted successfully.');
    }

}

    
    