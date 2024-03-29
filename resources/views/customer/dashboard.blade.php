@extends('customer.layout')


@section('dashboards')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

  <style>

    .card {
      border: none;
      border-radius: 10px;
      margin-bottom: 20px;
      overflow: hidden;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: box-shadow 0.3s;
    }

    .card:hover {
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .card-img-top {
      max-height: 200px;
      object-fit: cover;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    .card-body {
      padding: 1.25rem;
    }

    .card-title {
      font-size: 1.25rem;
      margin-bottom: 0.75rem;
    }

    .card-text {
      color: #6c757d;
      font-size: 0.875rem;
    }

    .card-text strong {
      color: #000;
    }

    .featured-heading {
      text-align: center;
      color: #333;
      font-size: 2rem;
      font-weight: bold;
      margin-top: 2.5rem;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .featured-heading {
      background-color: #f8f9fa;
      padding: 10px 20px;
      border-radius: 5px;
      box-shadow: 0 20px 10px rgba(0, 0, 0, 0.1);
    }

    .featured-headings {
    display: inline-block;
    font-size: 3rem;
    font-weight: bold;
    color: #333;
    text-align: start;
    text-transform: uppercase;
    letter-spacing: 1px;
    background-color: aqua;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); 
    padding: 5px 10px; 
    margin: 0; 
    }

    .arrow {
    position: absolute;
    right: 2px;
    top: 50%;
    transform: translateY(-50%);
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
</head>
<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>


<div class="container">
    {{-- <h1 class="featured-headings">Featured Vehicles</h1> --}}
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

  <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="1300" style="max-width: 800px; margin: 0 auto;">  <div class="carousel-indicators">
        @foreach($featuredVehicles as $key => $vehicle)
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $key }}"></button>
        @endforeach
    </div>
    <div class="carousel-inner">
        @foreach($featuredVehicles as $key => $vehicle)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
              <h5 class="text-center featured-heading">{{ $vehicle->vehicle->brand }} {{ $vehicle->vehicle->model }}</h5>

                <img src="{{ asset('storage/vehicles_images/' .$vehicle->vehicle->image) }}" class="d-block w-100" alt="Vehicle Image" style="object-fit: cover; height: 500px;">
                <div class="carousel-caption d-none d-md-block">
                 
                </div>
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>

<div class="container">
  <div class="row mt-4">
      <div class="col-md-6">
          <a href="{{ url('/vehicles') }}" class="btn btn-lg btn-outline-primary rounded-pill px-4 position-relative d-block text-center custom-button">
              Explore More Vehicles
              <span class="arrow">&#10148;</span>
          </a>
      </div>
      <div class="col-md-6">
          <a href="{{ url('/vehicles') }}" class="btn btn-lg btn-outline-primary rounded-pill px-4 position-relative d-block text-center custom-button">
              Buy Vehicles
              <span class="arrow">&#10148;</span>
          </a>
      </div>
  </div>
</div>

  <div class="row mt-4">
    <h1 class="featured-heading mb-5">SHOWED Vehicles</h1>
    @foreach($allVehicles as $key => $vehicle)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow text-center">
                <img src="{{ asset('storage/vehicles_images/' .$vehicle->vehicle->image) }}" class="card-img-top" alt="Vehicle Image">
                <div class="card-body">
                    <h5 class="card-title">{{ $vehicle->vehicle->brand }}</h5>
                    {{-- @if ($vehicle->new_price)
                        <p class="card-text"><strong>Price:</strong> {{ $vehicle->new_price }}</p>
                    @endif
                    <p class="card-text"><strong>Dealer:</strong> {{ $vehicle->dealer->name }}</p>
                    <p class="card-text"><strong>Contact No.:</strong> {{ $vehicle->dealer->phone_number }}</p>
                    <p class="card-text"><strong>Address:</strong> {{ $vehicle->dealer->region }}, {{ $vehicle->dealer->city }} City, {{ $vehicle->dealer->address }}</p>
               --}}
                  </div>
                {{-- <div class="card-footer bg-transparent"> --}}

                    {{-- <a href="#" class="btn btn-success btn-sm"
                    @if(Auth::check() && Auth::user()->role === 'customer')
                        data-bs-toggle="modal" data-bs-target="#reserveConfirmationModal{{ $key }}"
                    @else
                        data-bs-toggle="modal" data-bs-target="#loginRequiredModal"
                    @endif
                >
                    Reserve
                </a>
                
                  <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#vehicleModal{{ $key }}">View Details </a>
                  <a href="#" class="btn btn-danger btn-sm" 
                        @if(Auth::check() && Auth::user()->role === 'customer')
                            data-bs-toggle="modal" data-bs-target="#buyConfirmationModal"
                        @else
                            data-bs-toggle="modal" data-bs-target="#loginRequiredModal"
                        @endif
                    >
                        Buy
                    </a> --}}
                {{-- </div> --}}
            </div>
        </div>

   
    <!-- Modal for Reservation Confirmation -->
<!-- Modal for Reservation Confirmation -->
{{-- <div class="modal fade" id="reserveConfirmationModal{{ $key }}" tabindex="-1" aria-labelledby="reserveConfirmationModalLabel{{ $key }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="reserveConfirmationModalLabel{{ $key }}">Confirm Reservation</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <h6>Vehicle Details:</h6>
              <p><strong>Brand:</strong> {{ $vehicle->vehicle->brand }}</p>
              <p><strong>Model:</strong> {{ $vehicle->vehicle->model }}</p>
              <hr>
              <form method="POST" action="{{ route('vehicles.buy') }}">
                  @csrf
                  <input type="hidden" name="manufacturer_vehicle_id" value="{{ $vehicle->vehicle->id }}">
                  <div class="mb-3">
                      <label for="gender{{ $key }}" class="form-label">Gender</label>
                      <select class="form-select" id="gender{{ $key }}" name="gender">
                          <option selected>Select gender</option>
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                          <option value="other">Other</option>
                      </select>
                  </div>
                  <div class="mb-3">
                      <label for="income{{ $key }}" class="form-label">Income</label>
                      <input type="text" class="form-control" id="income{{ $key }}" name="income">
                  </div>
                  <div class="mb-3">
                      <label for="details{{ $key }}" class="form-label">Details</label>
                      <textarea class="form-control" id="details{{ $key }}" rows="3" name="details"></textarea>
                  </div>
                  <div class="mb-3">
                      <label for="address{{ $key }}" class="form-label">Address</label>
                      <input type="text" class="form-control" id="address{{ $key }}" name="delivery_address">
                  </div>
                  <button type="submit" class="btn btn-primary">Confirm Reservation</button>
              </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div> --}}


    
         {{-- <!-- Modal for buying -->
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
     --}}

    

                <!-- Login Required Modal -->
        {{-- <div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-labelledby="loginRequiredModalLabel" aria-hidden="true">
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
        </div> --}}
        
        <!-- View Details Modal -->
        {{-- <div class="modal fade" id="vehicleModal{{ $key }}" tabindex="-1" aria-labelledby="vehicleModalLabel{{ $key }}" aria-hidden="true">
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
                        <p><strong>Address:</strong> {{ $vehicle->dealer->region }}, {{ $vehicle->dealer->city }} City, {{ $vehicle->dealer->address }}</p>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">

                        
                  <a href="#" class="btn btn-success btn-sm mx-2">Reserve</a>
                      <a href="#" class="btn btn-danger btn-sm mx-2">Buy</a>
                      <button type="button" class="btn btn-secondary btn-sm mx-2" data-bs-dismiss="modal">Close</button>
                  </div>
                  
                </div>
            </div>
        </div> --}}
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
<!-- Showing X to Y of Z entries -->
{{-- <p style="text-align: center; margin-top: 10px;">
    Showing {{ $allVehicles->firstItem() }} to {{ $allVehicles->lastItem() }} of {{ $allVehicles->total() }} entries
</p> --}}
</div>







@endsection




{{-- <a href="#" class="btn btn-success btn-sm" 
                  @if(Auth::check() && Auth::user()->role === 'customer')
                      data-bs-toggle="modal" data-bs-target="#reserveConfirmationModal"
                  @else
                      data-bs-toggle="modal" data-bs-target="#loginRequiredModal"
                  @endif
                   >
                  Reserve
                   </a> --}}



       <!-- Modal for reserving-->
      {{-- <div class="modal fade" id="reserveConfirmationModal" tabindex="-1" aria-labelledby="reserveConfirmationModalLabel" aria-hidden="true">
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
      </div> --}}


       {{-- <div class="row mt-4">
      @foreach($allVehicles as $vehicle)
          <div class="col-md-4 mb-4">
              <div class="card h-100 shadow text-center">
                  <img src="{{ asset('storage/vehicles_images/' .$vehicle->vehicle->image) }}" class="card-img-top" alt="Vehicle Image">
                  <div class="card-body">
                      <h5 class="card-title">{{ $vehicle->vehicle->brand }} {{ $vehicle->vehicle->model }}</h5>
                     
                      @if ($vehicle->new_price)
                          <p class="card-text"><strong>Price:</strong> {{ $vehicle->new_price }}</p>
                      @endif
                      <p class="card-text"><strong>Dealer:</strong> {{ $vehicle->dealer->name }}</p>
                      <p class="card-text"><strong>Contact No.:</strong> {{ $vehicle->dealer->phone_number }}</p>
                  </div>
                  <div class="card-footer bg-transparent">
                    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#vehicleModal">View Details</a>
                    <!-- Modal -->
                    <div class="modal fade" id="vehicleModal" tabindex="-1" aria-labelledby="vehicleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="vehicleModalLabel">Vehicle Details</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                {{ $vehicle->vehicle->brand }} {{ $vehicle->vehicle->model }}
                                @if ($vehicle->new_price)
                                <p class="card-text"><strong>Price:</strong> {{ $vehicle->new_price }}</p>
                            @endif
                            <p class=""><strong>Dealer:</strong> {{ $vehicle->dealer->name }}</p>
                                          <p class=""><strong>Contact No.:</strong> {{ $vehicle->dealer->phone_number }}</p>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              </div>
                          </div>
                      </div>
                    </div>

                  </div>
              </div>
          </div>
      @endforeach
  </div> --}}
 