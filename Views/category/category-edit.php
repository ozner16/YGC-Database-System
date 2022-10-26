<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";

$db = new Database();

if (isset($_POST["editCategory"])) {
  $category_id = $_POST["category-id"];
  $category_name = $_POST["category-name"];


  $db->query("SELECT `id` FROM `category` WHERE `category_name` = '$category_name'");
  $db->execute();
  $db->closeStmt();

  if (sizeof($db->resultSet()) === 0){
    $point_person_position = strtoupper($point_person_position);
    $db->query("UPDATE `category` SET `category_name` = '$category_name' WHERE `id`= '$category_id'");
    $db->execute();
    $db->closeStmt(); 
    $_SESSION["success-category"] = "Data has been updated successfully.";
  } else {
    $_SESSION["success-category"] = "Category is already in the database.";
  }
}

?>
<section>
<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
        <div class="form-check form-switch mt-2">
          <label class="form-check-label" for="flexSwitchCheckDefault">Active Status</label>
          <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./index.php" method="POST">
        <div class="modal-body">
            <div class="container">
              <div class="row mt-2">
                <div class="col">
                  <label for="category-name">Category Name</label><br>
                  <div class="input-group">
                    <input type="hidden" class="form-control" name="category-id" id="category-id">
                    <input type="text" class="form-control" name="category-name" id="category-name">
                    <span class="input-group-text border"><i class="fas fa-align-justify pt-0 mr-3"></i></span>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="editCategory" class="btn btn-primary ms-auto" >Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
</section>
