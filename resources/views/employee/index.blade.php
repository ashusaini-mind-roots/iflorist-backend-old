@extends('contentlayout')
@section('content')
    <div ng-controller="employeesController" class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Employees</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatablePedidos" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th ><button ng-show="rsRole == 'Admin'" id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)">New Employee</button></th>
                                <th>Name</th>
                                <th>Work Man Comp</th>
                                <th>Store</th>
                                <th>Category</th>
                                <th>Overtime Elegible</th>
                                <th>Hourly Payrate</th>
                                <th>Active</th>
                                <th ng-show="rsRole == 'Admin'">Actions</th>
                            </tr>
                            </thead>
                            <tbody ng-cloak>
                            <tr ng-repeat="employee in employees">
                                <td>@{{ employee.id }}</td>
                                <td>@{{ employee.name }}</td>
                                <td>@{{ employee.work_man_comp }}</td>
                                <td>@{{ employee.store }}</td>
                                <td>@{{ employee.category }}</td>
                                <td ng-show="employee.overtimeelegible==1">Yes</td>
                                <td ng-show="employee.overtimeelegible==0">No</td>
                                <td>@{{ employee.hourlypayrate | currency }}</td>
                                <td ng-show="employee.active==1">Yes</td>
                                <td ng-show="employee.active==0">No</td>
                                <td ng-show="rsRole == 'Admin'">
                                    <button class="btn btn-default btn-xs btn-detail" ng-click="toggle('edit', employee.id)">Edit</button>
                                    <!--<button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(user.id)">Delete</button>-->
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="modal" id="employeeModal" tabindex="-1" user="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content top-info">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                                        {{--<h4 class="modal-title" id="myModalLabel">@{{form_title}}</h4>--}}
                                    </div>
                                    <div class="modal-body">
                                        <form name="frmemployee" class="form-horizontal" novalidate="">
                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Employee Name *</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control has-error" id="name" name="name" placeholder="Name" value="@{{employee.name}}"
                                                           ng-model="employee.name" ng-required="true">
                                                    <span class="help-inline" ng-show="frmemployee.name.$invalid && frmemployee.name.$touched">Name Required</span>
                                                </div>
                                            </div>

                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Store *</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control has-error" name="store_id" id="store_id" ng-model="employee.store_id" ng-selected="employee.store_id" ng-options="store.id as store.store_name for store in stores" ng-required="true">
                                                        <!--<option ng-repeat="store.name for store in stores" value="@{{ store.id  }}">@{{ store.store_name  }}</option>-->
                                                    </select>
                                                    <span class="help-inline" ng-show="frmemployee.store_id.$invalid && frmemployee.store_id.$touched">Store Required</span>
                                                </div>
                                            </div>

                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Category *</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control has-error" name="category_id" id="category_id" ng-model="employee.category_id" ng-selected="employee.category_id" ng-options="category.id as category.name for category in categories" ng-required="true">
                                                        <!--<option ng-repeat="category in categories" value="@{{ category.id  }}">@{{ category.name  }}</option>-->
                                                    </select>
                                                    <span class="help-inline" ng-show="frmemployee.category_id.$invalid && frmemployee.category_id.$touched">Category Required</span>
                                                </div>
                                            </div>

                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Work Man Comp *</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control has-error" name="work_man_comp_id" id="work_man_comp_id" ng-model="employee.work_man_comp_id" ng-selected="employee.work_man_comp_id" ng-options="work_man_comp.id as work_man_comp.name for work_man_comp in work_mans_comp" ng-required="true">
                                                        <!--<option ng-repeat="work_man_comp in work_mans_comp" value="@{{ work_man_comp.id  }}">@{{ work_man_comp.name  }}</option>-->
                                                    </select>
                                                    <span class="help-inline" ng-show="frmemployee.work_man_comp_id.$invalid && frmemployee.work_man_comp_id.$touched">Work Man Comp Required</span>
                                                </div>
                                            </div>

                                            <div ng-show="modalstate=='edit'" class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Active *</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control has-error" name="active" id="active" ng-model="employee.active" ng-selected="employee.active" ng-options="active.id as active.name for active in actives">
                                                        <!--<option value="1">Yes</option>
                                                        <option value="0">No</option>-->
                                                    </select>
                                                    <!--<span class="help-inline" ng-show="frmemployee.active.$invalid && frmemployee.active.$touched">Active Required</span>-->
                                                </div>
                                            </div>

                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Hourly Pay Rate *</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control has-error" id="hourlypayrate" name="hourlypayrate" placeholder="Hourly Pay Rate" value="@{{employee.hourlypayrate}}"
                                                           ng-model="employee.hourlypayrate" ng-required="true">
                                                    <span class="help-inline" ng-show="frmemployee.hourlypayrate.$invalid && frmemployee.hourlypayrate.$touched">Hourly Pay Rate Required</span>
                                                </div>
                                            </div>

                                            <div class="form-group error">
                                                <label for="inputEmail3" class="col-sm-3 control-label">Over Time Elegible *</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control has-error" name="overtimeelegible" id="overtimeelegible" ng-model="employee.overtimeelegible" ng-selected="employee.overtimeelegible" ng-options="overtimeelegible.id as overtimeelegible.name for overtimeelegible in overtimeelegibles" ng-required="true">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                    <span class="help-inline" ng-show="frmemployee.overtimeelegible.$invalid && frmemployee.overtimeelegible.$touched">Over Time Elegible Required</span>
                                                </div>
                                            </div>

                                            <div class="form-group error" ng-show="loading">
                                                <div class="col-sm-12">
                                                    <div class="spinner-border" role="status">
                                                        <span class="sr-only">Loading....</span>
                                                    </div>
                                                    <div>
                                                        <span>Please, wait ....</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate,id)" ng-disabled="frmemployee.$invalid">Save changes</button>
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
<script src="{{asset('js/angularjs/controller/employee.js')}}"></script>
@endsection
