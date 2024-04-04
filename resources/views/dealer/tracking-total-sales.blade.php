@extends('dealer.layout')

@section('dealer')


<a href="{{ url('/dealer/dashboard/car-sales/track-car-sales') }}"><button class="btn btn-outline-success me-2" type="button">BACK TO SALES VEHICLES</button></a>

<h1 class="featured-heading"> TRAcking Sales Vehicles</h1>
<div class="container mt-4">

    <div class="col-md-12">
        <form action="{{ route('dealer.track-car-sales.total-search') }}" method="GET" class="row" id="filter-form">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search brand" name="brand_search" value="{{ request('brand_search') }}">
                    <input type="text" class="form-control" placeholder="Search model" name="model_search" value="{{ request('model_search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
             
                        <div class="input-group mb-3">
                            <select class="form-select" name="month">
                                <option value="">Select month</option>
                                <option value="01"{{ request('month') == '01' ? ' selected' : '' }}>January</option>
                                <option value="02"{{ request('month') == '02' ? ' selected' : '' }}>February</option>
                                <option value="03"{{ request('month') == '03' ? ' selected' : '' }}>March</option>
                                <option value="04"{{ request('month') == '04' ? ' selected' : '' }}>April</option>
                                <option value="05"{{ request('month') == '05' ? ' selected' : '' }}>May</option>
                                <option value="06"{{ request('month') == '06' ? ' selected' : '' }}>June</option>
                                <option value="07"{{ request('month') == '07' ? ' selected' : '' }}>July</option>
                                <option value="08"{{ request('month') == '08' ? ' selected' : '' }}>August</option>
                                <option value="09"{{ request('month') == '09' ? ' selected' : '' }}>September</option>
                                <option value="10"{{ request('month') == '10' ? ' selected' : '' }}>October</option>
                                <option value="11"{{ request('month') == '11' ? ' selected' : '' }}>November</option>
                                <option value="12"{{ request('month') == '12' ? ' selected' : '' }}>December</option>
                            </select>
                            <input type="text" class="form-control" placeholder="Enter year" name="year" value="{{ request('year') }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">Search</button>
        
                            </div>
                        </div>
                    
            </div>
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search anything here" name="search_anything" value="{{ request('search_anything') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                        <a href="{{ route('dealer.track-car-sales.total') }}" class="btn btn-outline-secondary">Show All</a>
                    </div>
                </div>
            </div>
        </form>
      
    </div>

    @if($confirmedSales->isEmpty())
        <p>No confirmed sales found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Brand</th>
                    <th>Model Name</th>
                    <th>Price</th>
                    <th>Quantity Sold</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1 @endphp
                @foreach($confirmedSales as $sale)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $sale->manufacturerVehicle->brand }}</td>
                    <td>{{ $sale->manufacturerVehicle->model }}</td>
                    <td>{{ $sale->price }}</td>
                    <td>{{ $totals[$sale->manufacturerVehicle->brand . $sale->manufacturerVehicle->model]['totalQuantitySold'] ?? 1 }}</td>
                    <td>{{ $sale->price * ($totals[$sale->manufacturerVehicle->brand . $sale->manufacturerVehicle->model]['totalQuantitySold'] ?? 1) }}</td>
                </tr>
            @endforeach
            
            
            </tbody>
        </table>
       
    
    @endif
</div>

@endsection