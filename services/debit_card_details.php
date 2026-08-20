


<!--Begin Debit Card Detail Form-->
<div id="tabDebitCardDetailsForm" class="tab-content">
    <form class="form-horizontal" autocomplete="off">

        <div class="form-group">
            <label class="col-md-4 control-label-my">Card Num</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="txtCard" value="<?php echo "0123456789012345"; ?>" disabled />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label-my">Embossed Name</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="txtEmbossed" value="<?php echo "Test"; ?>" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label-my">Expiry Date</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="txtExpiry" value="<?php echo "18-May-12 01:00:00"; ?>" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label-my">Product</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="txtProduct" value="<?php echo "Debit Card"; ?>" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label-my">Status</label>
            <div class="col-md-8">
                <select class="form-control" id="ddlStatus3">
                    <option value="1">Active</option>
                    <option value="2">Deactive</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label-my">Available POS Limit</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="txtId" value="<?php echo ""; ?>" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label-my">Change in pin Counts</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="txtId" value="<?php echo ""; ?>" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label-my">Daily Cash Limit</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="txtId" value="<?php echo ""; ?>" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label-my">Daily POS Limit</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="txtId" value="<?php echo ""; ?>" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label-my">Linked Account List</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="txtId" value="<?php echo ""; ?>" />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label-my">Pin Change History</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="txtId" value="<?php echo ""; ?>" />
            </div>
        </div>

        <div class="form-actions">
            <input type="button" class="btn btn-info btn-md" value="Back" id="btnBackDebit" />
        </div>

    </form>
</div>
<!--End Debit Card Detail Form-->


