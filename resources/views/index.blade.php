<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <title>Tienda!</title>

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
    <style>
        .form-signin
        {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }
        .form-signin .form-signin-heading, .form-signin .checkbox
        {
            margin-bottom: 10px;
        }
        .form-signin .checkbox
        {
            font-weight: normal;
        }
        .form-signin .form-control
        {
            position: relative;
            font-size: 16px;
            height: auto;
            padding: 10px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        .form-signin .form-control:focus
        {
            z-index: 2;
        }
        .form-signin input[type="text"]
        {
            margin-bottom: -1px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .form-signin input[type="password"]
        {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
        .account-wall
        {
            margin-top: 20px;
            padding: 40px 0px 20px 0px;
            background-color: #f7f7f7;
            -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        }
        .login-title
        {
            color: #555;
            font-size: 18px;
            font-weight: 400;
            display: block;
        }
        .profile-img
        {
            width: 96px;
            height: 96px;
            margin: 0 auto 10px;
            display: block;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            border-radius: 50%;
        }
        .need-help
        {
            margin-top: 10px;
        }
        .new-account
        {
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body ng-app="app">

<div ng-controller="loginController" class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            {{--<h1 class="text-center login-title">Sign in to continue to Bootsnipp</h1>--}}
            <div class="account-wall">
                <img class="profile-img" src=""
                     alt="">
                <form name="frmLogin" class="form-signin"  ng-submit="frmLogin.$valid && login()" novalidate>
                    <input type="text" class="form-control" placeholder="Email" ng-model="username" required autofocus>
                    <input type="password" class="form-control" placeholder="Password" ng-model="password" required>
                    <button ng-disabled="frmLogin.$invalid" class="btn btn-primary">Login</button>
                    {{--<button class="btn btn-lg btn-primary btn-block" type="submit">--}}
                        {{--Login</button>--}}
                    {{--<label class="checkbox pull-left">--}}
                        {{--<input type="checkbox" value="remember-me">--}}
                        {{--Remember me--}}
                    {{--</label>--}}
                    {{--<a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>--}}
                    <div ng-if="error" class="alert alert-danger">@{{error}}</div>
                </form>
            </div>
            {{--<a href="#" class="text-center new-account">Create an account </a>--}}
        </div>
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
<script src="{{asset('js/angularjs/controller/login.js')}}"></script>



</body>
</html>