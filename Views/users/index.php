<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle("User Accounts");
require_once "../../Controllers/Database.php";
$db = new Database();
$table_name = "User Accounts";
$filter_department = null;
if (isset($_GET["selected_department"])) {
  $filter_department = $_GET["selected_department"];
}
allow_specific_user_only(["web admin"]);
?>
<?php require_once("./add.php"); ?>

<?php require_once "../../Templates/sidebar.php"; ?>
<?php if($_SESSION["logged_in_user_type"] == "viewer"):?>
<style>
  #datatable-main .delete-button {
    display:none;    
  }
  #datatable-main .edit-button {
    display:none;    
  }
</style>
<?php endif?>
<div class="main-content w-100">
  <?php
  if (isset($_SESSION["success-card"])) { ?>
    <div class="alert alert-success text-success">
      <?php
      echo $_SESSION["success-card"];
      unset($_SESSION["success-card"]);
      ?>
    </div> <?php
          }
            ?>
  <h4 class="py-2"><?= $table_name ?></h4>
  <div>
  <?php require_once "./filters.php"; ?>
</div>
  <div>
    <ul class="nav nav-tabs flex-row justify-content-start">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="./index.php">Table View</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./grid.php">Grid View</a>
      </li>
    </ul>
  </div>
  <div class="p-4 shadow-sm table-container">
    <table id="datatable-main" class="table table-striped" style="width:100%"></table>
  </div>
</div>

<?php require_once("./edit.php"); ?>
<?php require_once("./delete.php"); ?>

<div>
</div>


<?php

$select_user_query = "SELECT * from users";
if($filter_department && $filter_department != "All Department" )$select_user_query = $select_user_query." WHERE department='{$filter_department}'";
$db->query($select_user_query);
$db->execute();
$accounts = array(
  "rows" => json_encode($db->resultSet()),
  "columns" => json_encode(array(
    "id" => "ID",
    "first_name" => "First name",
    "middle_name" => "Middle name",
    "last_name" => "Last name",
    "user_type" => "User Type",
    "department" => "Department",
    "gender" => "Gender",
    "birthday" => "Birthday",
  ))
);
$db->closeStmt();
//print_r($accounts["rows"]);
?>
<script src="../../Assets/js/datatables_functions.js"></script>
<script>
  $(document).ready(function() {
    var tableName = "<?= $table_name ?>";
    var editor;
    var columns = JSON.parse('<?php print_r($accounts["columns"]); ?>');
    var rows = ObjectsToDataTableArray(JSON.parse('<?php print_r($accounts["rows"]); ?>'), Object.keys(columns));
    var mainDataTableId = "#datatable-main";
    showDataTable(rows, columns, mainDataTableId, tableName);
    // Edit record
    $(mainDataTableId).on('click', 'td.editor-edit', function(e) {

    });
  });
</script>
</body>