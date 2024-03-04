
@extends('supplier.layout')

@section('modelparts')
<div>
    <h1>Inventory</h1>
    @foreach ($inventories as $inventory)
    <tr>
        <td>{{ $inventory->modelPart->model_name }}</td>
        <td>{{ $inventory->quantity_sold }}</td>
        <td>{{ $inventory->quantity_remaining }}</td>
    </tr>
@endforeach
</div>
@endsection