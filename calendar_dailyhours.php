<?php
    include('classes/calendar.php');
    $objcal = new Calendar();
?>

<div class="alert alert-success fade in m-b-15" id="divSuccess" style="display: none;">
</div>
<div class="alert alert-danger fade in m-b-15" id="divError" style="display: none;">
    <strong>Error!</strong>
    Error while saving record, Please try again!
    <span class="close" data-dismiss="alert">&times;</span>
</div>

<div class="table-responsive">
    <table id="data-table" class="table table-striped text-center table-bordered dataTable no-footer dtr-inline" role="grid" aria-describedby="data-table_info"><!-- 4396BB -->
        <thead>
            <tr role="row">
                <th class="text-center">Effective From
                </th>
                <th class="text-center">Effective To
                </th>
                <th class="text-center">Start Time
                </th>
                <th class="text-center">End Time
                </th>
                <th class="text-center">Action
                </th>
            </tr>
        </thead>

        <tbody>
            <?php $data = $objcal->GetDailyHours(0);
                foreach($data as $row) {
            ?>
            <tr role="row">
                <td><? echo $row["effective_from"] ?></td>
                <td><? echo $row["effective_to"] ?></td>
                <td><? echo $row["start_time"] ?></td>
                <td><? echo $row["end_time"] ?></td>
                <td>
                    <a class="btn btn-sm btn-primary m-r-5 btnEditDailyHours" id="<?php echo $row['id']?>">Edit</a>
                    <!-- <a class="btn btn-sm btn-danger m-r-5 checkDelete">Delete</a> -->
                </td>
            </tr>
            <? } ?>
        </tbody>
    </table>
</div>

<!-- begin Modal Daily Hours -->
<div class="modal fade" id="ModalDailyHours" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a id="btnCloseDailyHours" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Daily Hours</h4>
                    </div>
                </div>

                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;" id="">

                    <div class="panel-body panel-body-igi">
                        <table id="data-table" class="table table-striped text-center table-bordered dataTable no-footer dtr-inline" role="grid" aria-describedby="data-table_info"><!-- 4396BB -->
                            <thead>
                            <tr role="row">
                                <th style="display: none;">Id</th>
                                <th class="text-center">Effective From</th>
                                <th class="text-center">Effective To</th>
                                <th class="text-center">Start Time</th>
                                <th class="text-center">End Time</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr role="row">
                                <td style="display: none;"><input type="hidden" class="form-control" id="txtId" value="" /></td>
                                <td style="width: 100px">
                                    <input type="text" class="form-control" id="datepicker-autoClose" value="<?php echo date("m/d/Y"); ?>" />
                                    <div class="input-error form-control-input" style="color: Red; display: none;">From Date Required</div>
                                </td>
                                <td style="width: 100px">
                                    <input type="text" class="form-control" id="datepicker-autoClose1" value="<?php echo date("m/d/Y",(strtotime("+ 1 month"))); ?>" />
                                    <div class="input-error form-control-input" style="color: Red; display: none;">To Date Required</div>
                                </td>
                                <td style="width: 350px">
                                    <div>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" id="txtStartHours" value="00" min="0" max="24" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" id="txtStartMinutes" value="00" min="0" max="60" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" id="txtStartSeconds" value="00" min="0" max="60" />
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 350px">
                                    <div>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" id="txtEndHours" value="00" min="0" max="24" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" id="txtEndMinutes" value="00" min="0" max="60" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" id="txtEndSeconds" value="00" min="0" max="60" />
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 50px;">
                                    <!--<a style="display: none" class="btn btn-sm btn-warning m-r-5" id="btnUpdateDailyHours">Update</a>-->
                                    <a style="display: none" class="btn btn-sm btn-primary m-r-5" id="btnSaveModalDailyHours"></a>
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

<!-- End Modal Daily Hours -->