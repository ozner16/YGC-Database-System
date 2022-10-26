<?php
require_once "../../Controllers/Database.php";

$db = new Database();
if (isset($_POST['editmagazine'])) {
  $idedit = $_POST["edit-id"];
  $brand_title = $_POST["brand-title"];
  $status = $_POST["status"];
  $storage_link = $_POST["link"];
  $exhibitors_name = $_POST["exhibitors-name"];
  $edit_position = $_POST["edit-position"];
  
  $db->query("SELECT * FROM magazine WHERE `exhibitors_name`='$exhibitors_name' AND `position`='$edit_position' AND `storage_link`='$storage_link';");
  $db->execute();
  $db->closeStmt();  
  if (sizeof($db->resultSet()) === 0){
  $db->query("UPDATE magazine SET `brand_title` ='$brand_title', `status` ='$status',`storage_link` ='$storage_link' WHERE `id` = '$idedit';");
  $db->execute();
  $_SESSION["success"] = "Record successfully update.";
  $db->closeStmt();
  echo '<script> window.location.href="/WSAP_DATABASE/Views/magazine/index.php" </script>';	
}else{
  $_SESSION["failed"] = "Magazine information have no changes!";
  echo '<script> window.location.href="/WSAP_DATABASE/Views/magazine/index.php" </script>';	
}
}
?>

<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Edit Magazine</h5>
       
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./index.php" method="POST">
      <div class="modal-body"> 
  
      <div class="row mt-2">
            <div class="col">
            <input type="hidden" id="edit-id" name="edit-id" class="form-control" >
              <label for="exhibitors_name">Exhibitors Name</label><br>
              <div class="input-group">
             
                <input type="text" id="edit-exhibitors" name="exhibitors-name" class="form-control" disabled>
                <span class="input-group-text border"><i class="fas fa-address-card pt-0 mr-3"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="position">Position</label><br>
              <div class="input-group">
                <input type="text" class="form-control" id="edit-position" disabled>
                <span class="input-group-text border"><i class="fas fa-user-tie"></i></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="brand_title">Brand Title</label><br>
              <div class="input-group">
                <input type="text" class="form-control" id="edit-brand_title" name="brand-title">
                <span class="input-group-text border"><i class="fas fa-user-tag"></i></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->
          <div class="row mt-2">
            <div class="col">
              <label for="position">Status</label><br>
              <div class="input-group">
            
                <select id="edit-status" name="status" class="form-control">
                <option value="ONGOING">ONGOING</option>
                <option value="TO POST">TO POST</option>
                <option value="DONE">DONE</option>
              </select>
                <span class="input-group-text border"><i class="fas fa-toggle-on"></i></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="storage_link">Storage Link</label><br>
              <div class="input-group">
                <input type="text" class="form-control" id="edit-storage_link" name="link">
                <span class="input-group-text border"><i class="fas fa-database"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->
        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ms-auto" name="editmagazine">Save Changes</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>
