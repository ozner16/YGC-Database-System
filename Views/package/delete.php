<?php 

require_once "../../Controllers/Database.php";

$db = new Database();

  if(isset($_POST["deleteRow"])){

    $db->query("DELETE FROM package WHERE id='{$_POST['id']}';");
    $db->execute();
    $db->closeStmt();
    $_SESSION["success-card"] = "Media Partner successfully deleted.";

  }


?>

<div class="modal fade modal-lg" id="deleteModal" tabindex="3" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Package</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this Package?
      </div>

      <form action="./index.php" method="POST">
      <input type="hidden" name="id" id="delete-input">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="deleteRow" class="btn btn-danger">Delete</button>
      </div>
      </form>
    </div>
  </div>
</div>