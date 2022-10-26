<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";
$db = new Database();
if (isset($_POST["add-on-site"])) {
    $expo_name = str_replace("'", "`", $_POST["expo_name"]);
    $expo_loc = $_POST["expo_location"];
    $expo_date = $_POST["expo_date"];
    $expo_poster = $_POST["expo_poster"];
    $slot_count = $_POST["slot_count"];
    $promotion_packages = $_POST["promotion_packages"];
    $is_online = $_POST["expo_type"];

    $db->query(" SELECT * FROM expo_details WHERE expo_name='$expo_name' AND expo_date='$expo_date';");
    $db->execute();
    $db->closeStmt();
    if (sizeof($db->resultSet()) === 0) {
        $db->query("INSERT INTO expo_details (expo_name, expo_location, expo_date, expo_poster, slot_count, promotion_packages, is_online)
        VALUES ( '$expo_name' , '$expo_loc', '$expo_date', '$expo_poster', '$slot_count', '$promotion_packages', '$is_online');");
        $db->execute();
        $db->closeStmt();
        $_SESSION["success-expo-details"] = "Data has been added successfully.";
    }
    else{
        $_SESSION["failed"] = "Data adding failed.";
    }
}
?>
<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">ADD EXPO DETAILS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./index.php" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label for="expo_type">Expo Type</label><br />
                            <div class="input-group">
                                <select class="form-select" name="expo_type" id="expo_type_add" required>
                                    <option value="" selected="true" disabled="disabled"></option>
                                    <option value="YES">Online</option>
                                    <option value="NO">Onsite</option>
                                </select>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->
                    <div class="row mt-2">
                        <div class="col">
                            <label for="expo_name">Expo Name</label><br />
                            <div class="input-group">
                                <input type="text" name="expo_name" class="form-control" />
                                <span class="input-group-text border"><i class="fas far fa-address-card"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->
                    <div class="row mt-2">
                        <div class="col">
                            <label for="expo_location">Expo Location</label><br />
                            <div class="input-group">
                                <input type="text" name="expo_location" class="form-control" />
                                <span class="input-group-text border"><i class="fas fa-solid fa-location-crosshairs"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->
                    <div class="row mt-2">
                        <div class="col">
                            <label for="expo_date">Expo Date</label><br />
                            <div class="input-group">
                                <input type="date" name="expo_date" class="form-control" />
                                <span class="input-group-text border"><i class="fas fa-solid fa-calendar-days"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->
                    <div class="row mt-2">
                        <div class="col">
                            <label for="expo_poster">Expo Poster</label><br />
                            <div class="input-group">
                                <input type="text" name="expo_poster" class="form-control" />
                                <span class="input-group-text border"><i class="fas fa-solid fa-scroll"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->
                    <div class="row mt-2">
                        <div class="col">
                            <label for="slot_count">Slot Count</label><br />
                            <div class="input-group">
                                <input type="text" id="slot_count_add" name="slot_count" class="form-control slot_count" />
                                <span class="input-group-text border"><i class="fas fa-solid fa-hashtag"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->
                    <div class="row mt-2">
                        <div class="col">
                            <label for="promotion_packages">Promotion Packages</label><br />
                            <div class="input-group">
                                <input type="text" name="promotion_packages" class="form-control" />
                                <span class="input-group-text border"><i class="fas fa-solid fa-box-open"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->
                </div>
                <div class="modal-footer w-100">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add-on-site" class="btn btn-primary ms-auto">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
  (function() {
  $(document).ready(function() {
    $('#expo_type_add').on('change', function() {
      var getValue = document.getElementById("expo_type_add");
      var value = getValue.value;
      const slotCountInput = document.getElementById("slot_count_add");
      console.log('value: ' + value); 

      if(value == "YES") {
        slotCountInput.value = '';
        slotCountInput.disabled = true;
      } else {
        slotCountInput.disabled = false;
      }
    });
  });
})();
</script>