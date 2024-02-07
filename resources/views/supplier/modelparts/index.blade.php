@extends('supplier.supplier-dashboard')

@section('modelparts')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model Parts</title>
    <style>
    /* Custom CSS for pagination */
    .pagination {
        display: inline-block;
        margin: 0;
        padding: 0;
    }

    .pagination > li {
        display: inline;
        list-style: none;
        margin-right: 5px;
    }

    .pagination > li > a,
    .pagination > li > span {
        color: #007bff;
        font-size: 10px; /* Adjust font size as needed */
        text-decoration: none;
        padding: 5px 8px; /* Adjust padding */
        border: 1px solid #007bff;
        border-radius: 3px;
    }

    .pagination > .active > a,
    .pagination > .active > span {
        background-color: #007bff;
        color: #fff;
    }

    .pagination > li > a:hover,
    .pagination > li > span:hover {
        background-color: #f8f9fa;
    }

    .pagination > .disabled > span,
    .pagination > .disabled > a,
    .pagination > .disabled > a:hover,
    .pagination > .disabled > span:hover {
        color: #6c757d;
        background-color: transparent;
        pointer-events: none;
        cursor: not-allowed;
    }

    .pagination > li:first-child > a,
    .pagination > li:last-child > a {
        font-size: 8px; /* Adjust font size for arrows */
    }
</style>

</head>
<body>
    <div style="text-align: center;">
        <h1>All Model Parts</h1>

          <!-- Add New Model Part Button -->
          <a href="{{ route('supplier.modelparts.addmodelparts') }}" class="btn btn-primary">Add New Model Part</a>
      
          <!-- Search Form -->
        <form action="{{ route('supplier.modelparts.search') }}" method="GET">
            <input type="text" name="search" placeholder="Search by model name">
            <input type="number" name="min_price" placeholder="Min Price">
            <input type="number" name="max_price" placeholder="Max Price">
            <select name="availability">
                <option value="">Select Availability</option>
                <option value="1">Available</option>
                <option value="0">Not Available</option>
            </select>
            <button type="submit">Search</button>
            <a href="{{ route('supplier.modelparts.index') }}" class="btn btn-primary">Show All</a>
        </form>

        <table border="1" style="margin: 0 auto; margin-top:20px">
            <thead>
                <tr>
                    <th>Supplier ID</th>
                    <th>Supplier Name</th>
                    <th>Model Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Date Supplied</th>
                    <th>Available</th>
                </tr>
            </thead>
            <tbody>
                @foreach($model_parts as $part)
                <tr>
                    <td>{{ $part->user_id }}</td>
                    <td>{{ $part->user->name }}</td>
                    <td>{{ $part->model_name }}</td>
                    <td><img src="{{ asset($part->image) }}" alt="Model Parts Image" style="max-width: 100px;"></td>
                    <td>{{ $part->price }}</td>
                    <td>{{ $part->quantity }}</td>
                    <td>{{ $part->date_supplied }}</td>
                    <td>{{ $part->is_available ? 'Yes' : 'No' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                {{ $model_parts->render() }}
            </ul>
        </nav>
    </div>
</body>
</html>
@endsection


{{-- @extends('supplier.supplier-dashboard')

@section('modelparts')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model Parts</title>
    <style>
    /* Custom CSS for pagination */
    .pagination {
        display: inline-block;
        margin: 0;
        padding: 0;
    }

    .pagination > li {
        display: inline;
        list-style: none;
        margin-right: 5px;
    }

    .pagination > li > a,
    .pagination > li > span {
        color: #007bff;
        font-size: 10px; /* Adjust font size as needed */
        text-decoration: none;
        padding: 5px 8px; /* Adjust padding */
        border: 1px solid #007bff;
        border-radius: 3px;
    }

    .pagination > .active > a,
    .pagination > .active > span {
        background-color: #007bff;
        color: #fff;
    }

    .pagination > li > a:hover,
    .pagination > li > span:hover {
        background-color: #f8f9fa;
    }

    .pagination > .disabled > span,
    .pagination > .disabled > a,
    .pagination > .disabled > a:hover,
    .pagination > .disabled > span:hover {
        color: #6c757d;
        background-color: transparent;
        pointer-events: none;
        cursor: not-allowed;
    }

    .pagination > li:first-child > a,
    .pagination > li:last-child > a {
        font-size: 8px; /* Adjust font size for arrows */
    }
</style>

</head>
<body>
    <div style="text-align: center;">
        <h1>All Model Parts</h1>

        <!-- Search Form -->
        <form action="{{ route('supplier.modelparts.search') }}" method="GET">
            <input type="text" name="search" placeholder="Search by model name">
            <button type="submit">Search</button>
            <a href="{{ route('supplier.modelparts.index') }}" class="btn btn-primary">Show All</a>
        </form>


        <table border="1" style="margin: 0 auto;">
            <thead>
                <tr>
                    <th>Supplier ID</th>
                    <th>Supplier Name</th>
                    <th>Model Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Date Supplied</th>
                    <th>Available</th>
                </tr>
            </thead>
            <tbody>
                @foreach($model_parts as $part)
                <tr>
                    <td>{{ $part->user_id }}</td>
                    <td>{{ $part->user->name }}</td>
                    <td>{{ $part->model_name }}</td>
                    <td><img src="{{ asset($part->image) }}" alt="Model Parts Image" style="max-width: 100px;"></td>
                    <td>{{ $part->price }}</td>
                    <td>{{ $part->quantity }}</td>
                    <td>{{ $part->date_supplied }}</td>
                    <td>{{ $part->is_available ? 'Yes' : 'No' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                {{ $model_parts->render() }}
            </ul>
        </nav>
    </div>
</body>
</html>
@endsection

 --}}




{{-- <!-- resources/views/supplier/dashboard/modelparts/create.blade.php -->
@extends('supplier.supplier-dashboard')

@section('modelparts')


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model Parts</title>
</head>
<body>
    <h1>All Model Parts</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Model Name</th>
                <th>Image</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Date Supplied</th>
                <th>Available</th>
            </tr>
        </thead>
        <tbody>
            @foreach($model_parts as $part)
            <tr>
                <td>{{ $part->model_name }}</td>
                <td><img src="{{ asset($part->image) }}" alt="Model Parts Image" style="max-width: 100px;"></td>
                <td>{{ $part->price }}</td>
                <td>{{ $part->quantity }}</td>
                <td>{{ $part->date_supplied }}</td>
                <td>{{ $part->is_available ? 'Yes' : 'No' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $model_parts->links() }}
</body>
</html>

@endsection --}}