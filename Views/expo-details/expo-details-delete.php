<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";
$db = new Database();
//To press save button
if (isset($_POST["delete_expo"])) {
    $id = $_POST["id"];
    $db->query("DELETE FROM expo_details WHERE id = '$id';");
    $db->execute();
    $db->closeStmt();
}
?>
<div class="modal fade modal-lg" id="deleteModal" tabindex="3" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="./index.php" method="POST">
                    <div>
                        <div class="input-group">
                            <input type="hidden" class="form-control" name="id" id="delete-input" />
                        </div>
                    </div>
                    Are you sure you want to delete this expo?

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="delete_expo" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>