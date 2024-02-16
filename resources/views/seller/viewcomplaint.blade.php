@extends('seller.masterseller')
@section('content')
@if (count($data)=="")
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">No data found!</h4>
        </div>
    </div>
</div>
@else
@foreach ($data as $cd)
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-6 d-flex no-block align-items-center">
            <h4 class="page-title"> Complaint ID: {{ $cd->Id }}</h4>
        </div>
        <div class="col-6 text-right"><a href="{{url('seller/complaint')}}" class="btn btn-primary">Back</a></div>
    </div>
</div>

<div class="container-fluid">
    <div class="row ">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12 border-right">
                            <h4 class="text-danger">Complaint Description: {{ $cd->compdesc }}</h4>
                            <br>
                            <p>Complaint Date: {{ $cd->Creation_at }}</p>
                        </div>

                        <div class="col-md-6 col-12">
                            <h4 class="text-primary">Product Name: <span class="text danger">{{ $cd->prodname }}</span></h4>
                            <p>Product Description: <span class="text-dark">{{$cd->proddesc}}</span></p>
                            <img src="{{ asset('storage/' . $cd->CoverImage) }}" width="50%" alt="Complained product image unable to load">
                            <hr>
                            <h4 class="text-dark">Seller ID: {{ $cd->sellerid }}</h4>
                            <h5 class="text-dark">Seller Name: {{ $cd->sellername }}</h5>
                            <h5 class="text-dark">Product Price: {{ $cd->sellercont }}</h5>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
@endsection
