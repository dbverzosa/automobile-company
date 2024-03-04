<?php

namespace App\Http\Controllers\ManufacturerPanel;

use App\Http\Controllers\Controller;
use App\Models\ModelParts;
use App\Models\PurchaseModelParts;
use Illuminate\Http\Request;

class PurchaseModelPartController extends Controller
{

    
    public function purchasedModelParts()
    {
        // Get the logged-in user's ID
        $manufacturerId = auth()->id();
    
        // Paginate the purchased model parts for the logged-in user
        $purchasedModelParts = PurchaseModelParts::where('manufacturer_id', $manufacturerId)->paginate(10); // Change 10 to the desired number of items per page
    
        // Return the view with the purchased model parts data
        return view('manufacturer.purchased-model-parts', ['purchasedModelParts' => $purchasedModelParts]);
    }
    public function search(Request $request)
    {
        $manufacturerId = auth()->id();
    
        $query = PurchaseModelParts::query()->where('manufacturer_id', $manufacturerId);
    
        if ($request->filled('supplier_name')) {
            $query->whereHas('supplier', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('supplier_name') . '%');
            });
        }
    
        if ($request->filled('model_name')) {
            $query->whereHas('modelPart', function ($q) use ($request) {
                $q->where('model_name', 'like', '%' . $request->input('model_name') . '%');
            });
        }
    
        if ($request->filled('date_purchased')) {
            $query->whereDate('date_purchased', $request->input('date_purchased'));
        }
    
        if ($request->filled('amount_filter')) {
            if ($request->input('amount_filter') == 'big_to_small') {
                $query->orderBy('price', 'desc');
            } elseif ($request->input('amount_filter') == 'small_to_big') {
                $query->orderBy('price', 'asc');
            }
        }
    
        if ($request->filled('date_filter')) {
            if ($request->input('date_filter') == 'latest_to_oldest') {
                $query->orderBy('date_purchased', 'desc');
            } elseif ($request->input('date_filter') == 'oldest_to_latest') {
                $query->orderBy('date_purchased', 'asc');
            }
        }
    
        $purchasedModelParts = $query->paginate(10); // Change 10 to the desired number of items per page
    
        return view('manufacturer.purchased-model-parts', ['purchasedModelParts' => $purchasedModelParts]);
    }
    
    public function purchase(Request $request, $id)
    {
        $modelPart = ModelParts::findOrFail($id);

        // Validate the request
        $request->validate([
            'quantity' => 'required|integer|min:1|max:'.$modelPart->quantity,
        ]);

        // Process the purchase
        $quantity = $request->input('quantity');
        $totalPrice = $modelPart->price * $quantity;

        // Save the purchase details to the PurchaseModelParts table
        $purchaseModelPart = new PurchaseModelParts();
        $purchaseModelPart->model_id = $modelPart->id;
        $purchaseModelPart->supplier_id = $modelPart->user_id; // Assuming user_id is the supplier ID
        $purchaseModelPart->manufacturer_id = auth()->id(); // Assuming the logged-in user is the manufacturer
        $purchaseModelPart->quantity = $quantity;
        $purchaseModelPart->price = $modelPart->price;
        $purchaseModelPart->total_price = $totalPrice;
        $purchaseModelPart->details = $request->input('details');
        $purchaseModelPart->date_purchased = now(); // Assuming you want to store the current date and time
        $purchaseModelPart->save();

        // Update the available quantity of the model part
        $modelPart->quantity -= $quantity;
        $modelPart->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Successfully purchased '.$quantity.' '.$modelPart->model_name.' for a total of '.$totalPrice.' Pesos ');
    }
  
}


  // public function purchase(Request $request)
    // {
    //     // Validate the incoming request data
    // $request->validate([
    //     'model_id' => 'required|exists:model_parts,id',
    //     'supplier_id' => 'required|exists:users,id,role,supplier',
    //     'quantity' => 'required|integer|min:1',
    //     'price' => 'required|numeric|min:0',
    //     'details' => 'nullable|string',
    //     'payment_method' => 'required|string',
    //     'amount_paid' => 'nullable|numeric|min:0',
    //     'date_purchased' => 'nullable|date',
    // ]);

    // // Calculate the total price
    // $quantity = $request->input('quantity');
    // $price = $request->input('price');
    // $totalPrice = $quantity * $price;

    // // Create a new purchase record
    // $purchase = PurchaseModelParts::create([
    //     'model_id' => $request->input('model_id'),
    //     'supplier_id' => $request->input('supplier_id'),
    //     'manufacturer_id' => auth()->id(), // Assuming the manufacturer is authenticated
    //     'quantity' => $quantity,
    //     'price' => $price,
    //     'total_price' => $totalPrice,
    //     'details' => $request->input('details'),
    //     'payment_method' => $request->input('payment_method'),
    //     'amount_paid' => $request->input('amount_paid'),
    //     'date_purchased' => $request->input('date_purchased') ?? now(),
    //     'is_approved' => false,
    // ]);
    // }