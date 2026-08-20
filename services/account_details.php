<!--Begin Account Details-->
<div id="AccountForm" class="tab-content">
    <div class="tab-pane fade active in" id="nav-tab-AccountDetails">
        <form class="form-horizontal" autocomplete="off">

            <div class="form-group">
                <label class="col-md-4 control-label-my">Account Num</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="txtId" value="<?php echo "0118006000004896"; ?>" disabled />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label-my">Account Type</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="txtId" value="<?php echo "CA"; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label-my">Branch Name</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="txtId" value="<?php echo "Karachi"; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label-my">Branch Code</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="txtId" value="<?php echo "0526"; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label-my">Status</label>
                <div class="col-md-8">
                    <select class="form-control" id="ddlStatus">
                        <option value="1">Active</option>
                        <option value="2">Deactive</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label-my">Currency</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="txtId" value="<?php echo "PKR"; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label-my">Available Balance</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="txtId" value="<?php echo "100,000"; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label-my">Customer Branch</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="txtId" value="<?php echo "XYZ"; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label-my">MISYS Branch</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="txtId" value="<?php echo "XYA"; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label-my">Linked Account</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="txtId" value="<?php echo "02126"; ?>" />
                </div>
            </div>

            <div class="form-actions">
                <input type="button" class="btn btn-info btn-md" value="Back" id="btnBackAccounts" />
            </div>

        </form>
    </div>
</div>
<!--End Account Details-->