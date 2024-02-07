<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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

<div class="navbar">
    <h1>Supplier Dashboard</h1>
</div>

<div class="sidebar">
    <a href="{{ url('supplier/dashboard') }}">Dashboard </a>

    <a href="{{ url('supplier/dashboard/modelparts') }}">Model Parts</a>
    
    <a href="{{ url('supplier/dashboard/inventory') }}">Inventory</a>
    
    <a href="{{ url('supplier/dashboard/sales') }}">Sales</a>
    
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




{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboardasfasf') }}
          
        </h2>
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div>{{ Auth::user()->email }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
    </x-slot>

    
</x-app-layout> --}}


<!-- resources/views/supplier/dashboard/modelparts/create.blade.php -->
{{-- 
 <!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Supplier Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('supplier/dashboard') }}">DASHBOARD</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{ url('supplier/dashboard/modelparts') }}">Add Model Parts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('supplier/dashboard') }}">Features</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown link
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
{{-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Sidebar Menu</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            padding-top: 20px;
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

        .content {
            margin-left: 200px;
            padding: 16px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <a href="#home">Home</a>
    <a href="#about">About</a>
    <a href="#services">Services</a>
    <a href="#contact">Contact</a>
</div>

<div class="content">
    <h2>Main Content</h2>
    <p>This is the main content area. Replace this with your actual content.</p>
</div>

</body>
</html>

    <h1 class="p-4 text-center">Supplier Dashboardasfasf</h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
 
    <button class="btn btn-primary text-black" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
        Toggle static offcanvas
      </button>
    

    <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
        Link with href
      </a>
      <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
        Button with data-bs-target
      </button>
      
      <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          
          <div class="dropdown mt-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
              Dropdown button
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ url('supplier/dashboard/modelparts') }}">model</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </div>
        </div>
      </div>  --}}
{{--   
      
      <div class="offcanvas offcanvas-start show text-bg-dark" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="staticBackdropLabel">Offcanvas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <div> --}}
            
       
{{--           

            <div class="p-6 text-gray-900">
                {{ __("You're logged in as!") }}
                <div>{{ Auth::user()->role }}</div>
                <div>{{ Auth::user()->name }}</div>
               
            </div>
<form method="POST" action="{{ route('logout') }}">
    @csrf

<a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                        this.closest('form').submit();">
    Logout
    </a>
</form>

@yield('content')
          </div>
        </div>
      </div>

</body>
</html>  --}}
{{-- 
<h1> supplier dashboard</h1>

<form method="POST" action="{{ route('logout') }}">
    @csrf

<a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                        this.closest('form').submit();">
    Logout
    </a>
</form>




 --}} --}}
