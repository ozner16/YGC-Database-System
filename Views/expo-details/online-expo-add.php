<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";
$db = new Database();
if (isset($_POST["add-online"])) {
  $expo_id = $_POST["expo_name"];
  $business_id = $_POST["business_name"];
  $package_link = $_POST["package_link"];
  $logo_storage = $_POST["logo_storage"];

  $db->query("INSERT INTO expo_slots (expo_id, business_id, package_link, logo_storage_for_online)VALUES( '$expo_id', '$business_id', '$package_link', '$logo_storage');");
  $db->execute();
  $db->closeStmt();
  $_SESSION["success-online"] = "Data has been added successfully.";
}
?>
<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">ADD ONLINE EXPO</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="./online-expo-index.php" method="POST">
      <div class="modal-body">
        <div class="container">
        
              <div class="row mt-2">
                <div class="col">
              <label for="expo-name">Expo Name</label><br> 
              <div class="input-group"> 
                <select class='form-select' name="expo_name">
                <?php
                    $db->query("SELECT * FROM expo_details WHERE is_online = 'YES';");
                    $db->execute();
                    $position_query = $db->resultSet();
                    $db->closeStmt();
                    foreach ($position_query as $row) {
                    ?>
                    <option value="<?= $row->id?>"><?= $row->expo_name?></option>
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
                <label for="business-name">Business Name</label><br>
                <div class="input-group">
                <select class='form-select' name="business_name"> 
                 <?php
                    $db->query("SELECT * FROM business;");
                    $db->execute();
                    $position_query = $db->resultSet();
                    $db->closeStmt();
                    foreach ($position_query as $row) {
                    ?>
                    <option value="<?= $row->id?>"><?= $row->business_name?></option>
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
                  <input type="text" class="form-control" name="logo_storage">
                  <span class="input-group-text"><i class="fas fa-box-open"></i></span>
                </div>
                </div>
                </div>

                <div class="row mt-2">
                  <div class="col">
            <label for="package_link">Package Link</label><br>
                <div class="input-group">
                  <input type="text" class="form-control" name="package_link">
                  <span class="input-group-text"><i class="fas fa-link"></i></span>
                </div>
                </div>
                </div>
      
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="add-online" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>