<?php
require_once "../../Controllers/Database.php";

$db = new Database();
if (isset($_POST['edit_online'])) {
  $idedit = $_POST["edit-id"];
  $expo_name = $_POST["expo_name"];
  $logo_storage = $_POST["logo_storage"];
  $package_link = $_POST["package_link"];
  $db->query("SELECT * FROM expo_slots WHERE `expo_name`='$expo_name';");
  $db->execute();
  $db->closeStmt();  
  if (sizeof($db->resultSet()) === 0){
  $db->query("UPDATE expo_slots SET `expo_id` ='$expo_name', `logo_storage_for_online` ='$logo_storage',`package_link` ='$package_link' WHERE `id` = '$idedit';");
  $db->execute();
  $db->closeStmt();
}else{
  $_SESSION["failed"] = "Data has been updated successfully.";
  echo '<script> window.location.href="/WSAP_DATABASE/Views/expo-details/online-expo-index.php" </script>';	
}

}
?>


<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="editModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">EDIT ONLINE EXPO</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="./online-expo-index.php" method="POST">
      <div class="modal-body">
        <div class="container">
           
            <input type="hidden" id="edit-id" name="edit-id" class="form-control" >
            <div class="row mt-2">
              <div class="col">
                <label for="expo-name">Expo Name:</label><br>
                <div class="input-group">
                <select class='form-select' name="expo_name" id="expo_name">
                <?php
                    $db->query("SELECT ed.id,es.expo_id,ed.expo_name  FROM expo_slots as es LEFT JOIN expo_details as ed ON ed.id = es.expo_id WHERE ed.is_online = 'YES' GROUP BY es.expo_id; ");
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
                 <span class="input-group-text"><i class="fas fa-address-card"></i></span>
            </div>
          </div>
        </div>
            
         
            <div class="row mt-2">
              <div class="col">
                <label for="business-name">Business Name:</label><br>
                <div class="input-group">
                <select class='form-select' name="business_name" id="business_name" disabled> 
                 <?php
                    $db->query("SELECT * FROM business;");
                    $db->execute();
                    $position_query = $db->resultSet();
                    $db->closeStmt();
                    foreach ($position_query as $row) {
                    ?>

                    
                    <option value="<?= $row->id?>" data="<?= $row->business_name ?>"><?= $row->business_name ?></option>

                    <?php
                    };
                  ?>
                 </select>
                 <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                 </div>
                </div>
               </div>

            
            <div class="row mt-2">
              <div class="col">
            <label for="logo_storage">Logo Storage</label><br>
                <div class="input-group">
                  <input type="text" class="form-control" name="logo_storage" id="logo_storage">
                  <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                </div>
              </div>
            </div>

                <div class="row mt-2">
                  <div class="col">
                <label for="package_link">Package Link</label><br>
                <div class="input-group">
                  <input type="text" class="form-control" name="package_link" id="package_link">
                  <span class="input-group-text"><i class="fas fa-link"></i></span>
                </div>
              </div>
            </div>
                  
              
      </div> <!-- container closing-->
      </div> <!-- modal-body closing -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="edit_online" class="btn btn-primary">Save Changes</button>
      </div>
      </form>
    </div>
  </div>
</div>