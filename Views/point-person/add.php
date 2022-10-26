<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";

$db = new Database();

if (isset($_POST["addPointPerson"])) {
  $point_person_name = $_POST['point-person-name']; 
  $point_person_position = $_POST['point-person-position']; 
  $point_person_contact = $_POST['point-person-contact-number']; 
  $point_person_email = $_POST['point-person-email']; 
  $point_person_record_for = $_POST['point-person-record-for']; 

  $db->query("SELECT * FROM point_person WHERE `name` ='$point_person_name' AND `email` = 'point_person_email' AND  `contact_number`='$point_person_contact_number';");
  $db->execute();
  $db->closeStmt(); 

  if (sizeof($db->resultSet()) === 0){
    $db->query("INSERT INTO `point_person`(`id`,`position_id`,`name`,`contact_number`,`email`,`point_person_category_id`)
    VALUES (NULL,'$point_person_position','$point_person_name','$point_person_contact','$point_person_email','$point_person_record_for')");
    $db->execute();
    $db->closeStmt(); 
    $_SESSION["success-business"] = "Point person information was successfully inserted into the database.";
    echo '<script> window.location.href="/WSAP_DATABASE/Views/point-person/index.php" </script>';	
  } else {
    $_SESSION["failed"] = "Point person information is already in the database.";
    echo '<script> window.location.href="/WSAP_DATABASE/Views/point-person/index.php" </script>';	
  }
}
?>


<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add Point Person</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./index.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="container">
              <div class="row mt-2">
                <div class="col">
                  <label for="point-person-name">Name</label><br>
                  <div class="input-group">
                    <input type="text" name="point-person-name" class="form-control" required>
                    <span class="input-group-text border"><i class="fas fa-address-card pt-0 mr-3"></i></span>
                  </div>
                </div>
              </div>
              
              <div class="row mt-2">
                <div class="col">
                  <label for="point-person-position">Position</label><br>
                  <div class="input-group">
                    <select name="point-person-position" id="status"  class="form-select" required>
                      <option value="" selected="true" disabled="disabled"></option>
                      <?php
                      $db->query("SELECT `id`,`position` FROM `point_person_position`;");
                      $db->execute();
                      $status_query = $db->resultSet();
                      $db->closeStmt(); 
                      foreach ($status_query as $row) {
                        ?>
                        <option value="<?= $row->id?>"><?= $row->position?></option>
                        <?php
                      };
                      ?>
                    </select>
                    <span class="input-group-text"><i class="fas fa-solid fa-user-gear"></i></span>
                  </div>
                </div>
              </div>

              <div class="row mt-2">
                <div class="col">  
                  <label for="point-person-email">Email</label><br>
                  <div class="input-group">
                    <input type="email" class="form-control" name="point-person-email" required>
                    <span class="input-group-text"><i class="fas fa-envelope pt-0 mr-3"></i></span>
                  </div>
                </div>
              </div> 

              <div class="row mt-2">
                <div class="col">
                  <label for="point-person-contact-number">Contact Number</label><br>
                  <div class="input-group">
                    <input type="text" class="form-control" name="point-person-contact-number" pattern="[0-9]+" required>
                    <span class="input-group-text"><i class="fas fa-phone pt-0 mr-3"></i></span>
                  </div>
                </div>
              </div>

              <div class="row mt-2">  
                <div class="col">
                  <label for="point-person-record-for">Manages</label><br>
                    <div class="input-group">
                    <select name="point-person-record-for" class="form-select" required>
                        <option value="" selected disabled></option>
                         
                 <?php
                    $db->query("SELECT * FROM point_person_category ;");
                    $db->execute();
                    $position_query = $db->resultSet();
                    $db->closeStmt();
                    foreach ($position_query as $row) {
                    ?>
                    <option value="<?= $row->id?>"><?= $row->category_name?></option>
                    <?php
                    };
                  ?>
                    </select>
                  <span class="input-group-text"><i class="fas fa-solid fa-certificate"></i></span>
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