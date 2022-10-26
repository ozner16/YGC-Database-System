<?php
require_once "../../Controllers/Database.php";

$db = new Database();
if (isset($_POST['edit_onsite_link'])) {
  $idedit = $_POST["edit-id"];
  $expo_name = $_POST["expo_name"];
  $logo_storage = $_POST["logo_storage"];
  $package_link = $_POST["package_link"];
  $db->query("SELECT * FROM links_for_expo WHERE `link`='$package_link ';");
  $db->execute();
  $db->closeStmt();  
if (sizeof($db->resultSet()) === 0){
  $db->query("UPDATE links_for_expo SET `link_name` ='$logo_storage',`link` ='$package_link' WHERE `id` = '$idedit';");
  $db->execute();
  $db->closeStmt();
  $_SESSION["success-online-link"] = "Data has been updated successfully.";
  echo '<script> window.location.href="/WSAP_DATABASE/Views/pte-link-template/on-site_index.php" </script>';	
}else{
  $_SESSION["failed"] = "Link is already in the database!";
  echo '<script> window.location.href="/WSAP_DATABASE/Views/pte-link-template/on-site_index.php" </script>';	
}
}
?>


<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h5 class="modal-title" id="addModalLabel">Edit Onsite Links</h5>
        <div class="form-check form-switch mt-2">
          <label class="form-check-label" for="flexSwitchCheckDefault">Active Status</label>
          <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="./on-site_index.php" method="post">
        <div class="modal-body"> 
          <div class="row mt-2">
            <div class="col">

            <input type="hidden" id="edit-id" name="edit-id" class="form-control" >
            <label for="expo-name">Expo Name:</label><br>
                <select class='form-select' name="expo_name" id="expo_name" disabled>
                <?php
                    $db->query("SELECT ed.id,es.expo_id,ed.expo_name  FROM expo_slots as es LEFT JOIN expo_details as ed ON ed.id = es.expo_id WHERE ed.is_online = 'NO' GROUP BY es.expo_id; ");
                    $db->execute();
                    $position_query = $db->resultSet();
                    $db->closeStmt();
                    foreach ($position_query as $row) {
                    ?>
                    <!-- for selecting data -->
                    <option value="<?= $row->id?>" data="<?= $row->expo_name ?>"><?= $row->expo_name ?></option>
                    
                    <?php
                    };
                  ?>
                 </select>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

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
          <button type="submit" name="edit_onsite_link" class="btn btn-primary ms-auto">Submit</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>