@extends('User.masteruser')
@section('content')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ url('user/dashboard') }}">Home</a></li>
                    <li><a href="{{ url('user/myorders') }}">MyOrders</a></li>
                    <li class="active">view Order</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-10 offset-1">
                <div class="card mb-4">
                    <div class="card-body">
                        <a href="{{ url('user/myorders') }}" class="btn text-light" style="background: green;">Back</a>
                        <div class="text-right mb-3">
                            @php
                                $prevOrderId = null; // Variable to store the previous Order_Id
                            @endphp
                            @foreach ($orderDetail as $cd)
                                @if ($cd->Order_Id != $prevOrderId)
                                    <h5>Order No: {{ $cd->Order_Id }}</h5>
                                    <h6>Order Date: {{ \Carbon\Carbon::parse($cd->Order_Date)->format('Y-F-d h:i A') }}</h6>
                                    @php
                                        $prevOrderId = $cd->Order_Id; // Update the previous Order_Id
                                    @endphp
                                @endif
                            @endforeach
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-tranparent">
                                <thead>
                                </thead>
                                <tbody>
                                    @foreach ($orderDetail as $cd)
                                        <tr>
                                            <div class="col-md-6 col-12">
                                                <td class="text-center">
                                                    <a href="{{ url('user/productdetail/' . $cd->ID) }}">
                                                        <img width="150px" src="{{ asset('storage/' . $cd->CoverImage) }}"
                                                            alt="{{ $cd->CoverImage }}" class="img-fluid">
                                                    </a>
                                                </td>
                                                <td>Product No: {{ $cd->ID }}</td>

                                                <td>{{ $cd->Name }}</td>
                                                <td>Color: {{ $cd->Product_Color }} & Size: {{ $cd->Product_Size }}</td>
                                                <td>Quantity: {{ $cd->Quantity }}</td>
                                                <td>Status: {{ $cd->Status }}</td>
                                            </div>
                                            <div>
                                                <td>
                                                    @if ($cd->Status == 'placed')
                                                        @php
                                                            $today = date('Y-m-d');
                                                            $orderDate = date('Y-m-d', strtotime($cd->Order_Date));
                                                        @endphp

                                                        @if ($today == $orderDate)
                                                            <a href="{{ url('user/cancelorder/' . $cd->Order_Id . '/' . $cd->ID . '') }}"
                                                                class="btn text-light bg-danger">Cancel Order</a>
                                                        @else
                                                            <p>Delivery Pending</p>
                                                        @endif
                                                    @endif
                                                    @if ($cd->Status == 'cancelled')
                                                        <p class="text-danger">Cancelled</p>
                                                    @endif

                                                    @if ($cd->Status == 'delivered')
                                                        @if (empty($cd->Rating))
                                                            <button type="button" class="btn btn-primary" id="ratingtoggle"
                                                                data-id="{{ $cd->ID }}"
                                                                data-orderid="{{ $cd->Order_Id }}" data-toggle="modal"
                                                                data-target="#ratingModal">Rate
                                                                Product</button>
                                                        @else
                                                            <div class="rating-box ">
                                                                <ul class="rating rating-with-review-item">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        @if ($i <= $cd->Rating)
                                                                            <li><i class="fa fa-star"></i></li>
                                                                        @elseif(empty($cd->Rating))
                                                                            <li><i class="fa fa-star-o"></i></li>
                                                                        @else
                                                                            <li><i class="fa fa-star-o"></i></li>
                                                                        @endif
                                                                    @endfor
                                                                    @if (empty($cd->Rating))
                                                                        <li>
                                                                            <p>(0)</p>
                                                                        </li>
                                                                    @else
                                                                        <li>
                                                                            <p>({{ $cd->Rating }})</p>
                                                                        </li>
                                                                    @endif

                                                                </ul>
                                                            </div>
                                                            <p>Feedback : {{ $cd->Feedback }}</p>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($cd->Status == 'delivered')
                                                        @if (count($complaint) > 0)
                                                            @foreach ($complaint as $com)
                                                                <p>Complaint: {{ $com->Description }} on
                                                                    Dated:

                                                                    {{ \Carbon\Carbon::parse($com->Creation_at)->format('Y-F-d h:i A') }}
                                                                </p>
                                                            @endforeach
                                                        @else
                                                            <button type="button" class="btn btn-danger" id="complaintbtn"
                                                                data-prodid="{{ $cd->ID }}" data-toggle="modal"
                                                                data-target="#complaintModal">Complaint</button>
                                                        @endif
                                                    @endif
                                                </td>
                                            </div>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!----------------------model for rate product-------------->
    <form action="{{ route('user.rateproduct') }}" method="POST">
        @csrf
        <div class="modal" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="ratingModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ratingModalLabel">Rate Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="rating">Rating:</label>
                                <select class="form-control" id="rating" name="rating">
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="5">5 Stars</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="feedback">Feedback:</label>
                                <textarea class="form-control" id="feedback" name="feedback" rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="submitRatingBtn" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!----------------complaint Model------------------->
    <form action="{{ url('user/docomplaint') }}" method="POST">
        @csrf
        <div class="modal" id="complaintModal" tabindex="-1" role="dialog" aria-labelledby="complaintModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="complaintModalLabel">Submit Complaint</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="complaintMessage">Message</label>
                                <textarea class="form-control" id="complaintMessage" name="complaint" rows="5"
                                    placeholder="Enter your complaint message"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="submitComplaintBtn" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#ratingtoggle').click(function() {
                var productId = $(this).data('id');
                var orderId = $(this).data('orderid');

                $('#submitRatingBtn').click(function(e) {
                    e.preventDefault();

                    var rating = $('#rating').val();
                    var feedback = $('#feedback').val();

                    // Send the data to the server using AJAX
                    $.ajax({
                        url: '{{ url('user/rateproduct') }}',
                        method: 'POST',
                        data: {
                            productId: productId,
                            orderId: orderId,
                            rating: rating,
                            feedback: feedback,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Handle the success response
                            // Close the modal after successful submission
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            // Handle the error response
                        }
                    });
                });
            });
            $('#complaintbtn').click(function() {
                var productId = $(this).data('prodid');

                $('#submitComplaintBtn').click(function(e) {
                    e.preventDefault();

                    // Get the form data
                    var complaintMessage = $('#complaintMessage').val();
                    //var productId = $(this).data('id');

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    // Set the CSRF token in the AJAX headers
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    // Send the data to the server using AJAX
                    $.ajax({
                        url: '{{ url('user/docomplaint') }}',
                        method: 'POST',
                        data: {
                            id: productId,
                            complaint: complaintMessage
                        },
                        success: function(response) {
                            // Handle the success response
                            if (response.success) {
                                // Complaint submitted successfully
                                // Perform any desired action
                                location.reload();
                                console.log('Complaint submitted successfully');
                            } else {
                                // Complaint already exists
                                // Perform any desired action
                                console.log('Complaint already exists');
                            }

                            // Close the modal after successful submission
                            $('#complaintModal').modal('hide');
                        },
                        error: function(xhr, status, error) {
                            // Handle the error response
                            console.error(error);
                        }
                    });
                });
            });
        });
    </script>
@endpush
