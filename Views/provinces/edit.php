<?php
require_once "../../Controllers/Database.php";

$db = new Database();
if (isset($_POST['edit-prov'])) {

  $id = $_POST['id'];
  $province = strtoupper($_POST['province']);

  $db->query("UPDATE refprovince SET `provDesc` ='$province' WHERE `id` = '$id';");
  $db->execute();
  $db->closeStmt();
  $_SESSION["success-card"] = "The province is successfully updated.";
}
?>

<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Edit Province</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./index.php" method="POST">
        <div class="modal-body"> 
         
          <div class="row mt-2">
            <div class="col">
            <input type="hidden" id="edit-id" name="id" style="width:460px;margin-bottom:12px;">
              <label for="province">Province</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="province" id="edit-province">
                <span class="input-group-text"><i class="fas fa-solid fa-info"></i><span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->
          <br>

        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ms-auto" name="edit-prov">Save changes</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>