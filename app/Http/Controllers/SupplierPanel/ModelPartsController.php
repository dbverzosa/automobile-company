<?php

namespace App\Http\Controllers\SupplierPanel;
use App\Models\ModelParts;
use App\Http\Controllers\Controller;
use App\Models\InventorySales;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


    class ModelPartsController extends Controller
    { 
        
         /*** START SUPPLIER PART  */ 


        /**
         * Display all the listing of the modelname.
        */ 

    public function index()
    {
        // fetch model parts associated with the authenticated user
        $user = Auth::user();
        $modelParts = ModelParts::where('user_id', $user->id)->paginate(10);

        // then return and pass model parts data to the view
        return view('supplier.modelparts.index', ['model_parts' => $modelParts]);
    }


    public function search(Request $request): View
{
    // pag retrieve sa search parameters from the request
    $search = $request->input('search');
    $minPrice = $request->input('min_price');
    $maxPrice = $request->input('max_price');
    $availability = $request->input('availability');

    // get ang authenticated user which sa kani na case kay supplier
    $user = Auth::user();

    // start sa query
    $query = ModelParts::where('user_id', $user->id);

    if ($search) {
        $query->where('model_name', 'like', '%' . $search . '%');
    }
    if ($minPrice && $maxPrice) {
        $query->whereBetween('price', [$minPrice, $maxPrice]);
    } elseif ($minPrice) {
        $query->where('price', '>=', $minPrice);
    } elseif ($maxPrice) {
        $query->where('price', '<=', $maxPrice);
    }
    if ($availability !== null) {
        $query->where('is_available', (bool) $availability);
    }

    $modelParts = $query->paginate(10);

    $modelParts->appends($request->except('page'));

    // Return the view with search results
    return view('supplier.modelparts.index', ['model_parts' => $modelParts]);
}

public function store(Request $request)
{
    // validate the form data
    $validatedData = $request->validate([
        'model_name' => 'required|string',
        'image' => 'required|image',
        'price' => 'required|numeric',
        'quantity' => 'required|numeric',
        'date_supplied' => 'required|date',
        'is_available' => 'boolean',
    ]);

    try {
        // store sa uploaded image
        $imageFileName = $request->file('image')->getClientOriginalName(); // get ang original filename
        $imagePath = 'modelparts_images/' . $imageFileName; // construct sa desired image path

        $request->file('image')->storeAs('public', $imagePath); // store dayon ang image sa desired path

        // create a new model part instance or new record/entry sa model parts
        $modelPart = new ModelParts();
        $modelPart->model_name = $validatedData['model_name'];
        $modelPart->image = $imagePath;
        $modelPart->price = $validatedData['price'];
        $modelPart->quantity = $validatedData['quantity'];
        $modelPart->date_supplied = $validatedData['date_supplied'];
        $modelPart->is_available = $request->has('is_available');
        $modelPart->user_id = auth()->id(); 

        // save ang model part
        $modelPart->save();

        //create dayon ug new entry sa InventorySales table with the total quantity set to the model part's quantity
        $inventorySales = new InventorySales();
        $inventorySales->model_part_id = $modelPart->id;
        $inventorySales->remaining_quantity = $modelPart->quantity;
        $inventorySales->sold_quantity = 0;
        $inventorySales->total_quantity = $modelPart->quantity; // set the total quantity to the model part's quantity
        $inventorySales->total_sales = 0;
        $inventorySales->save();

        // tas redirect back with success message
        return redirect()->back()->with('success', 'Model part created successfully.');
    } catch (\Exception $e) {
        // then handle any errors that occur during the process
        return redirect()->back()->with('error', 'Failed to create model part. ' . $e->getMessage());
    }
}
  // original store
    // public function store(Request $request)
    // {
    //     // Validate the form data
    //     $validatedData = $request->validate([
    //         'model_name' => 'required|string',
    //         'image' => 'required|image',
    //         'price' => 'required|numeric',
    //         'quantity' => 'required|numeric',
    //         'date_supplied' => 'required|date',
    //         'is_available' => 'boolean',
    //     ]);

    //     // Store the uploaded image
    //     $imageFileName = $request->file('image')->getClientOriginalName(); // Get the original filename
    //     $imagePath = 'modelparts_images/' . $imageFileName; // Construct the desired image path

    //     $request->file('image')->storeAs('public', $imagePath); // Store the image in the desired path

    //     // Create a new model part instance
    //     $modelPart = new ModelParts();
    //     $modelPart->model_name = $validatedData['model_name'];
    //     $modelPart->image = $imagePath;
    //     $modelPart->price = $validatedData['price'];
    //     $modelPart->quantity = $validatedData['quantity'];
    //     $modelPart->date_supplied = $validatedData['date_supplied'];
    //     $modelPart->is_available = $request->has('is_available');
    //     $modelPart->user_id = auth()->id(); // Assuming you have user_id field in model_parts table

    //     // Save the model part
    //     $modelPart->save();

    //     // Redirect back with success message
    //     return redirect()->back()->with('success', 'Model part created successfully.');
    // }


    public function update(Request $request, ModelParts $modelpart)
{
    // validate sa form data gikan sa request
    $validatedData = $request->validate([
        'model_name' => 'required|string',
        'image' => 'image',
        'price' => 'required|numeric',
        'quantity' => 'required|numeric',
        'date_supplied' => 'required|date',
        'is_available' => 'boolean',
    ]);

    // update the model part with validated data
    $modelpart->model_name = $validatedData['model_name'];
    $modelpart->price = $validatedData['price'];
    $modelpart->quantity = $validatedData['quantity'];
    $modelpart->date_supplied = $validatedData['date_supplied'];
    $modelpart->is_available = $request->has('is_available');

    // update the image if provided
    if ($request->hasFile('image')) {
        // store the new image
        $imageFileName = $request->file('image')->getClientOriginalName();
        $imagePath = 'modelparts_images/' . $imageFileName;
        $request->file('image')->storeAs('public', $imagePath);
        $modelpart->image = $imagePath;
    }

    // save the updated model part
    $modelpart->save();

    // then redirect back with success message dayon
    return redirect()->back()->with('success', 'Model part updated successfully.');
}


        public function destroy($id)
        {
            // find ang model part by ID
            $modelPart = ModelParts::findOrFail($id);
        
            // delete the model part
            $modelPart->delete();
        
            // then redirect back with success message
            return redirect()->back()->with('success', 'Model part deleted successfully.');
        }

         /*** END OF SUPPLIER PART  */ 

     

    }

    



        
        