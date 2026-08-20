<?php

ob_start();
session_start();

if (isset($_SESSION['user_id'])) {

    if ($_SESSION['user_type'] == 3 ){
              
              header('Location: search.php');
         }else{
             header('Location: dashboard.php');
         } 
    //exit;
}

?>


<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>::IGI Admin | Login Page.::</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link rel="icon" href="assets/img/IGI.png" type="image/png" sizes="57x57">

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/plugins/ionicons/css/ionicons.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
     <link href="assets/plugins/notification/css/jquery.notifyBar.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.min.css" rel="stylesheet" />
    <link href="assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="assets/css/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body class="pace-top">
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->

<div class="login-cover">
    <div class="login-cover-image"><img src="assets/img/login-bg/bg-2.jpg" data-id="login-cover-image" alt="" /></div>
    <div class="login-cover-bg"></div>
</div>

<!-- begin #page-container -->
<div id="page-container" class="fade">
    <!-- begin login -->
    <div class="login login-v2" data-pageload-addclass="animated fadeIn">
        <!-- begin brand -->
        <div class="login-header">
            <div class="brand">
                <span class="logo"><img src="assets/img/logo.png" alt=""></span>
            </div>
            <div class="icon" style="display: none;">
                <i class="ion-ios-locked"></i>
            </div>
        </div>
        <!-- end brand -->
        <div class="login-content">
            <form action="#" method="POST" class="margin-bottom-0" id="LoginForm">
                <div class="form-group m-b-20">
                    <input type="text" class="form-control input-lg" placeholder="Email Address" id="txtEmail" name="txtEmail" />
                </div>
                <div class="form-group m-b-20">
                    <input type="password" class="form-control input-lg" placeholder="Password" id="txtPass" name="txtPass" />
                </div>
                <div class="login-buttons">
                    <button type="button" class="btn btn-primary btn-block btn-lg" id="btnSignin" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Validating...">Sign me in</button>
                </div>
                <div class="m-t-20" style="display: none;">
                    Not a member yet? Click <a href="#">here</a> to register.
                </div>
            </form>
        </div>
    </div>
    <!-- end login -->

    <ul class="login-bg-list clearfix" style="display: none;">
        <li class="active"><a href="#" data-click="change-bg"><img src="assets/img/login-bg/bg-1.jpg" alt="" /></a></li>
        <li><a href="#" data-click="change-bg"><img src="assets/img/login-bg/bg-2.jpg" alt="" /></a></li>
        <li><a href="#" data-click="change-bg"><img src="assets/img/login-bg/bg-3.jpg" alt="" /></a></li>
        <li><a href="#" data-click="change-bg"><img src="assets/img/login-bg/bg-4.jpg" alt="" /></a></li>
        <li><a href="#" data-click="change-bg"><img src="assets/img/login-bg/bg-5.jpg" alt="" /></a></li>
        <li><a href="#" data-click="change-bg"><img src="assets/img/login-bg/bg-6.jpg" alt="" /></a></li>
    </ul>

</div>
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="assets/plugins/jquery/jquery-1.9.1.min.js"></script>
<script src="assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="assets/crossbrowserjs/html5shiv.js"></script>
<script src="assets/crossbrowserjs/respond.min.js"></script>
<script src="assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="assets/plugins/notification/jquery.notifyBar.js"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/js/login-v2.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        LoginV2.init();
    });
</script>

<script type="text/javascript">



    $(document).on('click', '#btnSignin', function () {
        login();
        return false;
    });

    $('#LoginForm').keypress(function (e) {
        if (e.which == 13) {
            login();
        }
    });


    function login() {

        var action = 'login';
        var email = $('#txtEmail').val();
        var password = $('#txtPass').val();

    if(validation()){

          $("#btnSignin").button('loading');
        $.ajax({
            data: {
                'action': action,
                'email' : email,
                'password':password
            },
            type: 'POST',
            url: "includes/ajax/action_login.php",
            success: function(data) {
               // alert(data);
                //data = data.trim();
                console.log(data);
                var obj = jQuery.parseJSON(data);
                //alert(obj.Status);
                $("#btnSignin").button('reset');
            if(!isEmpty(obj)){
               //alert(obj.Status);
                if(obj.Status == 'success'){
                    $('#divError').hide();
                    window.location = 'index.php';
                }else if(obj.Status == 'user block'){
                      $.notifyBar({ cssClass: "warning", html: "Alert! User has been blocked for 15 minutes", delay: 2000, animationSpeed: "normal" });
                }else if(obj.Status == 'fail password'){
                      $.notifyBar({ cssClass: "error", html: "Error Occured, Invalid Username Or Password", delay: 2000, animationSpeed: "normal" });
                }else if(obj.Status == 'fail_exists'){
                      $.notifyBar({ cssClass: "error", html: "Error Occured, User Not Found", delay: 2000, animationSpeed: "normal" });
                }else if(obj.Status == 'user deactive'){
                      $.notifyBar({ cssClass: "error", html: "Error Occured, Deactive User", delay: 2000, animationSpeed: "normal" });
                }else if(obj.Status == 'expired'){
                    $.notifyBar({ cssClass: "error", html: "Error Occured, User Expired", delay: 2000, animationSpeed: "normal" });
                }
            }
          }
        });
      }
    }


    function isEmpty(obj) {
        for(var prop in obj) {
            if(obj.hasOwnProperty(prop))
                return false;
        }
        return true;
    }

    function validation (){
        var email = $('#txtEmail').val();
        var password = $('#txtPass').val();

        if(email == "" || password == "" ){
            $.notifyBar({ cssClass: "warning", html: "Alert! Empty username OR Password", delay: 2000, animationSpeed: "normal" });
            return false;

        }else{
            return true;
        }

    }
</script>

</body>
</html>

