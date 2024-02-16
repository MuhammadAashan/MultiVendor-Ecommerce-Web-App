@extends('seller.masterseller')
@section('content')

    <!-----------Model for Password changes------------------>
    <form action="/seller/changepassword" method="post" class="m-4 py-4">
        @csrf
        <h5>Change Password</h5>
        @if ( $errors->count() > 0 )

        @foreach( $errors->all() as $message )
        <p class="text-danger">{{ $message }}</p>
        @endforeach

    @endif
        <div class="form-group">
            <input type="hidden" class="form-control" name="id" id="id" value="{{ Auth::user()->id }}">
        </div>
        <div class="form-group">
            <label for="oldpassword" class="col-form-label">Old Password</label>
            <input type="text" class="form-control" name="oldpassword" id="oldpassword"
                placeholder="Please Enter Old Password">
        </div>
        <div class="form-group">
            <label for="newpassword" class="col-form-label">New Password</label>
            <input type="text" class="form-control" name="newpassword" id="newpassword"
                placeholder="Please Enter New Password">
        </div>
        <div class="form-group">
            <label for="conpassword" class="col-form-label">Confrim New Password</label>
            <input type="text" class="form-control" name="conpassword" id="conpassword"
                placeholder="Confrim New Password">
        </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Change Password</button>
        </div>

    </form>

@endsection
