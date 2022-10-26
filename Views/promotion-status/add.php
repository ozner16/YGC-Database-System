<?php
require_once "../../Controllers/Database.php";

$db = new Database();


if (isset($_POST["submit"])) {

  if(!empty($_POST['promotion-status']))
    {

      $status = strtoupper($_POST['promotion-status']); 

      
      $db->query("SELECT * FROM promotion_status WHERE prom_status ='$status';");
      $db->execute();
      $db->closeStmt(); 
      if (sizeof($db->resultSet()) === 0){
        $db->query("INSERT INTO promotion_status ( prom_status )
        VALUES('$status');");
        $db->execute();
        $db->closeStmt();
      $_SESSION["success-card"] = "Promotion Status successfully added.";
      } 
      else{
        $_SESSION["failed-card"] = "Promotion Status is already in the database!";
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
        <h5 class="modal-title" id="addModalLabel">Add Promotion Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./index.php" method="post">
        <div class="modal-body"> 
        <div class="row mt-2">
            <div class="col">
              <label for="promotion-status">Status</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="promotion-status">
                <span class="input-group-text"><i class="fas fa-solid fa-info"></i><span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->
          <br>

        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ms-auto" name="submit">Submit</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>