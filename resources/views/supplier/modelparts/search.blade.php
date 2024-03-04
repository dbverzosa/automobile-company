@extends('supplier.supplier-dashboard')

@section('modelparts')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model Parts - Search Results</title>
   
</head>
<body>
    <div style="text-align: center;">
        <h1>Search Results</h1>

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
                @foreach($search_results as $part)
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
</body>
</html>
@endsection
