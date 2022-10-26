<?php
require_once "../../Controllers/Database.php";

$db = new Database();
if (isset($_POST['edit-ps'])) {
  $id = $_POST['edit_id'];
  $company_name = $_POST['edit_company_name'];
  $location = $_POST['edit_location'];
  $db->query("SELECT * FROM `event` WHERE `company_name` = '$company_name' AND location = ' $location';");
  $db->execute();
  $db->closeStmt(); 
  if (sizeof($db->resultSet()) === 0){
  $db->query("UPDATE `event` SET `company_name` ='$company_name', `location` = '$location'
   WHERE `id` = '$id';");
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
      <h5 class="modal-title" id="addModalLabel">Add Event Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./index.php" method="post">
        <div class="modal-body"> 
        <div class="row mt-2">
            <div class="col">
            <input type="hidden" id="edit_id" name="edit_id" class="form-control" >
              <label for="promotion-status">Point Person</label><br>
              <div class="input-group">
              <select name="edit_point_person" id="edit_point_person"  class="form-select" disabled>
              <option value="" selected="true" disabled="disabled"></option>
                      <?php
                      $db->query("SELECT * FROM `point_person`;");
                      $db->execute();
                      $status_query = $db->resultSet();
                      $db->closeStmt(); 
                      foreach ($status_query as $row) {
                        ?>
                        <option value="<?= $row->id?>" data="<?= $row->name?>"><?= $row->name?></option>
                        <?php
                      };
                      ?>
                    </select>
                <span class="input-group-text"><i class="fas fa-solid fa-info"></i><span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->
         
              

          <div class="row mt-2">
            <div class="col">
              <label for="promotion-status">Company Name</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="edit_company_name" id="company_name">
                <span class="input-group-text"><i class="fas fa-solid fa-info"></i><span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="promotion-status">Location</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="edit_location" id="location">
                <span class="input-group-text"><i class="fas fa-solid fa-info"></i><span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->


        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ms-auto" name="edit-ps">Save changes</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>