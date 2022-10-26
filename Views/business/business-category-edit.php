<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";

$db = new Database();

if (isset($_POST["editBusinessCategory"])) {
  $category_name = $_POST["category-name"];
  $business_category_id = $_POST["business_category_id"];
  $business_id = $_POST["business_id"];

  $db->query("SELECT `id` FROM `category` WHERE `category_name` = '$category_name'");
  $db->execute();
  $db->closeStmt();
  $category_id = $db->resultSet();
  $category_id = $category_id[0]->id;
  
  $db->query("SELECT `id` FROM `business_category` WHERE `business_id` = '$business_id' AND `category_id`='$category_id';");
  $db->execute();
  $db->closeStmt();

  if (sizeof($db->resultSet()) === 0){
    $db->query("UPDATE `business_category` SET `category_id` ='$category_id' WHERE `id`= '$business_category_id';");
    $db->execute();
    $db->closeStmt();
    $_SESSION["success-business"] = "Data has been updated successfully.";
  } else {
    $_SESSION["failed"] = "Business Category is already in the database.";
  }
}
?>

<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mr-2" id="editModalLabel">Edit Business Category</h5>
        <div class="form-check form-switch mt-2">
          <label class="form-check-label" for="flexSwitchCheckDefault">Active Status</label>
          <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

      <form action="./business-category-index.php" class="align-items center" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
      <div class="container">
          <div class="row mt-2">
            <div class="col">
              <label for="point-person-position">Business Name</label><br>
              <div class="input-group">
                <input type="hidden" id="business_category_id" name="business_category_id">
                <input type="hidden" id="business_id" name="business_id">
                <input id='business_name' class="form-select" disabled>
                <span class="input-group-text"><i class="fas fa-solid fa-address-card"></i></span>
              </div>
            </div><!-- col closing -->
          </div><!-- row closing -->
          
          <div class="row mt-2">
            <div class="col">
              <label for="point-person-position">Category Name</label><br>
              <div class="input-group">
                <select name="category-name" id="category_name"  class="form-select" required>
                  <option value="" selected="true" disabled="disabled"></option>
                  <?php
                  $db->query("SELECT `id`,`category_name` FROM `category`;");
                  $db->execute();
                  $status_query = $db->resultSet();
                  $db->closeStmt(); 
                  foreach ($status_query as $row) {
                    ?>
                    <option value="<?= $row->category_name?>"><?= $row->category_name?></option>
                    <?php
                  };
                  ?>
                </select>
                <span class="input-group-text"><i class="fas fa-solid fa-bars"></i></span>
                </div>
              </div>
            </div><!-- col closing -->

                </div>
          </div><!-- modal-body closing -->
          <div class="modal-footer w-100">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary ms-auto" name="editBusinessCategory">Save Changes</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script>
  function previewEdit() {
    edit_frame.src=URL.createObjectURL(event.target.files[0]);
  }
</script>