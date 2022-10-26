<?php
require_once "../../Controllers/Database.php";

$db = new Database();


if (isset($_POST["submit"])) {

  if(!empty($_POST['category']))
    {

      $status = $_POST['category'];

      
      $db->query("SELECT * FROM point_person_category WHERE category_name ='$status';");
      $db->execute();
      $db->closeStmt(); 
      if (sizeof($db->resultSet()) === 0){
        $db->query("INSERT INTO point_person_category ( category_name )
        VALUES('$status');");
        $db->execute();
        $db->closeStmt();
      $_SESSION["success-card"] = "Record successfully added.";
      } 
      else{
        $_SESSION["failed-card"] = "Point Person Category Information is already in the database!";
      }
   
     
      // $_SESSION["success-card"] = " successfully added.";

      //echo("<script>console.log('PHP: " . 'wew'. "');</script>");
      

    }

}

?>

<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add Point Person Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./index.php" method="post">
        <div class="modal-body"> 
        <div class="row mt-2">
            <div class="col">
              <label for="promotion-status">Category</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="category">
                <span class="input-group-text"><i class="fas fa-bars"></i><span>
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