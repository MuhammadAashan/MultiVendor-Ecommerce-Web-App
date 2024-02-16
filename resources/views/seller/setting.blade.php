@extends('seller.masterseller')
@section('content')
<!-- ============================================================== -->
<div class="page-breadcrumb">
    @if ( $errors->count() > 0 )

    @foreach( $errors->all() as $message )
    <p class="text-danger">{{ $message }}</p>
    @endforeach

    @endif
</div>

<!-- ============================================================== -->

<div class="container">
    <div class="row">
        <div class="col-12 text-right">
            <a href="{{url('seller/editshop')}}" data-toggle="modal" data-target="#editshop" class="btn btn-primary mb-2">Edit Shop</a>
        </div>
        <div class="col-12">
            <!-- Form START -->
            <form action="{{url('/seller/updateseller')}}" method="post" class="mb-5">
                @csrf
                <div class="row mb-2 bg-light">
                    <!-- Contact detail -->
                    <div class="col-12 mb-md-0">
                        <div class="py-5 rounded">
                            <h4 class="mb-4 mt-0">Contact detail</h4>
                            <hr>
                            <div class="row">
                                <!-- First Name -->


                                <input type="hidden" class="form-control" id="id" name="id" placeholder=""
                                    aria-label="First name" value="{{Auth::user()->id}}">
                                <div class="col-md-6">
                                    <label class="form-label">Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder=""
                                        aria-label="First name" value="{{Auth::user()->name}}">
                                </div>
                                <!-- Mobile number -->
                                <div class="col-md-6">
                                    <label class="form-label">Mobile number *</label>
                                    <input type="text" class="form-control" id="mobileno" name="mobileno" placeholder=""
                                        aria-label="Phone number" value="{{Auth::user()->mobileno}}">
                                </div>
                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="inputEmail4" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{Auth::user()->email}}">
                                </div>

                                <div class="col-md-6">
                                    <label for="inputEmail4" class="form-label">CNIC *</label>
                                    <input type="text" class="form-control" id="cnic" name="cnic"
                                        value="{{Auth::user()->cnic}}">
                                </div>
                                <!-- Skype -->
                                <div class="col-md-6">
                                    <label class="form-label">Address *</label>
                                    <input type="text" class="form-control" placeholder="" id="address" name="address"
                                        aria-label="address" value="{{Auth::user()->address}}">
                                </div>
                            </div>
                        </div> <!-- Row END -->
                    </div>
                </div>

                <!-- Row END -->
                <div class="col-12">

                    <button type="submit" class="btn btn-primary ">Save Changes</button>

                </div>

            </form>


        </div>

    </div>
</div>

<!--------------------------------------------------------->
<form action="/seller/editshop" method="post">
    @csrf
    <div class="modal fade" id="editshop" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit
                        Shop</h5>
                    <button type="button" class="close"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                    <div class="form-group">
                        <input type="hidden" class="form-control"
                            name="id" id="id" value="{{Auth::user()->id}}">
                    </div>
                    <div class="form-group">
                        <label for="name"
                            class="col-form-label">Shop Name</label>
                        <input type="text" class="form-control"
                            name="name" id="name">

                    </div>
                    <div class="form-group">
                        <label for="mobileno"
                            class="col-form-label">Shop Description</label>
                        <input type="text" class="form-control"
                            name="desc" id="desc">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save
                        Changes</button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
