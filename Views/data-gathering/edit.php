<?php
if ($_SERVER["REQUEST_METHOD"]=="POST") {
  if (isset($_POST["edit_data"])) {
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $databaseName = "wsap_db";

    $connect = mysqli_connect($hostname, $username, $password, $databaseName);
    $expo_s_id = $_POST["edit-id"];

    $blast = $_POST["blast"];
    $date_b = $_POST['founding-date'];
    $response = $_POST["response"];

    $sql1 = mysqli_query($connect,"SELECT data_blasting_id, id FROM expo_data_gathering WHERE id = '$expo_s_id'");
    $row = mysqli_fetch_array($sql1);
    $data_b_upt = $row['data_blasting_id'];

    $sql = "UPDATE data_blasting SET blasting_type = '$blast', blasting_date ='$date_b', response = '$response' WHERE id = '$data_b_upt'";
    if ($connect->query($sql) == TRUE) {
      $_SESSION["success-data_gathering"] = "Data successfully updated.";
      echo '<script> window.location.href="/WSAP_DATABASE/Views/data-gathering/index.php" </script>';	
      } else {
      echo "Error: " . $sql . "<br>" . $connect->error;
      }
  }}
?>

<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h5 class="modal-title" id="editModalLabel">Edit Data Gathering</h5>
        <div class="form-check form-switch mt-2">
          
          <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
        </div>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="./index.php" method="post">
        <div class="modal-body"> 
          <div class="row mt-2">
            <div class="col">
            <input type="hidden" id="edit-id" name="edit-id" class="form-select" >
            <label for="expo-name">Expo Name:</label><br>
            <div class="input-group">
                <select class='form-select' name="expo_name" id="expo_name" disabled>
                <?php
                    $db->query("SELECT * FROM expo_details ");
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
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
                <label for="expo-name">Business Name</label><br>
                <div class="input-group">
                <select class="form-select" name="business_name" id="business_name" disabled>
                                        <?php
                                          $db->query("SELECT * FROM business;"); $db->execute(); $position_query = $db->resultSet(); $db->closeStmt(); foreach ($position_query as $row) { ?>
                                        <option value="<?= $row->id?>" data="<?= $row->business_name ?>"><?= $row->business_name?></option>
                                        <?php
                                              };
                                            ?>
                                    </select>
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
            </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="promos_packages">Blasting Type</label><br>
              <div class="input-group">
              <select class="form-select" name="blast" id="blasting_type">
                  <option value="Email">Email</option>
                  <option value="Text">Text</option>
                  <option value="Telemarketing">Telemarketing</option>
                  <option value="Chat">Chat</option>
                </select>
                <span class="input-group-text"><i class="fas fa-tablet-alt"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="promos_packages">Date</label><br>
              <div class="input-group">
              <input type="date" class="form-control" name="founding-date" id="blasting_date" required>
                    <span class="input-group-text"><i class="fas fa-calendar-alt pt-0 mr-3"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="list_of_participating_exhibitors">Response</label><br>
              <div class="input-group">
              <select class="form-select" name="response" id="response">
                  <option value="Done">Done</option>
                  <option value="Confirmed">Confirmed</option>
                  <option value="Follow-up">Follow-up</option>
                  <option value="Closable">Closable</option>
                  <option value="Declined">Declined</option>
                </select>
                <span class="input-group-text"><i class="fas fa-reply"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->     

        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="edit_data" class="btn btn-primary ms-auto">Save Changes</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>