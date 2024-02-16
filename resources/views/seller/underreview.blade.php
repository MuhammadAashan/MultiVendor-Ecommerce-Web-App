@extends('User.masteruser')
@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="container m-5 text-center">
                <div class="row">
                    <div class="col-12 m-5 center">
                        <h1>Please Wait Until Approve.</h1>
                        <h1>Your Shop is In UnderReview Will update you later</h1>
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
            </div>
        </div>
    @endsection
