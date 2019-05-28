<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>CostOfGoods</title>

    <!-- Bootstrap CSS CDN -->
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">-->
    <!--<link rel="stylesheet" href="{{asset('css/external/bootstrap.min.css')}}">-->
    <link rel="stylesheet" href="{{asset('css/external/bootstrap4.3.min.css')}}">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{asset('css/custom_css.css')}}">

    <!-- Font Awesome JS -->
    <!--<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>-->
    <!--<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>-->

</head>

<body ng-app="app">

<div class="wrapper">
    @yield('content_layout')
</div>

<script src="{{asset('js/external/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('js/external/popper.min.js')}}"></script>
<script src="{{asset('js/external/bootstrap.min.js')}}"></script>

<script src="{{asset('js/angularjs/angular.min.js')}}"></script>
<script src="{{asset('js/angularjs/angular-resource.min.js')}}"></script>
{{--<script src="{{asset('js/angularjs/angular-money-mask.js')}}"></script>--}}
<script src="{{asset('js/angularjs/ngStorage.min.js')}}"></script>

<script src="{{asset('js/angularjs/app.js')}}"></script>
<script src="{{asset('js/angularjs/services/authentication.service.js')}}"></script>
<script src="{{asset('js/angularjs/controller/logout.js')}}"></script>
<script src="{{asset('js/angularjs/controller/login.js')}}"></script>
<script src="{{asset('js/external/jQ-Mask-Plugin/src/jquery.mask.js')}}"></script>

@yield('js')

<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });

    $('.money').mask('#,##0.00', { reverse: true });
</script>
</body>

</html>