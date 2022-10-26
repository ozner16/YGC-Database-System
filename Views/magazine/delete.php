<?php
require_once "../../Controllers/Database.php";

$db = new Database();
if (isset($_POST["delete-row"])) {
  $db->query("DELETE FROM magazine WHERE id = '{$_POST['id']}' ; ");
  $db->execute();
  $_SESSION["success"] = "Record successfully deleted.";
  $db->closeStmt();
  echo '<script> window.location.href="/WSAP_DATABASE/Views/magazine/index.php" </script>';	
}
?>
<div class="modal fade modal-lg" id="deleteModal" tabindex="3" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Delete Magazine</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">
                Are you sure you want to delete this magazine?
             </div>
                <form action="./index.php" method="POST">
                <input type="hidden" name="id" id="delete-input">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger"  name="delete-row">Delete</button>
                 </form>
            </div>
      </div>
   </div>
</div>