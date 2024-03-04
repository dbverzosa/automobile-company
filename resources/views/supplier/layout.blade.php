<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff8f8; /* Dark background color */
        }

        .navbar {
            background-color: #333;
            padding: 1px;
            color: white;
            text-align: center;
        }

        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            padding-top: 10px; /* Adjusted to accommodate the navbar height */
        }

        .sidebar a {
            padding: 16px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #ddd;
            color: black;
        }

        .sidebar .dropdown {
            padding: 16px;
            font-size: 18px;
            color: white;
            display: block;
            cursor: pointer;
            transition: 0.3s;
        }

        .sidebar .dropdown-content {
            display: none;
            padding-left: 20px;
        }

        .sidebar .dropdown:hover .dropdown-content {
            display: block;
        }

        .sidebar .dropdown-content a {
            padding: 10px;
            text-decoration: none;
            font-size: 16px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        .sidebar .dropdown-content a:hover {
            background-color: #ddd;
            color: rgb(160, 78, 78); 
          /* color: black;  */

        }

        .content {
            margin-left: 200px;
            padding: 16px;
        }
        
    </style>
</head>
<body>
  <div class="navbar d-flex justify-content-center" style="padding: 10px;">
    <h1>Supplier Dashboard</h1>
</div>

<div class="sidebar">
    <div style="text-align: center;">
        <div style="color: white; font-weight: bold;">{{ __("WELCOME!") }}</div>
        <div style="color: green; font-weight: bold;">Role: {{ Auth::user()->role }}</div>
        <div style="color: red; font-weight: bold;">Name: {{ Auth::user()->name }}</div>
        <div style="color: orange; font-weight: bold;">ID: {{ Auth::user()->id }}</div>
    </div>
    <a href="{{ url('supplier/dashboard') }}">Dashboard </a>

    <a href="{{ url('supplier/dashboard/modelparts') }}">Model Parts</a>
    
    <a href="{{ url('supplier/dashboard/inventory') }}">Parts Inventory</a>
    
    <a href="{{ url('supplier/dashboard/sales') }}">Parts Sales</a>
    
<div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <x-dropdown-link :href="route('logout')"
                onclick="event.preventDefault();
                            this.closest('form').submit();">
            {{ __('Log Out') }}
        </x-dropdown-link>
    </form>
</div>
</div>

<div class="content">
    @yield('modelparts')
</div>

</body>
</html>
