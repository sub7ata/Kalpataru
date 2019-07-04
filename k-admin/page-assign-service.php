<?php include("functions/k_a_init.php"); ?>
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
  </head>
  <?php
  if (!logged_admin()) {
  redirect("page-login.php");
  }
  ?>
  <?php include("includes/k_a_nav.php") ?>
  <div class="content-page">
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="page-title-box">
              <h4 class="page-title">Assign Service</h4>
              <ol class="breadcrumb p-0 m-0">
                <li>
                  <a href="#">Kalpataru</a>
                </li>
                <li>
                  <a href="#">Services</a>
                </li>
                <li class="active">
                  Assign Service
                </li>
              </ol>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
   
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <a href="#custom-modal" class="btn btn-primary waves-effect w-md m-r-5 m-b-10" data-animation="door" data-plugin="custommodal"
                data-overlaySpeed="100" data-overlayColor="#36404a"><i class="fa fa-plus-circle"></i> Assign service</a>

<?php assign_service(); ?>
<?php display_message(); ?>
                
                <?php
                $sql = "SELECT * FROM assign_service WHERE city_status = 0 AND service_status = 0 ORDER BY id DESC";
                $result=(query($sql));
                if(row_count($result)<=0)
                {
                ?>
                
                <div class='alert alert-danger text-center'><strong>Not Found !</strong></div>
                
                <?php
                } else {
                ?>
                <table class="table table-striped add-edit-table table-bordered dt-responsive nowrap" id="datatable-editable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                  <thead>
                    <tr>
                      <th>Serial No.</th>
                      <th>Service Name</th>
                      <th>City</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <?php
                  $i = 0;
                  while($row =fetch_array($result)) {
                  $i++;
                  $id=$row["id"];
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
                        <?php
                        $service_id=$row["service_id"];
                        $sql2 = "SELECT * FROM services WHERE id = '$service_id'";
                        $result2 = query($sql2);
                        confirm($result2);
                        $row2=fetch_array($result2);
                        
                        echo ucwords($row2['name']);
                        ?>
                        
                      </td>
                      <td>
                        <?php
                        $city_id=$row["city_id"];
                        $sql1 = "SELECT * FROM city WHERE id = '$city_id'";
                        $result1 = query($sql1);
                        confirm($result1);
                        $row1=fetch_array($result1);
                        
                        echo ucwords($row1['city_name']);
                        ?>
                      </td>
                      
                      <td class="actions">
                        <?php if($status == 0){ ?>
                        <a href="page-assign-service.php?block=<?php echo $id?>" onclick="return confirm('Are you sure ?')" class="hidden on-editing save-row"><i class="fa fa-ban" style="color: red;"></i></a>
                        <?php }else{ ?>
                        
                        <a href="page-assign-service.php?accept=<?php echo $id?>" onclick="return confirm('Are you sure ?')" class="hidden on-editing save-row"><i class="fa fa-check"></i></a>
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
                        <?php
                        $service_id=$row["service_id"];
                        $sql2 = "SELECT * FROM services WHERE id = '$service_id'";
                        $result2 = query($sql2);
                        confirm($result2);
                        $row2=fetch_array($result2);
                        
                        echo ucwords($row2['name']);
                        ?>
                      </td>
                      
                      <td>
                        <?php
                        $city_id=$row["city_id"];
                        $sql2 = "SELECT * FROM city WHERE id = '$city_id'";
                        $result2 = query($sql2);
                        confirm($result2);
                        $row2=fetch_array($result2);
                        
                        echo ucwords($row2['city_name']);
                        ?>
                      </td>
                      
                      <td class="actions">
                        <?php if($status == 0){ ?>
                        <a href="page-assign-service.php?block=<?php echo $id?>" onclick="return confirm('Are you sure ?')" title="Block" class="hidden on-editing save-row"><i class="fa fa-ban" style="color: red;"></i></a>
                        <?php }else{ ?>
                        <a href="page-assign-service.php?accept=<?php echo $id?>" onclick="return confirm('Are you sure ?')" class="hidden on-editing save-row"><i class="fa fa-check"></i></a>
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
    $querB    = "UPDATE assign_service SET status = 1 WHERE id = '$block_id'";
    query($querB);
    
    header("location: page-assign-service.php");
    
    set_message("<div class='alert alert-danger'>
                <strong>Blocked</strong> successfully.</div>
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
    $quer1     = "UPDATE assign_service SET status = 0 WHERE id = '$accept_id'";
    query($quer1);
    
    header("location: page-assign-service.php");
    
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
              
              <div id="custom-modal" class="modal-demo">
                <button type="button" class="close" onclick="Custombox.close();">
                <span>&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="custom-modal-title">Assign Service</h4>
                <div class="custom-modal-text">
                  <form method="POST" autocomplete="off">
                    <div class="form-group row">
                      <label class="col-md-2 control-label">City Name</label>
                      <div class="col-md-10">
                        <select name="city" class=" md-form"  style="border: none; border-bottom: 1px solid #ced4da; width:100%;background-color: white;">
                          <option value=" " selected disabled>Select City</option>
<?php
$sql    = "SELECT * FROM city WHERE status = 0 ORDER by city_name ASC";
$result = (query($sql));
while ($row = mysqli_fetch_array($result)) {
    $id        = $row["id"];
    $city_name = $row["city_name"];
    echo "<option value='$id'> $city_name </option></a></li>";
    
}
?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-2 control-label">Service Name</label>
                      <div class="col-md-10">
                        <select name="service" class=" md-form"  style="border: none; border-bottom: 1px solid #ced4da; width:100%; background-color: white;">
                          <option value=" " selected disabled>Select Service</option>
<?php
$sql1    = "SELECT * FROM services WHERE status = 0 ORDER by name ASC";
$result1 = (query($sql1));
while ($row1 = mysqli_fetch_array($result1)) {
    $SId   = $row1["id"];
    $SName = $row1["name"];
    echo "<option value='$SId'> $SName </option></a></li>";
    
}
?>
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary waves-effect waves-light"> Save </button>
                    </div>
                  </form>
                </div>
              </div>
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

<script>
var resizefunc = [];
</script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/metisMenu.min.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="plugins/custombox/js/custombox.min.js"></script>
<script src="plugins/custombox/js/legacy.min.js"></script>
<script src="assets/js/jquery.core.js"></script>
<script src="assets/js/jquery.app.js"></script>
</body>
</html>