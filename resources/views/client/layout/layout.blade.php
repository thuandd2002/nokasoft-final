<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add to Cart Interaction Example</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
    <div id="wrapper">
        <div class="cart-icon-top">
        </div>

        
        <div id="checkout">
            CHECKOUT
        </div>
        <div id="header">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="{{ route('show-cart') }}">Cart</a></li>
                @auth
                <li><a style="background-color:red " href="{{route('route.customer.logout')}}">Louout</a></li>
                @else
                <li><a  style="background-color:green " href="{{route('route.customer.login')}}">Login</a></li>
                @endauth
               
            </ul>
        </div>
        @include('client.layout.slidebar')
        <div id="grid-selector">
            <div id="grid-menu">
                View:
                <ul>
                    <li class="largeGrid"><a href=""></a></li>
                    <li class="smallGrid"><a class="active" href=""></a></li>
                </ul>
            </div>

        </div>
        @yield('content')
        {{-- @include('client.templates.home') --}}
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</body>
<script src="{{ asset('js/script.js') }}"></script>
</html>
@yield('css')
