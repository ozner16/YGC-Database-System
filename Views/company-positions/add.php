<?php
require_once "../../Controllers/Database.php";

$db = new Database();


if (isset($_POST["submit"])) {

  if(!empty($_POST['company_position']))
    {

      $position = strtoupper($_POST['company_position']);

      
      $db->query("SELECT * FROM company_positions WHERE comp_position ='$position';");
      $db->execute();
      $db->closeStmt(); 
      if (sizeof($db->resultSet()) === 0){
        $db->query("INSERT INTO company_positions ( comp_position )
        VALUES('$position');");
        $db->execute();
        $db->closeStmt();
      $_SESSION["success-card"] = "The Position is successfully added.";
      } 
      else{
        $_SESSION["failed-card"] = "The Position is already in the database!";
      }
   
     
      // $_SESSION["success-card"] = "Promotion Status successfully added.";

      //echo("<script>console.log('PHP: " . 'wew'. "');</script>");
      

    }

}

?>

<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add Company Position</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./index.php" method="post">
        <div class="modal-body"> 
        <div class="row mt-2">
            <div class="col">
              <label for="company_position">Position</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="company_position">
                <span class="input-group-text"><i class="fas fa-user-tie"></i><span>
              </div>
              <br>
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