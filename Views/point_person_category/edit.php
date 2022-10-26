<?php
require_once "../../Controllers/Database.php";

$db = new Database();
if (isset($_POST['edit-ps'])) {

  $id = $_POST['id'];
  $status = $_POST['category'];
  $db->query("SELECT * FROM point_person_category WHERE category_name ='$status';");
  $db->execute();
  $db->closeStmt(); 
  if (sizeof($db->resultSet()) === 0){
  $db->query("UPDATE point_person_category SET `category_name` ='$status' WHERE `id` = '$id';");
  $db->execute();
  $db->closeStmt();
  $_SESSION["success-card"] = "Record successfully updated.";
}
else{
  $_SESSION["failed-card"] = "Information is already in the database!";
}
}
?>

<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Edit Point Person Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./index.php" method="POST">
        <div class="modal-body"> 
         
          <div class="row mt-2">
            <div class="col">
            <input type="hidden" id="edit_id" name="id" style="width:460px;margin-bottom:12px;">
              <label for="package_price">Category</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="category" id="edit_category">
                <span class="input-group-text"><i class="fas fa-bars"></i><span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->
          <br>

        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ms-auto" name="edit-ps">Save changes</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>