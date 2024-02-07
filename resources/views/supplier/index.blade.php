<!-- SHOWS ALL THE MODEL PARTS -->

@extends('supplier.layout')

@section('allmodels')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model Parts</title>
    
</head>
<body>
    <div>
        <div class="d-flex justify-content-between align-items-center">
            <h1>All Model Parts</h1>
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

                        <form action="" method="POST" enctype="multipart/form-data">
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
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Create</button>
                </div>
            </div>
            </div>
        </div>


        <div class="d-flex justify-content-center">
        <form action="{{ route('supplier.search') }}" method="GET" class="d-flex mt-4" role="search" >
            <input class="form-control me-2" style="width: 150px;" type="text" name="search" placeholder="Model Part Name">
            <input class="form-control me-2" style="width: 150px;" type="number" name="min_price" placeholder="Min Price">
            <input class="form-control me-2" style="width: 150px;" type="number" name="max_price" placeholder="Max Price">
            <select class="form-select me-2" style="width: 200px;" name="availability">
                <option value="">Select Availability</option>
                <option value="1">Available</option>
                <option value="0">Not Available</option>
            </select>
            <button class="btn btn-outline-success" style="padding: .375rem .5rem; font-size: .875rem; width: 100px;" type="submit">Search</button>
        </form>
        </div>

        <table class="table" border="1" style="margin: 0 auto; margin-top:20px">
            <thead>
                <tr>
                    <th>Supplier ID</th>
                    <th>Supplier Name</th>
                    <th>Model Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Date Supplied</th>
                    <th>Available</th>
                </tr>
            </thead>
            <tbody>
                @foreach($model_parts as $part)
                <tr>
                    <td>{{ $part->user_id }}</td>
                    <td>{{ $part->user->name }}</td>
                    <td>{{ $part->model_name }}</td>
                    <td><img src="{{ asset($part->image) }}" alt="Model Parts Image" style="max-width: 100px;"></td>
                    <td>{{ $part->price }}</td>
                    <td>{{ $part->quantity }}</td>
                    <td>{{ $part->date_supplied }}</td>
                    <td>{{ $part->is_available ? 'Yes' : 'No' }}</td>
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


