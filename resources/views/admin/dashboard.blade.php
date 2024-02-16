@extends('admin.masteradmin')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-4 ">
                        <div class="bg-dark p-10 text-white text-center">
                            <i class="fas fa-tags m-b-5 font-16"></i>
                            <h5 class="m-b-0 m-t-5"  id="totalProducts">0</h5>
                            <small class="font-light">Total Products</small>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="bg-dark p-10 text-white text-center">
                            <i class="fa fa-tag m-b-5 font-16"></i>
                            <h5 class="m-b-0 m-t-5" id="totalOrders">0</h5>
                            <small class="font-light">Total Orders</small>
                        </div>
                    </div>
                    <div class="col-4 ">
                        <div class="bg-dark p-10 text-white text-center">
                            <i class="fas fa-times  font-16"></i>
                            <h5 class="m-b-0 m-t-5" id="cancelledOrders">0</h5>
                            <small class="font-light">Cancelled Orders</small>
                        </div>
                    </div>
                    <div class="col-3 mt-3">
                        <div class="bg-dark p-10 text-white text-center">
                            <i class="fa fa-table m-b-5 font-16"></i>
                            <h5 class="m-b-0 m-t-5" id="pendingOrders">0</h5>
                            <small class="font-light">Pending Orders</small>
                        </div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="bg-dark p-10 text-white text-center">
                            <i class=" fas fa-dollar-sign m-b-5 font-16"></i>
                            <h5 class="m-b-0 m-t-5" id="totalSale">$12,323,090</h5>
                            <small class="font-light">Total Revenue Generated on plateform</small>
                        </div>
                    </div>
                    <div class="col-3 mt-3">
                        <div class="bg-dark p-10 text-white text-center">
                            <i class="far fa-money-bill-alt m-b-5 font-16"></i>
                            <h5 class="m-b-0 m-t-5" id="earning">$344</h5>
                            <small class="font-light">Admins profit</small>
                        </div>
                    </div>

                    <div class="col-6 mt-3 ">
                        <div class="bg-dark p-10 text-white text-center">
                            <i class="fas fa-users m-b-5 font-16"></i>
                            <h5 class="m-b-0 m-t-5" id="totalSellers">0</h5>
                            <small class="font-light">Total Sellers</small>
                        </div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="bg-dark p-10 text-white text-center">
                            <i class="fas fa-user m-b-5 font-16"></i>
                            <h5 class="m-b-0 m-t-5" id="totalUsers">0</h5>
                            <small class="font-light">Total Users</small>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->

            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Orders Analytics</h5>
                        <canvas id="pieChart" style="height: 400px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4> Products</h4>
                        <ul id="ratedproduct" style="  list-style-type: none;"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            // Make an AJAX request to fetch the data
            function fetchData() {
                $.ajax({
                    url: '{{ url('admin/analytics') }}', // Replace with your server-side endpoint URL
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
                        $('#totalUsers').text(response.data.totalCustomers);
                        $('#totalSellers').text(response.data.totalSellers);


                        var ratedProductList = $('#ratedproduct');
                ratedProductList.empty();

                $.each(response.products, function(index, product) {
                    var listItem = $('<li>').html(product.Name + ' (Seller: ' + product.sellerName + ') with Average Rating of <i class="fas fa-star"></i> ' + product.avgRating);
                    ratedProductList.append(listItem);
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
