<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";
$db = new Database();
//To press save button
if (isset($_POST["delete_expo"])) {
  $id = $_POST["id"];

  $db->query("SELECT requirement_id FROM expo_slots WHERE id = '$id';");
  $db->execute();
  $row_data = $db->fetch();
  if (sizeof($db->resultSet()) > 0) {
    $requirement_id = $row_data["requirement_id"];
    $db->query("DELETE FROM expo_slots WHERE id = '$id';");
    $db->execute();
    $db->closeStmt();
    $db->query("DELETE FROM requirement_for_expo_slot WHERE id = '$requirement_id';");
    $db->execute();
    $db->closeStmt();
    $_SESSION["success"] = "Data has been deleted successfully.";
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
      <form action="./onsite-expo-index.php" method="POST">
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