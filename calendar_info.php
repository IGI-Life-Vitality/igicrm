<?php
    $page_title = "Calendar";
    $permission_type = "view";
    $module_id = "10";
    $parent_id ="20";
    $menu_id = "calendar_info";

    include('includes/header.php');
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet" />
<link href="assets/plugins/password-indicator/css/password-indicator.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-combobox/css/bootstrap-combobox.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
<link href="assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
<link href="assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-eonasdan-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css" rel="stylesheet" />
<link href="assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css" rel="stylesheet" />
<link href="assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css" rel="stylesheet" />
<link href="assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css" rel="stylesheet" />

<link href='assets/plugins/jquery-noty/noty_theme_default.css' rel='stylesheet'>

<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Administration</a></li>
        <li><a href="javascript:;">Calendar Information</a></li>
    </ol>

    <h1 class="page-header">Administration</h1>

    <div class="panel panel-inverse panel-with-tabs" data-sortable-id="ui-unlimited-tabs-1" data-init="true">
        <div class="panel-heading p-0">
            <div class="panel-heading-btn-igi panel-heading-btn m-r-10 m-t-10">
                <label for="file-upload" class="custom-file-upload">
                    <a class="btn btn-icon btn-circle btn-info btnAdd" title="Click Here To Add" id="">
                        <i class="fa fa fa-plus-square"></i></a>
                </label>
            </div>

            <!-- begin nav-tabs -->
            <div class="tab-overflow overflow-right">
                <ul class="nav nav-pills nav-tabs-inverse">
                    <li class="prev-button">
                        <a href="javascript:;" data-click="prev-tab" class="text-success"><i class="fa fa-arrow-left"></i></a>
                    </li>
                    <!-- <li class="">
                        <a href="#nav-tab-1" id="tabDailyHours" data-toggle="tab">Daily Hours</a>
                    </li>
                    <li class="">
                        <a href="#nav-tab-2" id="tabWeekends" data-toggle="tab">Week Ends</a>
                    </li> -->
                    <li class="active">
                        <a href="#nav-tab-3" id="tabHolidays" data-toggle="tab">Event Holidays</a>
                    </li>
                    <li class="next-button" style="">
                        <a href="javascript:;" data-click="next-tab" class="text-success"><i class="fa fa-arrow-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="tab-content">
            <div class="tab-pane fade" id="nav-tab-1">
                <?php include('calendar_dailyhours.php'); ?>
            </div>
            <div class="tab-pane fade" id="nav-tab-2">
                <?php include('calendar_weekends.php'); ?>
            </div>
            <div class="tab-pane fade active in" id="nav-tab-3">
                <?php include('calendar_holidays.php'); ?>
            </div>
        </div>
    </div>
</div>
<!-- end #content -->

<!-- begin #footer -->
<?php include('includes/footer.php'); ?>
<!-- end #footer -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="assets/plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
<script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/plugins/masked-input/masked-input.min.js"></script>
<script src="assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="assets/plugins/password-indicator/js/password-indicator.js"></script>
<script src="assets/plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
<script src="assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js"></script>
<script src="assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>
<script src="assets/plugins/bootstrap-daterangepicker/moment.js"></script>
<script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="assets/plugins/bootstrap-show-password/bootstrap-show-password.js"></script>
<script src="assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
<script src="assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js"></script>
<script src="assets/plugins/clipboard/clipboard.min.js"></script>
<script src="assets/js/form-plugins.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
    });
</script>

<script type="text/javascript">
    $().ready(function () {
        /* Begin Daily Hours */
        // $('.btnAdd').attr('id','btnAddDailyHours');
        // $(document).on('click','#tabDailyHours', function() {
        //     $('.btnAdd').attr('id','btnAddDailyHours');
        // });

        // $(document).on('click','#btnAddDailyHours', function() {
        //     $('#ModalDailyHours').modal({backdrop: 'static', keyboard: false});
        //     $('#ModalDailyHours').modal('show');
        //     $('#btnSaveModalDailyHours').css("display", "block");
        //     $('#btnSaveModalDailyHours').text('Add');

        //     return false;
        // });

        // $(document).on('click','#btnSaveModalDailyHours', function() {
        //     var id = $('#txtId').val() != 0 ? $('#txtId').val() : 0;
        //     var action =  id == 0 ? "save" : "edit";
        //     var effective_from = $('#datepicker-autoClose').val();
        //     var effective_to = $('#datepicker-autoClose1').val();
        //     var start_hours = $('#txtStartHours').val();
        //     var start_mins = $('#txtStartMinutes').val();
        //     var start_sec = $('#txtStartSeconds').val();
        //     var end_hours = $('#txtEndHours').val();
        //     var end_mins =  $('#txtEndMinutes').val();
        //     var end_sec =   $('#txtEndSeconds').val();

        //     if(validation())
        //     {
        //         $.ajax({
        //             type: "POST",
        //             url: "includes/ajax/action_calendar.php",
        //             data: 
        //             {
        //                 'id'              :id,
        //                 'action'          :action,
        //                 'effective_from'  :effective_from,
        //                 'effective_to'    :effective_to,
        //                 'start_hours'     :start_hours,
        //                 'start_mins'      :start_mins,
        //                 'start_sec'       :start_sec,
        //                 'end_hours'       :end_hours,
        //                 'end_mins'        :end_mins,
        //                 'end_sec'         :end_sec
        //             },
        //             success: function (data) 
        //             {
        //                 data = data.trim();
        //                 //alert(data);
        //                 console.log(data);
        //                 var result = data.split("|");

        //                 if (result[0] == 'success') 
        //                 {
        //                     $('#ModalDailyHours').modal('hide');
        //                     $('html, body').animate({scrollTop: 0}, 600);
        //                     $('#divSuccess').show();
        //                     $('#divSuccess').html('<strong>'+ result[1] +'</strong> <span class="close" data-dismiss="alert">&times;</span>');
        //                     setTimeout(function(){
        //                         location.reload();
        //                     }, 2000);
        //                 }
        //                 else
        //                 {
        //                     $('#ModalDailyHours').modal('hide');
        //                     $('html, body').animate({scrollTop: 0}, 600);
        //                     $('#divError').show();
        //                 }
        //             }
        //         });
        //     }

        // });

        // $(document).on('click','.btnEditDailyHours', function() {
        //     var id = $(this).attr('id');

        //     if(id != 0)
        //     {
        //         $.ajax({
        //             type: "POST",
        //             url: "includes/ajax/action_calendar.php",
        //             data: {
        //                 'id': id,
        //                 'action'  :'daily_hours_data'
        //             },
        //             success: function (data) 
        //             {
        //                 data = data.trim();
        //                 //alert(data);
        //                 console.log(data);
        //                 var result = data.split("|");

        //                 if (result[0] == 'success') 
        //                 {
        //                     $('#ModalDailyHours').modal({backdrop: 'static', keyboard: false});
        //                     $('#ModalDailyHours').modal('show');
        //                     $('#btnSaveModalDailyHours').css("display", "block");
        //                     $('#btnSaveModalDailyHours').text('Update');
        //                     $('#txtId').val(id);
        //                     $('#datepicker-autoClose').val(result[1]);
        //                     $('#datepicker-autoClose1').val(result[2]);
        //                     $('#txtStartHours').val(result[3]);
        //                     $('#txtStartMinutes').val(result[4]);
        //                     $('#txtStartSeconds').val(result[5]);
        //                     $('#txtEndHours').val(result[6]);
        //                     $('#txtEndMinutes').val(result[7]);
        //                     $('#txtEndSeconds').val(result[8]);

        //                 }
        //                 else if (data == 'fail') {
        //                     $('#ModalDailyHours').modal('hide');
        //                     $('html, body').animate({scrollTop: 0}, 600);
        //                     alert("Fail");
        //                 }
        //             }
        //         });
        //     }
        // });

        // $(document).on('click', '#btnCloseDailyHours', function () {
        //     $('#ModalDailyHours').modal('hide');
        // });
        /* End Daily Hours */


        /* Begin WeekEnds */
        // $(document).on('click','#tabWeekends', function() {
        //     $('.btnAdd').attr('id','btnAddWeekends');
        // });

        // $(document).on('click','#btnAddWeekends', function() {
        //     $('#ModalWeekEnds').modal({backdrop: 'static', keyboard: false});
        //     $('#ModalWeekEnds').modal('show');
        //     $('#btnSaveModalWeekEnds').css("display", "block");
        //     $('#btnSaveModalWeekEnds').text('Add');
        //     return false;
        // });

        // $(document).on('click','#btnSaveModalWeekEnds', function() {
        //     var id = $('#txtWeekendId').val() != 0 ? $('#txtWeekendId').val() : 0;
        //     var action =  id == 0 ? "saveweekend" : "editweekend";
        //     var effective_from = $('#datepicker-autoClose2').val();
        //     var effective_to = $('#datepicker-autoClose3').val();
        //     var week_day = $('#ddlWeekDay').val();

        //     $.ajax({
        //         type: 'POST',
        //         url: 'includes/ajax/action_calendar.php',
        //         data:{
        //             'id'              :id,
        //             'action'          :action,
        //             'effective_from'  :effective_from,
        //             'effective_to'    :effective_to,
        //             'week_day'        :week_day
        //         },
        //         success: function(data) {
        //             data = data.trim();
        //             console.log(data);
        //             var result = data.split("|");

        //             if (result[0] == 'success') {
        //                 $('#ModalWeekEnds').modal('hide');
        //                 $('html, body').animate({scrollTop: 0}, 600);
        //                 $('#divSuccess1').show();
        //                 $('#divSuccess1').html('<strong>'+ result[1] +'</strong> <span class="close" data-dismiss="alert">&times;</span>');
        //                 setTimeout(function(){
        //                     location.reload();
        //                 }, 2000);
        //             }else{
        //                 $('#ModalWeekEnds').modal('hide');
        //                 $('html, body').animate({scrollTop: 0}, 600);
        //                 $('#divError1').show();
        //             }
        //         }

        //     });
        // });

        // $(document).on('click','.btnEditWeekEnds', function() {
        //     var id = $(this).attr('id');

        //     if(id != 0)
        //     {
        //         $.ajax({
        //             type: "POST",
        //             url: "includes/ajax/action_calendar.php",
        //             data: {
        //                 'id': id,
        //                 'action'  :'weekend_data'
        //             },
        //             success: function (data) {
        //                 data = data.trim();
        //                 //alert(data);
        //                 console.log(data);
        //                 var result = data.split("|");

        //                 if (result[0] == 'success') {

        //                     $('#ModalWeekEnds').modal({backdrop: 'static', keyboard: false});
        //                     $('#ModalWeekEnds').modal('show');
        //                     $('#btnSaveModalWeekEnds').css("display", "block");
        //                     $('#btnSaveModalWeekEnds').text('Update');
        //                     $('#txtWeekendId').val(id);
        //                     $('#datepicker-autoClose2').val(result[1]);
        //                     $('#datepicker-autoClose3').val(result[2]);
        //                     $('#ddlWeekDay').val(result[3]);
        //                 }
        //                 else if (data == 'fail') {
        //                     $('#ModalWeekEnds').modal('hide');
        //                     $('html, body').animate({scrollTop: 0}, 600);
        //                     alert("Fail");
        //                 }
        //             }
        //         });
        //     }
        // });

        // $(document).on('click', '#btnCloseWeekEnds', function () {
        //     $('#ModalWeekEnds').modal('hide');
        // });
        /* End WeekEnds */

        /* Begin Holidays */
        /* For page on load */
        $('.btnAdd').attr('id','btnAddHolidays');

        /* For Click Event */
        // $(document).on('click','#tabHolidays', function() {
        //     $('.btnAdd').attr('id','btnAddHolidays');
        // });

        $(document).on('click','#btnAddHolidays', function() {
            $('#ModalHolidays').modal({backdrop: 'static', keyboard: false});
            $('#ModalHolidays').modal('show');
            $('#btnSaveModalHolidays').css("display", "block");
            $('#btnSaveModalHolidays').text('Add');
        });

        $(document).on('click','#btnSaveModalHolidays', function() {
            var id = $('#txtHolidaysId').val() != 0 ? $('#txtHolidaysId').val() : 0;
            var action =  id == 0 ? "saveholidays" : "editholidays";
            var from_date = $('#datepicker-autoClose4').val();
            var to_date = $('#datepicker-autoClose5').val();
            var event_name = $('#txtEvent').val();
            var is_repeat = $('#chkIsActive').is(":checked") ? 1 : 0;

            $.ajax({
                type: 'POST',
                url: 'includes/ajax/action_calendar.php',
                data:{
                    'id'              :id,
                    'action'          :action,
                    'effective_from'  :from_date,
                    'effective_to'    :to_date,
                    'event_name'      :event_name,
                    'is_repeat'       :is_repeat
                },
                success: function(data) {
                    data = data.trim();
                    console.log(data);
                    var result = data.split("|");

                    if (result[0] == 'success') {
                        $('#ModalHolidays').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $('#divSuccess2').show();
                        $('#divSuccess2').html('<strong>'+ result[1] +'</strong> <span class="close" data-dismiss="alert">&times;</span>');
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    }else{
                        $('#ModalHolidays').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $('#divError2').show();
                    }
                }

            });
        });

        $(document).on('click','.btnEditHolidays', function() {
            var id = $(this).attr('id');

            if(id != 0)
            {
                $.ajax({
                    type: "POST",
                    url: "includes/ajax/action_calendar.php",
                    data: {
                        'id': id,
                        'action'  :'holidays_data'
                    },
                    success: function (data) {
                        data = data.trim();
                        //alert(data);
                        console.log(data);
                        var result = data.split("|");

                        if (result[0] == 'success') {

                            $('#ModalHolidays').modal({backdrop: 'static', keyboard: false});
                            $('#ModalHolidays').modal('show');
                            $('#btnSaveModalHolidays').css("display", "block");
                            $('#btnSaveModalHolidays').text('Update');
                            $('#txtHolidaysId').val(id);
                            $('#datepicker-autoClose4').val(result[1]);
                            $('#datepicker-autoClose5').val(result[2]);
                            result[3] == 1 ? $('#chkIsActive').attr('checked',true) : $('#chkIsActive').attr('checked',false);
                            $('#txtEvent').val(result[4]);
                        }
                        else if (data == 'fail') {
                            $('#ModalWeekEnds').modal('hide');
                            $('html, body').animate({scrollTop: 0}, 600);
                            alert("Fail");
                        }
                    }
                });
            }
        });

        $(document).on('click', '#btnCloseHolidays', function () {
            $('#ModalHolidays').modal('hide');
        });
        /* End Holidays */
    });

    function validation()
    {
        var hasFocus = false;
        var errCount = 0;

        if($('#datepicker-autoClose').val() == "") 
        {
            $('#datepicker-autoClose').parents('.control-group').addClass('error');
            $('#datepicker-autoClose').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#datepicker-autoClose').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#datepicker-autoClose1').parents('.control-group').removeClass('error');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#datepicker-autoClose1').parent().find('.input-error').hide();
        }

        if($('#datepicker-autoClose1').val() == "") 
        {

            $('#datepicker-autoClose1').parents('.control-group').addClass('error');
            $('#datepicker-autoClose1').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#datepicker-autoClose1').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#datepicker-autoClose1').parents('.control-group').removeClass('error');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#datepicker-autoClose1').parent().find('.input-error').hide();
        }

        if (errCount > 0) {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        }
        else
            return true;
    }
</script>

</body>
</html>