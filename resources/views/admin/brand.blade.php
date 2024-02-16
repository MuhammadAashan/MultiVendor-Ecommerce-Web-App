@extends('admin.masteradmin')
@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-4  align-items-center">
                <h4 class="page-title">brand List</h4>
                @if ($errors->count() > 0)
                    @foreach ($errors->all() as $message)
                        <p class="text-danger">{{ $message }}</p>
                    @endforeach
                @endif
            </div>

            <div class="col-8 text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addmodel"><i
                        class="fas fa-plus"></i> Brand</button>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row ">

            <div class="col-12">
                <table class="table table-bordered data-table text-center bg-light overflow-auto">
                    <thead class="thead-dark">
                        <tr>
                            <th>Brand Id</th>
                            <th>Brand Name</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    @foreach ($brand as $cd)
                        <tbody>
                            <td>{{ $cd->ID }}</td>
                            <td>{{ $cd->Name }}</td>

                            <td>
                                <button type="button" class="btn btn-primary m-1" data-brandid="{{ $cd->ID }}"
                                    data-brandname="{{ $cd->Name }}" data-toggle="modal" data-target="#editbrand"><i
                                        class=" far fa-edit"></i></button>
                                <button type="button" class="btn btn-danger m-1" data-brandid="{{ $cd->ID }}"
                                    data-toggle="modal" data-target="#branddel"><i class=" far fa-trash-alt"></i></button>
                                <!---------- category Delete button ---------->
                                <!--<a href="{url('/delete',$cd->cat_id)}}" class="btn btn-danger my-1"><i class=" far fa-trash-alt"></i></a>-->
                            </td>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <!-------------_____________________________---------->

    <!----------------------------model to add brand -------------------->

    <form action="/admin/addbrand" method="post">
        @csrf
        <div class="modal fade" id="addmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Brand</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="form-group">
                            <label for="catname" class="col-form-label">Brand Name</label>
                            <input type="text" class="form-control" name="brandname" id="brandname">

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
    <!-------------------------------->

    <!-------Model for delete button--------->
    <form action="/admin/deletebrand" method="post">
        @csrf
        <div class="modal" tabindex="-1" role="alertdialog" id="branddel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Warning!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete this Category?</p>
                        <div class="form-group">
                            <input type="hidden" class="form-control catid" name="brandid" id="brandid">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"class="btn btn-primary">Yes</button></a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!----------Model for edit button------------>
    <form action="/admin/editbrand" method="post">
        @csrf
        <div class="modal fade" id="editbrand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit brand</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">

                            <input type="hidden" class="form-control" name="brandid" id="brandid">
                        </div>
                        <div class="form-group">
                            <label for="brandname" class="col-form-label">Brand Name</label>
                            <input type="text" class="form-control" name="brandname" id="brandname">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


@endsection

