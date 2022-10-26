<?php
require_once "../../Controllers/Database.php";

$db = new Database();


if (isset($_POST["submit"])) {

  
      $pointperson = $_POST['point_person'];
      $company_name = $_POST['company_name'];
      $location = $_POST['location'];
      
      $db->query("SELECT * FROM `event` WHERE `location` = '$location';");
      $db->execute();
      $db->closeStmt(); 
      if (sizeof($db->resultSet()) === 0){
        $db->query("INSERT INTO `event` (`point_person_id`,`company_name`,`location` )
        VALUES('$pointperson','$company_name','$location');");
        $db->execute();
        $db->closeStmt();
      $_SESSION["success-card"] = "Record successfully added.";
      } 
      else{
        $_SESSION["failed-card"] = "Information is already in the database!";
      }
   
     
      // $_SESSION["success-card"] = " successfully added.";

      //echo("<script>console.log('PHP: " . 'wew'. "');</script>");
}

?>

<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
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
              <label for="promotion-status">Point Person</label><br>
              <div class="input-group">
              <select name="point_person" id="status"  class="form-select" required>
              <option value="" selected="true" disabled="disabled"></option>
                      <?php
                      $db->query("SELECT * FROM `point_person` WHERE `point_person_category_id` > 2 ;");
                      $db->execute();
                      $status_query = $db->resultSet();
                      $db->closeStmt(); 
                      foreach ($status_query as $row) {
                        ?>
                        <option value="<?= $row->id?>"><?= $row->name?></option>
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
                <input type="text" class="form-control" name="company_name">
                <span class="input-group-text"><i class="fas fa-solid fa-info"></i><span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="promotion-status">Location</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="location">
                <span class="input-group-text"><i class="fas fa-solid fa-info"></i><span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->


        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ms-auto" name="submit">Submit</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>