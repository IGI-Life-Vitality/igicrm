

<!--Begin Debit Card Status Change-->
<div class="tab-content" id="tabStatusChange" style="display: none;">
    <div class="tab-pane fade active in" id="nav-tab-StopPayment">
        <legend>Debit Card Status Change Request Section</legend>

        <form class="form-horizontal" autocomplete="off" action="#" method="post">

            <div class="form-group">
                <label class="col-md-2 control-label-my">CNIC</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="txtDebitCardCNIC" value="" disabled/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label-my">Account Number</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="txtDebitCardAccount" value="" disabled/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label-my">Status</label>
                <div class="col-md-4">
                    <select class="form-control" id="ddlDebitCardStatus">
                        <option value="">Select Status</option>
                        <option value="1">Active</option>
                        <option value="2">Deactive</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label-my">Agent ID</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="txtDebitCardAgentId" value="" />
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <button type="button" class="btn btn-sm btn-info" id="btnStatusChangeSave">Save</button>
                </div>
            </div>

        </form>
    </div>
</div>
<!--End Debit Card Status Change-->


