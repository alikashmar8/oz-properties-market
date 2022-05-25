<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Oz Property Market</title>
    <link rel="icon" href="{{asset('logo/fav.jpg')}}" type="image/gif" sizes="16x16">
    <!-- Fonts -->
    <!link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hind&family=Pacifico&family=Sansita+Swashed&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Old+Standard+TT&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">

    {{--    Scripts--}}
    <script src="{{ asset('js/app.js') }}" defer></script>

    {{--    leafletMap--}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{--    custom added new--}}

<!-- Animate.css -->
    <link rel="stylesheet" href="{{ URL::asset('css/animate.css') }}">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="{{ URL::asset('css/icomoon.css') }}">
    <!-- Bootstrap  -->
    {{--    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.css') }}">--}}
<!-- Superfish -->
    <link rel="stylesheet" href="{{ URL::asset('css/superfish.css') }}">
    <!-- Flexslider  -->
    <link rel="stylesheet" href="{{ URL::asset('css/flexslider.css') }}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ URL::asset('css/magnific-popup.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-datepicker.min.css') }}">
    <!-- CS Select -->
    <link rel="stylesheet" href="{{ URL::asset('css/cs-select.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/cs-skin-border.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://kit-free.fontawesome.com/releases/latest/css/free.min.css" media="all" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f9262e0935.js" crossorigin="anonymous"></script>

    {{--    <link href={{ asset("bootstrap/css/bootstrap.css") }} rel="stylesheet"/>--}}

<!-- Custom styles for this template -->
    {{--    <link href={{ asset("bootstrap/css/sticky-footer-navbar.css") }} rel="stylesheet"/>--}}

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Optional theme -->
    {{--    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap-theme.min.css') }}">--}}

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.css"/>

    <style>


    </style>
</head>

<body class="bg-css">
<div>
    <nav class="navbar navbar-expand-lg navbar-inverse navbar-static-top navbar-dark bg-blue" >
        <a class="navbar-brand " href="/"><img src="{{asset('logo/logowithout.png')}}" style="width:100%; max-width: 220px"></a>
        {{--        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">--}}

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarsExample05" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="nav navbar-nav mr-auto">

                {{--                <li class="nav-item">--}}
                {{--                    <a class="nav-link" href="/categories">Categories</a>--}}
                {{--                </li>--}}
                @if(!\Illuminate\Support\Facades\Auth::guest())
                    {{--                    user is logged in--}}
                    @if(\Illuminate\Support\Facades\Auth::user()->role == 0)
                        {{--                    admin menu option--}}
                        <li class="nav-item">
                            <a class="special-link" href="/acceptedProperties">All Properties</a>
                        </li>
                        <li class="nav-item">
                            <a class="special-link" href="/allCommercials">All Commercials</a>
                        </li>
                        <li class="nav-item">
                            <a href="/users" class="special-link">All Users</a>
                        </li>
                        <li class="nav-item">
                            <a href="/agents" class="special-link">Agents</a>
                        </li>
                        <li class="nav-item">
                            <a href="/adminPayments" class="special-link">Payments</a>
                        </li>
                        <li class="nav-item">
                            <a href="/histories" class="special-link">Histories</a>
                        </li>
                    @else
                        {{--                        user menu options--}}
                        <li class="nav-item">
                            <a class="special-link" href="/properties/buy">Buy</a>
                        </li>

                        <li class="nav-item">
                            <a class="special-link" href="/properties/create">Sell</a>
                        </li>

                        <li class="nav-item">
                            <a class="special-link" href="/properties/rent">Rent / Share</a>
                        </li>


                        <li class="nav-item">
                            <a class="special-link" href="/properties/myProperties">My Properties</a>
                        </li>


                        <li class="nav-item">
                            <a href="/findAgents" class="special-link">Find agent</a>
                        </li>

                        <li class="nav-item">
                            <a href="/tips" class="special-link">Tips</a>
                        </li>
                        <li class="nav-item">
                            <a href="/evaluate" class="special-link">Evaluate</a>
                        </li>
                        <li class="nav-item">
                            <a href="/insurance" class="special-link">Insurance</a>
                        </li>

            </ul>
            <ul class="nav navbar-nav mr-auto">

                <li class="nav-item">
                    <a href="/commercial" class="special-link">Commercial</a>
                </li>


                @endif
                @endif
                @if(\Illuminate\Support\Facades\Auth::guest())
                    {{--                    guest only menu options--}}
                    <li class="nav-item">
                        <a class="special-link" href="/properties/buy">Buy</a>
                    </li>

                    <li class="nav-item">
                        <a class="special-link" href="{{ route('login') }}">Sell</a>
                    </li>

                    <li class="nav-item">
                        <a class="special-link" href="/properties/rent">Rent / Share</a>
                    </li>


                    <li class="nav-item">
                        <a href="/findAgents" class="special-link">Find agent</a>
                    </li>

                    <li class="nav-item">
                        <a href="/tips" class="special-link">Tips</a>
                    </li>
                    <li class="nav-item">
                        <a href="/evaluate" class="special-link">Evaluate</a>
                    </li>
                    <li class="nav-item">
                        <a href="/insurance" class="special-link">Insurance</a>
                    </li>

            </ul>
            <ul class="nav navbar-nav mr-auto">

                <li class="nav-item">
                    <a href="/commercial" class="special-link">Commercial</a>
                </li>

                @endif
            </ul>

            {{--right side of nav--}}
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="special-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        {{--                        <button class="nav-item navbar-toggler" data-toggle="collapse" data-target="#registerType" type="button">--}}
                        <a class="special-link" href="{{ route('register') }}">Register</a>
                        {{--                                {{ __('Register') }}--}}


                    @endif
                @else

                    <li class="nav-item">
                        <a class="  mr-3" href="/users/{{ Auth::id() }}" style="padding : 0px">

                            <img style="width: 40px; height: 40px; border-radius: 50%;"
                                 src="{{url('/storage/user_profile_images/' . Auth::user()->profileImg )}}"
                            >
                            {{--                            id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" aria-haspopup="true" aria-expanded="false" v-pre--}}
                            {{--                           data-toggle="dropdown" --}}
                            {{-- Auth::user()->name --}}
                        </a>
                    </li>
                    <!li class="  m-1"><!/li>
                    <li>
                        <a class="btn " style="padding: 4px; color: #e4002b"
                           role="button" onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">Logout</a>

                        <div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="navbarDropdown">
                            {{--                            <a class="dropdown-item text-white" href="{{ route('logout') }}"--}}
                            {{--                               onclick="event.preventDefault();--}}
                            {{--                                                     document.getElementById('logout-form').submit();">--}}
                            {{--                                {{ __('Logout') }}--}}
                            {{--                            </a>--}}

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
</div>

<main class="m-0 p-0">
    @yield('content')
</main>

{{--footer side--}}
<footer>

    @include('layouts.footer')

</footer>


</body>
</html>
