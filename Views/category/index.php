<?php
$table_name = "Business Category";
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle($table_name);
require_once "../../Controllers/Database.php";
$db = new Database();
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
  #addButtonForAllTable{
    display:none;
  }
</style>
<?php endif?>
<?php require_once("./category-add.php"); ?>
<?php require_once("./category-edit.php"); ?>
<?php
    if (isset($_SESSION["success-category"])) { ?>
        <div class="alert alert-success text-success">
            <?php
            echo $_SESSION["success-category"];
            unset($_SESSION["success-category"]);
            ?>
        </div> <?php
            }
?>
 <?php
  if (isset($_SESSION["failed"])) { ?>
      <div class="alert alert-danger text-danger">
      <?php
         echo $_SESSION["failed"];
         unset($_SESSION["failed"]);
          ?>
        </div> 
        <?php
          }
          ?>
<div class="main-content w-100">


<div class="py-4 w-100">
  <h4 class="py-2"><?= $table_name ?></h4>
  <!-- Script for toggle -->
  <div>
        <ul class="nav nav-tabs flex-row justify-content-start">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./index.php"><i class="fa-solid fa-building-circle-arrow-right" data-toggle="tooltip" data-placement="top" title="Business Category"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./business-status-index.php"><i class="fa-solid fa-tags" data-toggle="tooltip" data-placement="top" title="Business Status"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./bd-status-index.php"><i class="fa-solid fa-tag" data-toggle="tooltip" data-placement="top" title="BD Status"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./partnership-processing-status-index.php"><i class="fa-solid fa-handshake" data-toggle="tooltip" data-placement="top" title="Partnership Processing Status"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./promotion-status-index.php"><i class="fa-solid fa-photo-film" data-toggle="tooltip" data-placement="top" title="Promotion Status"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./company-positions-index.php"><i class="fa-solid fa-user-gear" data-toggle="tooltip" data-placement="top" title="Company Positions"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./point-person-position-index.php"><i class="fa-solid fa-building-user" data-toggle="tooltip" data-placement="top" title="Point Person Position"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./event-category-index.php"><i class="fa-solid fa-calendar-day" data-toggle="tooltip" data-placement="top" title="Event Category"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./company-category-update-index.php"><i class="fa-solid fa-square-poll-horizontal" data-toggle="tooltip" data-placement="top" title="Company Category Update"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./podmots-category-index.php"><i class="fa-solid fa-folder-tree" data-toggle="tooltip" data-placement="top" title="Publication Materials Category"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./provinces-index.php"><i class="fa-solid fa-map-location-dot" data-toggle="tooltip" data-placement="top" title="Provinces"></i></a>
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


$db->query("SELECT * from category;");
$db->execute();
$table_data = $db->resultSet();
$table_structure = array(
  "rows" => json_encode($table_data),
  "columns" => json_encode(array(
    "category_name" => "Categories",
    "id" => "",
  ))
);
$db->closeStmt();
//print_r($table_structure["rows"]);
?>
<script src="../../Assets/js/datatables_functions.js"></script>
<script>
  $(document).ready(function() {
    var tableName = "<?= $table_name ?>";
    var editor;
    var columns = JSON.parse('<?php print_r($table_structure["columns"]); ?>');
    var rows = ObjectsToDataTableArray(JSON.parse('<?php print_r($table_structure["rows"]); ?>'), Object.keys(columns));
    var mainDataTableId = "#datatable-main";
    showDataTable(rows,columns, mainDataTableId,tableName,option={
      isWitheditButton: true,
      isWithAddButton: true,
      isWithDropdownButton: true,
      isWithDropdownButton1: true,
      paging: false,
      isWithdeleteButton: false,
    });
    // hiding data from the table
    $("#datatable-main tbody tr td:nth-child(2)").each(function() {
      var tdData = $(this).text();
      $(this).html(
        `
        <span style="visibility:hidden; width:1px; position:absolute;">${tdData}<span>
        `
        );
      });
     // Edit record
    $(mainDataTableId).on('click', 'td.editor-edit', function (e) {
      var rowObject = JSON. parse($(this).attr("rowdata"));
      $("#category-id").val(rowObject['id']);
      $("#category-name").val(rowObject['category_name']);
    });

    var table = $('#datatable-main').DataTable();
    $('#datatable-main tbody').on('mouseenter', 'td', function () {
        var colIdx = table.cell(this).index().column;

        $(table.cells().nodes()).removeClass('highlight');
        $(table.column(colIdx).nodes()).addClass('highlight');
    });

    var columnArr = Object.keys(columns);
    console.log(columnArr);
    $("#datatable-main tbody tr").each(function() {
      var element = $(this);
      console.log(element);
      var rowObject = {};
      var i = 0;
      element.children('td').each(function () {
        var textData = $(this).text().trim();
        rowObject[columnArr[i]] = textData;
        if(i == 2){
          $(this).attr("rowdata",JSON.stringify(rowObject));
        }
        i++;
      });
    });
  });
</script>
</body>