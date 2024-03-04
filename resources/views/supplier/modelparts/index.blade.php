<!-- SUPPLIER DASHBOARD CRUD -->
<!-- resources/views/supplier/dashboard/modelparts/index.blade.php -->
@extends('supplier.supplier-dashboard')

@section('modelparts')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model Parts</title>
    
</head>
<body>
    <div>
            <!-- Success message display -->
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center">
            <h1>Your Model Parts</h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add New Model Part</button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"> Add New Model Part</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form action="{{ route('supplier.modelparts.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="model_name" class="form-label">Model Name</label>
                                    <input type="text" class="form-control" id="model_name" name="model_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="price" name="price" required>
                                </div>
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                                </div>
                                <div class="mb-3">
                                    <label for="date_supplied" class="form-label">Date Supplied</label>
                                    <input type="date" class="form-control" id="date_supplied" name="date_supplied" required>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1" checked>
                                    <label class="form-check-label" for="is_available">Available</label>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <form action="{{ route('supplier.modelparts.search') }}" method="GET" class="d-flex mt-4" role="search" >
                <input class="form-control me-2" style="width: 150px;" type="text" name="search" placeholder="Model Part Name">
                <input class="form-control me-2" style="width: 150px;" type="number" name="min_price" placeholder="Min Price">
                <input class="form-control me-2" style="width: 150px;" type="number" name="max_price" placeholder="Max Price">
                <select class="form-select me-2" style="width: 200px;" name="availability">
                    <option value="">Select Availability</option>
                    <option value="1">Available</option>
                    <option value="0">Not Available</option>
                </select>
                <button class="btn btn-outline-success" style="padding: .375rem .5rem; font-size: .875rem; width: 100px;" type="submit">Search</button>
                <a href="{{ route('supplier.modelparts.index') }}" class="btn btn-primary" style="padding: .375rem .5rem; font-size: .875rem; width: 100px; margin-left:5px">Show All</a>
            </form>
        </div>

        <table class="table" border="1" style="margin: 0 auto; margin-top:20px">
            <thead>
                <tr>
                    {{-- <th>Supplier ID</th> --}}
                    {{-- <th>Supplier Name</th> --}}
                    <th>Model Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Date Supplied</th>
                    <th>Available</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($model_parts as $part)
                    <tr>
                        {{-- <td>{{ $part->user_id }}</td> --}}
                                {{-- <td>{{ $part->user->name }}</td> --}}
                                <td>{{ $part->model_name }}</td>
                                <td><img src="{{ asset($part->image) }}" alt="Model Parts Image" style="max-width: 100px;"></td>
                                <td>{{ $part->price }}</td>
                                <td>{{ $part->quantity }}</td>
                                <td>{{ $part->date_supplied }}</td>
                                <td>{{ $part->is_available ? 'Yes' : 'No' }}</td>
                                <td>
                                    
                                    <!-- Action Buttons in the table -->
                                
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $part->id }}">Edit</button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $part->id }}">Delete</button>


                                        <div class="modal fade" id="editModal{{ $part->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $part->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $part->id }}">Edit Model Part</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="editForm" action="{{ route('supplier.modelparts.update', ['modelpart' => $part->id]) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf <!-- CSRF token -->
                                                            @method('PUT') <!-- Use PUT method for update -->
                                                            <div class="mb-3">
                                                                <label for="edit_model_name" class="form-label">Model Name</label>
                                                                <input type="text" class="form-control" id="edit_model_name" name="model_name" required>
                                                                <div class="invalid-feedback">Please enter the model name.</div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="edit_image" class="form-label">Image</label>
                                                                <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                                                                <div class="invalid-feedback">Please choose a valid image file.</div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="edit_price" class="form-label">Price</label>
                                                                <input type="number" class="form-control" id="edit_price" name="price" required>
                                                                <div class="invalid-feedback">Please enter a valid price.</div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="edit_quantity" class="form-label">Quantity</label>
                                                                <input type="number" class="form-control" id="edit_quantity" name="quantity" required>
                                                                <div class="invalid-feedback">Please enter a valid quantity.</div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="edit_date_supplied" class="form-label">Date Supplied</label>
                                                                <input type="date" class="form-control" id="edit_date_supplied" name="date_supplied" required>
                                                                <div class="invalid-feedback">Please enter a valid date.</div>
                                                            </div>
                                                            <div class="mb-3 form-check">
                                                                <input type="checkbox" class="form-check-input" id="edit_is_available" name="is_available" value="1">
                                                                <label class="form-check-label" for="edit_is_available">Available</label>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                                <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $part->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Delete Model Part</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this model part?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form id="deleteForm{{ $part->id }}" action="{{ route('supplier.modelparts.destroy', ['id' => $part->id]) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <div style="text-align: center;">
        <div style="display: inline-block; margin-top: 20px;">
            <ul class="pagination" style="margin: 0; padding: 0;">
                <!-- Custom pagination rendering -->
                @if ($model_parts->lastPage() > 1)
                    @if ($model_parts->currentPage() != 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $model_parts->url(1) }}">«</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">«</span>
                        </li>
                    @endif
        
                    @for ($i = 1; $i <= $model_parts->lastPage(); $i++)
                        <li class="page-item{{ ($model_parts->currentPage() == $i) ? ' active' : '' }}">
                            <a class="page-link" href="{{ $model_parts->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
        
                    @if ($model_parts->currentPage() != $model_parts->lastPage())
                        <li class="page-item">
                            <a class="page-link" href="{{ $model_parts->url($model_parts->currentPage() + 1) }}">»</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">»</span>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    
        <!-- Showing X to Y of Z entries -->
        <p style="text-align: center; margin-top: 10px;">
            Showing {{ $model_parts->firstItem() }} to {{ $model_parts->lastItem() }} of {{ $model_parts->total() }} entries
        </p>
    </div>
</body>
</html>
@endsection


 <!-- SUPPLIER DASHBOARD DONEEEEEEEEEEEEEEEEE!!!-->

<!-- TO BE POLISHED!!-->
 <!-- DELETE THE INDEX AND SEARCH IN SUPPLIER/INDEX,SEARCH  DO NOT TOUCH THE MODELPARTS!!-->

 <!-- TO DOs!!!-->

  <!-- MANUFACTURER DASHBOARD -->
  <!-- DEALER DASHBOARD -->
  <!-- CUSTOMER DASHBOARD -->


   <!-- MAJOR -->
   <!-- INVENTORY AND SALES -->

