<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="has-background-grey-light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body >
    <div id="app">
        <nav class="navbar is-dark">
            
                <div class="navbar-brand">

                    <a class="navbar-item" href="{{ url('/') }}">
                        <h1 class="title has-text-white-ter">{{ config('app.name', 'Laravel') }}</h1>
                    </a>
                    
                </div>
                

                <div class="navbar-menu">
                    <div class="navbar-start">
                        <a href="{{route('gallery')}}" class="navbar-item">Gallery</a>
                        <a href="{{route('profiles')}}" class="navbar-item">{{__('Profiles')}}</a>
                    </div>
            
                    <div class="navbar-end">
                    
             
                
                    <!-- Authentication Links -->
                    @guest
                        <div class="navbar-item">
                            <div class="field is-grouped">
                                <p class="control">
                              <!--       <a href="{{ route('login') }}" class="button">{{ __('Login') }}</a>
                                    <a href="{{ route('register') }}" class="button">{{ __('Register') }}</a> -->

                                </p>
                            </div>
                        </div>
                    
                        
                    @else
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a href="#" class="navbar-link">{{ Auth::user()->name }} </a>
                        </div>
                        <div class="navbar-dropdown is-boxed">
                            <a href="{{ route('logout') }}" class="navbar-item" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                           
                        
                    @endguest
                
                       </div>
                    

                </div>
            
        </nav>

        <main class="section">
            @yield('content')
        </main>
    </div>
</body>
</html>
