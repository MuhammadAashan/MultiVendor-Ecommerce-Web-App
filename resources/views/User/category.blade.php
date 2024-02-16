@extends('User.masteruser')
@section('content')
<div class="breadcrumb-area my-5">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{url('user/dashboard')}}">Home</a></li>
                <li class="active">Categories</li>
            </ul>
        </div>
    </div>
</div>
    <div class="container text-center">
        <h4 class="text-center text-success">Categories</h4>
        <div class="row my-5 mx-2">

            @foreach ($catdata->groupBy('categoryname') as $category => $subcategories)
            <div class="col-md-4 col-12 px-5">
                <ul>
                    <li><h3><a>{{ $category }}</a></h3></li>
                    <ul>
                        @foreach ($subcategories as $subcategory)
                            <li><a href="{{url('user/category/'.$subcategory->Id.'')}}">{{ $subcategory->Name }}</a>({{$subcategory->totalproducts}})</li>
                        @endforeach
                    </ul>
                </ul>
            </div>
        @endforeach


        </div>
    </div>
@endsection
