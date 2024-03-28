{{-- dashboard.blade.php --}}


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

        /* Additional styles for a more attractive design */
        .featured-heading {
            background-color: #f8f9fa;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 20px 10px rgba(0, 0, 0, 0.1);
        }
        .featured-headings {
            display: inline-block; /* Display as inline-block */
            font-size: 3rem;
            font-weight: bold;
            color: #333;
            text-align: start;
            text-transform: uppercase;
            letter-spacing: 1px;
            background-color: aqua;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); /* Add box shadow */
            padding: 5px 10px; /* Add padding */
            margin: 0; /* Remove default margin */
        }

        .arrow {
          position: absolute;
          right: 2px;
          top: 50%;
          transform: translateY(-50%);
       }

        
  </style>
</head>
<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>



<div class="container">
    {{-- <h1 class="featured-headings">Featured Vehicles</h1> --}}

  <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000" style="max-width: 800px; margin: 0 auto;">  <div class="carousel-indicators">
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


{{-- 
 <div class="container">
  <div class="row justify-content-center">
      
          <form action="" method="GET" class="d-flex mx-auto" style="max-width: 1100px;">
              <select class="form-select me-2 dropdown-hoverable" name="brand">
                  <option value="">Brand</option>
                  @foreach($allVehicles->pluck('vehicle.brand')->unique() as $brand)
                      <option value="{{ $brand }}">{{ $brand }}</option>
                  @endforeach
              </select>
              <select class="form-select me-2 dropdown-hoverable" name="model">
                  <option value="">Model</option>
                  @foreach($allVehicles->pluck('vehicle.model')->unique() as $model)
                      <option value="{{ $model }}">{{ $model }}</option>
                  @endforeach
              </select>
              <select class="form-select me-2 dropdown-hoverable" name="engine">
                  <option value="">Engine</option>
                  @foreach($allVehicles->pluck('vehicle.engine')->unique() as $engine)
                      <option value="{{ $engine }}">{{ $engine }}</option>
                  @endforeach
              </select>
              <select class="form-select me-2 dropdown-hoverable" name="color">
                  <option value="">Color</option>
                  @foreach($allVehicles->pluck('vehicle.color')->unique() as $color)
                      <option value="{{ $color }}">{{ $color }}</option>
                  @endforeach
              </select>
              <select class="form-select me-2 dropdown-hoverable" name="transmission">
                  <option value="">Transmission</option>
                  @foreach($allVehicles->pluck('vehicle.transmission')->unique() as $transmission)
                      <option value="{{ $transmission }}">{{ $transmission }}</option>
                  @endforeach
              </select>
              <select class="form-select me-2 dropdown-hoverable" name="manufacturing_plant">
                  <option value="">Plant</option>
                  @foreach($allVehicles->pluck('vehicle.manufacturing_plant')->unique() as $plant)
                      <option value="{{ $plant }}">{{ $plant }}</option>
                  @endforeach
              </select>
              <button class="btn btn-outline-success" type="submit">Search</button>
              <a href="{{ url('/') }}" class="btn btn-outline-success">Show All</a>

          </form>
      </div>
  </div>
</div>  --}}

{{-- <div class="container">
  <div class="row justify-content-center">
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
</div> --}}



 <div class="container">
  <div class="d-flex justify-content-center mt-4">
    <a href="{{ url('/vehicles') }}" class="btn btn-lg btn-outline-primary rounded-pill px-4 position-relative">
        Explore More Vehicles
        <span class="arrow">&#10148;</span>
    </a>
</div>
    <div class="row mt-4">
      @foreach($allVehicles as $vehicle)
          <div class="col-md-4 mb-4">
              <div class="card h-100 shadow text-center">
                  <img src="{{ asset('storage/vehicles_images/' .$vehicle->vehicle->image) }}" class="card-img-top" alt="Vehicle Image">
                  <div class="card-body">
                      <h5 class="card-title">{{ $vehicle->vehicle->brand }} {{ $vehicle->vehicle->model }}</h5>
                      {{-- <p class="card-text"><strong>VIN:</strong> {{ $vehicle->vehicle->vin }}</p> --}}
                      {{-- <p class="card-text"><strong>Color:</strong> {{ $vehicle->vehicle->color }}</p>
                      <p class="card-text"><strong>Transmission:</strong> {{ $vehicle->vehicle->transmission }}</p>
                      <p class="card-text"><strong>Engine:</strong> {{ $vehicle->vehicle->engine }}</p> --}}
                      @if ($vehicle->new_price)
                          <p class="card-text"><strong>Price:</strong> {{ $vehicle->new_price }}</p>
                      @endif
                      <p class="card-text"><strong>Manufacturing Plant:</strong> {{ $vehicle->vehicle->manufacturing_plant }}</p>
                      <p class="card-text"><strong>Dealer:</strong> {{ $vehicle->dealer->name }}</p>
                      <p class="card-text"><strong>Contact No.:</strong> {{ $vehicle->dealer->phone_number }}</p>
                  </div>
                  <div class="card-footer bg-transparent">
                      <a href="#" class="btn btn-primary btn-sm">View Details</a>
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
<!-- Showing X to Y of Z entries -->
<p style="text-align: center; margin-top: 10px;">
    Showing {{ $allVehicles->firstItem() }} to {{ $allVehicles->lastItem() }} of {{ $allVehicles->total() }} entries
</p>
</div>

</html>




@endsection