<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";
$db = new Database();
if (isset($_POST["delete_link"])) {
    $id = $_POST["id"];

    $db->query("SELECT e.data_blasting_id FROM expo_data_gathering as e WHERE id = '$id';");
    $db->execute();
    $row_data = $db->fetch();
    if (sizeof($db->resultSet()) > 0) {
        $data_blasting_id = $row_data["data_blasting_id"];
        $db->query("DELETE FROM expo_data_gathering WHERE id = '$id';");
        $db->execute();
        $db->closeStmt();
        $db->query("DELETE FROM data_blasting WHERE id = '$data_blasting_id';");
        $db->execute();
        $db->closeStmt();
        $_SESSION["success-data_gathering"] = "Data has been deleted successfully.";
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
        <form action="./data-gathering-index.php" method="POST">
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