@extends('layout')
@section('content')
    <div ng-controller="storesController" class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Stores</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatablePedidos" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th><button ng-show="rsRole == 'Admin'" id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">New Store</button></th>
                                <th>Store Name</th>
                                <th>Contact Email</th>
                                <th>Contact Phone</th>
                                <th>Zip Code</th>
                                <th>Address</th>
                                <th ng-show="rsRole=='Admin' || rsRole=='Manager'">Actions</th>
                            </tr>
                            </thead>
                            <tbody ng-cloak>
                            <tr ng-repeat="store in stores">
                                <td>@{{ store.id }}</td>
                                <td>@{{ store.store_name }}</td>
                                <td>@{{ store.contact_email }}</td>
                                <td>@{{ store.contact_phone }}</td>
                                <td>@{{ store.zip_code }}</td>
                                <td>@{{ store.address }}</td>
                                <td ng-show="rsRole=='Admin' || rsRole=='Manager'">
                                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', store.id)">Edit</button>
                                    <button ng-show="rsRole == 'Admin'" class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(store.id)">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="modal" id="storeModal" tabindex="-1" store="dialog" aria-labelledby="storeModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content top-info">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                                        <h4 class="modal-title" id="myModalLabel">@{{form_title}}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form name="frmstore" class="form-horizontal" novalidate="">
                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Store Name *</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control has-error" id="store_name" name="store_name" placeholder="Store Name" value="@{{store_name}}"
                                                           ng-model="store.store_name" ng-required="true">
                                                    <span class="help-inline" ng-show="frmstore.store_name.$invalid && frmstore.store_name.$touched">Store Name Required</span>
                                                </div>
                                            </div>
                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Contact Email *</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control has-error" id="contact_email" name="contact_email" placeholder="Contact Email" value="@{{contact_email}}"
                                                           ng-model="store.contact_email" ng-required="true">
                                                    <span class="help-inline" ng-show="frmstore.contact_email.$invalid && frmstore.contact_email.$touched">Contact Email Required</span>
                                                </div>
                                            </div>
                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Contact Phone</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control has-error" id="contact_phone" name="contact_phone" placeholder="Contact Phone" value="@{{contact_phone}}"
                                                           ng-model="store.contact_phone">
                                                </div>
                                            </div>
                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Zip Code</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control has-error" id="zip_code" name="zip_code" placeholder="Zip Code" value="@{{zip_code}}"
                                                           ng-model="store.zip_code">
                                                </div>
                                            </div>
                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Address</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control has-error" id="address" name="address" placeholder="Address" value="@{{address}}"
                                                           ng-model="store.address">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate,id)" ng-disabled="frmstore.$invalid">Save changes</button>
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
<script src="{{asset('js/angularjs/controller/stores.js')}}"></script>
@endsection