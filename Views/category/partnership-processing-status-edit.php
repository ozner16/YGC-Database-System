<?php
require_once "../../Controllers/Database.php";

$db = new Database();
if (isset($_POST['edit-pps'])) {

  $id = $_POST['id'];
  $status = $_POST['partnership-processing-status'];

  $db->query("SELECT * FROM partnership_processing_status WHERE pp_status ='$status';");
      $db->execute();
      $db->closeStmt(); 
      if (sizeof($db->resultSet()) === 0){
        $db->query("UPDATE partnership_processing_status SET `pp_status` ='$status' WHERE `id` = '$id';");
        $db->execute();
        $db->closeStmt();
       
      $_SESSION["success-card"] = "Data has been updated successfully.";
      } 
      else{
        $_SESSION["failed-card"] = "Partnership Processing Status already exists!";
      }
}
?>

<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Edit Partnership Processing Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./partnership-processing-status-index.php" method="POST">
        <div class="modal-body"> 
         
          <div class="row mt-2">
            <div class="col">
            <input type="hidden" id="edit-id" name="id" style="width:460px;margin-bottom:12px;">
              <label for="package_price">Status</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="partnership-processing-status" id="edit-partnership-processing-status">
                <span class="input-group-text"><i class="fas fa-solid fa-info"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->
          <br>

        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ms-auto" name="edit-pps">Save changes</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>