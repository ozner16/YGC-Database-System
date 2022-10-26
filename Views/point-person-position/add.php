<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";

$db = new Database();

if (isset($_POST["addPointPerson"])) {
  $point_person_position = strtoupper($_POST['point-person-position']); 

  $db->query("SELECT * FROM `point_person_position` WHERE `position`='$point_person_position';");
  $db->execute();
  $db->closeStmt(); 

  if (sizeof($db->resultSet()) === 0){
    $db->query("INSERT INTO `point_person_position`(`id`,`position`) VALUES (NULL,'$point_person_position');");
    $db->execute();
    $db->closeStmt(); 
    $_SESSION["success-business"] = "Point person position was successfully inserted into the database.";
  } else {
    $_SESSION["failed"] = "Point person position is already in the database.";
  }
}
?>


<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add Point Person Position</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./index.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="container">
              <div class="row mt-2">
                <div class="col">
                  <label for="point-person-position">Position</label><br>
                  <div class="input-group">
                    <input type="text" name="point-person-position" class="form-control" required>
                    <span class="input-group-text border"><i class="fas fa-address-card pt-0 mr-3"></i></span>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="addPointPerson" class="btn btn-primary ms-auto">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>