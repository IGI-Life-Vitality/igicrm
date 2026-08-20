<?php

$page_title = "Product Manager";
$permission_type = "view";
$module_id = "13";
$menu_id = "product_view";

include('includes/header.php');
include('classes/product.php');

$objProduct = new Product();

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
        <li><a href="javascript:;">Product Manager</a></li>
        <li class="active">View Products</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Product Manager</h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse panel-with-tabs" data-sortable-id="ui-unlimited-tabs-1">
                <div class="panel-heading p-0">
                    <div class="panel-heading-btn m-r-10 m-t-10">
                    </div>
                    <!-- begin nav-tabs -->
                    <div class="tab-overflow">
                        <ul class="nav nav-tabs nav-tabs-inverse">
                            <li class="prev-button"><a href="javascript:;" data-click="prev-tab" class="text-success"><i class="fa fa-arrow-left"></i></a></li>
                            <li class="active"><a id="tabProductCategoryDetails" href="#nav-tab-product_category_view" data-toggle="tab">Product Category Details</a></li>
                            <li class=""><a id="tabProductDetails" href="#nav-tab-product_type_view" data-toggle="tab">Product Details</a></li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">

                    <div class="tab-pane fade active in" id="nav-tab-product_category_view">
                        <div class="panel-body">
                            <!--Begin Product Category Details-->
                            <?php include ('product_category_list.php'); ?>
                            <!--End Product Category-->
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-tab-product_type_view">
                        <div class="panel-body">
                            <!--Begin Product Details-->
                            <?php include ('product_list.php'); ?>
                            <!--End Product Type-->
                        </div>
                    </div>

                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
</div>
<!-- end #content -->


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

<script type="text/javascript">
</script>

</body>
</html>
