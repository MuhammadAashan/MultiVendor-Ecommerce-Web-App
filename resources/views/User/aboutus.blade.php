@extends('User.masteruser')
@section('content')
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{url('user/dashboard')}}">Home</a></li>
                <li class="active">About Us</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!-- about wrapper start -->
<div class="about-us-wrapper pt-60 pb-40">
    <div class="container">
        <div class="row">
            <!-- About Text Start -->
            <div class="col-lg-6 order-last order-lg-first">
                <div class="about-text-wrap">
                    <h2><span>Provide Best</span>Product For You</h2>
                    <p>We provide the best  all over the world.You can buy our product without any hegitation because they truste us and buy our product without any hagitation because they belive and always happy buy our product.</p>
                    <p>Some of our customer say’s that they trust us and buy our product without any hagitation because they belive us and always happy to buy our product.</p>
                    <p>We provide the product and they trusted us and buy our product without any hagitation because they belive us and always happy to buy.</p>
                </div>
            </div>
            <!-- About Text End -->
            <!-- About Image Start -->
            <div class="col-lg-5 col-md-10">
                <div class="about-image-wrap">
                    <img class="img-full" src="{{asset('asset/images/icon5.png')}}" alt="About Us" />
                </div>
            </div>
            <!-- About Image End -->
        </div>
    </div>
</div>
@endsection
