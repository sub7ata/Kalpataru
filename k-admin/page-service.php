<?php
include("functions/k_a_init.php");
?>
<?php
if (!logged_admin()) {
    redirect("page-login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>K-admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="assets/images/favicon123.png">
    <link href="plugins/custombox/css/custombox.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
    <script src="assets/js/modernizr.min.js"></script>
    <style type="text/css">
    </style>
  </head>
  <?php include("includes/k_a_nav.php") ?>
  <div class="content-page">
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="page-title-box">
              <h4 class="page-title">Services</h4>
              <ol class="breadcrumb p-0 m-0">
                <li>
                  <a href="#">Kalpataru</a>
                </li>
                <li>
                  <a href="#">Services</a>
                </li>
                <li class="active">
                  Services
                </li>
              </ol>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
        
        <!-- Custom Modals -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <a href="#custom-modal" class="btn btn-primary waves-effect w-md m-r-5 m-b-10" data-animation="door" data-plugin="custommodal"
                data-overlaySpeed="100" data-overlayColor="#36404a"><i class="fa fa-plus-circle"></i> Add service</a>
<?php display_message(); ?>
<?php add_service(); ?>                

<?php
$sql    = "SELECT * FROM services ORDER BY id DESC";
$result = (query($sql));
if (row_count($result) <= 0) {
echo " <div class='alert alert-danger text-center'><strong>Not Found !</strong></div>";

} else {
?>
                <table class="table table-striped add-edit-table table-bordered dt-responsive nowrap" id="datatable-editable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                  <thead>
                    <tr>
                      <th>Serial No.</th>
                      <th>Service Name</th>
                      <th>Service ID</th>
                      <th>No of Workers</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
<?php
$i = 0;
while ($row = fetch_array($result)) {
    $i++;
    $id     = $row["id"];
    $status = $row["status"];

?>
                  <tbody>
                    <?php
                    if($i%2 == 0){
                    ?>
                    
                    <tr class="gradeX" style="background-color: white">
                      <td>
                        <?php echo $i;?>
                      </td>
                      <td>
                        <?php echo $row["name"]; ?>
                      </td>
                      <td> <?php echo $row["service_id"]; ?>
                      </td>
                      <td>
                        <span class="badge badge-pill badge-primary">
<?php
$sql2    = "SELECT id FROM employee WHERE service_id = $id AND approve = 0";
$result2 = query($sql2);
confirm($result2);
$i2 = 0;
while ($row2 = fetch_array($result2)) {
    $i2++;
}
echo $i2;
?>
                        </span>                </td>
                        <td class="actions">
                          <?php if($status == 0){ ?>
                          <a href="page-service.php?block=<?php echo $id?>" onclick="return confirm('Are you sure ?')" class="hidden on-editing save-row"><i class="fa fa-ban" style="color: red;"></i></a>
                          <?php }else{ ?>
                          
                          <a href="page-service.php?accept=<?php echo $id?>" onclick="return confirm('Are you sure ?')" class="hidden on-editing save-row"><i class="fa fa-check"></i></a>
                          <?php } ?>
                        </td>
                      </tr>
                      <?php
                      }else{
                      ?>
                      <tr class="gradeC">
                        <td>
                          <?php echo $i;?>
                        </td>
                        <td>
                          <?php echo $row["name"]; ?>
                        </td>
                        <td>  <?php echo $row["service_id"]; ?>
                        </td>
                        
                        <td>
                          <span class="badge badge-pill badge-info">
<?php
$sql2    = "SELECT id FROM employee WHERE service_id = $id AND approve = 0";
$result2 = query($sql2);
confirm($result2);
$i2 = 0;
while ($row2 = fetch_array($result2)) {
    $i2++;
}
echo $i2;
?>

                          </span>
                        </td>
                        <td class="actions">
                          <?php if($status == 0){ ?>
                          <a href="page-service.php?block=<?php echo $id?>" onclick="return confirm('Are you sure ?')" title="Block" class="hidden on-editing save-row"><i class="fa fa-ban" style="color: red;"></i></a>
                          <?php }else{ ?>
                          <a href="page-service.php?accept=<?php echo $id?>" onclick="return confirm('Are you sure ?')" class="hidden on-editing save-row"><i class="fa fa-check"></i></a>
                          <?php } ?>
                        </td>
                      </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                    <?php
                    }
                    }
                  echo "</table>";
                  ?>
                  
                  <?php
if (isset($_GET['block'])) {
    $block_id = $_GET['block'];
    $querB    = "UPDATE services SET status = 1 WHERE id = '$block_id'";
    query($querB);
    
    header("location: page-service.php");
    
    set_message("<div class='alert alert-danger'>
                  <strong>Blocke </strong>successfully.</div>
                  <script type='text/javascript'>
                  window.setTimeout(function() {
                  $('.alert').fadeTo(500, 0).slideUp(500, function(){
                  $(this).remove();
                  });
                  }, 2000);
                  </script>
                  ");
}
?>
                 <?php
if (isset($_GET['accept'])) {
    $accept_id = $_GET['accept'];
    $quer1     = "UPDATE services SET status = 0 WHERE id = '$accept_id'";
    query($quer1);
    
    header("location: page-service.php");
    
    set_message("<div class='alert alert-info'>
                  <strong>Approved</strong> successfully.</div>
                  <script type='text/javascript'>
                  window.setTimeout(function() {
                  $('.alert').fadeTo(500, 0).slideUp(500, function(){
                  $(this).remove();
                  });
                  }, 2000);
                  </script>
                  ");
}
?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <center>
        2019 © Kalpataru.
        </center>
      </footer>
    </div>
    
  </div>
  
  <div id="custom-modal" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.close();">
    <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Add new Service</h4>
    <div class="custom-modal-text">
      <form method="POST" autocomplete="off" enctype="multipart/form-data">
        <div class="form-group row">
          <label class="col-md-2 control-label">Service Name</label>
          <div class="col-md-10">
            <input type="text" name="service" class="form-control" value="">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 control-label">Service page Image </label>
          <div class="col-md-10">
            <input type="file" name="img1" class="form-control" value="">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 control-label">Homepage page Icon</label>
          <div class="col-md-10">
            <input type="file" name="img2" class="form-control" value="">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-2 control-label">About Service</label>
          <div class="col-md-10">
            <textarea name="about" required="required" class="form-control" rows="4"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary waves-effect waves-light"> Save </button>
        </div>
      </form>
    </div>
  </div>
  <script>
  var resizefunc = [];
  </script>
  <!-- jQuery  -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/metisMenu.min.js"></script>
  <script src="assets/js/waves.js"></script>
  <script src="assets/js/jquery.slimscroll.js"></script>
  <script src="plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
  <!-- Modal-Effect -->
  <script src="plugins/custombox/js/custombox.min.js"></script>
  <script src="plugins/custombox/js/legacy.min.js"></script>
  <!-- App js -->
  <script src="assets/js/jquery.core.js"></script>
  <script src="assets/js/jquery.app.js"></script>
</body>
</html>