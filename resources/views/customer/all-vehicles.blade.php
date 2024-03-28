@extends('customer.layout')


@section('dashboards')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

</head>
<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<style>
   .featured-heading {
            text-align: center;
            color: #333;
            font-size: 1rem;
            font-weight: bold;
            margin-top: 2.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Additional styles for a more attractive design */
        .featured-heading {
            background-color: #f8f9fa;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 20px 10px rgba(0, 0, 0, 0.1);
        }
</style>

 <div class="container">
    {{-- <div class="featured-heading">
        <form class="d-flex" role="search" action="" method="GET">
            <input class="form-control me-2" type="search" placeholder="Model" aria-label="Model">
            <input class="form-control me-2" type="search" placeholder="Brand" aria-label="Brand">
            <input class="form-control me-2" type="search" placeholder="Transmission" aria-label="Transmission" style="width: 130px;">
            <input class="form-control me-2" type="search" placeholder="Engine" aria-label="Engine">
            <input class="form-control me-2" type="search" placeholder="Color" aria-label="Color">
            <input class="form-control me-2" type="search" placeholder="Price Min" aria-label="Price Min">
            <input class="form-control me-2" type="search" placeholder="Price Max" aria-label="Price Max">
            <input class="form-control me-2" type="search" placeholder="Plant" aria-label="Manufacturing Plant">
            <button class="btn btn-outline-success me-2" type="submit">Search</button>
            <a href="{{ url('/vehicles') }}"><button class="btn btn-outline-success me-2" type="button">Show</button></a> 
        </form>
    </div> --}}
    
    {{-- <div class="featured-heading">
        <form class="d-flex" role="search" action="{{ route('vehicles.search') }}" method="GET">
            <input class="form-control me-2" type="search" placeholder="Brand" aria-label="Brand" name="brand">
            <input class="form-control me-2" type="search" placeholder="Model" aria-label="Model" name="model">
            <input class="form-control me-2" type="search" placeholder="Transmission" aria-label="Transmission" style="width: 130px;" name="transmission">
            <input class="form-control me-2" type="search" placeholder="Engine" aria-label="Engine" name="engine">
            <input class="form-control me-2" type="search" placeholder="Color" aria-label="Color" name="color">
            <input class="form-control me-2" type="search" placeholder="Price Min" aria-label="Price Min" name="price_min">
            <input class="form-control me-2" type="search" placeholder="Price Max" aria-label="Price Max" name="price_max">
            <input class="form-control me-2" type="search" placeholder="Plant" aria-label="Manufacturing Plant" name="manufacturing_plant">
            <button class="btn btn-outline-success me-2" type="submit">Search</button>
            <a href="{{ url('/vehicles') }}"><button class="btn btn-outline-success me-2" type="button">Show</button></a> 
        </form>
        
    </div> --}}

    {{-- <div class="featured-heading">
        <form class="d-flex" role="search" action="{{ route('vehicles.search') }}" method="GET">
            <select class="form-select me-2" aria-label="Brand" name="brand">
                <option value="" selected> Brand</option>
                @foreach($brands as $brand)
                <option value="{{ $brand }}">{{ $brand }}</option>
                @endforeach
            </select>
            <select class="form-select me-2" aria-label="Model" name="model">
                <option value="" selected>Model</option>
                @foreach($models as $model)
                <option value="{{ $model }}">{{ $model }}</option>
                @endforeach
            </select>
            <select class="form-select me-2" aria-label="Transmission" style="width: 130px;" name="transmission">
                <option value="" selected>Transmission</option>
                @foreach($transmissions as $transmission)
                <option value="{{ $transmission }}">{{ $transmission }}</option>
                @endforeach
            </select>
            <select class="form-select me-2" aria-label="Engine" name="engine">
                <option value="" selected>Engine</option>
                @foreach($engines as $engine)
                <option value="{{ $engine }}">{{ $engine }}</option>
                @endforeach
            </select>
            <select class="form-select me-2" aria-label="Color" name="color">
                <option value="" selected>Color</option>
                @foreach($colors as $color)
                <option value="{{ $color }}">{{ $color }}</option>
                @endforeach
            </select>
            <input class="form-control me-2" type="search" placeholder="Price Min" aria-label="Price Min" name="price_min">
            <input class="form-control me-2" type="search" placeholder="Price Max" aria-label="Price Max" name="price_max">
             <select class="form-select me-2" aria-label="Manufacturing Plant" name="manufacturing_plant">
                <option value="" selected>Plant</option>
                @foreach($manufacturing_plants as $plant)
                <option value="{{ $plant }}">{{ $plant }}</option>
                @endforeach
            </select>
            <button class="btn btn-outline-success me-2" type="submit">Search</button>
            <a href="{{ url('/vehicles') }}"><button class="btn btn-outline-success me-2" type="button">Show</button></a> 
        </form>
    </div> --}}

    <div class="featured-heading">
        <form class="d-flex" role="search" action="{{ route('vehicles.search') }}" method="GET">
            <select class="form-select me-2" aria-label="Brand" name="brand">
                <option value="" selected> Brand</option>
                @foreach($brands as $brand)
                <option value="{{ $brand }}">{{ $brand }}</option>
                @endforeach
            </select>
            <select class="form-select me-2" aria-label="Model" name="model">
                <option value="" selected>Model</option>
                @foreach($models as $model)
                <option value="{{ $model }}">{{ $model }}</option>
                @endforeach
            </select>
            <select class="form-select me-2" aria-label="Transmission" style="width: 130px;" name="transmission">
                <option value="" selected>Transmission</option>
                @foreach($transmissions as $transmission)
                <option value="{{ $transmission }}">{{ $transmission }}</option>
                @endforeach
            </select>
            <select class="form-select me-2" aria-label="Engine" name="engine">
                <option value="" selected>Engine</option>
                @foreach($engines as $engine)
                <option value="{{ $engine }}">{{ $engine }}</option>
                @endforeach
            </select>
            <select class="form-select me-2" aria-label="Color" name="color">
                <option value="" selected>Color</option>
                @foreach($colors as $color)
                <option value="{{ $color }}">{{ $color }}</option>
                @endforeach
            </select>
            <input class="form-control me-2" type="search" placeholder="Price Min" aria-label="Price Min" name="price_min">
            <input class="form-control me-2" type="search" placeholder="Price Max" aria-label="Price Max" name="price_max">
             <select class="form-select me-2" aria-label="Manufacturing Plant" name="manufacturing_plant">
                <option value="" selected>Plant</option>
                @foreach($manufacturing_plants as $plant)
                <option value="{{ $plant }}">{{ $plant }}</option>
                @endforeach
            </select>
            <button class="btn btn-outline-success me-2" type="submit">Search</button>
            <a href="{{ url('/vehicles') }}"><button class="btn btn-outline-success me-2" type="button">Show</button></a> 
        </form>
    </div>


    <div class="row mt-4">
        @foreach($allVehicles as $key => $vehicle)
        <div class="col-3 mb-4">
            <div class="card h-100 shadow text-center">
                <img src="{{ asset('storage/vehicles_images/' . $vehicle->vehicle->image) }}" class="card-img-top" alt="Vehicle Image">
                <div class="card-body">
                    <h5 class="card-title">{{ $vehicle->vehicle->brand }} {{ $vehicle->vehicle->model }}</h5>
                    @if ($vehicle->new_price)
                    <p class="card-text"><strong>Price:</strong> {{ $vehicle->new_price }}</p>
                    @endif
                    <p class="card-text"><strong>Dealer:</strong> {{ $vehicle->dealer->name }}</p>
                    <p class="card-text"><strong>Contact No.:</strong> {{ $vehicle->dealer->phone_number }}</p>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="#" class="btn btn-success btn-sm">Reserve</a>
                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#vehicleModal{{ $key }}">View Details </a>
                    <a href="#" class="btn btn-danger btn-sm">Buy</a>
                  </div>
            </div>
        </div>

         <!-- Modal -->
         <div class="modal fade" id="vehicleModal{{ $key }}" tabindex="-1" aria-labelledby="vehicleModalLabel{{ $key }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" >
                        <h5 class="modal-title" id="vehicleModalLabel{{ $key }}" >Vehicle Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="text-align: center">
                      <img src="{{ asset('storage/vehicles_images/' .$vehicle->vehicle->image) }}" class="card-img-top" alt="Vehicle Image">

                        <p style="margin-top: 10px;"><strong>Brand:</strong> {{ $vehicle->vehicle->brand }}</p>
                        <p><strong>Model:</strong> {{ $vehicle->vehicle->model }}</p>
                        @if ($vehicle->new_price)
                            <p><strong>Price:</strong> {{ $vehicle->new_price }}</p>
                        @endif
                        <p><strong>Color:</strong> {{ $vehicle->vehicle->color }}</p>
                        <p><strong>Transmission:</strong> {{ $vehicle->vehicle->transmission }}</p>
                        <p><strong>Engine:</strong> {{ $vehicle->vehicle->engine }}</p>


                        <p><strong>Manufacturing Plant:</strong> {{ $vehicle->vehicle->manufacturing_plant }}</p>

                        <p><strong>Dealer:</strong> {{ $vehicle->dealer->name }}</p>
                        <p><strong>Contact No.:</strong> {{ $vehicle->dealer->phone_number }}</p>

                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                      <a href="#" class="btn btn-success btn-sm mx-2">Reserve</a>
                      <a href="#" class="btn btn-danger btn-sm mx-2">Buy</a>
                      <button type="button" class="btn btn-secondary btn-sm mx-2" data-bs-dismiss="modal">Close</button>
                  </div>
                  
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
</div>


<div class="d-flex justify-content-center mt-4">
    <ul class="pagination" style="margin: 0; padding: 0;">
        @if ($allVehicles->lastPage() > 1)
            @if ($allVehicles->currentPage() != 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $allVehicles->url(1) }}">«</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">«</span>
                </li>
            @endif

            @for ($i = 1; $i <= $allVehicles->lastPage(); $i++)
                <li class="page-item{{ ($allVehicles->currentPage() == $i) ? ' active' : '' }}">
                    <a class="page-link" href="{{ $allVehicles->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            @if ($allVehicles->currentPage() != $allVehicles->lastPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $allVehicles->url($allVehicles->currentPage() + 1) }}">»</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">»</span>
                </li>
            @endif
        @endif
    </ul>
</div>



</html>


@endsection

{{-- <!-- Showing X to Y of Z entries -->
<p style="text-align: center; margin-top: 10px;">
    Showing {{ $allVehicles->firstItem() }} to {{ $allVehicles->lastItem() }} of {{ $allVehicles->total() }} entries
</p> --}}





{{-- 

<div class="container">
    <div class="featured-heading">
        <form action="" method="GET" class="d-flex mx-auto" style="max-width: 1100px;">
            <div class="dropdown me-2">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="brandDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Brand
                </button>
                <ul class="dropdown-menu" aria-labelledby="brandDropdown">
                    @foreach($allVehicles->pluck('vehicle.brand')->unique() as $brand)
                        <li><a class="dropdown-item" href="#">{{ $brand }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="dropdown me-2">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="modelDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Model
                </button>
                <ul class="dropdown-menu" aria-labelledby="modelDropdown">
                    @foreach($allVehicles->pluck('vehicle.model')->unique() as $model)
                        <li><a class="dropdown-item" href="#">{{ $model }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="dropdown me-2">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="engineDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Engine
                </button>
                <ul class="dropdown-menu" aria-labelledby="engineDropdown">
                    @foreach($allVehicles->pluck('vehicle.engine')->unique() as $engine)
                        <li><a class="dropdown-item" href="#">{{ $engine }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="dropdown me-2">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="colorDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Color
                </button>
                <ul class="dropdown-menu" aria-labelledby="colorDropdown">
                    @foreach($allVehicles->pluck('vehicle.color')->unique() as $color)
                        <li><a class="dropdown-item" href="#">{{ $color }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="dropdown me-2">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="transmissionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Transmission
                </button>
                <ul class="dropdown-menu" aria-labelledby="transmissionDropdown">
                    @foreach($allVehicles->pluck('vehicle.transmission')->unique() as $transmission)
                        <li><a class="dropdown-item" href="#">{{ $transmission }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="dropdown me-2">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="manufacturingPlantDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Manufacturing Plant
                </button>
                <ul class="dropdown-menu" aria-labelledby="manufacturingPlantDropdown">
                    @foreach($allVehicles->pluck('vehicle.manufacturing_plant')->unique() as $plant)
                        <li><a class="dropdown-item" href="#">{{ $plant }}</a></li>
                    @endforeach
                </ul>
            </div>
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
    

    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif

    <div class="row mt-4">
        @foreach($allVehicles as $vehicle)
        <div class="col-3 mb-4">
            <div class="card h-100 shadow text-center">
                <img src="{{ asset('storage/vehicles_images/' . $vehicle->vehicle->image) }}" class="card-img-top" alt="Vehicle Image">
                <div class="card-body">
                    <h5 class="card-title">{{ $vehicle->vehicle->brand }} {{ $vehicle->vehicle->model }}</h5>
                   
                    @if ($vehicle->new_price)
                    <p class="card-text"><strong>Price:</strong> {{ $vehicle->new_price }}</p>
                    @endif
                </div>
                <div class="card-footer bg-transparent">
                    <a href="#" class="btn btn-primary btn-sm">View Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    

</div> --}}
