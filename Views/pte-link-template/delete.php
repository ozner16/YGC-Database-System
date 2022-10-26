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
				$sql = "DELETE FROM pte_templates WHERE id = '$id'";
				$result = mysqli_query($connect, $sql);
				if ($result) {
          $_SESSION["success-pte"] = "Data has been removed successfully.";
          echo '<script> window.location.href="/WSAP_DATABASE/Views/pte-link-template/index.php" </script>';				
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
        <h5 class="modal-title" id="deleteModalLabel">Delete PTE Template Link</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="./index.php" method="POST">
           <div>   
            <div class="input-group">
              <input type="hidden" class="form-control" name="id" id="delete-input">
            </div>
             Are you sure you want to delete this PTE template Link?
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