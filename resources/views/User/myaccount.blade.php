@extends('User.masteruser')
@section('content')

<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{url('user/dashboard')}}">Home</a></li>
                <li class="active">My Account</li>
            </ul>
        </div>

    </div>
</div>

<div class="container">
    <div class="row">

            <div class="col-md-8 offset-md-2 my-4">
                <div class="card p-5">
                <h2>User Details</h2>
                <form>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name"  value="{{auth()->user()->name}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email </label>
                        <input type="email" class="form-control" id="email"  value="{{auth()->user()->email}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <input type="tel" class="form-control" id="mobile" value="{{auth()->user()->mobileno}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="cnic">CNIC</label>
                        <input type="text" class="form-control" id="cnic" value="{{auth()->user()->cnic}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" value="{{auth()->user()->address}}" readonly>
                    </div>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editModal">Edit Details</button>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#changePasswordModal">Change Password</button>
                    @if ( $errors->count() > 0 )

                    @foreach( $errors->all() as $message )
                    <p class="text-danger">{{ $message }}</p>
                    @endforeach

                @endif
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Details Modal -->
<form action="{{url('user/editmyaccount')}}" method="post">
    @csrf
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="form-group">
                        <label for="edit-name"></label>
                        <input type="hidden" class="form-control" id="id" name="id"  value="{{auth()->user()->id}}" readonly>
                        <input type="text" class="form-control" id="edit-name" name="name" value="{{auth()->user()->name}}" readonly>
                        <p class="text-danger">can't editable</p>
                    </div>
                    <div class="form-group">
                        <label for="edit-email">Email</label>
                        <input type="email" class="form-control" id="edit-email" name="email" value="{{auth()->user()->email}}" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-mobile">Mobile Number</label>
                        <input type="tel" class="form-control" id="edit-mobile" name="mobileno" value="{{auth()->user()->mobileno}}" required>
                    </div>
                    <div class="form-group">
                        <label for="cnic">CNIC</label>
                        <input type="tel" class="form-control" id="cnic" name="cnic" value="{{auth()->user()->cnic}}" readonly>
                        <p class="text-danger">can't editable</p>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{auth()->user()->address}}" required>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save Changes</button>
            </div>
        </div>
    </div>
</div>
</form>

<!-- Change Password Modal -->
<form action="{{url('user/changepassword')}}" method="post">
    @csrf
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="form-group">
                        <label for="current-password">Current Password</label>
                        <input type="hidden" class="form-control" id="id" name="id"  value="{{auth()->user()->id}}" readonly>
                        <input type="text" class="form-control" name="currentpassword" id="current-password" required>
                    </div>
                    <div class="form-group">
                        <label for="new-password">New Password</label>
                        <input type="text" class="form-control" name="newpassword" id="new-password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm New Password</label>
                        <input type="text" class="form-control" name="confrimnewpassword" id="confirm-password" required>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save Changes</button>
            </div>
        </div>
    </div>
</div>
</form>

@endsection
