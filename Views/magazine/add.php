<?php
require_once "../../Controllers/Database.php";

$db = new Database();


if (isset($_POST['addmagazine'])) {
  $id = $_POST["ID"];
  $exhibitor_name = $_POST["exhibitor_name"];
  $brand_title = $_POST["brand_title"];
  $position = $_POST["position"];
  $status = $_POST["status"];
  $storage_link = $_POST["storage_link"];

  $db->query("SELECT * FROM magazine WHERE `storage_link`='$storage_link';");
  $db->execute();
  $db->closeStmt();  
  if (sizeof($db->resultSet()) === 0){
  $db->query("INSERT INTO magazine (`business_id`, `position`, `brand_title`, `exhibitors_name`, `status`, `storage_link`)
  VALUES ( '$id', '$position', '$brand_title' , '$exhibitor_name',  '$status','$storage_link' ) ;");
  $db->execute();
  $_SESSION["success"] = "Record successfully added.";
  $db->closeStmt();
  echo '<script> window.location.href="/WSAP_DATABASE/Views/magazine/index.php" </script>';	
  }else{
    $_SESSION["failed"] = "Magazine information is already in the database!";
    echo '<script> window.location.href="/WSAP_DATABASE/Views/magazine/index.php" </script>';	
  }

}
  


?>

<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add Magazine</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./index.php" method="POST">
        <div class="modal-body"> 
        <div class="row mt-2">
            <div class="col">
              <label for="position">Company Name</label><br>
              <div class="input-group">
            <select name="ID" class="form-control">
            <?php 
             $db->query("SELECT * from business");
              $db->execute();
              $status_query = $db->resultSet();
              $db->closeStmt();
              foreach ($status_query as $row){ 
              ?>
              <option value="<?= $row->id ?>"><?= $row->business_name ?></option>
             <?php 
             } ;
             ?>
              </select>
                <span class="input-group-text border"><i class="fas fa-solid fa-building "></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="exhibitors_name">Exhibitors Name</label><br>
              <div class="input-group">
                <input type="text" name="exhibitor_name" class="form-control">
                <span class="input-group-text border"><i class="fas fa-address-card pt-0 mr-3"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="position">Position</label><br>
              <div class="input-group">
                <input type="text"  name="position" class="form-control">
                <span class="input-group-text border"><i class="fas fa-user-tie"></i></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="brand_title">Brand Title</label><br>
              <div class="input-group">
                <input type="text" name="brand_title"  class="form-control">
                <span class="input-group-text border"><i class="fas fa-user-tag"></i></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

       

          <div class="row mt-2">
            <div class="col">

              <label for="status">Status</label><br>
              <div class="input-group">
              <select name="status" class="form-control">
                <option value="ONGOING">ONGOING</option>
                <option value="TO POST">TO POST</option>
                <option value="DONE">DONE</option>
              </select>
                <span class="input-group-text border"><i class="fas fa-toggle-on"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="storage_link">Storage Link</label><br>
              <div class="input-group">
                <input type="text"  name="storage_link" class="form-control">
                <span class="input-group-text border"><i class="fas fa-database"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->
        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="addmagazine" class="btn btn-primary ms-auto" >Submit</button>
        </div> <!-- modal-footer closing -->
    </form>
  </div>
</div>