
@extends('dealer.layout')

@section('dealer')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .vehicle-image {
    max-width: 100px;
    height: auto;
}


</style>
<h1>Car Inventory</h1>
<form action="{{ route('dealer.car-inventory.search') }}" method="GET" class="d-flex justify-content-between align-items-center" id="filter-form">
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Search anything" name="search-anything" value="">
        <select class="form-control" id="quantity_filter" name="quantity_filter">
            <option value="">Select if posted</option>
            <option value="1">Posted</option>
            <option value="0">Not Posted</option>
        </select>
        <select class="form-control" id="trend_filter" name="trend_filter">
            <option value="">Select if trend</option>
            <option value="1">Trend</option>
            <option value="0">Not Trend</option>
        </select>
        <button class="btn btn-outline-secondary" type="submit">Search</button>
        <a href="{{ url('dealer/dashboard/car-inventory') }}" class="btn btn-outline-secondary">Show All</a>
    </div>
    
</form>



<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Image</th>
            <th>VIN</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Color</th>
            <th>Transmission</th>
            <th>Engine</th>
            <th>Price</th>
            <th>New Price</th>
            <th>Post</th>
            <th>Trend</th>
            <th>Details</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($vehicles as $vehicle)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td><img src="{{ asset('storage/vehicles_images/' .$vehicle->vehicle->image) }}" alt="Vehicle Image" class="vehicle-image"></td>
            <td>{{ $vehicle->vehicle->vin }}</td>
            <td>{{ $vehicle->vehicle->brand }}</td>
            <td>{{ $vehicle->vehicle->model }}</td>
            <td>{{ $vehicle->vehicle->color }}</td>
            <td>{{ $vehicle->vehicle->transmission }}</td>
            <td>{{ $vehicle->vehicle->engine }}</td>
            <td>{{ $vehicle->vehicle->price }}</td>
            <td>{{ $vehicle->new_price }}</td>
            <td>{{ $vehicle->post ? 'Yes' : 'No' }}</td>
            <td>{{ $vehicle->trend ? 'Yes' : 'No' }}</td>
            <td>{{ $vehicle->details }}</td>
            <td>
                <button type="button" class="btn btn-primary editBtn" data-bs-toggle="modal" data-bs-target="#editModal{{ $vehicle->id }}">Edit</button>
            </td>
        </tr>
       

         <div class="modal fade" id="editModal{{ $vehicle->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $vehicle->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $vehicle->id }}">Edit Vehicle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                     
                    <img src="{{ asset('storage/vehicles_images/' . $vehicle->vehicle->image) }}" alt="Vehicle Image" style="max-width: 100px; height: auto;">
                        <p><strong>Brand:</strong> {{ $vehicle->vehicle->brand }}</p>
                        <p><strong>Model:</strong> {{ $vehicle->vehicle->model }}</p>
                        <p><strong>Color:</strong> {{ $vehicle->vehicle->color }}</p>
                        <p><strong>Transmission:</strong> {{ $vehicle->vehicle->transmission }}</p>
                        <p><strong>Engine:</strong> {{ $vehicle->vehicle->engine }}</p>
                        <p><strong>Price:</strong> {{ $vehicle->vehicle->price }}</p>
                        <p><strong>VIN:</strong> {{ $vehicle->vehicle->vin }}</p>
                        <form method="GET" action="{{ route('dealer.vehicles.edit', ['id' => $vehicle->id]) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="new_price" class="form-label">New Price</label>
                                <input type="number" class="form-control" id="new_price" name="new_price" placeholder="Enter new price">
                            </div>
                            <div class="mb-3">
                                <label for="post" class="form-label">Post</label>
                                <select class="form-select" id="post" name="post">
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="trend" class="form-label">Trend</label>
                                <select class="form-select" id="trend" name="trend">
                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="details" class="form-label">Details</label>
                                <textarea class="form-control" id="details" name="details" rows="3" placeholder="Enter details"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                   
                </div>
            </div>
        </div>
        
        @endforeach
    </tbody>
</table>
<div style="text-align: center;">
    <div style="display: inline-block; margin-top: 20px;">
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

    <p style="text-align: center; margin-top: 10px;">
        Showing {{ $vehicles->firstItem() }} to {{ $vehicles->lastItem() }} of {{ $vehicles->total() }} entries
    </p>
</div>



@endsection
