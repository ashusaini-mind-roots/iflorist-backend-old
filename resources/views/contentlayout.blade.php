@extends('layout')

@section('content_layout')
    @parent
    <!-- Sidebar  -->
    <nav id="sidebar">
        @section('sidebar')
            <div class="sidebar-header">
                <h3>Cost of Goods</h3>
                <!--<strong>COG</strong>-->
            </div>
            <ul class="list-unstyled components">
                {{--<li class="active">--}}
                    {{--<a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">--}}
                        {{--<i class="fas fa-home"></i>--}}
                        {{----}}
                    {{--</a>--}}
                    {{--<ul class="collapse list-unstyled" id="homeSubmenu">--}}
                        {{--<li>--}}
                            {{--<a href="#">Home 1</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#">Home 2</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#">Home 3</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                <li class="" ng-show="rsRole == 'Admin'">
                    <a href="{{url('/role')}}">
                        <i class="fas fa-briefcase"></i>
                        Roles
                    </a>
                    {{--<a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">--}}
                        {{--<i class="fas fa-copy"></i>--}}
                        {{--Pages--}}
                    {{--</a>--}}
                    {{--<ul class="collapse list-unstyled" id="pageSubmenu">--}}
                        {{--<li>--}}
                            {{--<a href="#">Logout</a>--}}
                        {{--</li>--}}
                        {{--<!--<li>-->--}}
                        {{--<!--<a href="#">Page 2</a>-->--}}
                        {{--<!--</li>-->--}}
                        {{--<!--<li>-->--}}
                        {{--<!--<a href="#">Page 3</a>-->--}}
                        {{--<!--</li>-->--}}
                    {{--</ul>--}}
                </li>
                <li>
                    <a href="{{url('/stores')}}">
                        <i class="fas fa-image"></i>
                        Stores
                    </a>
                </li>
                <li ng-show="rsRole == 'Admin'" >
                    <a href="{{url('/users')}}">
                        <i class="fas fa-question"></i>
                        Users
                    </a>
                </li>
                <li>
                    <a href="{{url('/masteroverview')}}">
                        <i class="fas fa-question"></i>
                        Overview
                    </a>
                </li>
                {{--<li>--}}
                    {{--<a href="#">--}}
                        {{--<i class="fas fa-paper-plane"></i>--}}
                        {{--Contact--}}
                    {{--</a>--}}
                {{--</li>--}}
            </ul>
        @show

        <!--<ul class="list-unstyled CTAs">-->
        <!--<li>-->
        <!--<a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a>-->
        <!--</li>-->
        <!--<li>-->
        <!--<a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a>-->
        <!--</li>-->
        <!--</ul>-->
    </nav>

    <!-- Page Content  -->
    <div id="content">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i>
                    <span>Toggle Sidebar</span>
                </button>
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item active" ng-controller="logoutController">
                            <a class="nav-link" title="Logout" href="#" ng-click="logout()">Logout</a>
                        </li>
                        <!--<li class="nav-item">-->
                        <!--<a class="nav-link" href="#">Page</a>-->
                        <!--</li>-->
                        <!--<li class="nav-item">-->
                        <!--<a class="nav-link" href="#">Page</a>-->
                        <!--</li>-->
                        <!--<li class="nav-item">-->
                        <!--<a class="nav-link" href="#">Page</a>-->
                        <!--</li>-->
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')

    </div>

@endsection
