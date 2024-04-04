<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>DevCo - Where awesome cars are located</title>


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])


        
  <style>
   
    .dropdown:hover .dropdown-menu {
      display: block;
    }
    .navbar {
      padding: 10px;
      border-bottom: 1px solid #000; /* Black border */
    }
    
    .dropdown-menu {
        display: none;
        position: absolute;
        z-index: 1000;
    }

    /* Show dropdown menu when parent is hovered */
    .form-select:hover .dropdown-menu {
        display: block;
    }
        
  </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        
<!-- Top navbar -->
<nav class="navbar navbar-expand-lg bg-white" style="padding: 0;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="path_to_your_logo_image" alt="Logo" height="30" >
        </a>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 " >
          <li class="nav-item">
            <a class="nav-link " href="{{ url('/') }}" role="button" aria-expanded="false" style="font-size: 0.8rem; padding: 0.25rem; margin-left: 90px;">
        HOME
            </a>
          </li>
        </ul>
        {{-- <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-center" >
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false" style="font-size: 0.8rem; padding: 0.25rem;">
             SEARCH VEHICLES
            </a>
          </li>
        </ul> --}}
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="padding: 0; margin-right: 0;">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false" style="font-size: 0.8rem; padding: 0.25rem;">
            Language
          </a>
          <ul class="dropdown-menu" style="font-size: 0.8rem; padding: 0;">
            <li><a class="dropdown-item" href="#">English</a></li>
            <li><a class="dropdown-item" href="#">Filipino</a></li>
            <li><a class="dropdown-item" href="#">Korean</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" style="font-size: 0.8rem; padding: 0.25rem;">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" style="font-size: 0.8rem; padding: 0.25rem;">Contact Us</a>
        </li>
      </ul>
    </div>
  </nav>


  
  
<!-- Main navbar -->
<nav class="navbar navbar-expand-lg bg-white">
    <div class="container-fluid">
      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
              <a class="nav-link" style="font-weight: bold;" href="{{ url('/') }}">EXPLORE VEHICLES</a>
          </li>

{{--   
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false">
                Brands
            </a>
            <ul class="dropdown-menu">
                @foreach($allVehicles->pluck('vehicle.brand')->unique() as $brand)
                    <li><a class="dropdown-item" href="{{ route('vehicles', ['brand' => $brand]) }}">{{ $brand }}</a></li>
                @endforeach
            </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false">
              Models
          </a>
          <ul class="dropdown-menu">
            @foreach($allVehicles->pluck('vehicle.model')->unique() as $model)
                  <li><a class="dropdown-item" href="{{ route('vehicles', ['model' => $model]) }}">{{ $model }}</a></li>
              @endforeach
          </ul>
        </li> --}}
          
        
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/vehicles') }}">Find a Car </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/featured-cars') }}">Featured Cars </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/find-dealer') }}">Find a Dealer</a>
          </li>
        </ul>
 
  
  @auth
      @if(Auth::user()->role === 'customer')
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                  <a class="nav-link" href="{{ url('customer-purchased') }}">Dashboard</a>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false">
                      {{ Auth::user()->name }}
                  </a>
                  <ul class="dropdown-menu">
                      <li>
                          <form action="{{ route('logout') }}" method="POST">
                              @csrf
                              <button type="submit" class="dropdown-item">Logout</button>
                          </form>
                      </li>
                  </ul>
              </li>
          </ul>
      @else
          <script>window.location = "{{ route('login') }}";</script>
      @endif
  @endauth
  
  @if (!Auth::check())
      @if (Route::has('login'))
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="{{ route('login') }}" role="button" aria-expanded="false">
                      Login as
                  </a>
                  <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{ route('login') }}">Customer</a></li>
                      <li><a class="dropdown-item" href="{{ route('login') }}">Dealer</a></li>
                      <li><a class="dropdown-item" href="{{ route('login') }}">Manufacturer</a></li>
                      <li><a class="dropdown-item" href="{{ route('login') }}">Supplier</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="{{ route('login') }}">Admin</a></li>
                  </ul>
              </li>
              <li class="nav-item dropdown">
                  @if (Route::has('register'))
                      <a class="nav-link" href="{{ route('register') }}" role="button" aria-expanded="false">
                          Register
                      </a>
                  @endif
              </li>
          </ul>
      @endif
  @endif
  
  
      </div>
    </div>
  </nav>
  
  

<div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="bg-image" style="background-image: url('{{ asset('storage/modelparts_images/fordmustang.jpg') }}'); background-size: cover; background-repeat: no-repeat; background-position: center; width: 100%; height: 122vh; display: flex; justify-content: center; align-items: center; padding-bottom: 50px;">
            <div class="w-full sm:max-w-md mt-6 px-6 py-1 bg-white shadow-md overflow-hidden sm:rounded-lg">

            {{ $slot }}
        </div>
    </div>
</div>


    </body>
</html>



{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html> --}}
