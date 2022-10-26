<?php
if ($_SERVER["REQUEST_METHOD"]=="POST") {
			//To press save button
			if (isset($_POST["delete_link"])) {
				$hostname = "localhost";
				$username = "root";
				$password = "";
				$databaseName = "wsap_db";
				$connect = mysqli_connect($hostname, $username, $password, $databaseName);
				$id = $_POST["id"];
        $sql1 = mysqli_query($connect,"SELECT data_blasting_id,id FROM expo_data_gathering WHERE id = '$id'");
        $row = mysqli_fetch_array($sql1);
        $data_blast_id = $row['data_blasting_id'];
        
        

				$sql = "DELETE FROM expo_data_gathering WHERE id = '$id'";
			
				if ($connect->query($sql) == TRUE) {
          
          } else {
          echo "Error: " . $sql . "<br>" . $connect->error;
          }

          $sql2 = "DELETE FROM data_blasting WHERE id = '$data_blast_id'";
			
				if ($connect->query($sql2) == TRUE) {
          $_SESSION["success-data_gathering"] = "Data Gathered successfully added.";
          echo '<script> window.location.href="/WSAP_DATABASE/Views/data-gathering/index.php" </script>';	
          } else {
          echo "Error: " . $sql2 . "<br>" . $connect->error;
          }
          mysqli_close($connect);
    }
      
    }
    ?>
<div class="modal fade modal-lg" id="deleteModal" tabindex="3" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="./index.php" method="POST">
            <div>   
              <div class="input-group">
                <input type="hidden" class="form-control" name="id" id="delete-input">
              </div>
              Are you sure you want to delete this data?
            </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="delete_link" class="btn btn-danger">Delete</button>
        </div>
        </form>
      
    </div>
  </div>
</div>