@extends('manufacturer.layout')

@section('manufacturer')


<div class="container">
    <h1 >My Sales</h1>
    <h4 class="text-center">Sold Vehicles</h4>
    <div class="row justify-content-center">
        <form action="{{ route('manufacturer.sales.search') }}" method="GET" class="row" id="filter-form">
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
                        <a href="{{ route('manufacturer.sales.search') }}" class="btn btn-outline-secondary">Show All</a>

                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search anything here" name="search_anything" value="{{ request('search_anything') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="col-md-12">
            <form action="{{ route('manufacturer.sales.search') }}" method="GET" class="row">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <select class="form-select" name="sort">
                            <option value="high_to_low"{{ request('sort') == 'high_to_low' ? ' selected' : '' }}>High to Low</option>
                            <option value="low_to_high"{{ request('sort') == 'low_to_high' ? ' selected' : '' }}>Low to High</option>
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Sort Sales</button>
                            <a href="{{ route('manufacturer.sales.index') }}" class="btn btn-outline-secondary">Back to Default</a>

                        </div>
                    </div>
                </div>
            </form>

        </div>
        
        
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Quantity Sold</th>
                    <th>Total Sales</th>
                </tr>
            </thead>
            <tbody>
                @php $index = 1; @endphp
                @foreach ($sales as $sale)
                @if ($loop->first || ($sale->vehicle->brand !== $prevBrand || $sale->vehicle->model !== $prevModel))
                @php
                $totalQuantitySold = $totals[$sale->vehicle->brand . $sale->vehicle->model] ?? 0;
                $totalSales = $sale->sale_price * $totalQuantitySold;
                @endphp
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $sale->vehicle->brand }}</td>
                    <td>{{ $sale->vehicle->model }}</td>
                    <td>{{ $sale->sale_price }}</td>
                    <td>{{ $totalQuantitySold }}</td>
                    <td>{{ $totalSales }}</td>
                </tr>
                @endif
                @php
                $prevBrand = $sale->vehicle->brand;
                $prevModel = $sale->vehicle->model;
                @endphp
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
                        <a class="page-link" href="{{ $sales->appends(request()->except('page'))->previousPageUrl() }}">«</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">«</span>
                    </li>
                @endif

                @for ($i = 1; $i <= $sales->lastPage(); $i++)
                    <li class="page-item{{ ($sales->currentPage() == $i) ? ' active' : '' }}">
                        <a class="page-link" href="{{ $sales->appends(request()->except('page'))->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                @if ($sales->currentPage() != $sales->lastPage())
                    <li class="page-item">
                        <a class="page-link" href="{{ $sales->appends(request()->except('page'))->nextPageUrl() }}">»</a>
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
