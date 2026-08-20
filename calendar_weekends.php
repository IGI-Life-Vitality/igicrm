<?php

$WeekDays = array(
    'sat' => 'Saturday',
    'sun' => 'Sunday',
    'mon' => 'Monday',
    'tue' => 'Tuesday',
    'wed' => 'Wednesday',
    'thurs'=> 'Thursday',
    'fri' => 'Friday');


?>

<div class="alert alert-success fade in m-b-15" id="divSuccess1" style="display: none;">
</div>
<div class="alert alert-danger fade in m-b-15" id="divError1" style="display: none;">
    <strong>Error!</strong>
    Error while saving record, Please try again!
    <span class="close" data-dismiss="alert">&times;</span>
</div>

<div class="table-responsive">
    <table id="data-table" class="table table-striped text-center table-bordered dataTable no-footer dtr-inline" role="grid" aria-describedby="data-table_info">
        <thead>
        <tr role="row">
            <th class="text-center">Effective From
            </th>
            <th class="text-center">Effective To
            </th>
            <th class="text-center">Day Of Week
            </th>
            <th class="text-center">Action
            </th>
        </tr>
        </thead>
        <tbody>

        <?php $data = $objcal->GetWeekEnds(0);
        foreach($data as $row){
        ?>


        <tr role="row">
            <td><? echo $row["effective_from"] ?></td>
            <td><? echo $row["effective_to"] ?></td>
            <td><? echo $WeekDays[$row["week_day"]]  ?></td>
            <td>
                <a class="btn btn-sm btn-primary m-r-5 btnEditWeekEnds" id="<?php echo $row['id']?>">Edit</a>
                <!-- <a class="btn btn-sm btn-danger m-r-5 checkDelete">Delete</a> -->
            </td>
        </tr>
        <? } ?>
        </tbody>
    </table>
</div>




<!-- begin Modal WeekEnds -->

<div class="modal fade" id="ModalWeekEnds" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a id="btnCloseWeekEnds" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Week Ends</h4>
                    </div>
                </div>

                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;" id="">

                    <div class="panel-body">
                        <table id="data-table" class="table table-striped text-center table-bordered dataTable no-footer dtr-inline" role="grid" aria-describedby="data-table_info"><!-- 4396BB -->
                            <thead>
                            <tr role="row">
                                <th style="display: none;">Id</th>
                                <th>Effective From</th>
                                <th>Effective To</th>
                                <th>Day of Week</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr role="row">
                                <td style="display: none;"><input type="hidden" class="form-control" id="txtWeekendId" value="" /></td>
                                <td style="width: 100px">
                                    <input type="text" class="form-control" id="datepicker-autoClose2" value="<?php echo date("m/d/Y"); ?>" />
                                    <div class="input-error form-control-input" style="color: Red; display: none;">From Date Required</div>
                                </td>
                                <td style="width: 100px">
                                    <input type="text" class="form-control" id="datepicker-autoClose3" value="<?php echo date("m/d/Y",(strtotime("+ 1 month"))); ?>" />
                                    <div class="input-error form-control-input" style="color: Red; display: none;">To Date Required</div>
                                </td>
                                <td style="width: 150px">
                                    <select class="form-control" id="ddlWeekDay" name="ddlWeekDay" title="Please select something!">
                                        <?php foreach($WeekDays as $key => $value){ ?>
                                            <option value="<?php echo($key); ?>"><?php echo($value); ?></option>
                                        <? }?>
                                    </select>
                                </td>
                                <td style="width: 50px;">
                                    <!--<a style="display: none" class="btn btn-sm btn-warning m-r-5" id="btnUpdateDailyHours">Update</a>-->
                                    <a style="display: none" class="btn btn-sm btn-primary m-r-5" id="btnSaveModalWeekEnds"></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Modal WeekEnds -->