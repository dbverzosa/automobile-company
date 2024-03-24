@extends('dealer.layout')

@section('dealer')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        text-align: left;
        font-size: 15px;
        border-bottom: 1px solid #ddd;
        word-wrap: break-word; /* Add this to prevent overlapping */
    }
    img {
        max-width: 100px;
        max-height: 100px;
    }
</style>
<div>
    <h1>Purchased Vehicles from Manufacturer</h1>

    <form action="{{ route('dealer.purchasedVehicles.search') }}" method="GET">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search">
        <button type="submit">Submit</button>
      <button href="{{ url('dealer/dashboard/purchased-vehicles') }}">Show All</button>  

    </form>
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Image</th>
                <th>VIN</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Price</th>
                <th>Manufacturing Plant</th>
                <th>Details</th>
                <th>Color</th>
                <th>Engine</th>
                <th>Transmission</th>
                <th>Manufacturer</th>
                <th>Date Purchased</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchasedVehicles as $purchasedVehicle)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td><img src="{{ asset('storage/vehicles_images/' .$purchasedVehicle->manufacturerVehicle->image) }}" alt="Vehicle Image" ></td>
                <td>{{ $purchasedVehicle->manufacturerVehicle->vin }}</td>
                <td>{{ $purchasedVehicle->manufacturerVehicle->brand }}</td>
                <td>{{ $purchasedVehicle->manufacturerVehicle->model }}</td>
                <td>{{ $purchasedVehicle->manufacturerVehicle->price }}</td>
                <td>{{ $purchasedVehicle->manufacturerVehicle->manufacturing_plant }}</td>
                <td>{{ $purchasedVehicle->manufacturerVehicle->details }}</td>
                <td>{{ $purchasedVehicle->manufacturerVehicle->color }}</td>
                <td>{{ $purchasedVehicle->manufacturerVehicle->engine }}</td>
                <td>{{ $purchasedVehicle->manufacturerVehicle->transmission }}</td>
                <td>{{ $purchasedVehicle->manufacturerVehicle->manufacturer->name }}</td>
                <td>{{ \Carbon\Carbon::parse($purchasedVehicle->date_purchased)->format('F d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
