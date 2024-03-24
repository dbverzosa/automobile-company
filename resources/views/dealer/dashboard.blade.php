@extends('dealer.layout')

@section('dealer')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dealer Dashboard</title>
    <style>
        .card {
            width: 25%;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
            display: inline-block;
        }
        .card img {
            width: 100%;
            max-height: 400px; /* Set a max height for the image */
            object-fit: cover; /* Ensure the image covers the entire space */
            border-radius: 5px 5px 0 0; /* Apply border radius only to the top corners */
        }

        #vehicleImageModal {
            max-width: 100%;
            max-height: 160px; /* Set the max height as needed */
            object-fit: contain; /* Ensure the image fits within the max height */
        }
        @media (max-width: 768px) {
            .card {
                width: 45%;
            }
        }
    </style>
</head>
<body>
<div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    
    @endif
    <div class="d-flex justify-content-center">
        <form action="{{ route('dealer.search') }}" method="GET" class="d-flex mt-4" role="search">
            <div class="input-group">
                <input class="form-control me-1" style="width: 100px;" type="text" name="brand_name" placeholder="Brand">
            </div>
            <div class="input-group">
                <input class="form-control me-1" style="width: 100px;" type="text" name="model_name" placeholder="Model">
            </div>
            <div class="input-group">
                <input class="form-control me-1" style="width: 100px;" type="text" name="color" placeholder="Color">
            </div>
            <div class="input-group">
                <input class="form-control me-1" style="width: 100px;" type="text" name="engine" placeholder="Engine">
            </div>
            <div class="input-group">
                <input class="form-control me-1" style="width: 130px;" type="text" name="transmission" placeholder="Transmission">
            </div>
            <div class="input-group">
                <input class="form-control me-1" style="width: 100px;" type="number" name="min_price" placeholder="Min">
            </div>
            <div class="input-group">
                <input class="form-control me-1" style="width: 100px;" type="number" name="max_price" placeholder="Max">
            </div>
            <div class="input-group">
                <input class="form-control me-1" style="width: 100px;" type="text" name="manufacturing_plant" placeholder="Plant">
            </div>
            <button class="btn btn-outline-success" style="padding: .25rem .5rem; font-size: .75rem; width: 80px;" type="submit">Search</button>
            <a href="{{ route('dealer.dashboard') }}" class="btn btn-primary" style="padding: .25rem .5rem; font-size: .75rem; width: 80px; margin-left:5px">Show All</a>
        </form>
    </div>

    @if($vehicles->isEmpty())
        <p>No results found</p>
    @else
        <div class="d-flex flex-wrap">
            @foreach ($vehicles as $vehicle)
                <div class="card">
                    <img src="{{ asset('storage/vehicles_images/' . $vehicle->image) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}">
                    <h3>{{ $vehicle->brand }} {{ $vehicle->model }}</h3>    
                    <p>Price: {{ $vehicle->price }}</p>
                    <form action="" method="POST" class="d-flex justify-content-around">
                        @csrf
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#vehicleModal" onclick="showVehicleDetailsModal('{{ $vehicle->image }}', '{{ $vehicle->brand }} {{ $vehicle->model }}', '{{ $vehicle->price }}', '{{ $vehicle->manufacturing_plant }}', '{{ $vehicle->details }}', '{{ $vehicle->color }}', '{{ $vehicle->engine }}', '{{ $vehicle->transmission }}', '{{ $vehicle->vin }}', '{{ $vehicle->manufacturer->name }}')">Preview</button>
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#buyModal_{{ $vehicle->id }}">Buy</button>
                    </form>
                </div>
                <!-- Buy Modal -->
                <div class="modal fade" id="buyModal_{{ $vehicle->id }}" tabindex="-1" aria-labelledby="buyModalLabel_{{ $vehicle->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="buyModalLabel_{{ $vehicle->id }}">Buy Vehicle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center ">
                                <div class=" mb-3">
                                    <p><strong style="color: red;">Are you sure you want to buy this vehicle?</strong></p>

                                    <img src="{{ asset('storage/vehicles_images/' . $vehicle->image) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" style="max-height: 200px;">
                                </div>
                                <p><strong>{{ $vehicle->brand }} {{ $vehicle->model }}</strong></p>
                                <p>Price: {{ $vehicle->price }}</p>
                                <form action="{{ route('dealer.purchase') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Purchase</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Pagination code here -->
        @if($vehicles->lastPage() > 1)
            <div style="text-align: center;">
                <div style="display: inline-block; margin-top: 20px;">
                    <ul class="pagination" style="margin: 0; padding: 0;">
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
                    </ul>
                </div>
                <p style="text-align: center; margin-top: 10px;">
                    Showing {{ $vehicles->firstItem() }} to {{ $vehicles->lastItem() }} of {{ $vehicles->total() }} entries
                </p>
            </div>
        @endif
    @endif
</div>
<!-- Modal -->
<div class="modal fade" id="vehicleModal" tabindex="-1" aria-labelledby="vehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vehicleModalLabel">Vehicle Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="vehicleImageModal" src="" alt="">
                <h3 id="vehicleNameModal"></h3>
                <p id="vehiclePriceModal"></p>
                <p id="vehiclePlantModal"></p>
                <p id="vehicleDetailsModal"></p>
                <p id="vehicleColorModal"></p>
                <p id="vehicleEngineModal"></p>
                <p id="vehicleTransmissionModal"></p>
                <p id="vehicleVINModal"></p>
                <p id="vehicleManufacturerModal"></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    function showVehicleDetailsModal(image, name, price, plant, details, color, engine, transmission, vin, manufacturer) {
        document.getElementById('vehicleImageModal').src = '{{ asset('storage/vehicles_images/') }}' + '/' + image;
        document.getElementById('vehicleNameModal').textContent = name;
        document.getElementById('vehiclePriceModal').textContent = 'Price: ' + price;
        document.getElementById('vehiclePlantModal').textContent = 'Manufacturing Plant: ' + plant;
        document.getElementById('vehicleDetailsModal').textContent = 'Details: ' + details;
        document.getElementById('vehicleColorModal').textContent = 'Color: ' + color;
        document.getElementById('vehicleEngineModal').textContent = 'Engine: ' + engine;
        document.getElementById('vehicleTransmissionModal').textContent = 'Transmission: ' + transmission;
        document.getElementById('vehicleVINModal').textContent = 'VIN: ' + vin;
        document.getElementById('vehicleManufacturerModal').textContent = 'Manufacturer: ' + manufacturer;
    }
</script>

@endsection


{{-- <h1> dealer dashboard</h1>

<form method="POST" action="{{ route('logout') }}">
    @csrf

<a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                        this.closest('form').submit();">
    Logout
    </a>
</form> --}}