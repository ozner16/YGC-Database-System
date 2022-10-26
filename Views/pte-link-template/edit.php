<?php
require_once "../../Controllers/Database.php";

$db = new Database();
if (isset($_POST['edit_pte'])) {
  $idedit = $_POST["edit-id"];
  $logo_storage = $_POST["logo_storage"];
  $package_link = $_POST["package_link"];
  $db->query("UPDATE pte_templates SET `link_name` ='$logo_storage',`link` ='$package_link' WHERE `id` = '$idedit';");
  $db->execute();
  $db->closeStmt();
  $_SESSION["success-pte"] = "Data has been updated successfully.";
  echo '<script> window.location.href="/WSAP_DATABASE/Views/pte-link-template/index.php" </script>';	
}
?>


<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

   
        <h5 class="modal-title" id="editModalLabel">Edit PTE Template Link</h5>
        <div class="form-check form-switch mt-2">
          <label class="form-check-label" for="flexSwitchCheckDefault">Active Status</label>
          <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
        </div>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="./index.php" method="post">
        <div class="modal-body"> 
        <input type="hidden" id="edit-id" name="edit-id" class="form-control" >
          <div class="row mt-2">
            <div class="col">
              <label for="promos_packages">Link Name</label><br>
              <div class="input-group">
                <input type="text" name="logo_storage" id= "logo_storage" class="form-control">
                <span class="input-group-text border"><i class="fas fa-solid fa-link"></i></span>
              </div>

            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="list_of_participating_exhibitors">Link</label><br>
              <div class="input-group">
                <input type="text" name="package_link" id = "package_link" class="form-control">
                <span class="input-group-text border"><i class="fas fa-solid fa-link"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->        

        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="edit_pte" class="btn btn-primary ms-auto">Save Changes</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>