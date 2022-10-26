<?php
require_once "../../Controllers/Database.php";

$db = new Database();
if (isset($_POST['edit-cs'])) {

  $id = $_POST['id'];
  $position = strtoupper($_POST['company_position']);

  $db->query("SELECT * FROM company_positions WHERE comp_position ='$position';");
      $db->execute();
      $db->closeStmt(); 
      if (sizeof($db->resultSet()) === 0){
        $db->query("UPDATE company_positions SET `comp_position` ='$position' WHERE `id` = '$id';");
        $db->execute();
        $db->closeStmt();
        $_SESSION["success-card"] = "The position is successfully updated.";
      } 
      else{
        $_SESSION["failed-card"] = "The Position is already exists!";
      }
   

  
}
?>

<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Edit Company Position</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./index.php" method="POST">
        <div class="modal-body"> 
         
          <div class="row mt-2">
            <div class="col">
            <input type="hidden" id="edit-id" name="id" style="width:460px;margin-bottom:12px;">
              <label for="company_position">Position</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="company_position" id="edit-company_position">
                <span class="input-group-text"><i class="fas fa-user-tie"></i><span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->
          <br>

        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ms-auto" name="edit-cs">Save changes</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>