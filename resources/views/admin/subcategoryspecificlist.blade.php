@extends('admin.masteradmin')
@section('content')

    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-4  align-items-center">
                @foreach ($maincategory as $cd)
                    <h4 class="page-title">{{ $cd->Name }}</h4>
                @endforeach
                @if ($errors->count() > 0)
                    @foreach ($errors->all() as $message)
                        <p class="text-danger">{{ $message }}</p>
                    @endforeach
                @endif
            </div>

            <div class="col-8 text-right">
                <a href="{{ url('/admin/categorylist') }}" class="btn btn-danger">Back</a>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addsubmodel"><i
                        class="fas fa-plus"></i>SubCategory</button>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <!------------------------------------------------->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-light">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Subcategory</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ($subcategorydata as $cd)
                                    <tbody>

                                        <td>{{ $cd->Name }}</td>
                                        <td>{{ $cd->Description }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary m-1"
                                                data-catid="{{ $cd->Id }}" data-catname="{{ $cd->Name }}"
                                                data-catdesc="{{ $cd->Description }}" data-toggle="modal"
                                                data-target="#editmodel"><i class=" far fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger m-1"
                                                data-catid="{{ $cd->Id }}" data-toggle="modal"
                                                data-target="#demoModal"><i class=" far fa-trash-alt"></i></button>
                                        </td>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---______________________________________________--->


    <!---Add sub model for sub category Add-->
    <form action="/admin/addsubcategory" method="post">
        @csrf
        <div class="modal fade" id="addsubmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add SubCategory</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="form-group">
                            <label for="cat">Choose Category:</label>
                            <select name="cat" id="cat">
                                @foreach ($categorydata as $cd)
                                    <option value="{{ $cd->ID }}">{{ $cd->Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="catname" class="col-form-label">SubCategory Name</label>
                            <input type="text" class="form-control" name="catname" id="catname">

                        </div>
                        <div class="form-group">
                            <label for="catdesc" class="col-form-label">SubCategory Description</label>
                            <textarea class="form-control" name="catdesc" id="catdesc"></textarea>
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

    <!-------------_____________________________________--------->

    <!-------Model for delete button--------->
    <form action="/admin/deletesubcategory" method="post">
        @csrf
        <div class="modal" tabindex="-1" role="alertdialog" id="demoModal">
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
                            <input type="hidden" class="form-control catid" name="catidp" id="catidp">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Yes</button></a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!----------Model for edit button------------>
    <form action="/admin/editsubcateogry" method="post">
        @csrf
        <div class="modal fade" id="editmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit SubCategory</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">

                            <input type="hidden" class="form-control" name="catid" id="catid">
                        </div>
                        <div class="form-group">
                            <label for="catname" class="col-form-label">SubCategory
                                Name</label>
                            <input type="text" class="form-control" name="catname" id="catname">
                        </div>
                        <div class="form-group">
                            <label for="catdesc" class="col-form-label">SubCategory
                                Description</label>
                            <textarea class="form-control" name="catdesc" id="catdesc"></textarea>
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
