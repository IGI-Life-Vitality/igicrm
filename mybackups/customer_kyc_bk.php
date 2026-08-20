<?php

$page_title = "Customer Information";
$menu_id = "customer_info";
$group_id = "kyc";

include('includes/header.php');
/*include('classes/eform.php');

$objeform = new eform();
$data = $objeform->e_form_complains($login_id,0);*/



?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->


<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Customer</a></li>
        <li class="active">View</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Customer Security Question</h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Customer Security Question</h4>
                </div>
                <div class="panel-body">
                    <!--<table id="data-table" class="table table-striped table-bordered">-->
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th style="text-align: center;">Question</th>
                            <th style="text-align: center;">Answer</th>
                            <th style="text-align: center;">Correct</th>
                            <th style="text-align: center;">Incorrect</th>
                            <th style="text-align: center;">Not Answered</th>
                        </tr>
                        </thead>


                        <tbody>

                            <tr>
                                <td><? echo "What is your CNIC Number?" ?></td>
                                <td><? echo "42201-5265471-5" ?></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired" id="radiorequired"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired2" id="radiorequired2"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired3" id="radiorequired3"></td>
                            </tr>

                            <tr>
                                <td><? echo "What is your Date of Birth?" ?></td>
                                <td><? echo "3-Nov-1971" ?></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired" id="radiorequired"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired2" id="radiorequired2"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired3" id="radiorequired3"></td>
                            </tr>

                            <tr>
                                <td><? echo "What is your Mobile Number?" ?></td>
                                <td><? echo "03332007896" ?></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired" id="radiorequired"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired2" id="radiorequired2"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired3" id="radiorequired3"></td>
                            </tr>

                            <tr>
                                <td><? echo "Who is your Employer?" ?></td>
                                <td><? echo "M3 Technologies (Pvt.) Ltd" ?></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired" id="radiorequired"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired2" id="radiorequired2"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired3" id="radiorequired3"></td>
                            </tr>

                            <tr>
                                <td><? echo "What is your Residence Phone Number?" ?></td>
                                <td><? echo "03333786112" ?></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired" id="radiorequired"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired2" id="radiorequired2"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired3" id="radiorequired3"></td>
                            </tr>

                            <tr>
                                <td><? echo "What is your Residence Address?" ?></td>
                                <td><? echo "Ibrahim Apartments" ?></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired" id="radiorequired"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired2" id="radiorequired2"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired3" id="radiorequired3"></td>
                            </tr>

                            <tr>
                                <td><? echo "What is your Email Address?" ?></td>
                                <td><? echo "zaheer@gmail.com" ?></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired" id="radiorequired"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired2" id="radiorequired2"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired3" id="radiorequired3"></td>
                            </tr>

                            <tr>
                                <td><? echo "What is your mother maiden name?" ?></td>
                                <td><? echo "" ?></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired" id="radiorequired"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired2" id="radiorequired2"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired3" id="radiorequired3"></td>
                            </tr>

                            <tr>
                                <td><? echo "What is your Office Address?" ?></td>
                                <td><? echo "N/A" ?></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired" id="radiorequired"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired2" id="radiorequired2"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired3" id="radiorequired3"></td>
                            </tr>

                            <tr>
                                <td><? echo "What is your Branch name?" ?></td>
                                <td><? echo "N/A" ?></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired" id="radiorequired"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired2" id="radiorequired2"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired3" id="radiorequired3"></td>
                            </tr>

                            <tr>
                                <td><? echo "What is your Passport Number?" ?></td>
                                <td><? echo "N/A" ?></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired" id="radiorequired"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired2" id="radiorequired2"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired3" id="radiorequired3"></td>
                            </tr>

                            <tr>
                                <td><? echo "What is your Credit Card Limit?" ?></td>
                                <td><? echo "Verify Manually" ?></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired" id="radiorequired"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired2" id="radiorequired2"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired3" id="radiorequired3"></td>
                            </tr>

                            <!--<tr>
                                <td><?/* echo "Original ID Seen" */?></td>
                                <td>
                                    <select style="width: 150px ;" class="form-control" id="select-required">
                                            <option value="">Select</option>
                                            <option value="foo">Yes</option>
                                            <option value="bar">No</option>
                                    </select>
                                </td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired" id="radiorequired"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired2" id="radiorequired2"></td>
                                <td style="text-align: center;"><input type="radio" name="radiorequired3" id="radiorequired3"></td>
                            </tr>-->

                        </tbody>

                    </table>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
</div>
<!-- end #content -->

<!--Begin Verify Model-->

<!--<div class="modal fade" id="ModalComments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="btnVerifiedComplaintClose" class="close" data-dismiss="modal">×</button>
                <h3>Verified Complaint Comments</h3>
            </div>

            <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;" id="div2">

                <div class="form-group">
                    <textarea class="form-control" style="width: 98%" rows="4" id="txtComments" placeholder="Enter Comments"></textarea><br />
                    <div class="input-error form-control-input" style="color: Red; display: none;">Please enter comments</div>
                </div>

                <div class="form-actions">
                    <input type="button" class="btn btn-warning btn-md" name="btnVerified" value="Verified" id="btnVerified" />
                </div>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>-->

<!--End Verify Model-->





<!-- begin #footer -->
<?php include('includes/footer.php') ?>
<!-- end #footer -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/table-manage-default.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        TableManageDefault.init();
    });
</script>

<!--<script type="text/javascript">
    $().ready(function() {
        var id = 0;
        var comments = '';

        $(document).on('click', '.btnVerify', function () {

            id = $(this).data('id');

            $('#ModalComments').modal({ backdrop: 'static', keyboard: false });
            $('#ModalComments').modal('show');
            $('#txtComments').focus();
            return false;
        });

        $(document).on('click', '#btnVerified', function () {
            comments = $('#txtComments').val();
            verified(id,comments);
        });

        $(document).on('click', '#btnVerifiedComplaintClose', function () {
            clear();
        });

        function verified(id,comments) {

            var action = "verified";

            if(validation()){

                $.ajax({
                    data: {
                        'id':id,
                        'action':action
                    },
                    type: 'POST',
                    url: "includes/ajax/action_eform_type.php",
                    success: function(data) {

                        data = data.trim();
                        console.log(data);

                        if(data == 'success'){
                            $('#ModalComments').modal('hide');
                            $('#notify_success_insert').show();
                        }else if(data == 'fail'){
                            $('#notify_error_insert').show();
                        }

                        setTimeout(function () {
                            $('.NotificationDiv').fadeOut('fast');
                            window.location.reload();
                        }, 2000);

                        clear();
                    }
                });
            }

        }

        function validation(){

            var hasFocus = false;
            var errCount = 0;


            if($('#txtComments').val() == '') {

                $('#txtComments').parents('.control-group').addClass('error');
                $('#txtComments').parent().find('.input-error').show().css('display', 'inline-block');

                if (!hasFocus) {
                    $('#txtComments').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else {
                $('#txtComments').parents('.control-group').removeClass('error');
                $('#txtComments').parent().find('.input-error').hide();
            }

            if (errCount > 0)
                return false;
            else
                return true;
        }

        function clear() {
            $('#txtComments').val('');
            $('#txtComments').parents('.control-group').removeClass('error');
            $('#txtComments').parent().find('.input-error').hide();
        }
    });
</script>-->


</body>
</html>