<?php
if ($_SERVER["REQUEST_METHOD"]=="POST") {
			//To press save button
			if (isset($_POST["delete_expo"])) {
				$hostname = "localhost";
				$username = "root";
				$password = "";
				$databaseName = "wsap_db";
				$connect = mysqli_connect($hostname, $username, $password, $databaseName);
				$id = $_POST["id"];

        $ql = mysqli_query($connect, "SELECT requirement_id FROM expo_slots WHERE id = '$id';");
        $row = mysqli_fetch_array($ql);
        $check_req = $row['requirement_id'];
        
				$sql = "DELETE FROM expo_slots WHERE id = '$id'";
				$result = mysqli_query($connect, $sql);
				if ($result) {					
         // $_SESSION["success-on-site"] = "On-site expo successfully deleted.";
          echo '<script> window.location.href="/WSAP_DATABASE/Views/On-site-expo/index.php" </script>';
				} else {					
				}
        
        $sql1 = "DELETE FROM requirement_for_expo_slot WHERE id = '$check_req'";
				$result1 = mysqli_query($connect, $sql1);
				if ($result1) {					
          $_SESSION["success-on-site"] = "On-site expo successfully deleted.";
          echo '<script> window.location.href="/WSAP_DATABASE/Views/On-site-expo/index.php" </script>';
				} else {					
				}	
				
				mysqli_close($connect);
      }
    }
?>

<div class="modal fade modal-lg" id="deleteModal" tabindex="3" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Onsite Expo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="./index.php" method="POST">
        <div>
            
                <div class="input-group">
                  <input type="hidden" class="form-control" name="id" id="delete-input">
                </div>
          </div> Are you sure you want to delete this Expo?
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="delete_expo" class="btn btn-danger">Delete</button>
      </div>
      </form>
    </div>
  </div>
</div>