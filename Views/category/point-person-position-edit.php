<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";

$db = new Database();

if (isset($_POST["editPointPersonPosition"])) {
  $point_person_id = $_POST["point-person-position-id"];
  $point_person_position = $_POST["point-person-position"];


  $db->query("SELECT `id` FROM `point_person_position` WHERE `position` = '$point_person_position'");
  $db->execute();
  $db->closeStmt();

  if (sizeof($db->resultSet()) === 0){
    $point_person_position = strtoupper($point_person_position);
    $db->query("UPDATE `point_person_position` SET `position`='$point_person_position' WHERE `id`= '$point_person_id'");
    $db->execute();
    $db->closeStmt(); 
    $_SESSION["success-business"] = "Data has been updated successfully.";
  } else {
    $_SESSION["success-business"] = "Point person position is already in the database.";
  }
}
?>

<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mr-2" id="addModalLabel">Edit Point Person Position</h5>
        <div class="form-check form-switch mt-2">
          <label class="form-check-label" for="flexSwitchCheckDefault">Active Status</label>
          <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="./point-person-position-index.php" class="align-items center" method="POST" enctype="multipart/form-data">
      <div class="container">
        <div class="row mt-2">
            <div class="col">
              <label for="point-person-position-id">Name</label><br>
              <div class="input-group">
                <input type="hidden" name="point-person-position-id" id="point-person-position-id" class="form-control" required>
                <input type="text" name="point-person-position" id="point-person-position" class="form-control" required>
                <span class="input-group-text border"><i class="fas fa-address-card pt-0 mr-3"></i></span>
              </div>
            </div>
          </div>
          <div class="modal-footer w-100">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary ms-auto" name="editPointPersonPosition">Save Changes</button>
          </div>
      </div>
      </form>
      </div>
    </div>
  </div>
</div>

<script>
  function previewEdit() {
    edit_frame.src=URL.createObjectURL(event.target.files[0]);
  }
</script>