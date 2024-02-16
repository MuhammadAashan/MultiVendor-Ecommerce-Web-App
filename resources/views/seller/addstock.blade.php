@extends('seller.masterseller')
@section('content')


    <div class="page-breadcrumb">
        <div class="row ">
            <div class="col-12 mb-2  align-items-center">
                <h4 class="page-title">Add Stock</h4>
                @if ($errors->count() > 0)
                    @foreach ($errors->all() as $message)
                        <p class="text-danger">{{ $message }}</p>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card ">
                @if (empty($productsubcategory))
                <form action="/seller/searchproduct" method="post" enctype="multipart/form-data" class="m-3">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="id">Product ID:</label>
                                <input type="text" class="form-control" id="id" name="id"
                                    placeholder="Enter product Id to add stock">
                            </div>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-dark mt-4" type="submit"><i
                                    class=" fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
                @else
                <form action="/seller/addstock" method="post" enctype="multipart/form-data" class="m-3">
                    @csrf

                    <div class="form-group">
                        <label for="id">Product ID:</label>
                        <input type="text" class="form-control" id="id" name="id"
                            placeholder="Enter product Id to add stock" value="{{$id}}">
                        <div class="invalid-feedback">Product Name Can't Be Empty</div>
                    </div>
                    <div class="form-group">
                        <label for="size">Choose Size</label>
                        <select name="size" id="size">
                            @if ($sizesubcategory=="")
                            <option value="Null">No size Available</option>
                            @else
                            @foreach ($sizesubcategory as $cd )
                            <option value="{{$cd->Name}}">{{$cd->Name}}</option>
                            @endforeach

                            @endif

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="color">Choose Color</label>
                        <select name="color" id="color">
                            @if ($colorsubcategory=="")
                            <option value="null">No color Available</option>
                            @else
                            @foreach ($colorsubcategory as $cd )
                            <option value="{{$cd->Name}}">{{$cd->Name}}</option>
                            @endforeach

                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="supplier">Choose Supplier</label>
                        <select name="supplier" id="supplier">
                            @if ($supplierdata=="")
                            <option>No supplier Available</option>
                            @else
                            @foreach ($supplierdata as $cd )
                            <option value="{{$cd->Id}}">{{$cd->Name}}</option>
                            @endforeach

                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Product Quantity</label>
                        <input type="text" class="form-control" id="quantity" name="quantity"
                            placeholder="Enter product quantity" required>
                        <div class="invalid-feedback">Product Name Can't Be Empty</div>
                    </div>


                    <button class="btn btn-dark mt-5 mx-auto d-block" type="submit">Add
                        Stock</button>
                </form>

                @endif


                </div>
            </div>
        </div>
    </div>
@endsection
