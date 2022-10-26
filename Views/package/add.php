<?php
require_once "../../Controllers/Database.php";

$db = new Database();


if (isset($_POST["submit"])) {

  if(!empty($_POST['package_name']) && !empty($_POST['package_price']))
    {

      $package_name = strtoupper($_POST["package_name"]);
      $package_price = $_POST["package_price"];
      $package_link = $_POST["package_link"];

      $db->query("SELECT * FROM package WHERE package_name ='$package_name';");
      $db->execute();
      $db->closeStmt(); 
      if (sizeof($db->resultSet()) === 0){
        $db->query("INSERT INTO package (package_name, package_price, package_link)
        VALUES ( '{$package_name}','{$package_price}','{$package_link}');");
        $db->execute();
        $db->closeStmt();
      $_SESSION["success-card"] = "Package successfully added.";
      } 
      else{
        $_SESSION["failed-card"] = "Package is already in the database!";
      }
      
   

    }

}

?>

<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add Package</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./index.php" method="post">
        <div class="modal-body"> 
          <div class="row mt-2">
            <div class="col">
              <label for="package_name">Package Name</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="package_name">
                <span class="input-group-text border"><i class="fas fa-solid fa-file-signature"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="package_price">Package Price</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="package_price">
                <span class="input-group-text border"><i class="fas fa-solid fa-peso-sign"></i></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->
        
          <div class="row mt-2">
            <div class="col">
              <label for="package_link">Package Link</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="package_link">
                <span class="input-group-text border"><i class="fas fa-solid fa-file-signature"></i></span>
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