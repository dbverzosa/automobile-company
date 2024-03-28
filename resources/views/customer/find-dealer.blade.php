@extends('customer.layout')

@section('dashboards')

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

</head>
<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<style>
   .featured-heading {
            text-align: center;
            color: #333;
            font-size: 2rem;
            font-weight: bold;
            margin-top: 2.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Additional styles for a more attractive design */
        .featured-heading {
            background-color: #f8f9fa;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 20px 10px rgba(0, 0, 0, 0.1);
        }
</style>

<div class="container">
    
 <h1 class="featured-heading">Find Dealers</h1>
 
</div>


</html>


@endsection