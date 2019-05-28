@extends('contentlayout')
@section('content')
    <div ng-controller="usersController" class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Users</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatablePedidos" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th ><button ng-show="rsRole == 'Admin'" id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">New User</button></th>
                                <th>User Name</th>
                                <th>Role</th>
                                <th>Store</th>
                                <th ng-show="rsRole == 'Admin'">Actions</th>
                            </tr>
                            </thead>
                            <tbody ng-cloak>
                            <tr ng-repeat="user in users">
                                <td>@{{ user.id }}</td>
                                <td>@{{ user.name }}</td>
                                <td>@{{ user.role_name }}</td>
                                <td ng-if="user.role_id == 1">All Store</td>
                                <td ng-if="user.role_id != 1">@{{ user.store_name }}</td>
                                <td ng-show="rsRole == 'Admin'">
                                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', user.id)">Edit</button>
                                    <button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(user.id)">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="modal" id="userModal" tabindex="-1" user="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content top-info">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                                        {{--<h4 class="modal-title" id="myModalLabel">@{{form_title}}</h4>--}}
                                    </div>
                                    <div class="modal-body">
                                        <form name="frmuser" class="form-horizontal" novalidate="">
                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">User Name *</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control has-error" id="name" name="name" placeholder="Name" value="@{{user.name}}"
                                                           ng-model="user.name" ng-required="true">
                                                    <span class="help-inline" ng-show="frmuser.name.$invalid && frmuser.name.$touched">Name Required</span>
                                                </div>
                                            </div>
                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Email *</label>
                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control has-error" id="email" name="email" placeholder="Email" value="@{{user.email}}"
                                                           ng-model="user.email" ng-required="true">
                                                    <span class="help-inline" ng-show="frmuser.email.$invalid && frmuser.email.$touched">Email Required</span>
                                                    <span class="help-inline" ng-show="frmuser.email.$error.email && frmuser.email.$touched">Error Email Format</span>
                                                </div>
                                            </div>
                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Password *</label>
                                                <div class="col-sm-9">
                                                    <input type="password" class="form-control has-error" id="password" name="password" placeholder="Password" value="@{{user.password}}"
                                                           ng-model="user.password" ng-required="true" ng-minlength="8">
                                                    <span class="help-inline" ng-show="frmuser.password.$invalid && frmuser.password.$touched">Password Required</span>
                                                    <span class="help-inline" ng-show="frmuser.password.$error.minlength && frmuser.password.$touched">Password Minlength 8</span>
                                                </div>
                                            </div>
                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Role *</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control has-error" name="role_id" id="role_id" ng-model="user.role_id" ng-required="true">
                                                        <option ng-selected="role.role_id==rol.id" ng-repeat="rol in roles" value="@{{ rol.id  }}">@{{ rol.name  }}</option>
                                                    </select>
                                                    <span class="help-inline" ng-show="frmuser.role_id.$invalid && frmuser.role_id.$touched">Role Required</span>
                                                </div>
                                            </div>

                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Store *</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control has-error" name="store_id" id="store_id" ng-model="user.store_id" ng-required="true">
                                                        <option ng-repeat="store in stores" value="@{{ store.id  }}">@{{ store.store_name  }}</option>
                                                    </select>
                                                    <span class="help-inline" ng-show="frmuser.store_id.$invalid && frmuser.store_id.$touched">Store Required</span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate,id)" ng-disabled="frmuser.$invalid">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{asset('js/angularjs/controller/users.js')}}"></script>
@endsection