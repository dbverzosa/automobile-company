@extends('manufacturer.layout')

@section('manufacturer')


<div class="container">
    <h1 >My Sales</h1>
    <h4 class="text-center">Sold Vehicles</h4>
    <div class="row justify-content-center">
        <form action="{{ route('manufacturer.sales.index') }}" method="GET" class="row" id="filter-form">
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
                        <a href="{{ route('manufacturer.sales.index') }}" class="btn btn-outline-secondary">Show All</a>

                    </div>
                </div>
            </div>
        </form>
        <div class="col-md-12">
            <form action="{{ route('manufacturer.sales.index') }}" method="GET" class="row">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <select class="form-select" name="sort">
                            <option value="oldest_to_latest"{{ request('sort') == 'oldest_to_latest' ? ' selected' : '' }}>Oldest to Latest</option>
                            <option value="latest_to_oldest"{{ request('sort') == 'latest_to_oldest' ? ' selected' : '' }}>Latest to Oldest</option>
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Filter</button>
                            <a href="{{ route('manufacturer.sales.search') }}" class="btn btn-outline-secondary">Go to Track Sales</a>

                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        
        
    
    <table class="table">
        <thead>
            <tr>
                <th>Date Purchased</th>
                <th>VIN</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Manufacturing Plant</th>
                <th>Details</th>
                <th>Color</th>
                <th>Engine</th>
                <th>Transmission</th>
                {{-- <th>Quantity Sold</th> --}}
                <th>Price</th>
                {{-- <th>Total Price</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($sale->date_purchased)->format('F d, Y') }}</td>
                    <td>{{ $sale->vehicle->vin }}</td>
                    <td>{{ $sale->vehicle->brand }}</td>
                    <td>{{ $sale->vehicle->model }}</td>
                    <td>{{ $sale->vehicle->manufacturing_plant }}</td>
                    <td>{{ $sale->vehicle->details }}</td>
                    <td>{{ $sale->vehicle->color }}</td>
                    <td>{{ $sale->vehicle->engine }}</td>
                    <td>{{ $sale->vehicle->transmission }}</td>
                    {{-- <td>{{ $sale->quantity_sold }}</td> --}}
                    <td>{{ $sale->sale_price }}</td>
                    {{-- <td>{{ $sale->total_price }}</td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

<div style="text-align: center;">
    <div style="display: inline-block; margin-top: 20px;">
        <ul class="pagination" style="margin: 0; padding: 0;">
            @if ($sales->lastPage() > 1)
                @if ($sales->currentPage() != 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $sales->url(1) }}">«</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">«</span>
                    </li>
                @endif

                @for ($i = 1; $i <= $sales->lastPage(); $i++)
                    <li class="page-item{{ ($sales->currentPage() == $i) ? ' active' : '' }}">
                        <a class="page-link" href="{{ $sales->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                @if ($sales->currentPage() != $sales->lastPage())
                    <li class="page-item">
                        <a class="page-link" href="{{ $sales->url($sales->currentPage() + 1) }}">»</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">»</span>
                    </li>
                @endif
            @endif
        </ul>
    </div>

    <p style="text-align: center; margin-top: 10px;">
        Showing {{ $sales->firstItem() }} to {{ $sales->lastItem() }} of {{ $sales->total() }} entries
    </p>
</div>



@endsection
