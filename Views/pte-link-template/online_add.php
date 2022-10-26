<?php
if ($_SERVER["REQUEST_METHOD"]=="POST") {


if (isset($_POST["add_online_link"])) {
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $databaseName = "wsap_db";

  $connect = mysqli_connect($hostname, $username, $password, $databaseName);
  $expo_id = $_POST["expo_name"];
  $link_name = $_POST["link_name"];
  $link = $_POST["link"];
  
  $db->query("SELECT * FROM links_for_expo WHERE `link`='$link';");
  $db->execute();
  $db->closeStmt();  
  if (sizeof($db->resultSet()) === 0){
  $sql = "INSERT INTO links_for_expo ( expo_details_id, link_name, link)VALUES( '$expo_id', '$link_name', '$link')";
      if ($connect->query($sql) == TRUE) {
        $_SESSION["success-online-link"] = "Data has been added successfully.";
        echo '<script> window.location.href="/WSAP_DATABASE/Views/pte-link-template/online_links_index.php" </script>';	
        } else {
        echo "Error: " . $sql . "<br>" . $connect->error;
        }
}else{
  $_SESSION["failed"] = "Link is already in the database!";
  echo '<script> window.location.href="/WSAP_DATABASE/Views/pte-link-template/online_links_index.php" </script>';	
}


mysqli_close($connect);
  
}
}

?>
<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h5 class="modal-title" id="addModalLabel">Add Online Links</h5>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="./online_links_index.php" method="post">
        <div class="modal-body"> 
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
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="promos_packages">Link Name</label><br>
              <div class="input-group">
                <input type="text" name="link_name" class="form-control">
                <span class="input-group-text border"><i class="fas fa-solid fa-link"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="list_of_participating_exhibitors">Link</label><br>
              <div class="input-group">
                <input type="text" name="link" class="form-control">
                <span class="input-group-text border"><i class="fas fa-solid fa-link"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          

        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="add_online_link" class="btn btn-primary ms-auto">Submit</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>