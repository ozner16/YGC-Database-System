<?php
$table_name = "Business Status";
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
// allow_specific_user_only(["web admin"],$_SERVER['HTTP_REFERER']);
setTitle($table_name);
require_once "../../Controllers/Database.php";
$db = new Database();
// allow_all_authenticated_only();
allow_specific_user_only(["web admin"]);
?>  

<?php require_once("./edit.php"); ?>
<?php require_once("./add.php"); ?>
<?php require_once("./delete.php"); ?>

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

  <h4 class="py-2" id="" ><?= $table_name ?></h4>
  <?php
  if (isset($_SESSION["success"])) { ?>
      <div class="alert alert-success text-success">
            <?php
           echo $_SESSION["success"];
            unset($_SESSION["success"]);
            ?>
        </div> <?php

          }
                ?>
  <?php
    if (isset($_SESSION["failed-card"])) { ?>
        <div class="alert alert-danger">
            <?php
            echo $_SESSION["failed-card"];
            unset($_SESSION["failed-card"]);
            ?>
        </div> <?php
            }
                ?>
  <div class="p-4 shadow-sm table-container">
    <table id="datatable-main" class="table table-striped h-full w-full"></table>
  </div>
</div>



<div>
</div>

<?php


$db->query("SELECT * from business_status;");
$db->execute();
$table_data = $db->resultSet();

$table_structure = array(
  "rows" => json_encode($table_data),
  "columns" => json_encode(array(
    "status" => "Status",
    "color" => "Color code",
    "id" => ""
  ))
);
//$db->closeStmt();
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
    showDataTable(rows, columns, mainDataTableId, tableName, {
    isWitheditButton: true,
    isWithAddButton: true,
    isWithDropdownButton: true,
    isWithDropdownButton1: true,
    paging: true,
    isWithdeleteButton: false
}) ;
    // Edit record
    $(mainDataTableId).on('click', 'td.editor-edit', function (e) {
      var rowObject = JSON. parse($(this).attr("rowdata"));
      $("#edit-id").val(rowObject['id']);
      $("#edit-status").val(rowObject['status']);
      $("#edit-color").val(rowObject['color']);
      
    });

    $("#datatable-main tbody tr td:nth-child(2)").each(function() {
      var color = $(this).text();
      $(this).html(
        `
          <div class="color-code-badge shadow-sm" style="background-color:${color}"></div>
          <span class="invisible">${color}</span>
        `
      );
    });
    $("#datatable-main tbody tr td:nth-child(3)").each(function() {
      var tdData = $(this).text();
      $(this).html(
        `
        <span class="invisible">${tdData}<span>
        `
        );
      });
    var columnArr = Object.keys(columns);
    console.log(columnArr);
    $("#datatable-main tbody tr").each(function() {
      var element = $(this);
      //console.log(element);
      var rowObject = {};
      var i = 0;
      element.children('td').each(function () {
        var textData = $(this).text().trim();
        rowObject[columnArr[i]] = textData;
        if(i == 3){
          $(this).attr("rowdata",JSON.stringify(rowObject));
        }
        i++;
      });
      
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