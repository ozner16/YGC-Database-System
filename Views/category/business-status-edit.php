<?php
require_once "../../Controllers/Database.php";

$db = new Database();
if (isset($_POST['edit_color'])) {
  $idedit = $_POST["edit-id"];
  $status = $_POST["status"];
  $color = $_POST["color"];

  $db->query("SELECT * FROM business_status WHERE `status` ='$status' OR color='$color';");
  $db->execute();
  $db->closeStmt(); 
  if (sizeof($db->resultSet()) === 0){
    $db->query("UPDATE business_status SET `status` ='$status', `color` ='$color' WHERE `id` = '$idedit';");
    $db->execute();
    $db->closeStmt();
    $_SESSION["success"] = "Data has been updated successfully.";
  }
  else{
    $_SESSION["failed-card"] = "Record is already exists!";
  }
}
?>
<section>
<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Status</h5>
        <div class="form-check">
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./business-status-index.php" method="POST">
        <div class="modal-body">
          <input type="hidden" class="form-control" name="edit-id" id="edit-id">
            <div class="container">
              <div class="row mt-2">
                <div class="col">
                  <label for="status" class="form-label">Status</label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="status" id="edit-status">
                    <span class="input-group-text border"><i class="fas fa-info pt-0 mr-3"></i></span>
                  </div>
                </div>
              </div>

              <div class="row mt-2">
                <div class="col">
                  <label for="color" class="form-label">Status color</label>
                  <input type="color" required class="form-control"  name="color" id="edit-color" aria-describedby="color">
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="edit_color" class="btn btn-primary ms-auto" >Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
</section>
