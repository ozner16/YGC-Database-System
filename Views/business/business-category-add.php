<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";

$db = new Database();

if (isset($_POST["addBusinessCategory"])) {
  $business_id = $_POST['business-id']; 
  $category_id = $_POST['category-id']; 

  $db->query("SELECT * FROM `business_category` WHERE `business_id`='$business_id'
  AND `category_id`='$category_id';");
  $db->execute();
  $db->closeStmt(); 

  if (sizeof($db->resultSet()) === 0){
    $db->query("INSERT INTO `business_category`(`id`,`business_id`,`category_id`)
    VALUES (NULL,'$business_id','$category_id');");
    $db->execute();
    $db->closeStmt(); 
    $_SESSION["success-business"] = "Data has been added successfully.";  
  } else {
    $_SESSION["failed"] = "The database contains information on the company's category.";
  }
}
?>


<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add Business Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./business-category-index.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="container">
              <div class="row mt-2">
                <div class="col">
                  <label for="business-id">Business Name</label><br>
                  <div class="input-group">
                    <select name="business-id" id="status"  class="form-select" required>
                      <option value="" selected="true" disabled="disabled"></option>
                      <?php
                      $db->query("SELECT `id`,`business_name` FROM `business`;");
                      $db->execute();
                      $status_query = $db->resultSet();
                      $db->closeStmt(); 
                      foreach ($status_query as $row) {
                        ?>
                        <option value="<?= $row->id?>"><?= $row->business_name?></option>
                        <?php
                      };
                      ?>
                    </select>
                    <span class="input-group-text"><i class="fas fa-solid fa-address-card"></i></span>
                  </div>
                </div>
              </div>

              <div class="row mt-2">
                <div class="col">
                  <label for="category-id">Category Name</label><br>
                  <div class="input-group">
                    <select name="category-id" id="status"  class="form-select" required>
                      <option value="" selected="true" disabled="disabled"></option>
                      <?php
                      $db->query("SELECT `id`,`category_name` FROM `category`;");
                      $db->execute();
                      $status_query = $db->resultSet();
                      $db->closeStmt(); 
                      foreach ($status_query as $row) {
                        ?>
                        <option value="<?= $row->id?>"><?= $row->category_name?></option>
                        <?php
                      };
                      ?>
                    </select>
                    <span class="input-group-text"><i class="fas fa-solid fa-bars"></i></span>
                  </div>
                </div>
              </div>
            </div> 
          </div>
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="addBusinessCategory" class="btn btn-primary ms-auto">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>