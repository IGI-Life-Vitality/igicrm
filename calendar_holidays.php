<?php
    $data = $objcal->GetHolidays(0);
    $counter = 0;
?>

<div class="alert alert-success fade in m-b-15" id="divSuccess2" style="display: none;">
</div>

<div class="table-responsive">
    <table id="data-table" class="table table-striped text-center table-bordered dataTable no-footer dtr-inline" role="grid" aria-describedby="data-table_info">
        <thead>
            <tr role="row">
                <th class="text-center">Event</th>
                <th class="text-center">From</th>
                <th class="text-center">To</th>
                <th class="text-center">Repeat Every Year</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($data as $row) {
                $repeat = $row['is_repeat'] == 1 ? 'true' : 'false';
            ?>
            <tr role="row">
                <td><?php echo $row["event_name"] ?></td>
                <td><?php echo $row["from_date"] ?></td>
                <td><?php echo $row["to_date"] ?></td>
                <td>
                    <?php 
                    if($repeat == 'true')
                    {
                        echo "Yes";
                    }
                    else if($repeat == 'false')
                    {
                        echo "No";
                    }
                    ?>
                </td>
                <td>
                    <a class="btn btn-sm btn-primary m-r-5 btnEditHolidays" id="<?php echo $row['id']?>">Edit</a>
                    <!-- <a class="btn btn-sm btn-danger m-r-5 checkDelete">Delete</a> -->
                </td>
            </tr>
            <? } ?>
        </tbody>
    </table>
</div>

<!-- begin Modal Holidays -->
<div class="modal fade" id="ModalHolidays" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a id="btnCloseHolidays" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Holidays</h4>
                    </div>
                </div>

                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;" id="">
                    <table id="data-table" class="table table-striped text-center table-bordered dataTable no-footer dtr-inline" role="grid" aria-describedby="data-table_info">
                        <thead>
                            <tr role="row">
                                <th style="display: none;">Id</th>
                                <th>Event</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Repeat Every Year</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr role="row">
                                <td style="display: none;"><input type="hidden" class="form-control" id="txtHolidaysId" value="" /></td>
                                <td style="width: 300px"><input type="text" class="form-control" id="txtEvent" placeholder="Event Name" value="" /></td>
                                <td style="width: 100px">
                                    <input type="text" class="form-control" id="datepicker-autoClose4" value="<?php echo date("m/d/Y"); ?>" />
                                    <div class="input-error form-control-input" style="color: Red; display: none;">From Date Required</div>
                                </td>
                                <td style="width: 100px">
                                    <input type="text" class="form-control" id="datepicker-autoClose5" value="<?php echo date("m/d/Y",(strtotime("+ 1 month"))); ?>" />
                                    <div class="input-error form-control-input" style="color: Red; display: none;">To Date Required</div>
                                </td>
                                <td style="width: 100px">
                                    <div class="form-control" style="background-color: #f2f2f2; border: none;">
                                        <input type="checkbox" id="chkIsActive" checked />
                                    </div>
                                </td>
                                <td style="width: 50px;">
                                    <!--<a style="display: none" class="btn btn-sm btn-warning m-r-5" id="btnUpdateDailyHours">Update</a>-->
                                    <a style="display: none" class="btn btn-sm btn-primary m-r-5" id="btnSaveModalHolidays"></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Holidays -->