<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";

$db = new Database();

if (isset($_POST["editPointPerson"])) {
  $point_person_id = $_POST["point-person-id"];
  $point_person_name = $_POST["point-person-name"];
  $point_person_position = $_POST["point-person-position"];
  $point_person_email = $_POST["point-person-email"];
  $point_person_contact_number = $_POST["point-person-contact-number"];
  $point_person_record_for = $_POST["cat_id"];
  $db->query("SELECT * FROM point_person WHERE `name` ='$point_person_name' AND `email` = 'point_person_email' AND  `contact_number`='$point_person_contact_number';");
  $db->execute();
  $db->closeStmt(); 
  if (sizeof($db->resultSet()) === 0){
  $db->query("UPDATE `point_person` SET `position_id` ='$point_person_position',`name`='$point_person_name',
  `contact_number`='$point_person_contact_number', `email`='$point_person_email', 
  `point_person_category_id` ='$point_person_record_for' WHERE `id`= '$point_person_id';");
  $db->execute();
  $db->closeStmt();
  $_SESSION["success-business"] = "Point person information was successfully updated.";
  echo '<script> window.location.href="/WSAP_DATABASE/Views/point-person/index.php" </script>';
  }else{
    $_SESSION["failed"] = "Information is already in the database!";
    echo '<script> window.location.href="/WSAP_DATABASE/Views/point-person/index.php" </script>';
  }
}
?>

<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mr-2" id="addModalLabel">Edit Point Person</h5>
      
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="./index.php" class="align-items center" method="POST" enctype="multipart/form-data">
      <div class="container">
        <div class="row mt-2">
            <div class="col">
            <input type="hidden" name="point-person-id" id="point-person-id" class="form-control" required>
              <label for="point-person-name">Name</label><br>
              <div class="input-group">
               
                <input type="text" name="point-person-name" id="point-person-name" class="form-control" required>
                <span class="input-group-text border"><i class="fas fa-address-card pt-0 mr-3"></i></span>
              </div>
            </div>
          </div>
          
          <div class="row mt-2">
            <div class="col">
              <label for="point-person-position">Position</label><br>
              <div class="input-group">
                <select name="point-person-position" id="point-person-position"  class="form-select" required>
                  <option value="" selected="true" disabled="disabled"></option>
                  <?php
                  $db->query("SELECT * FROM `point_person_position`;");
                  $db->execute();
                  $status_query = $db->resultSet();
                  $db->closeStmt(); 
                  foreach ($status_query as $row) {
                    ?>
                    <option value="<?= $row->id?>" data="<?= $row->position?>"><?= $row->position?></option>
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
                <input type="email" class="form-control" name="point-person-email" id="point-person-email" required>
                <span class="input-group-text"><i class="fas fa-envelope pt-0 mr-3"></i></span>
              </div>
            </div>
          </div> 

          <div class="row mt-2">
            <div class="col">
              <label for="point-person-contact-number">Contact Number</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="point-person-contact-number" 
                id='point-person-contact-number' pattern="[0-9]+" required>
                <span class="input-group-text"><i class="fas fa-phone pt-0 mr-3"></i></span>
              </div>
            </div>
          </div>

          <div class="row mt-2">  
            <div class="col">
              <label for="point-person-record-for">Manages</label><br>
                <div class="input-group">
                <select name="cat_id" id="point_person_record_for" class="form-select" >
                      <?php
                      $db->query("SELECT * FROM `point_person_category` ;");
                      $db->execute();
                      $status_query = $db->resultSet();
                      $db->closeStmt(); 
                      foreach ($status_query as $row) {
                        ?>
                        <option value="<?= $row->id?>"  data="<?= $row->category_name?>"><?= $row->category_name?></option>
                        <?php
                      };
                      ?>  
                </select>
              <span class="input-group-text"><i class="fas fa-solid fa-certificate"></i></span>
              </div>
            </div>
            
          </div> 
          <div class="modal-footer w-100">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary ms-auto" name="editPointPerson">Save Changes</button>
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