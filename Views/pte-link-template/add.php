<?php
require_once "../../Controllers/Database.php";

$db = new Database();
  
if (isset($_POST["add_pte"])) {
  $link_name= $_POST["link_name"];
  $link = $_POST["link"];
  $db->query("INSERT INTO pte_templates(link_name, link)
    VALUES ( '{$link_name}' , '{$link}' );");
  $db->execute();
  $db->closeStmt();
  $_SESSION["success-pte"] = "Data has been added successfully.";
  echo '<script> window.location.href="/WSAP_DATABASE/Views/pte-link-template/index.php" </script>';	
}

?>
<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h5 class="modal-title" id="addModalLabel">Add PTE Template Links</h5>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="./index.php" method="post">
        <div class="modal-body"> 
          
          <div class="row mt-2">
            <div class="col">
              <label for="promos_packages">Link Name</label><br>
              <div class="input-group">
                <input type="text" name="link_name" class="form-control">
                <span class="input-group-text border"><i class="fas fa-solid fa-link"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="list_of_participating_exhibitors">Link</label><br>
              <div class="input-group">
                <input type="text" name="link" class="form-control">
                <span class="input-group-text border"><i class="fas fa-solid fa-link"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          

        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="add_pte" class="btn btn-primary ms-auto">Submit</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>