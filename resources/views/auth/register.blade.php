<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Estore</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{url('favicon.ico')}}" type="image/x-icon">
    <!-----CSS ki bootstrap CDN---->
    <link rel="stylesheet" href="{{url('https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css')}}" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-----Bootstrap icon ka cdn---->
    <link rel="stylesheet" href="{{url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css')}}">
</head>
<body>
    <section class="vh-50">
        <div class="container">
            <div class="row m-5 " style="border-radius:62px ; background-color:gainsboro;">
                <div class="col-lg-6 col-md-12 d-none d-md-block">
                    <img src="{{asset('asset/images/icon5.png')}}" alt="" class="img-fluid mt-5 ">
                </div>
                <div class="col-lg-6 col-12 text-center" style="border-top-right-radius: 60px; border-bottom-right-radius: 60px;">
                    <div>

                        <form class="p-5" method="post"  action="{{ url('/Register') }}">
                            @csrf
                            <h3>Welcome to EStore!</h3>
                            <h6 >SignUp as Seller Account</h6>
                            <h6 class="pb-5 text-right" ><a  href="{{ url('/') }}">GoBack to Home</a></h6>
                            <div class="row">

                                <div class="col-6">
                                    <div class="form-outline mb-4">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus placeholder="Name">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-outline mb-4">
                                        <input id="mobileno" type="mobileno" class="form-control @error('mobileno') is-invalid @enderror" name="mobileno" value="{{ old('mobileno') }}"  autocomplete="mobilno" placeholder="Mobile No">

                                        @error('mobileno')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-outline mb-4">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"autocomplete="email" placeholder="Email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-outline mb-4">
                                <input id="cnic" type="text" class="form-control @error('cnic') is-invalid @enderror" name="cnic" value="{{ old('cnic') }}" autocomplete="cnic" placeholder="CNIC">

                                @error('cnic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-outline mb-4">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}"  autocomplete="address" placeholder="Address">

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-outline mb-4">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-outline mb-4">

                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" placeholder="Confirm Password">
                            </div>
                            <div class="form-outline mb-4">
                                <div class="col-md-12 text-left">
                                    <div>
                                        <input type="radio" id="check" name="check" value="Seller" checked>
                                        <label for="check">Seller</label>
                                    </div>
                                     <div >
                                        <input type="radio" id="check" name="check" value="Customer" >
                                        <label for="check">Customer</label>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center pt-1  pb-1 mr-5 ml-5">
                                <button class="btn text-light rounded-pill mb-3" type="submit" style="background-color: black;" type="submit">SignUp</button>
                            </div>
                            <p>Or</p>
                            <a href="{{ route('login') }}">If you have a account Please login</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
      </section>


    <!----Bootstrap ki JS ka <CDN---->
        <script src="{{url('https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js')}}" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="{{ url('https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js')}}" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="{{ url('https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js')}}" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
</body>
</html>
