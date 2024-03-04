@extends('supplier.layout')

@section('modelparts')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
    <div class="container">
        <h1>Inventory & Sales</h1>
        <div class="table-responsive">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4 text-right mb-4">
                        <form action="{{ route('supplier.inventory_sales') }}" method="GET" class="form-inline">
                            <label for="top_sold" class="mr-2">Top Sold Quantity:</label>
                            <select name="top_sold" id="top_sold" class="form-control mr-2" onchange="this.form.submit()">
                                <option value="desc"{{ request()->input('top_sold') == 'desc' ? ' selected' : '' }}>High to Low</option>
                                <option value="asc"{{ request()->input('top_sold') == 'asc' ? ' selected' : '' }}>Low to High</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-4 text-right mb-4">
                        <form action="{{ route('supplier.inventory_sales') }}" method="GET" class="form-inline">
                            <label for="sort" class="mr-2">Sort Sales from:</label>
                            <select name="sort" id="sort" class="form-control mr-2" onchange="this.form.submit()">
                                <option value="desc"{{ request()->input('sort') == 'desc' ? ' selected' : '' }}> High Sales to Low Sales</option>
                                <option value="asc"{{ request()->input('sort') == 'asc' ? ' selected' : '' }}> Low to High Sales</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Model Part Name</th>
                        <th>Price</th>
                        <th>Total Quantity</th>
                        <th>Remaining Quantity</th>
                        <th>Sold Quantity</th>
                        <th>
                            Total Sales
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventorySales as $inventorySale)
                        <tr>
                          
                            <td>{{ $inventorySale->modelPart->model_name }}</td>
                            <td>{{ $inventorySale->modelPart->price }}</td>
                            <td>{{ $inventorySale->total_quantity }}</td>
                            <td>{{ $inventorySale->total_quantity - $inventorySale->sold_quantity }}</td>
                            <td>{{ $inventorySale->sold_quantity }}</td>
                            <td>{{ $inventorySale->total_sales }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
@endsection

