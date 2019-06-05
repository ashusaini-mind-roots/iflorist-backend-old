<div class="modal" id="targetModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content top-info">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Target of Cost Percent</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body">
                <form name="frmTarget" class="form-horizontal" novalidate="">
                    <div class="form-group error">
                        <label for="inputEmail3" class="col-sm-4 control-label">% Target *</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control has-error" id="targetValue" name="targetValue"
                                   placeholder="Target value" value="@{{targetSelected}}"
                                   ng-model="targetSelected" ng-required="true">
                            <span class="help-inline"
                                  ng-show="frmTarget.targetValue.$invalid && frmTarget.targetValue.$touched">Value Required</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" ng-click="editTarget()"
                        ng-disabled="frmTarget.$invalid">Save changes
                </button>
            </div>
        </div>
    </div>
</div>