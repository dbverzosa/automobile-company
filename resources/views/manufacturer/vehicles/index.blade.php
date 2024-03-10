@extends('manufacturer.layout')

@section('manufacturer')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif



    <div class="d-flex justify-content-between align-items-center">
        <h1>Your Vehicles Created</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticVehicleModal">Add New Vehicle</button>
    </div>

      <!-- Modal -->
      <div class="modal fade" id="staticVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticVehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticVehicleModalLabel">Add New Vehicle</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form method="POST" action="{{ route('manufacturer.storeVehicle') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="brand" class="form-label">Brand</label>
                                <input type="text" class="form-control" id="brand" name="brand" required>
                            </div>
                            <div class="mb-3">
                                <label for="model" class="form-label">Model</label>
                                <input type="text" class="form-control" id="model" name="model" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="mb-3">
                                <label for="manufacturing_plant" class="form-label">Manufacturing Plant</label>
                                <input type="text" class="form-control" id="manufacturing_plant" name="manufacturing_plant">
                            </div>
                            <div class="mb-3">
                                <label for="details" class="form-label">Details</label>
                                <textarea class="form-control" id="details" name="details" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="color" class="form-label">Color</label>
                                <input type="text" class="form-control" id="color" name="color">
                            </div>
                            <div class="mb-3">
                                <label for="engine" class="form-label">Engine</label>
                                <input type="text" class="form-control" id="engine" name="engine">
                            </div>
                            <div class="mb-3">
                                <label for="transmission" class="form-label">Transmission</label>
                                <input type="text" class="form-control" id="transmission" name="transmission">
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
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
        <form action="{{ route('manufacturer.vehicles.index') }}" method="GET" class="d-flex mt-4" role="search">
            <select class="form-select me-2" style="width: 150px;" name="brand">
                <option value="" selected>Select Brand</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand }}">{{ $brand }}</option>
                @endforeach
            </select>
            <select class="form-select me-2" style="width: 150px;" name="model">
                <option value="" selected>Select Model</option>
                @foreach ($models as $model)
                    <option value="{{ $model }}">{{ $model }}</option>
                @endforeach
            </select>
            <input type="text" class="form-control me-2" style="width: 150px;" placeholder="Search anything" name="search">
            <button type="submit" class="btn btn-outline-success" style="padding: .375rem .5rem; font-size: .875rem; width: 100px;">Search </button>
            <a href="{{ route('manufacturer.vehicles.index') }}" class="btn btn-primary" style="padding: .375rem .5rem; font-size: .875rem; width: 100px; margin-left:5px;">Show All</a>
        </form>
    </div>
    <table class="table" border="1" style="margin: 0 auto; margin-top:20px">
        <thead>
            <tr>
                <th>Image</th>
                <th>VIN</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Price</th>
                <th>Manufacturing Plant</th>
                <th>Details</th>
                <th>Color</th>
                <th>Engine</th>
                <th>Transmission</th>
                {{-- <th>Quantity</th> --}}
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
             @if ($message)
                <p>{{ $message }}</p>
             @endif
            @foreach ($vehicles as $vehicle)
            <tr>
                
                <td><img src="{{ asset('storage/vehicles_images/'.$vehicle->image) }}" alt="Vehicle Image" style="max-width: 100px;"></td>
                <td>{{$vehicle->vin}}</td>
                <td>{{ $vehicle->brand }}</td>
                <td>{{ $vehicle->model }}</td>
                <td>{{ $vehicle->price }}</td>
                <td>{{ $vehicle->manufacturing_plant }}</td>
                <td>{{ $vehicle->details }}</td>
                <td>{{ $vehicle->color }}</td>
                <td>{{ $vehicle->engine }}</td>
                <td>{{ $vehicle->transmission }}</td>
                {{-- <td>{{ $vehicle->quantity }}</td> --}}
                <td>
                    <!-- Edit Button -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $vehicle->id }}">Edit</button>
                    
                    <!-- Delete Button -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $vehicle->id }}">Delete</button>
                

                    <div class="modal fade" id="editModal{{ $vehicle->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $vehicle->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $vehicle->id }}">Edit Vehicle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('manufacturer.updateVehicle', $vehicle->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="edit_image" class="form-label">Image</label>
                                            <input type="file" class="form-control" id="edit_image" name="edit_image" accept="image/*">
                                            <img src="{{ asset('storage/vehicles_images/'.$vehicle->image) }}" alt="Current Image" style="max-width: 100px; margin-top: 5px;">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_brand" class="form-label">Brand</label>
                                            <input type="text" class="form-control" id="edit_brand" name="edit_brand" value="{{ $vehicle->brand }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_model" class="form-label">Model</label>
                                            <input type="text" class="form-control" id="edit_model" name="edit_model" value="{{ $vehicle->model }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_price" class="form-label">Price</label>
                                            <input type="number" class="form-control" id="edit_price" name="edit_price" value="{{ $vehicle->price }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_manufacturing_plant" class="form-label">Manufacturing Plant</label>
                                            <input type="text" class="form-control" id="edit_manufacturing_plant" name="edit_manufacturing_plant" value="{{ $vehicle->manufacturing_plant }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_details" class="form-label">Details</label>
                                            <textarea class="form-control" id="edit_details" name="edit_details" rows="3">{{ $vehicle->details }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_color" class="form-label">Color</label>
                                            <input type="text" class="form-control" id="edit_color" name="edit_color" value="{{ $vehicle->color }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_engine" class="form-label">Engine</label>
                                            <input type="text" class="form-control" id="edit_engine" name="edit_engine" value="{{ $vehicle->engine }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_transmission" class="form-label">Transmission</label>
                                            <input type="text" class="form-control" id="edit_transmission" name="edit_transmission" value="{{ $vehicle->transmission }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $vehicle->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $vehicle->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $vehicle->id }}">Delete Vehicle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this vehicle?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form method="POST" action="{{ route('manufacturer.destroyVehicle', $vehicle->id) }}">
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
    
    <div class="d-flex justify-content-center mt-4">
        <ul class="pagination" style="margin: 0; padding: 0;">
            @if ($vehicles->lastPage() > 1)
                @if ($vehicles->currentPage() != 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $vehicles->url(1) }}">«</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">«</span>
                    </li>
                @endif
    
                @for ($i = 1; $i <= $vehicles->lastPage(); $i++)
                    <li class="page-item{{ ($vehicles->currentPage() == $i) ? ' active' : '' }}">
                        <a class="page-link" href="{{ $vehicles->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
    
                @if ($vehicles->currentPage() != $vehicles->lastPage())
                    <li class="page-item">
                        <a class="page-link" href="{{ $vehicles->url($vehicles->currentPage() + 1) }}">»</a>
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
        Showing {{ $vehicles->firstItem() }} to {{ $vehicles->lastItem() }} of {{ $vehicles->total() }} entries
    </p>
    
    {{-- <div class="d-flex justify-content-center mt-4">
        <ul class="pagination" style="margin: 0; padding: 0;">
            @if ($vehicles->lastPage() > 1)
                @if ($vehicles->currentPage() != 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $vehicles->url(1) }}">«</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">«</span>
                    </li>
                @endif
    
                @for ($i = 1; $i <= $vehicles->lastPage(); $i++)
                    <li class="page-item{{ ($vehicles->currentPage() == $i) ? ' active' : '' }}">
                        <a class="page-link" href="{{ $vehicles->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor
    
                @if ($vehicles->currentPage() != $vehicles->lastPage())
                    <li class="page-item">
                        <a class="page-link" href="{{ $vehicles->url($vehicles->currentPage() + 1) }}">»</a>
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
        Showing {{ $vehicles->firstItem() }} to {{ $vehicles->lastItem() }} of {{ $vehicles->total() }} entries
    </p>
     --}}
         
 @endsection 


