<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";

$db = new Database();

if (isset($_POST["editMembershipDetails"])) {
  $edit_membership_details_id = $_POST["edit-membership-details-id"];
  $edit_member_since = date('Y-m-d',strtotime($_POST["edit-member-since"]));
  $edit_membership_renewal = date('Y-m-d',strtotime($_POST["edit-membership-renewal"]));
  $edit_membership_expiration = date('Y-m-d',strtotime($_POST["edit-membership-expiration"]));

  $db->query("UPDATE `membership_details` SET `member_since` = '$edit_member_since', `membership_renewal` = '$edit_membership_renewal', `membership_expiration` = '$edit_membership_expiration' WHERE `membership_details`.`id` = '$edit_membership_details_id';");
  $db->execute(); 
  $db->closeStmt();
  $_SESSION["success-member-addition"] = "Membership Details information was successfully updated.";
}
?>


<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Membership Details</h5>
        <div class="form-check form-switch mt-2">
          <label class="form-check-label" for="flexSwitchCheckDefault">Active Status</label>
          <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./index.php" method="POST">
        <div class="modal-body">
          
          <div class="row mt-2">
            <div class="col">
            <label for="business-name">Business Name</label><br>
              <div class="input-group">
                <input type="hidden" id="edit-membership-details-id" name="edit-membership-details-id">
                <input type="text" class="form-control" id="edit-business-name" name="edit-business-name" disabled>
                <span class="input-group-text border"><i class="fas fa-solid fa-calendar-days"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row">
            <div class="col">
              <label for="member-since">Member Since</label><br>
              <div class="input-group">
                <input type="date" class="form-control" id="edit-member-since" name="edit-member-since">
                <span class="input-group-text border"><i class="fas fa-solid fa-calendar-days"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
            <label for="edit-membership-renewal">Started Membership</label><br>
              <div class="input-group">
              <input type="date" class="form-control" id="edit-membership-renewal" name="edit-membership-renewal">
                <span class="input-group-text border"><i class="fas fa-solid fa-calendar-days"></i></span>

              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
            <label for="edit-membership-expiration">Membership Expiration</label><br>
              <div class="input-group">
              <input type="date" class="form-control" id="edit-membership-expiration" name="edit-membership-expiration">
                <span class="input-group-text border"><i class="fas fa-solid fa-calendar-days"></i></span>

              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="editMembershipDetails" class="btn btn-primary ms-auto">Save Changes</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>