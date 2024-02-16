@extends('seller.master')
@section('reregister')
<div class="container">
    <div class="row m-4 " style="border-radius:62px ; background-color:gainsboro;">
        <div class="col-md-6 col-12 mt-5">
            <img src="{{asset('Assets/icon5.png')}}" alt="" class="img-fluid m-4 mt-5 ">
        </div>
        <div class="col-md-6 col-12 text-center p-5" style="border-top-right-radius: 60px; border-bottom-right-radius: 60px;">
            <div>
<form class="p-5" method="post" action="/seller/Re-Register">
    @csrf
    <h3>Welcome to EStore!</h3>
    <h6 class="pb-5">SignUp as Seller Account</h6>
    <div class="row">
              <div class="col-12">
            <div class="form-outline mb-4">
                <input type="hidden" id="id" name="id" class="form-control rounded-pill" value="{{$sellerdata->ID}}" />
            </div>
        </div>
        <div class="col-6">
            <div class="form-outline mb-4">
                <input type="text" id="name" name="name" class="form-control rounded-pill" value="{{$sellerdata->Name}}" />
            </div>
        </div>
        <div class="col-6">
            <div class="form-outline mb-4">
                <input type="text" id="contact" name="contact" class="form-control rounded-pill" value="{{$sellerdata->MobileNo}}" />
            </div>
        </div>
    </div>

    <div class="form-outline mb-4">
        <input type="email" id="email" name="email" class="form-control rounded-pill" value="{{$sellerdata->Email}}" />
    </div>
    <div class="form-outline mb-4">
        <input type="text" id="cnic" name="cnic" class="form-control rounded-pill" value="{{$sellerdata->CNIC}}" />
    </div>
    <div class="form-outline mb-4">
        <input type="text" id="address" name="address" class="form-control rounded-pill" value="{{$sellerdata->Address}}" />
    </div>

    <div class="form-outline mb-4">
        <input type="password" id="password" name="password" class="form-control rounded-pill" placeholder="Password" />
    </div>
    @if ( $errors->count() > 0 )

    @foreach( $errors->all() as $message )
    <p class="text-danger">{{ $message }}</p>
    @endforeach

@endif
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="checkbox" name="checkbox">
        <label class="form-check-label" for="exampleCheck1">Accept <a href="#">Term and Condition</a></label>
    </div>
    <div class="text-center pt-1  pb-1 mr-5 ml-5">
        <button class="btn text-light rounded-pill mb-3" style="background-color: black;" type="submit">Update SignUp Details</button>
    </div>
</form>
</div>
</div>
</div>
</div>
@endsection

