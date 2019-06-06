<div class="modal" id="projectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content top-info">
            <div class="modal-header">

                <h4 class="modal-title" id="myModalLabel">Projection Revenue Percent</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body">
                <form name="frmProjection" class="form-horizontal" novalidate="">
                    <div class="row">
                        <div class="col">
                            <b>Week Ending:</b> @{{ weekSelected.week_ending }}-@{{ selectedYearsItem }}
                            <br>
                            <b>Current Rev. for @{{ yearReferenceProjectionSelected }} Week Nbr @{{
                                weekSelected.week_number }}</b>:
                            @{{ year_reference_revenue | currency }}

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <div class="form-group error">
                                <label for="downValue" class=" control-label">% Down *</label>
                                <div class="">
                                    <input type="text" class="form-control has-error" id="downValue" name="downValue"
                                           placeholder="Down value" value="@{{downPercentSelected}}"
                                           ng-model="downPercentSelected" ng-required="true">
                                    <span class="help-inline"
                                          ng-show="frmProjection.downValue.$invalid && frmProjection.downValue.$touched">Value Required</span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group error">
                                <label for="downValue" class=" control-label">Year Reference *</label>
                                <div class="">
                                    <select id="yearReferenceProjectionSelectedId" class="form-control"
                                            ng-required="true"
                                            ng-model="yearReferenceProjectionSelected"
                                            ng-options="year for year in yearsListProjection"
                                            ng-change="getTotalByWeekYear()"
                                            id="yearProjectionValue"
                                            name="yearProjectionValue">
                                    </select>
                                    <span class="help-inline"
                                          ng-show="frmProjection.yearProjectionValue.$invalid && frmProjection.yearProjectionValue.$touched">Value Required</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <b>Projected Weekly Revevenue:</b>
                            <h3>@{{ (year_reference_revenue * (1-(downPercentSelected/100))) > 0 ?
                                (year_reference_revenue * (1-(downPercentSelected/100))) : 0 | currency }}</h3>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" ng-click="editProjection()"
                        ng-disabled="frmProjection.$invalid">Save changes
                </button>
            </div>
        </div>
    </div>
</div>
