@extends('seller.masterseller')
@section('content')

<div class="page-breadcrumb">
    <div class="row ">
        <div class="col-6 mb-2  align-items-center">
            <h4 class="page-title">Product list</h4>
            @if ($errors->count() > 0)
                @foreach ($errors->all() as $message)
                    <p class="text-danger">{{ $message }}</p>
                @endforeach
            @endif
        </div>

        <div class="col-6 mb-2 text-right">
            <a class="btn btn-primary" href="{{ url('/seller/addproductform') }}"><i class="fas fa-plus"></i></a>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row ">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-5">
                        <form method="GET" action="{{ url('seller/product') }}">
                            <div class="input-group  bg-dark p-1">
                                <input type="text" id="search" name="search" placeholder="Type & Enter"
                                    value="{{ Session::get('search') }}" class="form-control ">
                                <div class="input-group-append">
                                    <button class="input-group-text bg-light" id="basic-addon4"><i
                                            class=" fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-hover table-light">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Product_Id</th>
                                    <th>Product Name</th>
                                    <th>Image</th>
                                    <th>Stock</th>
                                    <th>Price</th>
                                    <th>View Variations</th>
                                    <th>Add Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($productdata)>0)
                                @foreach ($productdata as $cd)
                                    <tr>
                                        <td>{{ $cd->ID }}</td>
                                        <td>{{ $cd->Name }}</td>
                                        <td><img src="{{ asset('storage/' . $cd->CoverImage) }}" alt="image"
                                                width="100px" /></td>
                                        @if($cd->stock<=25 && $cd->stock>0)
                                            <td class="text-light bg-danger text-center">Low stock</td>
                                        @elseif($cd->stock=="")
                                            <td class="text-light bg-danger text-center">No stock</td>
                                        @else
                                            <td>{{ $cd->stock }}</td>
                                        @endif
                                        <td>{{ $cd->Price }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary m-1 view-variations-btn" id="view-variations-btn"
                                                data-productid="{{ $cd->ID }}" data-toggle="modal"
                                                data-target="#viewvariation"><i class="fas fa-eye"></i></button>
                                        </td>
                                        <td>
                                            <form action="/seller/searchproduct" method="post">
                                                @csrf
                                                <input type="hidden" class="form-control catid" name="id"
                                                    id="id" value="{{ $cd->ID }}">
                                                <input type="hidden" class="form-control catid" name="Category"
                                                    id="Category" value="{{ $cd->Subcategory_Id }}">
                                                <button type="submit" class="btn btn-primary m-1"><i
                                                        class="fas fa-plus"></i></button>
                                            </form>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary m-1"
                                                href="{{ url('seller/editproduct/'.$cd->ID.'') }}"><i
                                                    class="far fa-edit"></i></a>

                                            <button type="button" class="btn btn-danger m-1 delete-product-btn"
                                                data-catid="{{ $cd->ID }}" data-toggle="modal"
                                                data-target="#demoModal"><i class="far fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                <tr><p>No Product Found! please add product</p></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<form action="/seller/deleteproduct" method="post">
    @csrf
    <div class="modal" tabindex="-1" role="dialog" id="demoModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Warning!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Product?</p>
                    <div class="form-group">
                        <input type="hidden" class="form-control catid" name="catidp" id="catidp">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- View Variation Modal -->
<div class="modal" tabindex="-1" role="dialog" id="viewvariation">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Variations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-light text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        // Retrieve variations and update the modal body
        $(document).on('click', '#view-variations-btn', function() {
            var productId = $(this).data('productid');

            // Send an AJAX request to retrieve variations for the product
            $.ajax({
                url: '/seller/getvariations/' + productId,
                type: 'GET',
                success: function(response) {
                    var variations = response.variations;
                    var modalBody = $('#viewvariation').find('.modal-body');

                    // Clear the previous variations
                    modalBody.find('tbody').empty();

                    // Populate the modal body with variations
                    if (variations.length > 0) {
                        variations.forEach(function(variation) {
                            var row = '<tr>' +
                                '<td>' + variation.Color + '</td>' +
                                '<td>' + variation.Size + '</td>' +
                                '<td>' + variation.Quantity + '</td>' +
                                '<td>' +
                                '<button type="button" class="btn btn-danger delete-variation-btn" data-variationid="' + variation.Id + '"><i class="far fa-trash-alt"></i></button>' +
                                '</td>' +
                                '</tr>';

                            modalBody.find('tbody').append(row);
                        });
                    } else {
                        var emptyRow = '<tr><td colspan="4">No variations found</td></tr>';
                        modalBody.find('tbody').append(emptyRow);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });

        // Delete Variation button click event
        $(document).on('click', '.delete-variation-btn', function() {
    var variationId = $(this).data('variationid');
    var confirmation = confirm('Are you sure you want to delete this variation?');

    if (confirmation) {
        // Send an AJAX request to delete the variation
        $.ajax({
            url: '/seller/deletevariation/' + variationId,
            type: 'get',
            success: function(response) {
                // Handle the success response
                console.log(response.message);
                if (response.success) {
                    // Redirect back to the previous page
                    location.reload();
                } else {
                    // Display an error message or handle the unsuccessful deletion
                }

                // Refresh the modal or update the UI as needed
            },
            error: function(xhr, status, error) {
                // Handle the error response
                console.log('Error deleting variation:', error);
            }
        });
    }
});

    </script>
@endpush
