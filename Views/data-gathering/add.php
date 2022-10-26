<?php

if ($_SERVER["REQUEST_METHOD"]=="POST") {


if (isset($_POST["add_data"])) {
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $databaseName = "wsap_db";

  $connect = mysqli_connect($hostname, $username, $password, $databaseName);
  $expo_id = $_POST["expo_name"];
  $business_id = $_POST["business_name"];
  $blast = $_POST["blast"];
  $date_b = $_POST['founding-date'];
  
  $response = $_POST["response"];
  //duplication
  $sql1 = mysqli_query($connect,"SELECT business_id FROM expo_data_gathering WHERE business_id = '$business_id'");
        $row = mysqli_fetch_array($sql1);
        $business_is_exist = $row['business_id'];
  if($business_is_exist != $business_id)
  {
  $sql1 = "INSERT INTO data_blasting ( blasting_type, blasting_date, response)VALUES( '$blast', '{$date_b}', '$response')";
  if ($connect->query($sql1) == TRUE) {
    } else {
    echo "Error: " . $sql1 . "<br>" . $connect->error;
    }
  $sql = "INSERT INTO expo_data_gathering ( expo_id, business_id, data_blasting_id)VALUES( '$expo_id', '$business_id', (SELECT MAX(id) FROM data_blasting))";
      if ($connect->query($sql) == TRUE) {
        $_SESSION["success-data_gathering"] = "Data Gathered successfully added.";
        echo '<script> window.location.href="/WSAP_DATABASE/Views/data-gathering/index.php" </script>';	
        } else {
        echo "Error: " . $sql . "<br>" . $connect->error;
        }
  }else{
    $_SESSION["failed"] = "Data cannot be added.";
    echo '<script> window.location.href="/WSAP_DATABASE/Views/data-gathering/index.php" </script>';	
  }
        mysqli_close($connect);
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
      
      <form action="./index.php" method="post">
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