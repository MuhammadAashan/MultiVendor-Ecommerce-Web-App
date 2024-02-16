<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">



    <meta name="csrf-token" content="{{ csrf_token() }}">



    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ url('favicon.ico')}}" type="image/x-icon">
    <title>EStore multi vendor Ecommerce plateform</title>
    <!-- Custom CSS -->
    <link href="{{asset('asset/libs/flot/css/float-chart.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('dist/css/style.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('asset/extra-libs/multicheck/multicheck.css')}}">
    <link href="{{asset('asset/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">


    <!--Vite(['resources/sass/app.scss', 'resources/js/app.js'])-->
    <!--bootstrap Icon Linkage---->
    <link rel="stylesheet" href="{{url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css')}}">
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
           <!----------top navigation bar---------------->
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="{{url('/admin/dashboard')}}">
                        <!-- Logo icon -->
                        <b class="logo-icon ">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{asset('asset/images/icon7.png')}}" alt="homepage" class="light-logo img-fluid" />

                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <h1 class="pt-4 text-danger">EStore</h1>

                        </span>
                        <!-- Logo icon -->
                        <!-- <b class="logo-icon"> -->
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <!-- <img src="assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

                        <!-- </b> -->
                        <!--End Logo icon -->
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a
                                class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">

                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">


                            <a class="nav-link dropdown-toggle text-light waves-effect waves-dark pro-pic" href="javascript:void(0)"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{ Auth::user()->name }}<i class=" fas fa-chevron-down m-r-5 m-l-5"></i></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <a class="dropdown-item" href="{{url('admin/changepassword')}}"><i
                                        class="fas fa-key m-r-5 m-l-5"></i> Change Password</a>
                                        <div class="dropdown-divider"></div>
                               <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                      <i class="fa fa-power-off m-r-5 m-l-5"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            </div>

                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
<!-- =========================================================================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->


        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar ">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{url('/admin/dashboard')}}" aria-expanded="false"><i
                                    class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class=" fas fa-shopping-basket"></i><span class="hide-menu">Categories</span></a>

                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="{{url('/admin/categorylist')}}" class="sidebar-link">
                                    <i class="bi bi-bag-plus-fill"></i><span class="hide-menu">Main Category
                                        </span></a>
                                 </li>
                                <li class="sidebar-item"><a href="{{url('/admin/subcategory')}}" class="sidebar-link">
                                    <i class="bi bi-card-list"></i><span class="hide-menu">Sub Category
                                        </span></a>
                                </li>

                            </ul>
                        </li>


                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-pencil-alt"></i><span class="hide-menu">Add Product Attributes</span></a>

                            <ul aria-expanded="false" class="collapse  first-level">
                               <!-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{url('/admin/brand')}}" aria-expanded="false"><i class="bi bi-life-preserver"></i><span
                                        class="hide-menu">Brand</span></a></li>-->
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{url('/admin/color')}}" aria-expanded="false"><i class="bi bi-rainbow"></i><span
                                        class="hide-menu">Colors</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{url('/admin/size')}}" aria-expanded="false"><i class="bi bi-aspect-ratio"></i><span
                                        class="hide-menu">Sizes</span></a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{url('/admin/review')}}" aria-expanded="false"><i class="bi bi-chat-left-text-fill"></i><span
                                    class="hide-menu">Review</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{url('/admin/complaint')}}" aria-expanded="false"><i class="bi bi-clipboard-x"></i><span class="hide-menu">Complaints</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{url('/admin/seller')}}" aria-expanded="false"><i class="bi bi-shop-window"></i><span
                                    class="hide-menu">Sellers</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{url('/admin/customer')}}" aria-expanded="false"><i class="bi bi-person-square"></i><span
                                    class="hide-menu">Customers</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{url('/admin/admins')}}" aria-expanded="false"><i class="fas fa-user"></i><span
                                    class="hide-menu">Admins</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{url('/admin/setting')}}" aria-expanded="false"><i class="bi bi-gear-fill"></i><span
                                    class="hide-menu">Settings</span></a></li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            @yield('content')





            <!-- ============================================================== -->











            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                All Rights Reserved by &copy; EStore Multi-Vendor Ecommerce Plateform.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>

    <script src="{{asset('asset/libs/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('asset/libs/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('asset/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('asset/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('asset/extra-libs/sparkline/sparkline.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('dist/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('dist/js/sidebarmenu.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('dist/js/custom.min.js')}}"></script>
    <!--This page JavaScript -->
    <!-- <script src="dist/js/pages/dashboards/dashboard1.js"></script> -->
    <!-- Charts js Files -->
    <script src="{{asset('asset/libs/flot/excanvas.js')}}"></script>
    <script src="{{asset('asset/libs/flot/jquery.flot.js')}}"></script>
    <script src="{{asset('asset/libs/flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('asset/libs/flot/jquery.flot.time.js')}}"></script>
    <script src="{{asset('asset/libs/flot/jquery.flot.stack.js')}}"></script>
    <script src="{{asset('asset/libs/flot/jquery.flot.crosshair.js')}}"></script>
    <script src="{{asset('asset/libs/flot.tooltip/js/jquery.flot.tooltip.min.js')}}"></script>
    <script src="{{asset('dist/js/pages/chart/chart-page-init.js')}}"></script>

    <script src="{{ url('https://cdn.jsdelivr.net/npm/chart.js')}}"></script>

    <script src="{{asset('asset/extra-libs/multicheck/datatable-checkbox-init.js')}}"></script>
    <script src="{{asset('asset/extra-libs/multicheck/jquery.multicheck.js')}}"></script>
    <script src="{{asset('asset/extra-libs/DataTables/datatables.min.js')}}"></script>
    @stack('script')
<!-------edit category model script for editing and sending value to model--------->
   <script>



        $('#editmodel').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var cid = button.data('catid')
  var cname = button.data('catname')
  var cdesc = button.data('catdesc')
  var modal = $(this)
 // modal.find('.modal-title').text('New message to ' + recipient)

  modal.find('.modal-body input').val(cname)
  modal.find('.modal-body textarea').val(cdesc)
  modal.find('.modal-body #catid').val(cid)


})


$('#demoModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var cid = button.data('catid')
  var modal = $(this)


  modal.find('.modal-body input').val(cid)


})


$('#viewseller').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var sid = button.data('sellerid')
  var sname=button.data('sellername')
  var semail=button.data('selleremail')
  var scnic=button.data('sellercnic')
  var smob=button.data('sellermobileno')
  var saddress=button.data('selleraddress')
  var modal = $(this)


  modal.find('.modal-body #sellerid').val(sid)
  modal.find('.modal-body #sellername').val(sname)
  modal.find('.modal-body #sellercnic').val(scnic)
  modal.find('.modal-body #sellermobileno').val(smob)
  modal.find('.modal-body #selleremail').val(semail)
  modal.find('.modal-body #selleraddress').val(saddress)




})


$('#editadminmodel').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var aid = button.data('id')
  var aname=button.data('name')
  var aemail=button.data('email')
  var amob=button.data('mobileno')
  var apassword=button.data('password')
  var arole=button.data('role')
  var modal = $(this)


  modal.find('.modal-body #id').val(aid)
  modal.find('.modal-body #name').val(aname)
  modal.find('.modal-body #mobileno').val(amob)
  modal.find('.modal-body #email').val(aemail)
  modal.find('.modal-body #password').val(apassword)
  modal.find('.modal-body #role').val(arole)




})



$('#branddel').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var bid = button.data('brandid')
  var modal = $(this)
 // modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body #brandid').val(bid)

})
$('#editbrand').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var bid = button.data('brandid')
  var bname = button.data('brandname')

  var modal = $(this)
 // modal.find('.modal-title').text('New message to ' + recipient)

  modal.find('.modal-body #brandname').val(bname)
  modal.find('.modal-body #brandid').val(bid)


})
</script>





<!-----
    Server Side Scripting--->
<script type="text/javascript">

    $(function () {

      var table = $('.Admin-Datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('admin.adminlist') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'email', name: 'email'},
              {data: 'mobileno', name: 'mobileno'},
              {data: 'role', name: 'role'},
              {
                  data: 'action',
                  name: 'action',
                  orderable: true,
                  searchable: true
              },
          ]
      });

    });
  </script>




</body>

</html>
