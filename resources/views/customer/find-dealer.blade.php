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
</style>

<div class="container">
    
 <h1 class="featured-heading">Find Dealers</h1>
 <div class="featured-heading">
    <form class="d-flex" role="search" action="{{ route('customer.find-dealer') }}" method="GET">
        <input class="form-control me-2" type="search" placeholder="Name" aria-label="Name" name="name">
              
        <input class="form-control me-2" type="search" placeholder="Region" aria-label="Region" name="region">
        
        <input class="form-control me-2" type="search" placeholder="City" aria-label="City" name="city">
        
        <input class="form-control me-2" type="search" placeholder="Address" aria-label="Address" name="manufacturing_plant">
        
        <button class="btn btn-outline-success me-2" type="submit">Search</button>
        
        <a href="{{ url('/find-dealer') }}"><button class="btn btn-outline-success me-2" type="button">Show All</button></a> 
    </form>
    
    </div> 
 
 <div class="row">
    @foreach($dealers as $dealer)
    <div class="col-md-4">
        <div class="card mt-3">
            <strong><p class="text-start ms-3 mt-3">Dealer Name: {{ $dealer->name }}</p></strong>
            <strong><p class="text-start ms-3">Contact No.: {{ $dealer->phone_number }}</p></strong>
            <strong><p class="text-start ms-3">Address: {{ $dealer->region }}, {{ $dealer->city }} City, {{ $dealer->address }}</p></strong>
            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#loginModal">View Sell Vehicles</a>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Please log in to view sell vehicles.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            </div>
        </div>
    </div>
</div>



 
</div>

<div class="d-flex justify-content-center mt-4">
    <ul class="pagination" style="margin: 0; padding: 0;">
        @if ($dealers->lastPage() > 1)
            @if ($dealers->currentPage() != 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $dealers->url(1) }}">«</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">«</span>
                </li>
            @endif

            @for ($i = 1; $i <= $dealers->lastPage(); $i++)
                <li class="page-item{{ ($dealers->currentPage() == $i) ? ' active' : '' }}">
                    <a class="page-link" href="{{ $dealers->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            @if ($dealers->currentPage() != $dealers->lastPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $dealers->url($dealers->currentPage() + 1) }}">»</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">»</span>
                </li>
            @endif
        @endif
    </ul>
</div>
{{-- 
<p style="text-align: center; margin-top: 10px;">
    Showing {{ $dealers->firstItem() }} to {{ $dealers->lastItem() }} of {{ $dealers->total() }} entries
</p> --}}


</html>


@endsection


{{--<div class="card-body text-center">
                   <img src="{{ asset('storage/vehicles_images/' .$vehicle->vehicle->image) }}" class="card-img-top" alt="Vehicle Image">

                    <h5 class="card-title">{{ $vehicle->vehicle->brand }} {{ $vehicle->vehicle->model }}</h5>
                    <p class="card-text">Transmission: {{ $vehicle->vehicle->transmission }}</p>
                    <p class="card-text">Engine: {{ $vehicle->vehicle->engine }}</p>
                    <p class="card-text">Color: {{ $vehicle->vehicle->color }}</p>
                    <p class="card-text">Price: {{ $vehicle->vehicle->price }}</p>
                    <p class="card-text">Manufacturing Plant: {{ $vehicle->vehicle->manufacturing_plant }}</p>
                </div> --}}