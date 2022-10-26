<?php
require_once "../../Controllers/Database.php";
$db = new Database();

if (isset($_POST["add_data"])) {
    $expo_id = $_POST["expo_name"];
    $business_id = $_POST["business_name"];
    $blast = $_POST["blast"];
    $date_b = $_POST['founding-date'];
    $response = $_POST["response"];


    $db->query("SELECT business_id FROM expo_data_gathering WHERE business_id = '$business_id' AND expo_id='$expo_id';");
    $db->execute();
    $db->closeStmt(); 

    if (sizeof($db->resultSet()) === 0){
      $db->query("INSERT INTO data_blasting ( blasting_type, blasting_date, response)VALUES( '$blast', '{$date_b}', '$response');");
      $db->execute();
      $db->query("INSERT INTO expo_data_gathering ( expo_id, business_id, data_blasting_id)VALUES( '$expo_id', '$business_id', (SELECT MAX(id) FROM data_blasting));");
      $db->execute();

      $_SESSION["success-data_gathering"] = "Data has been added successfully.";
      $db->closeStmt(); 
    } else {
      $_SESSION["failed"] = "Data cannot be added.";
      $db->closeStmt();  
    }
  }
?>

<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h5 class="modal-title" id="addModalLabel">Add Data Gathering</h5>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="./data-gathering-index.php" method="post">
        <div class="modal-body"> 
          <div class="row mt-2">
            <div class="col">
                <label for="expo-name">Expo Name</label><br>
                <div class="input-group">
                <select class='form-select' name="expo_name"> 
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
                <select class="form-select" name="business_name">
                                        <?php
                                          $db->query("SELECT * FROM business;"); $db->execute(); $position_query = $db->resultSet(); $db->closeStmt(); foreach ($position_query as $row) { ?>
                                        <option value="<?= $row->id?>"><?= $row->business_name?></option>
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
              <select class="form-select" name="blast">
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
              <input type="date" class="form-control" name="founding-date" required>
                    <span class="input-group-text"><i class="fas fa-calendar-alt pt-0 mr-3"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="list_of_participating_exhibitors">Response</label><br>
              <div class="input-group">
              <select class="form-select" name="response">
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
          <button type="submit" name="add_data" class="btn btn-primary ms-auto">Submit</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>