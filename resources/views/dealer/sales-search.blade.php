@extends('dealer.layout')

@section('dealer')


<div class="container">
    <h1 class="featured-heading"> FINAL SEARCH Sales Vehicles</h1>
    <div class="row justify-content-center mt-3 mb-3">
        <a class="text-center mb-3" href="{{ url('/dealer/dashboard/car-sales/track-car-sales') }}"><button class="btn btn-outline-success me-2" type="button">2ND SEARCH TrackING Sales</button></a>

        <div class="col-md-12">
            <form class="d-flex justify-content-center" role="search" action="{{ route('dealer.sales.carSearch') }}" method="GET">
                <input class="form-control me-2" style="width: 2in;" type="search" placeholder="Search" aria-label="Name" name="name">
            
                <div class="d-inline-block me-2">
                    <select class="form-select" name="status-filter">
                        <option value="">Status</option>
                        <option value="1">Pending</option>
                        <option value="0">Confirmed</option>
                    </select>
                </div>
                <div class="d-inline-block me-2">
                    <select class="form-select" name="gender-filter">
                        <option value="">Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="d-inline-block me-2">
                    <select class="form-select" name="date-filter">
                        <option value="">Filter Date Purchased</option>
                        <option value="oldest">Oldest to Newest</option>
                        <option value="newest">Newest to Oldest</option>
                    </select>
                </div>
                <button class="btn btn-outline-success me-2" type="submit">Search</button>
            
                <a href="{{ route('dealer.sales.carSales') }}"><button class="btn btn-outline-success me-2" type="button">Show</button></a>

            </form>
        </div>
    </div>
</div>


<div class="container" >
    @if($purchasedVehicles->isEmpty())
    <div class="alert alert-warning" role="alert">
        No results found.
    </div>
    @else
    <table class="table">
        <thead>
            <tr>
                <th scope="col">More Info</th>
                <th scope="col">No.</th>
                {{-- <th scope="col">Vehicle ID</th> --}}
                <th scope="col">VIN</th>
                <th scope="col">Costumer Name</th>
                <th scope="col">Costumer Contact No.</th>
                <th scope="col">is Pending</th>
                <th scope="col">Gender</th>
                <th scope="col">Income</th>
                <th scope="col">Delivery Address</th>
                <th scope="col">Details</th>
                <th scope="col">Date Purchased</th>
                <th scope="col">Date Delivered</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchasedVehicles as $index => $purchasedVehicle)
            @if ($purchasedVehicle->manufacturerVehicle)
            <tr>
                <td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#vehicleModal{{ $index }}">More Info</button>
                </td>
                <td>{{ $index + 1 }}</td>
                {{-- <td>{{ $purchasedVehicle->manufacturerVehicle->id }}</td> --}}
                <td>{{ $purchasedVehicle->manufacturerVehicle->vin }}</td>
                <td>{{ $purchasedVehicle->customer->name }}</td>
                <td>{{ $purchasedVehicle->customer->phone_number }}</td>
                <td>{{ $purchasedVehicle->is_pending ? 'Pending' : 'Confirmed' }}</td>
                <td>{{ $purchasedVehicle->gender }}</td>
                <td>{{ $purchasedVehicle->income }}</td>
                <td>{{ $purchasedVehicle->delivery_address }}</td>
                <td>{{ $purchasedVehicle->details }}</td>
                <td>{{ \Carbon\Carbon::parse($purchasedVehicle->date_purchased)->format('F d, Y') }}</td>
                <td>{{ $purchasedVehicle->date_delivered ? \Carbon\Carbon::parse($purchasedVehicle->date_delivered)->format('F d, Y') : '' }}</td>
                <td>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $index }}">Update</button>
                    <div class="modal fade" id="editModal{{ $index }}" tabindex="-1" aria-labelledby="editModalLabel{{ $index }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $index }}">Update Vehicle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('dealer.update', $purchasedVehicle->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="is_pending" class="form-label">Is Pending</label>
                                            <select class="form-select" id="is_pending" name="is_pending">
                                                <option value="1" {{ $purchasedVehicle->is_pending ? 'selected' : '' }}>Pending</option>
                                                <option value="0" {{ !$purchasedVehicle->is_pending ? 'selected' : '' }}>Confirmed</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="date_delivered" class="form-label">Date Delivered</label>
                                            <input type="date" class="form-control" id="date_delivered" name="date_delivered" value="{{ $purchasedVehicle->date_delivered }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    @endif
</div>
</div>


@foreach ($purchasedVehicles as $index => $purchasedVehicle)
<div class="modal fade" id="vehicleModal{{ $index }}" tabindex="-1" aria-labelledby="vehicleModalLabel{{ $index }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vehicleModalLabel{{ $index }}">Vehicle Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('storage/vehicles_images/' . $purchasedVehicle->manufacturerVehicle->image) }}" alt="Vehicle Image" style="max-width: 100%; height: auto;">
                <strong> <p>VIN: </strong> {{ $purchasedVehicle->manufacturerVehicle->vin }}</p>
                <strong>  <p>Brand: </strong>{{ $purchasedVehicle->manufacturerVehicle->brand }}</p>
                <strong><p>Model Name:</strong> {{ $purchasedVehicle->manufacturerVehicle->model }}</p>
                <strong> <p>Color:</strong> {{ $purchasedVehicle->manufacturerVehicle->color }}</p>
                <strong><p>Engine: </strong>{{ $purchasedVehicle->manufacturerVehicle->engine }}</p>
                <strong><p>Transmission:</strong> {{ $purchasedVehicle->manufacturerVehicle->transmission }}</p>
                <strong><p>Manufacturing Plant:</strong> {{ $purchasedVehicle->manufacturerVehicle->manufacturing_plant }}</p>
                {{-- <strong><p>Vehicle ID: </strong>{{ $purchasedVehicle->manufacturerVehicle->id }}</p> --}}
                <strong><p>Customer Name: </strong>{{ $purchasedVehicle->customer->name }}</p>
                <strong><p>Customer Contact No.: </strong>{{ $purchasedVehicle->customer->phone_number }}</p>
                <strong><p>Customer Address: </strong>{{ $purchasedVehicle->customer->region }}, {{ $purchasedVehicle->customer->city }} City, {{ $purchasedVehicle->customer->address }}</p>
             
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
