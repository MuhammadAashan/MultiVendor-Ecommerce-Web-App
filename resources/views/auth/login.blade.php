<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Estore</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ url('favicon.ico') }}" type="image/x-icon">
    <!-----CSS ki bootstrap CDN---->
    <link rel="stylesheet" href="{{ url('https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css') }}"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-----Bootstrap icon ka cdn---->
    <link rel="stylesheet"
        href="{{ url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css') }}">
</head>

<body>

    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card py-2 px-3 mx-3" style="background-color:gainsboro; border-radius: 5rem;">
                        <div class="row">
                            <div class="col-md-6 col-12 ">
                                <img src="{{ asset('asset/images/icon5.png') }}" alt=""
                                    class="img-fluid my-5 p-3">
                            </div>
                            <div class="col-md-6 col-12 align-items-center">
                                <div class="card-body p-5 p-lg-5 text-black">
                                    @if (Route::has('login'))

                                        @auth
                                            @if (auth()->user()->role == 'admin')
                                                <a href="{{ url('/admin/dashboard') }}"
                                                    class="text-light btn btn-primary col-12  align-item-center justify-content-center text-center">Dashboard</a>
                                            @elseif (auth()->user()->role == 'seller')
                                                <a href="{{ url('/seller/dashboard') }}"
                                                    class="text-light btn btn-primary col-12  align-item-center justify-content-center text-center">Dashboard</a>
                                            @else
                                            @endif
                                        @else
                                            <form method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <div class="align-items-center mb-3 text-center">
                                                    <span class="h2 fw-bold mb-0 ">Welcome to EStore!</span>
                                                </div>
                                                <div class="align-items-center mb-5 pb-1 text-center">
                                                    <span class="h3 fw-bold mb-0 ">Login to serve</span>
                                                    <h6 class="pb-1 text-right" ><a  href="{{ url('/') }}">GoBack to Home</a></h6>
                                                </div>
                                                <div class="form-outline mb-4">
                                                    <input id="email" type="email"
                                                        class=" rounded-pill form-control @error('email') is-invalid @enderror"
                                                        name="email" value="{{ old('email') }}" autocomplete="email"
                                                        autofocus>

                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-outline mb-4">
                                                    <input id="password" type="password"
                                                        class=" rounded-pill form-control @error('password') is-invalid @enderror"
                                                        name="password" autocomplete="current-password">
                                                    <input type="checkbox" onclick="myFunction()">Show Password
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <!--<div class="form-outline mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" { old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                { __('Remember Me') }}
                                            </label>
                                        </div>
                                      </div>
                                    -->

                                    @error('error')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    @if ($errors->count() > 0)
                    @foreach ($errors->all() as $message)
                        <p class="text-danger">{{ $message }}</p>
                    @endforeach
                @endif


                                                <div class="pt-1 mb-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Login') }}
                                                    </button>
                                                    @if (Route::has('register'))
                                                        <a href="{{ route('register') }}"
                                                            class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">If you have no Account! Signup</a>
                                                    @endif

                                                    <!-- if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{ route('password.request') }}">
                                             __('Forgot Your Password?') }}
                                        </a>
                                    endif-->
                                                </div>
                                            </form>
                                        @endauth

                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>


    <!----Bootstrap ki JS ka <CDN---->
    <script src="{{ url('https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js') }}"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="{{ url('https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js') }}"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="{{ url('https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js') }}"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
    </script>
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>
