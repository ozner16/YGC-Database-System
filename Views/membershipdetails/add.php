<?php
  require_once "../../Controllers/Database.php";

  $db = new Database();

  if (isset($_POST["addNewMember"])) {
    $business_id = $_POST['business-id'];
    $member_since = date('Y-m-d',strtotime($_POST['member-since']));
    $started_membership = date('Y-m-d',strtotime($_POST['membership-renewal']));
    $membership_expiration = date('Y-m-d',strtotime($_POST['membership-expiration']));

    $db->query("SELECT `id` FROM `membership_details` WHERE business_id='$business_id'");
    $db->execute();
    $db->closeStmt(); 
    if (sizeof($db->resultSet()) === 0){
      $db->query("INSERT INTO `membership_details` (`id`, `business_id`, `member_since`, `membership_renewal`, `membership_expiration`) VALUES (NULL, '$business_id', '$member_since', '$started_membership', '$membership_expiration');");
      $db->execute();

      $db->query("UPDATE business SET is_a_member='YES' WHERE id='$business_id'");
      $db->execute();
      $db->closeStmt();
      $_SESSION["success-member-addition"] = "A new business is added to the Members!";
    } else {
      $_SESSION["success-member-addition"] = "Business is already a Members!"; 
    }
  }
  ?>  

<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add Membership Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./index.php" method="post">
        <div class="modal-body"> 
            <div class="col">
              <label for="business-id">Business Name</label><br>
              <div class="input-group">
                <select name="business-id" class="form-control" required>
                  <option value="" selected disabled>↓</option>
                  <?php
                    $db->query("SELECT id,business_name FROM business WHERE is_a_member='NO';");
                    $db->execute();
                    $status_query = $db->resultSet();
                    $db->closeStmt();
                    foreach ($status_query as $row) {
                      ?>
                      <option value="<?= $row->id?>"><?= $row->business_name?></option>
                      <?php
                    };
                    ?>
                </select>
                <span class="input-group-text"><i class="fas fa-file-image pt-0 mr-3"></i></span>
              </div> 
            </div>

          <div class="row">
            <div class="col">
              <label for="member-since">Member Since</label><br>
              <div class="input-group">
                <input type="date" class="form-control" name="member-since">
                <span class="input-group-text border"><i class="fas fa-solid fa-calendar-days"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
            <label for="membership_renewal">Membership Renewal</label><br>
              <div class="input-group">
              <input type="date" class="form-control" name="membership-renewal">
                <span class="input-group-text border"><i class="fas fa-solid fa-calendar-days"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
            <label for="membership-expiration">Membership Expiration</label><br>
              <div class="input-group">

              <input type="date" class="form-control" name="membership-expiration">
                <span class="input-group-text border"><i class="fas fa-solid fa-calendar-days"></i></span>

              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ms-auto" name="addNewMember">Submit</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>