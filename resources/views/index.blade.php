@extends('layout')
@section('content_layout')
<div ng-controller="loginController" class="container">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            {{--<h1 class="text-center login-title">Sign in to continue to Bootsnipp</h1>--}}
            <div class="account-wall">
                <img class="profile-img" src=""
                     alt="">
                <div class="card p-1">
                    <div class="card-header mb-3 text-center">
                        SouthFloral Costs
                    </div>
                    <form name="frmLogin" class="form-signin p-3 "  ng-submit="frmLogin.$valid && login()" novalidate>
                        <div class="form-group">
                            <label for="inputEmail">Email address</label>
                            <input type="text" id="inputEmail"  class="form-control" placeholder="Email" ng-model="username" required autofocus>
                        </div>
                        {{--<input type="text" class="form-control" placeholder="Email" ng-model="username" required autofocus>--}}
                        <div class="form-group">
                            <label for="inputPassword">Password</label>
                            <input type="password"  id="inputPassword"class="form-control" placeholder="Password" ng-model="password" required>
                        </div>

                        {{--<input type="password" class="form-control" placeholder="Password" ng-model="password" required>--}}
                        <button ng-disabled="frmLogin.$invalid" class="btn btn-primary ">Login</button>
                        {{--<button class="btn btn-lg btn-primary btn-block" type="submit">--}}
                        {{--Login</button>--}}
                        {{--<label class="checkbox pull-left">--}}
                        {{--<input type="checkbox" value="remember-me">--}}
                        {{--Remember me--}}
                        {{--</label>--}}
                        {{--<a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>--}}
                        <div ng-if="error" class="alert alert-danger mt-4">@{{error}}</div>
                    </form>
                </div>
            </div>
            {{--<a href="#" class="text-center new-account">Create an account </a>--}}
        </div>
    </div>
</div>

