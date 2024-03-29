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
            font-size: 2rem;
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

        
    .custom-button {
        color: black;
        background-color: white;
        border-color: black;
        transition: color 0.3s, background-color 0.3s, border-color 0.3s;
    }

    .custom-button:hover {
        color: white;
        background-color: black;
        border-color: white;
    }
</style>

<div class="container">
    
 <h1 class="featured-heading">Trend Vehicles</h1>
  <div class="d-flex justify-content-between mt-4">

 
     
    <a href="{{ url('/vehicles') }}" class="btn btn-lg btn-outline-primary rounded-pill px-4 position-relative  custom-button">
        Buy Vehicles
        <span class="arrow">&#10148;</span>
    </a>


    <form action="{{ route('featuredCars.search') }}" method="GET" class="d-flex align-items-center" style="width: 5in;">
      <input class="form-control form-control-sm me-2" type="search" name="search_query" placeholder="Search Anything" aria-label="Search">
      <button class="btn btn-outline-success me-2" type="submit">Search</button>
      <a href="{{ url('/featured-cars') }}"><button class="btn btn-outline-success me-2" type="button">All</button></a> 
  </form>
  </div>
</div>

{{-- 
@if(session('error'))
<div class="alert alert-danger" role="alert">
    {{ session('error') }}
</div>
@endif --}}

<div class="container">
    <div class="row mt-4">
        @foreach($featuredCars as $key => $car)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow text-center">
                <img src="{{ asset('storage/vehicles_images/' . $car->vehicle->image) }}" class="card-img-top" alt="Vehicle Image">
                <div class="card-body">
                    <h5 class="card-title">{{ $car->vehicle->brand }} {{ $car->vehicle->model }}</h5>
                    {{-- <p class="card-text"><strong>Details:</strong> {{ $car->vehicle->details }}</p> --}}
                    {{-- <p class="card-text"><strong>Color:</strong> {{ $car->vehicle->color }}</p>
                    <p class="card-text"><strong>Transmission:</strong> {{ $car->vehicle->transmission }}</p>
                    <p class="card-text"><strong>Engine:</strong> {{ $car->vehicle->engine }}</p> --}}
                    {{-- @if ($car->new_price)
                    <p class="card-text"><strong>Price:</strong> {{ $car->new_price }}</p>
                    @endif --}}
                </div>
                {{-- <div class="card-footer bg-transparent">
                    <a href="#" class="btn btn-success btn-sm" 
                    @if(Auth::check() && Auth::user()->role === 'customer')
                        data-bs-toggle="modal" data-bs-target="#reserveConfirmationModal"
                    @else
                        data-bs-toggle="modal" data-bs-target="#loginRequiredModal"
                    @endif
                    >
                        Reserve
                    </a>
                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#carModal{{ $key }}">View Details </a>
                    <a href="#" class="btn btn-danger btn-sm" 
                        @if(Auth::check() && Auth::user()->role === 'customer')
                            data-bs-toggle="modal" data-bs-target="#buyConfirmationModal"
                        @else
                            data-bs-toggle="modal" data-bs-target="#loginRequiredModal"
                        @endif
                    >
                        Buy
                    </a>
                </div> --}}
            </div>
        </div>

        
                <!-- Modal for buying -->
                <div class="modal fade" id="buyConfirmationModal" tabindex="-1" aria-labelledby="buyConfirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="buyConfirmationModalLabel">Confirm Buy</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to buy this item?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <a href="#" class="btn btn-danger">Buy</a>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Modal for reserving-->
                <div class="modal fade" id="reserveConfirmationModal" tabindex="-1" aria-labelledby="reserveConfirmationModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reserveConfirmationModalLabel">Confirm Reserve</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to reserve this item?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <a href="#" class="btn btn-success">Reserve</a>
                            </div>
                        </div>
                    </div>
                </div>
        

        <div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-labelledby="loginRequiredModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginRequiredModalLabel">Login Required</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Please log in first before proceeding.
                    </div>
                    <div class="modal-footer">
                        <button href="{{ url('/vehicles') }}" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    </div>
                </div>
            </div>
          </div>

        
         <!-- Modal -->
        <div class="modal fade" id="carModal{{ $key }}" tabindex="-1" aria-labelledby="carModalLabel{{ $key }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" >
                        <h5 class="modal-title" id="carModalLabel{{ $key }}" >Vehicle Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="text-align: center">
                      <img src="{{ asset('storage/vehicles_images/' .$car->vehicle->image) }}" class="card-img-top" alt="Vehicle Image">

                        <p style="margin-top: 10px;"><strong>Brand:</strong> {{ $car->vehicle->brand }}</p>
                        <p><strong>Model:</strong> {{ $car->vehicle->model }}</p>
                        @if ($car->new_price)
                            <p><strong>Price:</strong> {{ $car->new_price }}</p>
                        @endif
                        <p><strong>Color:</strong> {{ $car->vehicle->color }}</p>
                        <p><strong>Transmission:</strong> {{ $car->vehicle->transmission }}</p>
                        <p><strong>Engine:</strong> {{ $car->vehicle->engine }}</p>


                        <p><strong>Manufacturing Plant:</strong> {{ $car->vehicle->manufacturing_plant }}</p>

                        <p><strong>Dealer:</strong> {{ $car->dealer->name }}</p>
                        <p><strong>Contact No.:</strong> {{ $car->dealer->phone_number }}</p>
                        <p><strong>Address:</strong> {{ $car->dealer->region }}, {{ $car->dealer->city }} City, {{ $car->dealer->address }}</p>


                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                      {{-- <a href="#" class="btn btn-success btn-sm mx-2">Reserve</a>
                      <a href="#" class="btn btn-danger btn-sm mx-2">Buy</a> --}}
                      <button type="button" class="btn btn-secondary btn-sm mx-2" data-bs-dismiss="modal">Close</button>
                  </div>
                  
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
   
<div class="container text-center">
    <a href="{{ url('/vehicles') }}" class="btn btn-lg btn-outline-primary rounded-pill px-4 position-relative  custom-button">
        Explore More Vehicles
        <span class="arrow">&#10148;</span>
    </a>
</div>

<div class="d-flex justify-content-center mt-4">
    <ul class="pagination" style="margin: 0; padding: 0;">
        @if ($featuredCars->lastPage() > 1)
            @if ($featuredCars->currentPage() != 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $featuredCars->url($featuredCars->currentPage() - 1) }}" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
            @endif

            @for ($i = 1; $i <= $featuredCars->lastPage(); $i++)
                <li class="page-item{{ ($featuredCars->currentPage() == $i) ? ' active' : '' }}">
                    <a class="page-link" href="{{ $featuredCars->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            @if ($featuredCars->currentPage() != $featuredCars->lastPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $featuredCars->url($featuredCars->currentPage() + 1) }}">Next</a>
                </li>
            @endif
        @endif
    </ul>
</div>



</html>


@endsection