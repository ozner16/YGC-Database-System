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
  <?php require_once "./region-filters.php"; ?>
  <!-- Script for toggle -->
  <div>
        <ul class="nav nav-tabs flex-row justify-content-start">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="./index.php"><i class="fa-solid fa-building" data-toggle="tooltip" data-placement="top" title="Business"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./membership-details-index.php"><i class="fa-solid fa-building-circle-check" data-toggle="tooltip" data-placement="top" title="Membership Details"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./business-category-index.php"><i class="fa-solid fa-filter" data-toggle="tooltip" data-placement="top" title="Business Category"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="./region-index.php"><i class="fa-solid fa-map-location-dot" data-toggle="tooltip" data-placement="top" title="Business in each Region"></i></a>
            </li>
        </ul>
    </div>
    <div class="p-4 shadow-sm table-container">
        <table id="datatable-main" class="table table-striped" style="width: 100%;"></table>
    </div>
</div>

<!-- End of Script for toggle -->
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
        <span class="invisible">${tdData}</span>
        `
        );
      });
    $("#datatable-main tbody tr td:nth-child(4)").each(function() {
    var tdData = $(this).text();
    $(this).html(
      `
      <span class="invisible">${tdData}</span>
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