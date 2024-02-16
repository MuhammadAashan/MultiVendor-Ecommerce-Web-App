@extends('admin.masteradmin')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-6  align-items-center">
                <h4 class="page-title">Admin List</h4>
                @if ($errors->count() > 0)
                    @foreach ($errors->all() as $message)
                        <p class="text-danger">{{ $message }}</p>
                    @endforeach
                @endif
            </div>
            <div class="col-6 text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadmin"><i
                        class="fas fa-plus"></i> New Admin</button>

                <form action="/admin/addadmin" method="post">
                    @csrf
                    <div class="modal fade" id="addadmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">New Admin</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-left">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Name *</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Please enter Name">

                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-form-label">Email *</label>
                                        <input type="text" class="form-control" name="email" id="email"
                                            placeholder="Please enter Email">

                                    </div>
                                    <div class="form-group">
                                        <label for="mobileno" class="col-form-label">MobileNo *</label>
                                        <input type="text" class="form-control" name="mobileno" id="mobileno"
                                            placeholder="Please enter Mobile No">

                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-form-label">Password *</label>
                                        <input type="text" class="form-control" name="password" id="password"
                                            placeholder="Please enter Password">

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">


                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-light Admin-Datatable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>MobileNo</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <form action="/admin/editadmin" method="post">
                                    @csrf
                                    @method('post')
                                    <div class="modal fade" id="editadminmodel" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit
                                                        Admin</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-left">
                                                    <div class="form-group">
                                                        <label for="id" class="col-form-label">AdminID</label>
                                                        <input type="text" class="form-control" name="id"
                                                            id="id">

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name" class="col-form-label">Name</label>
                                                        <input type="text" class="form-control" name="name"
                                                            id="name">

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email" class="col-form-label">Email</label>
                                                        <input type="text" class="form-control" name="email"
                                                            id="email">

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="mobileno" class="col-form-label">MobileNo</label>
                                                        <input type="text" class="form-control" name="mobileno"
                                                            id="mobileno">

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="role">Admin Role</label>
                                                        <select name="role" id="role">
                                                            <option value="mainadmin">Main Admin</option>
                                                            <option value="admin">Admin</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password" class="col-form-label">Password</label>
                                                        <input type="text" class="form-control" name="password"
                                                            id="password">

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
                                <form action="/admin/removeadmin" method="post">
                                    @csrf
                                    <div class="modal" tabindex="-1" role="alertdialog" id="demoModal">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Warning!</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure to remove this admin?</p>
                                                    <div class="form-group">
                                                        <input type="hidden" class="form-control " name="ID"
                                                            id="ID">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Yes</button></a>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
