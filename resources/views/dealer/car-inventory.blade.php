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

<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Image</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Color</th>
            <th>Price</th>
            <th>VIN</th>
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
            <td>{{ $vehicle->vehicle->brand }}</td>
            <td>{{ $vehicle->vehicle->model }}</td>
            <td>{{ $vehicle->vehicle->color }}</td>
            <td>{{ $vehicle->vehicle->price }}</td>
            <td>{{ $vehicle->vehicle->vin }}</td>
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
                        <p><strong>Price:</strong> {{ $vehicle->vehicle->price }}</p>
                        <p><strong>VIN:</strong> {{ $vehicle->vehicle->vin }}</p>
        
                        <form method="POST" action="" enctype="multipart/form-data">
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
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
        
        @endforeach
    </tbody>
</table>



@endsection
