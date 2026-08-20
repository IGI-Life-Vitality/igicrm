<?php
$page_title = "Hospital Manager";
$permission_type = "view";
$module_id = "36";
$parent_id = '20';
$menu_id = "hospital_view";

include('includes/header.php');
include('classes/product.php');

$objProduct = new Product();
$data = $objProduct->GetHospital();
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
        <li><a href="javascript:;">Administration</a></li>
        <li class="active">View Hospital</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Administration</h1>
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
                    </div>
                    <h4 class="panel-title">Hospital Details</h4>
                </div>
                <div class="panel-body">
                    <table id="myTable" class="table table-striped table-bordered">
                        <thead>
                          <tr>
                              <th>Hospital</th>
                              <th>Is Active</th>
                              <th>Action</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php foreach ($data as $row){ ?>
                              <tr>
                                  <td><?php echo $row['fullname']; ?></td>
                                  <td><input type="checkbox" <?php echo ($row['isactive'] ? "checked='checked'" : ""); ?> disabled="disabled"></td>
                                  <td class="center">
                                      <a class="btn btn-primary btn-sm checkUpdate" href="hospital_add.php?id=<?php echo $row['id']; ?>">
                                          Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                      </a>
                                      <!-- <a class="btn btn-danger btn-sm checkDelete" href="#" onclick="javascript:return DEL(<?php //echo $row['id']; ?>);">
                                          Delete <i class="glyphicon glyphicon-trash icon-white"></i>
                                      </a> -->
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
<?php include('includes/footer.php'); ?>
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
<script src="assets/plugins/DataTables/extensions/Responsive/js/buttons.colVis.min.js"></script>
<script src="assets/js/table-manage-buttons.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        TableManageButtons.init();
    });

    $(document).ready(function() {
        $('#myTable').DataTable( {
            dom: 'Bfrtip',
            columnDefs: [
                {
                    targets: 1,
                    className: 'noVis'
                }
            ],
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [ 0, 1 ]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [ 0, 1 ]
                    }
                },
                {
                    extend: 'colvis',
                    columns: ':not(.noVis)'
                }
            ]
        } );
    } );

    function DEL(id){
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
      function(isConfirm) {
          if (isConfirm) {
            $.ajax({
                    data: {
                        'action':'delete_hospital',
                        'id':id
                    },
                    type: 'POST',
                    url: "includes/ajax/action_product.php",
                    success: function(data) {
                          //alert(data);
                        var result = data.split("|");
                        if(result[0] == 'success'){
                            $('#data-table').html(result[1]);
                            $('#data-table').dataTable({ 
                                       destroy: true,            
                                       responsive: true,            
                                       searching: false,            
                                       pageLength: 10,            
                                       order: [[ 0, "asc" ]]       
                                        });
                            swal({ title: "Deleted!", text: "Record has been deleted.", type: "success" ,confirmButtonClass: "btn-success", timer: 2000});
                        }else{
                           swal({ title: "Error!", text:  "Someting Goes Wrong.", type: "error" , confirmButtonClass: "btn-danger" ,timer: 2000 });

                        }      
                    }
                });
            
             

          } else {
            swal({ title: "Cancelled", text: "Record is safe :)", type: "error" ,confirmButtonClass: "btn-success"  , timer: 2000});
          }
    }); 
}
</script>

</body>
</html>