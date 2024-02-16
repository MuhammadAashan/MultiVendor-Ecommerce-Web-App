@extends('User.masteruser')
@section('content')
<div class="row m-5 text-center">
    <div class="col-12">
        <h1>You are Block by Admin Kindly Again Register Yourself</h1>
        <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                      document.getElementById('logout-form').submit();">
                                                      <i class="fa fa-power-off text-success m-r-5 m-l-5"></i>
                                         {{ __('Click Here') }}
                                     </a>

                                     <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                         @csrf
                                     </form>
    </div>

</div>
@endsection
