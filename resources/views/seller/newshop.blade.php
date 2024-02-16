@extends('User.masteruser')
@section('content')
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
<form action="/seller/newshop" method="POST" class="bg-light p-5">
    @csrf
    <div class="form-group">
        <input type="text" class="form-control" id="sellerId" name="sellerId" value="{{auth()->user()->id}}" readonly >
      </div>
    <div class="form-group">
      <label for="shopname">Name of the Shop</label>
      <input type="text" class="form-control" id="shopname" name="shopname" >
    </div>
    <div class="form-group">
      <label for="shopdesc">Description</label>
      <input type="text" class="form-control" id="shopdesc" name="shopdesc">
      <small class="form-text text-muted">Description should contain information about your Shop</small>
    </div>
    @if ( $errors->count() > 0 )

    @foreach( $errors->all() as $message )
    <p class="text-danger">{{ $message }}</p>
    @endforeach

@endif
    <button type="submit" class="btn btn-primary">Create Shop</button>
  </form>
    </div>
</div>
@endsection
