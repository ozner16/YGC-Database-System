<?php
require_once "../../Controllers/Database.php";
$db = new Database();

if (isset($_POST["addCategory"])) {
  $category_name = strtoupper($_POST["category-name"]);

  $db->query("SELECT * FROM `category` WHERE `category_name`='$category_name';");
  $db->execute();
  $db->closeStmt(); 

  if (sizeof($db->resultSet()) === 0){
    $db->query("INSERT INTO category (id, category_name) VALUES (NULL,'$category_name');");
    $db->execute();
    $db->closeStmt();
    $_SESSION["success-category"] = "Data has been added successfully.";
  } else {
    $_SESSION["failed"] = "Category is already in the database.";
  }
}
?>
<section>
<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="./index.php" method="POST">
        <div class="modal-body">
            <div class="container">
              <div class="row mt-2">
                <div class="col">
                  <label for="category-name">Category Name</label><br>
                  <div class="input-group">
                    <input type="text" class="form-control" name="category-name">
                    <span class="input-group-text border"><i class="fas fa-align-justify pt-0 mr-3"></i></span>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="addCategory" class="btn btn-primary ms-auto" >Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
</section>
