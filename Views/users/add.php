<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Date.php";
$db = new Database();
$date = new Date();
if (isset($_POST["add_user"])) {
  $last_name = $_POST["add_last_name"];
  $middle_name = $_POST["add_middle_name"];
  $first_name = $_POST["add_first_name"];
  $gender = $_POST["add_gender"];
  $department = $_POST["add_department"];
  $add_user_type = $_POST["add_user_type"];
  $comp_position = $_POST["comp_position"];


  do {
    $user_id = $date->getYear() . "-" . randomWord();
    $db->query("SELECT id FROM users WHERE id = '{$user_id}'");
    $db->execute();
    $db->closeStmt();
  } while ($db->rowCount() != 0);
  

  $db->query("INSERT INTO users (id, last_name, middle_name, first_name, gender, department, user_type, com_position_id)
    VALUES ('{$user_id}' ,'{$last_name}' , '{$middle_name}', '{$first_name}', '{$gender}', '{$department}',
    '{$add_user_type}','{$comp_position}');");
  $db->execute();
  $db->closeStmt();
  $_SESSION["success-card"] = "User successfully added.";
  redirect("./grid.php");
  die();
}

?>

<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">


        <h5 class="modal-title" id="addModalLabel">Add User</h5>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="./index.php" method="POST">
        <div class="modal-body">
          <div class="row mt-2">
            <div class="col">
              <label for="add_first_name">First Name</label><br>
              <div class="input-group">
                <input type="text" required class="form-control" id="add_first_name" name="add_first_name">
                <span class="input-group-text border"><i class="fas fa-solid fa-address-card"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="add_middle_name">Middle Name</label><br>
              <div class="input-group">
                <input type="text" required name="add_middle_name" id="add_middle_name" class="form-control">
                <span class="input-group-text border"><i class="fas fa-solid fa-address-card"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="add_last_name">Last Name</label><br>
              <div class="input-group">
                <input type="text" required class="form-control" id="add_last_name" name="add_last_name">
                <span class="input-group-text border"><i class="fas fa-solid fa-address-card"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="add_gender">Gender</label><br>
              <div class="input-group">
                <select required class="form-control" id="add_gender" name="add_gender">
                  <option selected value="male">Male</option>
                  <option value="female">Female</option>
                </select>
                <span class="input-group-text border"><i class="fas fa-solid fa-mars-and-venus"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="add_department">Department</label><br>
              <div class="input-group">
                <select required class="form-select" id="add_department" name="add_department">
                  <option selected value="Information Technology">Information Technology</option>
                  <option value="Marketing">Marketing</option>
                  <option value="Operations">Operations</option>
                  <option value="Accounting">Accounting</option>
                  <option value="Business Development">Business Development</option>
                  <option value="Human Resources">Human Resources</option>
                </select>
                <span class="input-group-text border"><i class="fas fa-solid fa-building-user"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="add_department">User Type</label><br>
              <div class="input-group">
                <select class="form-select" id="add_user_type" name="add_user_type">
                  <option selected value="viewer">Viewer</option>
                  <option selected value="editor">Editor</option>
                  <option selected value="web admin">Web Admin</option>
                  <option selected value="multimedia">Multimedia</option>
                </select>
                <span class="input-group-text border"><i class="fas fa-solid fa-building-user"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->
          <div class="row mt-2">
            <label for="status">Company Position</label><br>
            <div class="input-group">
            <select name="comp_position" id="comp_position"  class="form-select" required>
              <option value="" selected="true" disabled="disabled"></option>
              <?php
              $db->query("SELECT `id`,`comp_position` FROM company_positions;");
              $db->execute();
              $status_query = $db->resultSet();
              $db->closeStmt();
              foreach ($status_query as $row) {
              ?>
              <option value="<?= $row->id?>"><?= $row->comp_position?></option>
              <?php
              };
              ?>
            </select>
            <span class="input-group-text"><i class="fas fa-solid fa-user-gear"></i></span>
            </div>
          </div>
        </div><!-- modal-body closing -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary ms-auto" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="add_user" class="btn btn-primary">Add</button>
        </div>
    </div>
  </div>
</div>