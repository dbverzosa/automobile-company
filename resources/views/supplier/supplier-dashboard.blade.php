@extends('supplier.layout')

@section('modelparts')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model Parts</title>
    <style>
        .card {
            width: 25%;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
            display: inline-block;
        }
        .card img {
            max-width: 100px;
        }
        @media (max-width: 768px) {
            .card {
                width: 45%;
            }
        }
    </style>
</head>
<body>
    <div>
        <div class="d-flex justify-content-between align-items-center">
            <h1>All Model Parts from different suppliers</h1>
        </div>

        <div class="d-flex justify-content-center">
        <form action="{{ route('supplier.search') }}" method="GET" class="d-flex mt-4" role="search" >
            <input class="form-control me-2" style="width: 150px;" type="text" name="search" placeholder="Model Part Name">
            <input class="form-control me-2" style="width: 150px;" type="number" name="min_price" placeholder="Min Price">
            <input class="form-control me-2" style="width: 150px;" type="number" name="max_price" placeholder="Max Price">
            
            <button class="btn btn-outline-success" style="padding: .375rem .5rem; font-size: .875rem; width: 100px;" type="submit">Search</button>
            <a href="{{ route('supplier.dashboard') }}" class="btn btn-primary" style="padding: .375rem .5rem; font-size: .875rem; width: 100px; margin-left:5px">Show All</a>
        </form>
        </div>

        <div class="d-flex justify-content-center flex-wrap">
            @foreach ($model_parts as $modelPart)
                <div class="card">
                    <img src="{{ asset($modelPart->image) }}" alt="Model Parts Image">
                    <h3>{{ $modelPart->model_name }}</h3>
                    <p>Price: {{ $modelPart->price }}</p>
                    <p>Quantity: {{ $modelPart->quantity }}</p>
                    <p>Date Supplied: {{ $modelPart->date_supplied }}</p>
                    <p>Available: {{ $modelPart->is_available ? 'Yes' : 'No' }}</p>
                </div>
            @endforeach
        </div>
    </div>
    
    <div style="text-align: center;">
      <div style="display: inline-block; margin-top: 20px;">
          <ul class="pagination" style="margin: 0; padding: 0;">
              <!-- Custom pagination rendering -->
              @if ($model_parts->lastPage() > 1)
                  @if ($model_parts->currentPage() != 1)
                      <li class="page-item">
                          <a class="page-link" href="{{ $model_parts->url(1) }}">«</a>
                      </li>
                  @else
                      <li class="page-item disabled">
                          <span class="page-link">«</span>
                      </li>
                  @endif
      
                  @for ($i = 1; $i <= $model_parts->lastPage(); $i++)
                      <li class="page-item{{ ($model_parts->currentPage() == $i) ? ' active' : '' }}">
                          <a class="page-link" href="{{ $model_parts->url($i) }}">{{ $i }}</a>
                      </li>
                  @endfor
      
                  @if ($model_parts->currentPage() != $model_parts->lastPage())
                      <li class="page-item">
                          <a class="page-link" href="{{ $model_parts->url($model_parts->currentPage() + 1) }}">»</a>
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
          Showing {{ $model_parts->firstItem() }} to {{ $model_parts->lastItem() }} of {{ $model_parts->total() }} entries
      </p>
  </div>
    
</body>
</html>

@endsection

