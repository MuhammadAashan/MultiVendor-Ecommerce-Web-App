@extends('seller.masterseller')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Seller Dashboard of {{ App\Http\controllers\sellerController::getshopname() }}</h4>
            </div>
        </div>
    </div>

    @if (Auth::user())
        @foreach (Auth::user()->notifications as $notification)
            <p>{{$notification->data['title']}}</p>
            <p> {{$notification->data['message']}}</p>
        @endforeach
    @endif
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-4 mb-2">

                        <div class="bg-dark p-10 text-white text-center">
                            <i class="fa fa-user font-16"></i>
                            <h5 class="m-b-0 m-t-5" id="totalProducts">0</h5>
                            <small class="font-light">Total Products</small>
                        </div>
                    </div>
                    <div class="col-4 mb-2">
                        <div class="bg-dark p-10 text-white text-center">
                            <i class="fa fa-plus font-16"></i>
                            <h5 class="m-b-0 m-t-5" id="totalOrders">0</h5>
                            <small class="font-light">Total Orders</small>
                        </div>
                    </div>
                    <div class="col-4 mb-2">
                        <div class="bg-dark p-10 text-white text-center">
                            <i class=" fas fa-history  font-16"></i>
                            <h5 class="m-b-0 m-t-5" id="pendingOrders">0</h5>
                            <small class="font-light">Pending Orders</small>
                        </div>
                    </div>
                    <div class="col-3 mb-2">
                        <div class="bg-dark p-10 text-white text-center">
                            <i class="fas fa-times  font-16"></i>
                            <h5 class="m-b-0 m-t-5" id="cancelledOrders">0</h5>
                            <small class="font-light">Cancelled Orders</small>
                        </div>
                    </div>
                    <div class="col-3 mb-2">
                        <div class="bg-dark p-10 text-white text-center">
                            <i class="fab fa-gratipay  font-16"></i>
                            <h5 class="m-b-0 m-t-5" id="overallRating">0</h5>
                            <small class="font-light">Overall Product Rating</small>
                        </div>
                    </div>
                    <div class="col-3 mb-2">
                        <div class="bg-dark p-10 text-white text-center">
                            <i class=" fab fa-cc-discover font-16"></i>
                            <h5 class="m-b-0 m-t-5" id="totalSale">Rs: 0</h5>
                            <small class="font-light">Total Sale</small>
                        </div>
                    </div>
                    <div class="col-3 mb-2">
                        <div class="bg-dark p-10 text-white text-center">
                            <i class=" far fa-money-bill-alt  font-16"></i>
                            <h5 class="m-b-0 m-t-5" id="earning"> Rs: 0</h5>
                            <small class="font-light">Total Profit</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div class="row ">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Orders Analytics</h5>
                        <canvas id="pieChart" style="height: 400px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Low Stock Products</h4>
                        <ul id="stockList" style="  list-style-type: none;"></ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row order-2">
            <div class="row">
                <div class="col-12">
                    <h4>Latest Orders</h4>
                </div>
            </div>
            <div class="col-12">
                <!------+++++++++++++++++++++++++++++++++++-->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table class="table table-hover table-light">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Order No</th>
                                        <th>Product_Image</th>
                                        <th>Product Name</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Order_Date</th>
                                        <th>Detail</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="orders_table_body"></tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--<div class="row mt-4">
                                <div class="col-md-12 ">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-md-flex align-items-center">
                                                <div>
                                                    <h4 class="card-title">Site Analysis</h4>
                                                    <h5 class="card-subtitle">Overview of Latest Month</h5>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 ">
                                                <div class="flot-chart">
                                                    <div class="flot-chart-content " id="flot-line-chart"></div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>-->
    </div>

    <!-- Modal -->
    <form action="{{ url('seller/deliverproduct') }}" method="post">
        @csrf
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Product Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>You are Going to deliver Product!</p>
                        <input type="hidden" class="form-input" id="modalProduct" name="prod_Id" readonly>
                        <input type="hidden" class="form-input" id="modalOrderNo" name="order_Id" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"> Done</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('scripts')
    <script>
        $(document).on('click', '#deliveredButton', function() {
            var product = $(this).data('product');
            var orderNo = $(this).data('orderno');
            var pr = $('#modalProduct').val(product);
            var or = $('#modalOrderNo').val(orderNo);
            // Perform your logic here to update the order status or any other action

            // Close the modal
            $('#myModal').modal('hide');
        });



        $(document).ready(function() {

            // Fetch and display the orders using Ajax
            function fetchOrders() {
                $.ajax({
                    url: '{{ url('seller/orderstatusplaced') }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            var orders = response.orders;
                            var tableBody = $('#orders_table_body');
                            tableBody.empty();
                            $.each(orders, function(index, order) {
                                var row = $('<tr></tr>');
                                row.append('<td>' + order.Order_Id + '</td>');
                                row.append('<td><img src="' + '{{ asset('storage') }}/' + order
                                    .CoverImage +
                                    '" alt="Product Image" width="100px" /></td>');
                                row.append('<td>' + order.Name + '</td>');
                                row.append('<td>' + order.Product_Color + '</td>');
                                row.append('<td>' + order.Product_Size + '</td>');
                                row.append('<td>' + order.Quantity + '</td>');
                                row.append('<td>' + order.Purchase_Price + '</td>');
                                row.append('<td>' + order.Order_Date + '</td>');
                                row.append('<td><a href="{{ url('seller/viewdetailorder/') }}' +
                                    '/' + order.Order_Id + '/' + order.Product_Id +
                                    '" class="btn btn-success"><i class="fas fa-eye"></i></a></td>'
                                );
                                row.append(
                                    '<td><button class="btn btn-primary" id="deliveredButton" data-toggle="modal" data-target="#myModal" data-product="' +
                                    order.ID + '" data-orderno="' + order.Order_Id +
                                    '">Delivered</button></td>');
                                tableBody.append(row);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }

            // Call the fetchOrders function initially and on every change
            $('#address_option').change(function() {
                fetchOrders();
            });

            // Fetch orders on page load
            fetchOrders();
        });



        $(document).ready(function() {
            // Make an AJAX request to fetch the data
            function fetchData() {
                $.ajax({
                    url: '{{ url('seller/analytics') }}', // Replace with your server-side endpoint URL
                    type: 'get',
                    success: function(response) {
                        // Update the element values with the retrieved data
                        $('#totalProducts').text(response.data.totalProducts);
                        $('#totalOrders').text(response.data.totalOrders);
                        $('#pendingOrders').text(response.data.pendingOrders);
                        $('#cancelledOrders').text(response.data.cancelledOrders);
                        $('#overallRating').text(response.data.overallRating);
                        $('#totalSale').text('Rs. ' + response.data.totalSale);
                        $('#earning').text('Rs. ' + response.data.earning);



                        // Update the stock-wise products list
                        var stockList = $('#stockList');
                        stockList.empty(); // Clear previous list items

                        response.lowstock.forEach(function(product) {
                            var listItem = $('<li>').append(
                                $('<a>').css({
                                    color: 'red',
                                    cursor: 'pointer' // Set the cursor property to 'pointer' to display a hand cursor
                                })
                                .hover(
                                    function() {
                                        $(this).css('color',
                                        'blue'); // Change color to blue on hover
                                    },
                                    function() {
                                        $(this).css('color',
                                        'red'); // Change color back to red when not hovering
                                    }
                                )
                                .text('Product ID: ' + product.ID + ' & Name: ' + product
                                    .Name + ' (Stock: ' + product.stock + ')')
                                .on('click', function() {
                                    var form = $('<form>').attr({
                                        action: "{{ url('seller/searchproduct') }}",
                                        method: "POST"
                                    });
                                    var csrfToken = $('<input>').attr({
                                        type: "hidden",
                                        name: "_token",
                                        value: "{{ csrf_token() }}"
                                    });
                                    var input = $('<input>').attr({
                                        type: "hidden",
                                        name: "id",
                                        value: product.ID
                                    });
                                    form.append(csrfToken, input).appendTo('body')
                                        .submit();
                                })
                            );


                            stockList.append(listItem);
                        });




                        // Update the pie chart
                        var pieChartCanvas = document.getElementById('pieChart').getContext('2d');
                        var pieChart = new Chart(pieChartCanvas, {
                            type: 'pie',
                            data: {
                                labels: ['Delivered', 'Placed', 'Cancelled'],
                                datasets: [{
                                    data: [response.data.deliveredOrders, response.data
                                        .pendingOrders, response.data
                                        .cancelledOrders
                                    ],
                                    backgroundColor: ['rgba(75, 192, 192, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(255, 99, 132, 0.2)'
                                    ],
                                    borderColor: ['rgba(75, 192, 192, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(255, 99, 132, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(error); // Handle any error that occurs during the AJAX request
                    }
                });
            }

            // Initial fetch
            fetchData();

            // Refresh data every 5 seconds
            setInterval(fetchData, 5000);
        });
    </script>
@endpush
