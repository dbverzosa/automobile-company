{{-- @extends('manufacturer.layout')

@section('manufacturer')
<div class="row justify-content-center">
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Price</th>
                <th>Manufacturing Plant</th>
                <th>Details</th>
                <th>Color</th>
                <th>Engine</th>
                <th>Transmission</th>
                <th>Total Quantity Unsold</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventory as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->brand }}</td>
                    <td>{{ $item->model }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->manufacturing_plant }}</td>
                    <td>{{ $item->details }}</td>
                    <td>{{ $item->color }}</td>
                    <td>{{ $item->engine }}</td>
                    <td>{{ $item->transmission }}</td>
                    <td>{{ $item->total_quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection --}}

@extends('manufacturer.layout')

@section('manufacturer')
<div>
<h1 >My Inventory</h1>

<div class="row justify-content-center">
    <form action="{{ route('manufacturer.inventory.index') }}" method="GET" class="row" id="filter-form">
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
            <div class="input-group mb-4">
                <label for="quantity_filter" class="mr-2">Quantity Filter:</label>
                <select class="form-control" id="quantity_filter" name="quantity_filter">
                    <option value="">All</option>
                    <option value="high_to_low"{{ request('quantity_filter') === 'high_to_low' ? ' selected' : '' }}>High to Low</option>
                    <option value="low_to_high"{{ request('quantity_filter') === 'low_to_high' ? ' selected' : '' }}>Low to High</option>
                </select>
                <button class="btn btn-outline-secondary" type="submit">Apply Filter</button>
                <a href="{{ route('manufacturer.inventory.index') }}" class="btn btn-outline-secondary">Show All</a>

            </div>
        </div>
    </form>
    
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Price</th>
                <th>Manufacturing Plant</th>
                <th>Details</th>
                <th>Color</th>
                <th>Engine</th>
                <th>Transmission</th>
                <th>Total Quantity Unsold</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventory as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->brand }}</td>
                    <td>{{ $item->model }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->manufacturing_plant }}</td>
                    <td>{{ $item->details }}</td>
                    <td>{{ $item->color }}</td>
                    <td>{{ $item->engine }}</td>
                    <td>{{ $item->transmission }}</td>
                    <td>{{ $item->total_quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

<!-- Pagination -->
<div style="text-align: center;">
    <div style="display: inline-block; margin-top: 20px;">
        <ul class="pagination" style="margin: 0; padding: 0;">
            @if ($inventory->lastPage() > 1)
                @if ($inventory->currentPage() != 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $inventory->url(1) }}">«</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">«</span>
                    </li>
                @endif

                @for ($i = 1; $i <= $inventory->lastPage(); $i++)
                    <li class="page-item{{ ($inventory->currentPage() == $i) ? ' active' : '' }}">
                        <a class="page-link" href="{{ $inventory->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                @if ($inventory->currentPage() != $inventory->lastPage())
                    <li class="page-item">
                        <a class="page-link" href="{{ $inventory->url($inventory->currentPage() + 1) }}">»</a>
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
        Showing {{ $inventory->firstItem() }} to {{ $inventory->lastItem() }} of {{ $inventory->total() }} entries
    </p>
</div>
</div>
@endsection







    {{-- <h1 class="text-center">Manufacturer Car Inventory</h1>
    <div class="row justify-content-center mb-3">
        <form action="{{ route('manufacturer.inventory.index') }}" method="GET" class="input-group">
            <input type="text" class="form-control me-2" placeholder="Search by Brand" name="brand" value="{{ request('show_all') ? '' : request('brand') }}">
            <input type="text" class="form-control me-2" placeholder="Search by Model" name="model" value="{{ request('show_all') ? '' : request('model') }}">
            <button type="submit" class="btn btn-primary me-2">Search</button>

            <label class="input-group-text" for="sort">Sort by Quantity:</label>
            <select class="form-select me-2" name="sort" id="sort">
                <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Lowest to Highest</option>
                <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>Highest to Lowest</option>
            </select>
            <button type="submit" class="btn btn-primary me-2">Apply</button>
            <button type="submit" class="btn btn-primary" name="show_all" value="1">Show All</button>
        </form>
    </div> --}}
    {{-- <div class="row justify-content-center">
        <table class="table">
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Quantity Unsold</th>
                    <th>Quantity Sold</th>
                </tr>
            </thead> --}}
            {{-- <tbody>
                @foreach ($inventory as $vehicleInventory)
                    @php
                        $vehicle = $vehicleInventory->vehicle;
                        $totalQuantity = $vehicleInventory->sum('quantity');
                        $quantitySold = $vehicleInventory->sum('quantity_sold');
                        $quantityUnsold = $totalQuantity - $quantitySold;
                    @endphp
                    <tr>
                        <td>{{ $vehicle->brand }}</td>
                        <td>{{ $vehicle->model }}</td>
                        <td>{{ $quantityUnsold }}</td>
                        <td>{{ $quantitySold }}</td>
                    </tr>
                @endforeach
            </tbody> --}}
        {{-- </table>
    </div>
     --}}
    
    
    
{{-- 
    <!-- Pagination -->
    <div style="text-align: center;">
        <div style="display: inline-block; margin-top: 20px;">
            <ul class="pagination" style="margin: 0; padding: 0;">
                @if ($vehicles->lastPage() > 1)
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
                @endif
            </ul>
        </div>

        <p style="text-align: center; margin-top: 10px;">
            Showing {{ $vehicles->firstItem() }} to {{ $vehicles->lastItem() }} of {{ $vehicles->total() }} entries
        </p>
    </div> --}}
{{-- @endsection --}}



{{-- @extends('manufacturer.layout')

@section('manufacturer')
    <h1 class="text-center">Manufacturer Car Inventory</h1>
    <div class="row justify-content-center mb-3">
        <form action="{{ route('manufacturer.inventory.index') }}" method="GET" class="input-group">
            <input type="text" class="form-control me-2" placeholder="Search by Brand" name="brand" value="{{ request('show_all') ? '' : request('brand') }}">
            <input type="text" class="form-control me-2" placeholder="Search by Model" name="model" value="{{ request('show_all') ? '' : request('model') }}">
            <button type="submit" class="btn btn-primary me-2">Search</button>

            <label class="input-group-text" for="sort">Sort by Quantity:</label>
            <select class="form-select me-2" name="sort" id="sort">
                <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Lowest to Highest</option>
                <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>Highest to Lowest</option>
            </select>
            <button type="submit" class="btn btn-primary me-2">Apply</button>
            <button type="submit" class="btn btn-primary" name="show_all" value="1">Show All</button>
        </form>
    </div>

    <div class="row justify-content-center">
        <table class="table">
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Manufacturing Plant</th>
                    <th>Details</th>
                    <th>Color</th>
                    <th>Engine</th>
                    <th>Transmission</th>
                    <th>Quantity Unsold</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->brand }}</td>
                        <td>{{ $vehicle->model }}</td>
                        <td>{{ $vehicle->price }}</td>
                        <td>{{ $vehicle->manufacturing_plant }}</td>
                        <td>{{ $vehicle->details }}</td>
                        <td>{{ $vehicle->color }}</td>
                        <td>{{ $vehicle->engine }}</td>
                        <td>{{ $vehicle->transmission }}</td>
                        <td>{{ $vehicle->quantity }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">No vehicles in inventory.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="text-align: center;">
        <div style="display: inline-block; margin-top: 20px;">
            <ul class="pagination" style="margin: 0; padding: 0;">
                @if ($vehicles->lastPage() > 1)
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
                @endif
            </ul>
        </div>

        <p style="text-align: center; margin-top: 10px;">
            Showing {{ $vehicles->firstItem() }} to {{ $vehicles->lastItem() }} of {{ $vehicles->total() }} entries
        </p>
    </div>
@endsection --}}

{{-- 
@extends('manufacturer.layout')

@section('manufacturer')
    <div class="container">
        <h2>Car Inventory</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Manufacturing Plant</th>
                    <th>Details</th>
                    <th>Color</th>
                    <th>Engine</th>
                    <th>Transmission</th>
                    <th>Quantity Unsold</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->brand }}</td>
                        <td>{{ $vehicle->model }}</td>
                        <td>{{ $vehicle->price }}</td>
                        <td>{{ $vehicle->manufacturing_plant }}</td>
                        <td>{{ $vehicle->details }}</td>
                        <td>{{ $vehicle->color }}</td>
                        <td>{{ $vehicle->engine }}</td>
                        <td>{{ $vehicle->transmission }}</td>
                        <td>{{ $vehicle->quantity }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">No vehicles in inventory.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection --}}
