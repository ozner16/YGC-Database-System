<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";
$db = new Database();
  if (isset($_POST["edit-on-site"])) {
    $expo_s_id = $_POST["id"];
    $expo_id = $_POST["expo_name"];
    $expo_loc = $_POST["expo_location"];
    $expo_date = $_POST["expo_date"];
    $expo_poster = $_POST["expo_poster"];
    $slot_count = $_POST["slot_count"];
    $promo = $_POST["promotion_packages"];

    $db->query("UPDATE expo_details SET expo_name ='$expo_id', expo_location ='$expo_loc', expo_date ='$expo_date', expo_poster ='$expo_poster', slot_count ='$slot_count', promotion_packages ='$promo' WHERE id = '$expo_s_id';");
    $db->execute();
    $db->closeStmt();

    $_SESSION["success-expo-details"] = "Data has been updated successfully.";
  }
?>
<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Expo Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="./index.php" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <label for="expo_type">Expo Type</label><br />
                            <div class="input-group">
                                <select class="form-select" name="is_online" id="is_online" disabled>
                                    <option value="" selected disabled></option>
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
                                <input type="hidden" class="form-control" name="id" id="edit-id" />
                                <input type="text" name="expo_name" id="expo_name" class="form-control" />
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
                                <input type="text" name="expo_location" id="expo_location" class="form-control" />
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
                                <input type="date" name="expo_date" id="expo_date" class="form-control" />
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
                                <input type="text" name="expo_poster" id="expo_poster" class="form-control" />
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
                                <input type="text" id="slot_count" name="slot_count" class="form-control slot_count" />
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
                                <input type="text" name="promotion_packages" id="promotion_packages" class="form-control" />
                                <span class="input-group-text border"><i class="fas fa-solid fa-box-open"></i></span>
                            </div>
                        </div>
                        <!-- col closing -->
                    </div>
                    <!-- row closing -->
                    <div class="modal-footer w-100">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="edit-on-site" class="btn btn-primary ms-auto">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
