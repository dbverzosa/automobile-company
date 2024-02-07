<!-- resources/views/supplier/dashboard/modelparts/addmodelparts.blade.php -->
@extends('supplier.supplier-dashboard')

@section('modelparts')


    <h1 class="p-4 text-center">Add a Model Parts</h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <div class="container">

        <form action="{{ route('supplier.modelparts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="model_name" class="form-label">Model Name</label>
                <input type="text" class="form-control" id="model_name" name="model_name" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="mb-3">
                <label for="date_supplied" class="form-label">Date Supplied</label>
                <input type="date" class="form-control" id="date_supplied" name="date_supplied" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1" checked>
                <label class="form-check-label" for="is_available">Available</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection




{{-- <!-- resources/views/supplier/dashboard/modelparts/create.blade.php -->
@extends('supplier.supplier-dashboard')

@section('modelparts')


    <h1 class="p-4 text-center">Show all Model Parts</h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <div class="container">

        <form action="{{ route('modelparts.store') }}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="model_name">Model Name</label>
                <input type="text" name="model_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="date_supplied">Date Supplied</label>
                <input type="date" name="date_supplied" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="is_available">Is Available</label>
                <select name="is_available" class="form-control" required>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <!-- Add more form fields as needed -->

            <button type="submit" class="btn btn-primary">Create Model Part</button>
        </form>
    </div>

@endsection

 --}}


{{-- 

<h1>Add Vehicles</h1>
    <div class="row justify-content-center align-items-center" style="height: 60vh;">

        <div class="mt-5">
                @if($errors->any())
                    <div class="col-12">
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                    </div>
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif

                @if(session()->has('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
        </div>

        <form action="{{route('add.addvehiclepost')}}" method="POST" enctype="multipart/form-data" class="p-2" style="width: 500px;">
            @csrf
            @method('POST')
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">Vehicle Picture</label>
                <input type="file" class="form-control" name="vehicle_pic">
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">VIN</label>
                <input type="text" class="form-control" name="VIN">
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">MODEL ID</label>
                <input type="text" class="form-control" name="model_id">
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">COLOR</label>
                <input type="text" class="form-control" name="color">
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">Manufacturing Plant ID</label>
                <input type="text" class="form-control" name="plant_id">
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">Details</label>
                <textarea class="form-control" name="details" rows="4"></textarea>
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">Manufactured Date</label>
                <input type="text" class="form-control" name="manufactured_date">
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">Price</label>
                <input type="text" class="form-control" name="price">
            </div>
            
            <div class="row mt-2">
                <div class="col d-grid gap-2"> 
                    <button class="btn btn-primary mx-auto" type="submit">Add Vehicle</button>
                </div>
            </div>


{{-- 
            <h1>Add Vehicles</h1>
    <div class="row justify-content-center align-items-center" style="height: 60vh;">

        <div class="mt-5">
                @if($errors->any())
                    <div class="col-12">
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                    </div>
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif

                @if(session()->has('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
        </div>

        <form action="{{route('add.addvehiclepost')}}" method="POST" enctype="multipart/form-data" class="p-2" style="width: 500px;">
            @csrf
            @method('POST')
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">Vehicle Picture</label>
                <input type="file" class="form-control" name="vehicle_pic">
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">VIN</label>
                <input type="text" class="form-control" name="VIN">
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">MODEL ID</label>
                <input type="text" class="form-control" name="model_id">
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">COLOR</label>
                <input type="text" class="form-control" name="color">
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">Manufacturing Plant ID</label>
                <input type="text" class="form-control" name="plant_id">
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">Details</label>
                <textarea class="form-control" name="details" rows="4"></textarea>
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">Manufactured Date</label>
                <input type="text" class="form-control" name="manufactured_date">
            </div>
            <div class="col-md-12">
                <label for="inputEmail4" class="form-label">Price</label>
                <input type="text" class="form-control" name="price">
            </div>
            
            <div class="row mt-2">
                <div class="col d-grid gap-2"> 
                    <button class="btn btn-primary mx-auto" type="submit">Add Vehicle</button>
                </div>
            </div> --}} --}}