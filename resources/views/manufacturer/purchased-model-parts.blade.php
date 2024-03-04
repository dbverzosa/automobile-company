@extends('manufacturer.layout')

@section('manufacturer')
<div>
    <h1>Purchased Model Parts</h1>
    
  
    <form class="d-flex" action="{{ route('manufacturer.modelparts.search') }}" method="GET">
        <input class="form-control me-2" type="text" name="supplier_name" placeholder="Supplier Name">
        <input class="form-control me-2" type="text" name="model_name" placeholder="Model Name">
        <input class="form-control me-2" type="date" name="date_purchased" placeholder="Date Purchased">
        <select class="form-select me-2" name="amount_filter">
            <option value="">Price Filter</option>
            <option value="big_to_small">Big to Small</option>
            <option value="small_to_big">Small to Big</option>
        </select>
        <select class="form-select me-2" name="date_filter">
            <option value="">Date Filter</option>
            <option value="latest_to_oldest">Latest to Oldest</option>
            <option value="oldest_to_latest">Oldest to Latest</option>
        </select>
        <button class="btn btn-primary me-2" type="submit">Search</button>
        <a href="{{ route('manufacturer.purchasedModelParts') }}" class="btn btn-primary">Show All</a>
    </form>
    @if ($purchasedModelParts->isEmpty())
    <p>No purchased model parts found.</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>Model Image</th>
                <th>Model Name</th>
                <th>Supplier</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>Date Purchased</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchasedModelParts as $purchasePart)
            <tr>
                <td><img src="{{ asset('storage/' . $purchasePart->modelPart->image) }}" alt="{{ $purchasePart->modelPart->model_name }}" style="max-width: 100px;"></td>
                <td>{{ $purchasePart->modelPart->model_name }}</td>
                <td>{{ $purchasePart->supplier->name }}</td>
                <td>{{ $purchasePart->quantity }}</td>
                <td>{{ $purchasePart->price }}</td>
                <td>{{ $purchasePart->total_price }}</td>
                <td>{{ $purchasePart->date_purchased }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="text-align: center;">
        <div style="display: inline-block; margin-top: 20px;">
            <ul class="pagination" style="margin: 0; padding: 0;">
                <!-- Custom pagination rendering -->
                @if ($purchasedModelParts->lastPage() > 1)
                    @if ($purchasedModelParts->currentPage() != 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $purchasedModelParts->url(1) }}">«</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">«</span>
                        </li>
                    @endif
        
                    @for ($i = 1; $i <= $purchasedModelParts->lastPage(); $i++)
                        <li class="page-item{{ ($purchasedModelParts->currentPage() == $i) ? ' active' : '' }}">
                            <a class="page-link" href="{{ $purchasedModelParts->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
        
                    @if ($purchasedModelParts->currentPage() != $purchasedModelParts->lastPage())
                        <li class="page-item">
                            <a class="page-link" href="{{ $purchasedModelParts->url($purchasedModelParts->currentPage() + 1) }}">»</a>
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
            Showing {{ $purchasedModelParts->firstItem() }} to {{ $purchasedModelParts->lastItem() }} of {{ $purchasedModelParts->total() }} entries
        </p>
    </div>
    @endif
</div>
@endsection



{{-- super good na ni @extends('manufacturer.layout')

@section('manufacturer')
<div>
    <h1>Purchased Model Parts</h1>
    
  
    <form class="d-flex" action="{{ route('manufacturer.modelparts.search') }}" method="GET">
        <input class="form-control me-2" type="text" name="supplier_name" placeholder="Supplier Name">
        <input class="form-control me-2" type="text" name="model_name" placeholder="Model Name">
        <input class="form-control me-2" type="date" name="date_purchased" placeholder="Date Purchased">
    
        <select class="form-select me-2" name="amount_filter">
            <option value="">Price Filter</option>
            <option value="big_to_small">Big to Small</option>
            <option value="small_to_big">Small to Big</option>
        </select>
    
        <select class="form-select me-2" name="date_filter">
            <option value="">Date Filter</option>
            <option value="latest_to_oldest">Latest to Oldest</option>
            <option value="oldest_to_latest">Oldest to Latest</option>
        </select>
    
        <button class="btn btn-primary" type="submit">Search</button>
        <a href="{{ route('manufacturer.purchasedModelParts') }}" class="btn btn-primary">Show All</a>
    </form>
    @if ($purchasedModelParts->isEmpty())
    <p>No purchased model parts found.</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>Model Image</th>
                <th>Model Name</th>
                <th>Supplier</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>Date Purchased</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchasedModelParts as $purchasePart)
            <tr>
                <td><img src="{{ asset('storage/' . $purchasePart->modelPart->image) }}" alt="{{ $purchasePart->modelPart->model_name }}" style="max-width: 100px;"></td>
                <td>{{ $purchasePart->modelPart->model_name }}</td>
                <td>{{ $purchasePart->supplier->name }}</td>
                <td>{{ $purchasePart->quantity }}</td>
                <td>{{ $purchasePart->price }}</td>
                <td>{{ $purchasePart->total_price }}</td>
                <td>{{ $purchasePart->date_purchased }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    @endif
</div>
@endsection
 --}}



{{-- 

goods na ni
@extends('manufacturer.layout')

@section('manufacturer')
<div>
    <h1>Purchased Model Parts</h1>

    <form method="GET" action="">
        <div class="form-group">
            <label for="supplier">Supplier:</label>
            <input type="text" name="supplier" id="supplier" class="form-control" value="{{ request('supplier') }}">
        </div>
        <div class="form-group">
            <label for="model_name">Model Name:</label>
            <input type="text" name="model_name" id="model_name" class="form-control" value="{{ request('model_name') }}">
        </div>
        <div class="form-group">
            <label for="date_purchased">Date Purchased:</label>
            <input type="date" name="date_purchased" id="date_purchased" class="form-control" value="{{ request('date_purchased') }}">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    @if ($purchasedModelParts->isEmpty())
    <p>No purchased model parts found.</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>Model Image</th>
                <th>Model Name</th>
                <th>Supplier</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>Date Purchased</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchasedModelParts as $purchasePart)
            <tr>
                <td><img src="{{ asset('storage/' . $purchasePart->modelPart->image) }}" alt="{{ $purchasePart->modelPart->model_name }}" style="max-width: 100px;"></td>
                <td>{{ $purchasePart->modelPart->model_name }}</td>
                <td>{{ $purchasePart->supplier->name }}</td>
                <td>{{ $purchasePart->quantity }}</td>
                <td>{{ $purchasePart->price }}</td>
                <td>{{ $purchasePart->total_price }}</td>
                <td>{{ $purchasePart->date_purchased }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
 --}}


{{-- @extends('manufacturer.layout')

@section('manufacturer')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchased Model Parts</title>
    
</head>
<body>
    <div>
        <h1>Purchased Model Parts</h1>
        @if ($purchasedModelParts->isEmpty())
        <p>No purchased model parts found.</p>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>Model Image</th>
                    <th>Model Name</th>
                    <th>Supplier</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>Date Purchased</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchasedModelParts as $purchasePart)
                <tr>
                    <td><img src="{{ asset('storage/' . $purchasePart->modelPart->image) }}" alt="{{ $purchasePart->modelPart->model_name }}" style="max-width: 100px;"></td>
                    <td>{{ $purchasePart->modelPart->model_name }}</td>
                    <td>{{ $purchasePart->supplier->name }}</td>
                    <td>{{ $purchasePart->quantity }}</td>
                    <td>{{ $purchasePart->price }}</td>
                    <td>{{ $purchasePart->total_price }}</td>
                    <td>{{ $purchasePart->date_purchased }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
 
</body>
</html>
@endsection --}}