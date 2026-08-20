<?php
    include('includes/config.php');
    include('classes/user.php');
    $objUser = new User();
    $objUser->checkUser();

    if (isset($_SESSION['login_id'])) 
    {
        $login_id = $_SESSION['login_id'];
    }

    if (isset($_SESSION['group_id'])) 
    {
        $group_id = $_SESSION['group_id'];
    }

    if (isset($_SESSION['user_type'])) 
    {
        $user_type = $_SESSION['user_type'];
    }

    if($menu_id != 'dashboard' && $module_id != '0' && $user_type != '1')
    {
        $checkPermission = $objUser->GetPermissions($module_id,$permission_type);
        
        $str = "";
        foreach ($checkPermission as $value) 
        {
            
            $str .= $value[$permission_type].",";
        }
         
        //$str = "0,0,1,";
        $fnd = strpos($str,"1");

        if($fnd === false)
        {
            header( "Location: http://".$_SERVER['HTTP_HOST']."/igicrm/unauthorized.php",false ) ;
        }
    }
    
    // Check internet connectivity, if yes login to dashboad else logout from CRM
    /*$fun = is_connected();

    if($fun == 0)
    {
        header('Location: logout.php');
    }

    function is_connected()
    {
        $connected = @fsockopen("www.google.com",80);

        //website, port  (try 80 or 443)
        if ($connected)
        {
            $is_conn = 1; //action when connected
            fclose($connected);
        }
        else
        {
            $is_conn = 0; //action in connection failure
        }
        return $is_conn;
    }

    $date = DATE('Y-m-d');
    
    if($date > '2019-09-01')
    {
        header('Location: crm_expired.php');
        exit;
    }*/
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title><?php echo ($page_title); ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link rel="icon" href="assets/img/IGI.png" type="image/png" sizes="57x57">

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/plugins/ionicons/css/ionicons.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link href="assets/css/style.min.css" rel="stylesheet" />
    <link href="assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="assets/css/theme/default.css" rel="stylesheet" id="theme" />

    <link href="assets/plugins/notification/css/jquery.notifyBar.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" />
    <link href="assets/css/igiStyle.css" rel="stylesheet" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>

<body>
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">

    <!-- begin #header -->
    <div id="header" class="header navbar navbar-default navbar-fixed-top">
        <!-- begin container-fluid -->
        <div class="container-fluid">
            <!-- begin mobile sidebar expand / collapse button -->
            <div class="navbar-header">
                <div class="brand">
                    <span class="logo"><a href="dashboard.php" class="navbar-brand"><img src="assets/img/logo.png" alt="IGI Life Logo"></a></span>
                </div>

                <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- end mobile sidebar expand / collapse button -->

            <!-- begin header navigation right -->
            <ul class="nav navbar-nav navbar-right">
                <!-- <li>
                    <form class="navbar-form full-width">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter keyword" />
                            <button type="submit" class="btn btn-search"><i class="ion-ios-search-strong"></i></button>
                        </div>
                    </form>
                </li> -->

                <!-- <li class="dropdown">
                    <a href='javascript:;' data-toggle='dropdown' class='dropdown-toggle icon'>
                        <i class='ion-ios-bell'></i>
                        <span class='label' id="divNotCounts">0</span>
                    </a>
                
                    <ul class='dropdown-menu media-list pull-right animated fadeInDown' id="divNotification">
                
                    </ul>
                </li> -->

                <li class="dropdown navbar-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<span class="user-image online">
								<img src="assets/img/IGI-Pro.png" alt="" />
							</span>
                        <span class="hidden-xs"><?php echo @$_SESSION['user_name']; ?></span> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu animated fadeInLeft">
                        <li class="arrow"></li>
                        <!--<li><a href="javascript:;">Edit Profile</a></li>
                        <li><a href="javascript:;"><span class="badge badge-danger pull-right">2</span> Inbox</a></li>
                        <li><a href="javascript:;">Calendar</a></li>
                        <li><a href="javascript:;">Setting</a></li>
                        <li class="divider"></li>-->
                        <li><a href="change_password.php">Change Password</a></li>
                        <li><a href="logout.php">Log Out</a></li>
                    </ul>
                </li>
            </ul>
            <!-- end header navigation right -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- end #header -->

    <div id="top-menu" class="top-menu">
        <div class="panel-heading">
            <h4 class="panel-title" style="color: #fff0f0"></h4>
        </div>
    </div>

    <!-- begin #sidebar -->
    <?php include('includes/sidebar.php'); ?>
    <!-- end #sidebar -->
    <br /> 
    <br />

    <div class="modal fade" id="ModalWorkcode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="my_modal_width">
                <div class="modal-content ">
                
                    <div class="modal-header">
                        <button type="button" id="btnVerifiedComplaintClose" class="close" data-dismiss="modal">
                            <span class="label"> <!--data-click="panel-reload-->
                                <a href="javascript:;" class="btn btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a>
                            </span>
                        </button>
                    <h4>Workcode Form</h4>
                    </div>
                    <div class="modal-header">
                    <div class="panel panel-inverse" data-sortable-id="ui-widget-3" data-init="true">
                        <div class="panel-heading">
                            <div class="btn-group pull-right" data-toggle="buttons">
                                <label class="btn btn-warning btn-xs">
                                    <input type="radio" name="options" id="option1" checked=""> End Session
                                </label>
                                <label class="btn btn-danger btn-xs">
                                    <input type="radio" name="options" id="option2"> Cancel
                                </label>
                            </div>
                            <h4 class="panel-title">Session History Detail</h4>
                        </div>
                        <div class="legend1 margin_top_and_bottom">Call Outcome</div>
                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" name="optionsRadios" value="option1" checked="">
                                Full Satisfied
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="optionsRadios" value="option2">
                                Satisfied
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="optionsRadios" value="option3">
                                Somehow Satisfied
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="optionsRadios" value="option4">
                                Somehow Unsatisfied
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="optionsRadios" value="option5">
                                Fully Unsatisfied
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="optionsRadios" value="option6">
                                None
                            </label>
                        </div>
                        <div class="margin_top_and_bottom">
                            <div class="panel-inverse" data-sortable-id="ui-widget-1" data-init="true">
                            <div class="panel-heading">
                                <div class="panel-heading-btn">
                                    <span class="label pull-left"><a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-folder-open"></i></a> Add file</span>
                                    <span class="label pull-left"><a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> Remove All</span>
                                    <span class="label pull-left"><a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> Delete</span>
                                </div>
                                <h4 class="panel-title">Logged Activities</h4>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S.no</th>
                                            <th>Description</th>
                                            <th>Time</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                            <td>Table cell</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>

                        <div class="legend1 margin_top_and_bottom">Caution Box</div>
                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" name="optionsRadios" value="option1" checked=""> True
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="optionsRadios" value="option2"> False
                            </label>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="2" id="txtComments" placeholder="Enter Comments"></textarea>
                            <div class="input-error form-control-input" style="color: Red; display: none;">Please enter comments</div>
                        </div>
                        <div class="legend1">Notes</div>
                        <div class="form-group">
                            <textarea class="form-control" rows="2" id="txtComments" placeholder="Enter Comments"></textarea>
                            <div class="input-error form-control-input" style="color: Red; display: none;">Please enter comments</div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/plugins/bootstrap-sweetalert/sweetalert.min.js"></script>
    <script src="assets/js/ui-modal-notification.demo.min.js"></script>

    <script src="assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="assets/plugins/notification/jquery.notifyBar.js"></script>

    <script src="assets/js/jquery.inputmask.bundle.js"></script>

    <script type="text/javascript">
        var user_type = '<? echo $user_type; ?>';
        var moduleid = '<? echo $module_id; ?>';
        var permission = '';

        $(document).ready(function() {
            if(user_type != '2'){
                //GetNotification();
            }
        });

        $(document).on('click', '#divNotification', function () {

        });

        $(document).on('click', '.checkUpdate', function () {
            permission = 'update';
            if(user_type != '1'){
                return CheckPermissions(moduleid,permission);
            }else{
                return true;
            }
        });

        $(document).on('click', '#ancCollapse', function () {
            $('#top-menu').toggleClass('top-menu top-menu-2');
        });

        $(document).on('click', '.checkDelete', function () {
            permission = 'delete';

            if(user_type != '1'){
                return CheckPermissions(moduleid,permission);
            }else{
                return true;
            }
        });

        function GetNotification()
        {
            var site_url = 'includes/ajax/action_notification.php';

            jQuery.ajax({
                type: "POST",
                url: site_url,
                cache: false,
                dataType: 'text',
                data: {
                    'action' : 'get_notification'
                },
                success: function(data) 
                {
                    data = data.split("|");
                    console.log("Notification Received " + data[0]);

                    //$("#divNotCounts").html(data[0]);
                    //$("#divNotification").html(data[1]);

                    $("#divNotCounts").html(0);
                    $("#divNotification").html(0);
                }
            });

            //setTimeout('GetNotification()', 1000);
        }

        function CheckPermissions(moduleid,permission)
        {
            var site_url = 'includes/ajax/action_permission.php';
            var stop = true;

            $.ajax({
                    type: "POST",
                    url: site_url,
                    data: {
                        'action'     : 'get_permission',
                        'moduleid'   : moduleid,
                        'permission' : permission
                    },
                    async: false
                })
                .done(function (data) {

                    if(data == 0){
                        GetModal(permission);
                        stop = false;
                    }
                })
                .always(function () {

                });
                
            return stop;
        }

        function GetModal(permission)
        {
            swal({
                title: "Permission Denied",
                text: "You are not authorized to " + permission + " this record..!",
                type: "error",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "OK!"
            })
        }
    </script>
