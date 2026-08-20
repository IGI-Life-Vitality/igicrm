<?php
$page_title = "Leads Mapping";
$permission_type = "view";
$module_id = "39";
$parent_id = '35';
$menu_id = "leads_mapping_view";

include('includes/header.php');
include('classes/product.php');
include('classes/lead.php');

$objProduct = new Product();
$objLead    = new Lead();

$data = $objLead->GetLeadsMapping();
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Leads Management</a></li>
        <li class="active">View Leads Mapping</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Leads Management</h1>
    <!-- end page-header -->

    <?php 
      /*echo "<pre>";
        print_r($data);
      echo "</pre>";*/
    ?>

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
                    </div>
                    <h4 class="panel-title">View Leads Mapping</h4>
                </div>
                <div class="panel-body">
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Region</th>
                            <th>City</th>
                            <th>Regional Area</th>
                            <th>Regional Manager</th>
                            <th>Product Type</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                          <?php foreach ($data as $row) { ?>
                              <tr>
                                <td><?php echo $row['region']; ?></td>
                                <td><?php echo $row['city']; ?></td>
                                <td>
                                  <?php
                                    $area_id  = $row['lead_region_area'];
                                    $area_ids = explode(",", $area_id);
                                    $city_area = "";
                                    foreach($area_ids as $area_id)
                                    {
                                      $area_name = $objLead->GetRegionalAreas($area_id);
                                      $area   = ucfirst($area_name[0]['area']);
                                      $city_area .= $area.", ";
                                      echo "<span>" . $city_area . "</span>";
                                      $city_area ="";
                                    }
                                  ?>
                                </td>
                                <td><?php echo $row['regional_manager']; ?></td>
                                <td>
                                  <?php
                                    $product_name  = $row['lead_product'];
                                    $product_name_ids = explode(",", $product_name);
                                    
                                    foreach($product_name_ids as $product_name_id)
                                    {
                                      $product_name = $objLead->GetProducts($product_name_id);
                                      $product_name   = ucfirst($product_name[0]['fullname']);
                                      echo $product_name;
                                    }
                                  ?>    
                                </td>
                                <td class="center">
                                  <a class="btn btn-primary btn-xs checkUpdate" href="leads_mapping_add.php?id=<?php echo $row['id']; ?>"> Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                  </a>
                                </td>
                              </tr>
                          <?php } ?>
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


<!-- begin #footer -->
<?php include('includes/footer.php') ?>
<!-- end #footer -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/jszip.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/pdfmake.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/vfs_fonts.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/buttons.print.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/table-manage-buttons.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
      App.init();
      TableManageButtons.init();
    });

    function DEL(id)
    {
      swal({
          title: "Are you sure?",
          text: "You will not be able to recover!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Delete!",
          cancelButtonText: "Cancel",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm) 
        {
          if (isConfirm) 
          {
            $.ajax({
                    data: 
                    {
                      'action':'delete_hospital',
                      'id':id
                    },
                    type: 'POST',
                    url: "includes/ajax/action_product.php",
                    success: function(data) 
                    {
                        //alert(data);
                        var result = data.split("|");

                        if(result[0] == 'success')
                        {
                          $('#data-table').html(result[1]);
                          $('#data-table').dataTable({ 
                            destroy: true,            
                            responsive: true,            
                            searching: false,            
                            pageLength: 10,            
                            order: [[ 0, "asc" ]]       
                          });

                          swal({ title: "Deleted!", text: "Record has been deleted.", type: "success" ,confirmButtonClass: "btn-success", timer: 2000});
                        }
                        else
                        {
                          swal({ title: "Error!", text:  "Someting Goes Wrong.", type: "error", confirmButtonClass: "btn-danger", timer: 2000 });
                        }      
                    }
                });
          } 
          else 
          {
            swal({ title: "Cancelled", text: "Record is safe :)", type: "error",confirmButtonClass: "btn-success"  , timer: 2000});
          }
      });
    }
</script>

</body>
</html>