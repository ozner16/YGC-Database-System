<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
$table_name = "Regions";
setTitle($table_name);
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Date.php";
$db = new Database();
$date = new Date();

$filter_region = null;
if (isset($_GET["selected_region"])) {
  $filter_region = $_GET["selected_region"];
}

allow_all_fully_authenticated();
?>


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
  <h4 class="py-2"><?= $table_name ?></h4>
  <div class="p-4 shadow-sm table-container">
  <?php require_once "./filters.php"; ?>
    <table id="datatable-main" class="table table-striped w-100"></table>
  </div>
</div>

<div>
</div>


<?php

$select_user_query = "SELECT * from business";
if($filter_region && $filter_region != "All Region" )$select_user_query = $select_user_query." WHERE region ='{$filter_region}';";
$db->query($select_user_query);
$logs = array(
  "rows" => json_encode($db->resultSet()),
  "columns" => json_encode(array(
    "id" => "",
    "business_name" => "Business Name",
    "branch" => "Branch",
    "region" => "",
  ))
);
$db->closeStmt();
?>
<script src="../../Assets/js/datatables_functions.js"></script>
<script>
  $(document).ready(function() {
    var tableName = "<?= $table_name ?>";
    var editor;
    var columns = JSON.parse('<?php print_r($logs["columns"]); ?>');
    var rows = ObjectsToDataTableArray(JSON.parse('<?php print_r($logs["rows"]); ?>'), Object.keys(columns));
    var mainDataTableId = "#datatable-main";
    showDataTable(rows, columns, mainDataTableId, tableName, {
      isWithEditor: false,
      isWithAddButton: false,
      paging: false
    });
    // Edit record
    $(mainDataTableId).on('click', 'td.editor-edit', function(e) {

    });

    if (rows.length > 0) {
      var rowCounter = 1;
      $("#datatable-main tbody tr td:nth-child(1)").each(function() {
        $(this).text(rowCounter);
        rowCounter++;
      });
    }
    $("#datatable-main tbody tr td:nth-child(1)").each(function() {
      var tdData = $(this).text();
      $(this).html(
        `
        <span class="invisible">${tdData}<span>
        `
        );
      });
    $("#datatable-main tbody tr td:nth-child(4)").each(function() {
    var tdData = $(this).text();
    $(this).html(
      `
      <span class="invisible">${tdData}<span>
      `
      );
    });
    var table = $('#datatable-main').DataTable();
 
    $('#datatable-main tbody').on('mouseenter', 'td', function () {
     var colIdx = table.cell(this).index().column;

     $(table.cells().nodes()).removeClass('highlight');
     $(table.column(colIdx).nodes()).addClass('highlight');
 });

  });
</script>
</body>