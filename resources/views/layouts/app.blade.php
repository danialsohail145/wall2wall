<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Wall To Wall') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        <div class="black">
            <nav class="navbar navbar-expand-lg ">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#"></a>
                    <button class="navbar-toggler" style="padding: 0% 42%;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="text-white">MENU</span>
                        <!-- <span class="navbar-toggler-icon"></span> -->
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav ms-lg-auto pe-lg-5">
                            
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('LOGIN') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('REGISTER') }}</a>
                                </li>
                            @endif
                        @else

                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">PRODUCTS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">SPORTS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">LEGENDS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">ABOUT US</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">AUTHENTICITY</a>
                            </li>

                        
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('LOGOUT') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>


                    </div>
                </div>
            </nav>
        </div>

        <main class="py-4">
            @yield('content')
        </main>


        <div class="black">
            <h1 class="text-center text-white band pt-5" >Become A Legend</h1>
            
            <div class="row py-5 mt-5 mx-0">
                <div class="col-md-4">
                    <h4 class="num-1 text-white text-center text-md-end">Enter Your Email:</h4>
                </div>
                <div class="col-md-5">
                    <input class="input-invert" type="text" class="form-control">
                </div>
            </div>
        </div>


        <div class="container">
            <footer class="py-3 pt-5">
                <ul class="nav justify-content-center pb-3 mb-3">
                    <li class="ms-3"><a class="text-muted" href="#"><i class="fa fa-instagram  border-icon"></i></a></li>
                    <li class="ms-3"><a class="text-muted" href="#"><i class="fa fa-facebook-f  border-icon"></i></a></li>
                    <li class="ms-3"><a class="text-muted" href="#"><i class="fa fa-pinterest  border-icon"></i></a></li>
                </ul>
              <ul class="nav justify-content-center pb-3 mb-3">
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Search</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Faq</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Shipping & Returns</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Privacy Policy</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Terms of Service</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Refund policy</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Contact Us</a></li>
              </ul>
              <ul class="nav justify-content-center pb-3 mb-3">
                <li class="px-1"><a  href="#"><img src="{{ asset('/assets/images/Frame.png') }}" alt=""></a></li>
                <li class="px-1"><a  href="#"><img src="{{ asset('/assets/images/Frame-1.png') }}" alt=""></a></li>
                <li class="px-1"><a  href="#"><img src="{{ asset('/assets/images/Frame-2.png') }}" alt=""></a></li>
                <li class="px-1"><a  href="#"><img src="{{ asset('/assets/images/Frame-3.png') }}" alt=""></a></li>
                <li class="px-1"><a  href="#"><img src="{{ asset('/assets/images/Frame-4.png') }}" alt=""></a></li>
                <li class="px-1"><a  href="#"><img src="{{ asset('/assets/images/Frame-5.png') }}" alt=""></a></li>
                <li class="px-1"><a  href="#"><img src="{{ asset('/assets/images/Frame-6.png') }}" alt=""></a></li>
              </ul>
              <p class="text-center text-muted">Powered by Shopify</p>
            </footer>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
    @stack('page_scripts')
</body>
</html>
