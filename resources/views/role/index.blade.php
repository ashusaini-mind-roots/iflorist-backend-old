@extends('contentlayout')
@section('content')
    <div ng-controller="rolesController" class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Roles</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatablePedidos" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th><button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">New Role</button></th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody ng-cloak>
                            <tr ng-repeat="role in roles">
                                <td>@{{ role.id }}</td>
                                <td>@{{ role.name }}</td>
                                <td>@{{ role.description }}</td>
                                <td>
                                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', role.id)">Edit</button>
                                    <button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(role.id)">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="modal" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content top-info">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                                        <h4 class="modal-title" id="myModalLabel">@{{form_title}}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form name="frmRole" class="form-horizontal" novalidate="">
                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Name *</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control has-error" id="name" name="name" placeholder="Name" value="@{{name}}"
                                                           ng-model="role.name" ng-required="true">
                                                    <span class="help-inline" ng-show="frmRole.name.$invalid && frmRole.name.$touched">Name Required</span>
                                                </div>
                                            </div>

                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Description</label>
                                                <div class="col-sm-9">
                                                    <textarea type="text" class="form-control has-error" id="description" name="description" placeholder="Description" value="@{{description}}"
                                                              ng-model="role.description">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate,id)" ng-disabled="frmRole.$invalid">Save changes</button>
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
<script src="{{asset('js/angularjs/controller/roles.js')}}"></script>
@endsection