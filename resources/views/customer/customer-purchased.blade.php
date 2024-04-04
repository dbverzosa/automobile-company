@extends('customer.layout')


@section('dashboards')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

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

    .featured-heading {
      background-color: #f8f9fa;
      padding: 10px 20px;
      border-radius: 5px;
      box-shadow: 0 20px 10px rgba(0, 0, 0, 0.1);
    }

   
  </style>
</head>
<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
{{-- 

<div class="container">
    <h1 class="featured-heading">Purchased Vehicles</h1>

    <form class="d-flex mt-4 mb-3" role="search" action="" method="GET">
        <input class="form-control me-2" style="width: 2in;" type="search" placeholder="Search Anything" aria-label="Name" name="name">
            
        <button class="btn btn-outline-success me-2" type="submit">Search</button>
        
        <a href=""><button class="btn btn-outline-success me-2" type="button">Show</button></a> 
    </form>
    
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">More Info</th>
                        <th scope="col">No.</th>
                        <th scope="col">VIN</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Model</th>
                        <th scope="col">Price</th>
                        <th scope="col">Dealer Name</th>
                        <th scope="col">Dealer Contact No.</th>
                        <th scope="col">Date Purchased</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date Delivered</th>
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
                            <td>{{ $purchasedVehicle->manufacturerVehicle->vin }}</td>
                            <td>{{ $purchasedVehicle->manufacturerVehicle->brand }}</td>
                            <td>{{ $purchasedVehicle->manufacturerVehicle->model }}</td>
                            <td>{{ number_format($purchasedVehicle->price, 2, '.', '') }}</td>
                            <td>{{ $purchasedVehicle->dealer->name }}</td>
                            <td>{{ $purchasedVehicle->dealer->phone_number }}</td>
                            <td>{{ $purchasedVehicle->date_purchased }}</td>
                            <td>{{ $purchasedVehicle->is_pending ? 'Pending' : 'Confirmed' }}</td>
                            <td>{{ $purchasedVehicle->date_delivered }}</td>
                        </tr>
                        
                        @endif
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
</div>
 --}}


 <div class="container">
    <h1 class="featured-heading">Purchased Vehicles</h1>
    <div class="row justify-content-center mt-3 mb-3">
        <div class="col-md-12">
            <form class="d-flex justify-content-center" role="search" action="{{ route('customer.search') }}" method="GET">
                <input class="form-control me-2" style="width: 2in;" type="search" placeholder="Search Brand/Model" aria-label="Name" name="name">
    
                <div class="d-inline-block me-2">
                    <select class="form-select" name="status-filter">
                        <option value="">Status</option>
                        <option value="1">Pending</option>
                        <option value="0">Confirmed</option>
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
    
                <a href="{{ url('/customer-purchased') }}"><button class="btn btn-outline-success me-2" type="button">Show</button></a>
    
            </form>
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
        
                        <th scope="col">No.</th>
                        <th scope="col">VIN</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Model</th>
                        <th scope="col">Price</th>
                        <th scope="col">Dealer Name</th>
                        <th scope="col">Dealer Contact No.</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date Purchased</th>
                        <th scope="col">Date Delivered</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchasedVehicles as $index => $purchasedVehicle)
                        @if ($purchasedVehicle->manufacturerVehicle)
                        <tr>
                            
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $purchasedVehicle->manufacturerVehicle->vin }}</td>
                            <td>{{ $purchasedVehicle->manufacturerVehicle->brand }}</td>
                            <td>{{ $purchasedVehicle->manufacturerVehicle->model }}</td>
                            <td>{{ number_format($purchasedVehicle->price, 2, '.', '') }}</td>
                            <td>{{ $purchasedVehicle->dealer->name }}</td>
                            <td>{{ $purchasedVehicle->dealer->phone_number }}</td>
                            <td>{{ $purchasedVehicle->is_pending ? 'Pending' : 'Confirmed' }}</td>
                            <td>{{ \Carbon\Carbon::parse($purchasedVehicle->date_purchased)->format('F d, Y') }}</td>
                            <td>{{ $purchasedVehicle->date_delivered ? \Carbon\Carbon::parse($purchasedVehicle->date_delivered)->format('F d, Y') : '' }}</td>

                        </tr>
                        
                        @endif
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    <ul class="pagination">
        @if ($purchasedVehicles->currentPage() > 1)
        <li class="page-item">
            <a class="page-link" href="{{ $purchasedVehicles->previousPageUrl() }}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        @endif
        
        @for ($i = 1; $i <= $purchasedVehicles->lastPage(); $i++)
        <li class="page-item {{ $purchasedVehicles->currentPage() == $i ? 'active' : '' }}">
            <a class="page-link" href="{{ $purchasedVehicles->url($i) }}">{{ $i }}</a>
        </li>
        @endfor
        
        @if ($purchasedVehicles->currentPage() < $purchasedVehicles->lastPage())
        <li class="page-item">
            <a class="page-link" href="{{ $purchasedVehicles->nextPageUrl() }}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        @endif
    </ul>
</div>

<p style="text-align: center; margin-top: 10px;">
    Showing {{ $purchasedVehicles->firstItem() }} to {{ $purchasedVehicles->lastItem() }} of {{ $purchasedVehicles->total() }} entries
</p>

@endsection



