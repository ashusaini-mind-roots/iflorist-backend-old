<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <title>Cost of Good</title>

    <!-- Bootstrap -->
    <link href="{{asset('gentella/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('gentella/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('gentella/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('gentella/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{asset('gentella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{asset('gentella/vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('gentella/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{asset('gentella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('gentella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet)}}">
    <link href="{{asset('gentella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet)}}">
    <link href="{{asset('gentella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('gentella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{asset('gentella/build/css/custom.min.css')}}" rel="stylesheet">
</head>

<body  class="nav-md" ng-app="app">
{{csrf_field()}}
<div class="container body" >
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="#"></a>
                    {{--@{{rsRole}}--}}
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <!--<div class="profile clearfix">
                  <div class="profile_pic">
                    <img src="gentella/production/images/img.jpg" alt="..." class="img-circle profile_img">
                  </div>
                  <div class="profile_info">
                    <span>Welcome,</span>
                    <h2>John Doe</h2>
                  </div>
                </div>-->
                <!-- /menu profile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>Options</h3>
                        <ul class="nav side-menu">
                            {{--@{{ rsRole }}--}}
                            <li ng-show="rsRole == 'Admin'" class="active"><a><i class="fa fa-table"></i> Roles <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: block">
                                    <li class="current-page"><a href="{{url('/')}}">View roles</a></li>
                                    <!--<li><a href="index2.html">Dashboard2</a></li>
                                    <li><a href="index3.html">Dashboard3</a></li>-->
                                </ul>
                            </li>

                            <li class="active"><a><i class="fa fa-table"></i> Stores <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: block">
                                    <li class="current-page"><a href="{{url('/stores')}}">View stores</a></li>
                                    <!--<li><a href="index2.html">Dashboard2</a></li>
                                    <li><a href="index3.html">Dashboard3</a></li>-->
                                </ul>
                            </li>
                            <li ng-show="rsRole == 'Admin'" class="active"><a><i class="fa fa-table"></i> Users <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: block">
                                    <li ng-show="rsRole == 'Admin'" class="current-page"><a href="{{url('/users')}}">View users</a></li>
                                    <!--<li><a href="index2.html">Dashboard2</a></li>
                                    <li><a href="index3.html">Dashboard3</a></li>-->
                                </ul>
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div ng-controller="logoutController" class="sidebar-footer hidden-small">
                  {{--<a data-toggle="tooltip" data-placement="top" title="Settings">--}}
                    {{--<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>--}}
                  {{--</a>--}}
                  {{--<a data-toggle="tooltip" data-placement="top" title="FullScreen">--}}
                    {{--<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>--}}
                  {{--</a>--}}
                  {{--<a data-toggle="tooltip" data-placement="top" title="Lock">--}}
                    {{--<span class="glyphicon glyphicon-eye-close" aria-hidden="true">Admin</span>--}}
                  {{--</a>--}}
                  <a data-toggle="tooltip" data-placement="top" title="Logout" ng-click="logout()">
                    <span class="glyphicon glyphicon-off" aria-hidden="true" ></span>
                  </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                    <!--<li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <strong>
                                    @if(Session::has('empresa'))
                        {{ Session::get('empresa')  }}
                    @else
                        Usuario desconocido
                    @endif
                            </strong>
                            <span class=" fa fa-angle-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-usermenu pull-right">
                            <li><a href="{!! url('/logout'); !!}"><i class="fa fa-sign-out pull-right"></i> Salir</a></li>
                            </ul>
                        </li>-->

                        <li role="presentation" class="dropdown">
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                <li>
                                    <a>
                                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="text-center">
                                        <a>
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            @yield('content')
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                <a href="#"></a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="{{asset('gentella/vendors/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('gentella/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('gentella/vendors/fastclick/lib/fastclick.js')}}"></script>
<!-- NProgress -->
<script src="{{asset('gentella/vendors/nprogress/nprogress.js')}}"></script>
<!-- Chart.js -->
<script src="{{asset('gentella/vendors/Chart.js/dist/Chart.min.js')}}"></script>
<!-- gauge.js -->
<script src="{{asset('gentella/vendors/gauge.js/dist/gauge.min.js')}}"></script>
<!-- bootstrap-progressbar -->
<script src="{{asset('gentella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('gentella/vendors/iCheck/icheck.min.js')}}"></script>
<!-- Skycons -->
<script src="{{asset('gentella/vendors/skycons/skycons.js')}}"></script>
<!-- Flot -->
<script src="{{asset('gentella/vendors/Flot/jquery.flot.js')}}"></script>
<script src="{{asset('gentella/vendors/Flot/jquery.flot.pie.js')}}"></script>
<script src="{{asset('gentella/vendors/Flot/jquery.flot.time.js')}}"></script>
<script src="{{asset('gentella/vendors/Flot/jquery.flot.stack.js')}}"></script>
<script src="{{asset('gentella/vendors/Flot/jquery.flot.resize.js')}}"></script>
<!-- Flot plugins -->
<script src="{{asset('gentella/vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
<script src="{{asset('gentella/vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
<script src="{{asset('gentella/vendors/flot.curvedlines/curvedLines.js')}}"></script>
<!-- DateJS -->
<script src="{{asset('gentella/vendors/DateJS/build/date.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('gentella/vendors/jqvmap/dist/jquery.vmap.js')}}"></script>
<script src="{{asset('gentella/vendors/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
<script src="{{asset('gentella/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')}}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{asset('gentella/vendors/moment/min/moment.min.js')}}"></script>
<script src="{{asset('gentella/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>


<script src="{{asset('gentella/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('gentella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('gentella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('gentella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('gentella/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('gentella/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('gentella/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('gentella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{asset('gentella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('gentella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('gentella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
<script src="{{asset('gentella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
<script src="{{asset('gentella/vendors/jszip/dist/jszip.min.js')}}"></script>
<script src="{{asset('gentella/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{asset('gentella/vendors/pdfmake/build/vfs_fonts.js')}}"></script>

<!-- Custom Theme Scripts -->
<script src="{{asset('gentella/build/js/custom.min.js')}}"></script>
<script src="{{asset('js/angularjs/angular.min.js')}}"></script>
<script src="{{asset('js/angularjs/angular-resource.min.js')}}"></script>
<script src="{{asset('js/angularjs/ngStorage.min.js')}}"></script>
<script src="{{asset('js/angularjs/app.js')}}"></script>
<script src="{{asset('js/angularjs/services/authentication.service.js')}}"></script>
<script src="{{asset('js/angularjs/controller/logout.js')}}"></script>

@yield('js')



</body>
</html>
