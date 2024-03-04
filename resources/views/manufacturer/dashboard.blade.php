@extends('manufacturer.layout')

@section('manufacturer')

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
            <h1>Model Parts from Suppliers</h1>
        </div>

        <!-- Display error messages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Display success message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-center">
            <form action="{{ route('manufacturer.search') }}" method="GET" class="d-flex mt-4" role="search">
                <input class="form-control me-2" style="width: 150px;" type="text" name="search" placeholder="Model Part Name">
                <input class="form-control me-2" style="width: 150px;" type="number" name="min_price" placeholder="Min Price">
                <input class="form-control me-2" style="width: 150px;" type="number" name="max_price" placeholder="Max Price">
                <button class="btn btn-outline-success" style="padding: .375rem .5rem; font-size: .875rem; width: 100px;" type="submit">Search</button>
                <a href="{{ route('manufacturer.dashboard') }}" class="btn btn-primary" style="padding: .375rem .5rem; font-size: .875rem; width: 100px; margin-left:5px">Show All</a>
            </form>
        </div>

        <div class="d-flex justify-content-center flex-wrap">
            @foreach ($model_parts as $modelPart)
                <div class="card">
                    <img src="{{ asset($modelPart->image) }}" alt="Model Parts Image">
                    <h3>{{ $modelPart->model_name }}</h3>
                    <p><strong>Price:</strong> {{ $modelPart->price }}</p>
                    <p><strong>Available:</strong> {{ $modelPart->is_available ? 'Yes' : 'No' }}</p>
                    <p><strong>Quantity:</strong> {{ $modelPart->quantity }}</p>
                   <small> <p><strong>Address:</strong> Region {{ $modelPart->user->region }}, {{ $modelPart->user->city }} City, {{ $modelPart->user->address }}</p> </small>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#buyModelPartModal{{ $modelPart->id }}">
                        Buy
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="buyModelPartModal{{ $modelPart->id }}" tabindex="-1" aria-labelledby="buyModelPartModalLabel{{ $modelPart->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="buyModelPartModalLabel{{ $modelPart->id }}">Buy Model Part</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('manufacturer.purchase', $modelPart->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <!-- Modal body content -->
                                       <div>
                                        <img src="{{ asset($modelPart->image) }}" alt="Model Parts Image">
                                        <h3>{{ $modelPart->model_name }}</h3>
                                       </div>
                                        <div class="mb-3">
                                            <label for="price{{ $modelPart->id }}" class="form-label">Price</label>
                                            <input type="text" class="form-control" id="price{{ $modelPart->id }}" name="price" value="{{ $modelPart->price }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="quantity{{ $modelPart->id }}" class="form-label">Quantity</label>
                                            <input type="number" class="form-control" id="quantity{{ $modelPart->id }}" name="quantity" min="1" max="{{ $modelPart->quantity }}" required oninput="calculateTotalPrice(this, {{ $modelPart->price }}, '{{ $modelPart->id }}')">
                                            <small class="form-text text-muted">Available Quantity: {{ $modelPart->quantity }}</small>
                                        </div>
                                        <div class="mb-3">
                                            <label for="total_price{{ $modelPart->id }}" class="form-label">Total Price</label>
                                            <input type="text" class="form-control" id="total_price{{ $modelPart->id }}" name="total_price" value="{{ $modelPart->price }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="details{{ $modelPart->id }}" class="form-label">Details</label>
                                            <textarea class="form-control" id="details{{ $modelPart->id }}" name="details"></textarea>
                                        </div>
                                        <!-- Hidden input field for model part ID -->
                                        <input type="hidden" name="model_part_id" value="{{ $modelPart->id }}">
                                        <!-- Other form fields -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Buy Model Part</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Pagination-->
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

    <script>
        function calculateTotalPrice(input, price, id) {
            const quantity = input.value;
            const totalPrice = quantity * price;
            document.getElementById('total_price' + id).value = totalPrice.toFixed(2);
        }
    </script>
    
</body>
</html>

@endsection
