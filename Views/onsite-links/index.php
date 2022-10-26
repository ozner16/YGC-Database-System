<?php
$table_name = "Onsite Links";
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle($table_name);
require_once "../../Controllers/Database.php";
$db = new Database();

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
  #addButtonForAllTable{
    display:none;
  }
</style>
<?php endif?>
<?php
    if (isset($_SESSION["success-onsite-link"])) { ?>
        <div class="alert alert-success text-success">
            <?php
            echo $_SESSION["success-onsite-link"];
            unset($_SESSION["success-onsite-link"]);
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

  <h4 class="py-2"><?= $table_name ?></h4>
  <div class="p-4 shadow-sm table-container">
  <?php require_once "./filters.php"; ?>
    <table id="datatable-main" class="table table-striped h-full w-full"></table>
  </div>
</div>

<?php require_once("./edit.php"); ?>
<?php require_once("./add.php"); ?>
<?php require_once("./delete.php"); ?>

<div>
</div>

<?php

$log_filter = "";
$NO = "NO";
if ($filter_region && $filter_region != "All Online links" ) $log_filter = "WHERE expo_name LIKE CONCAT('{$filter_region}')";

$db->query("SELECT 
links_for_expo.id,
expo_details.expo_name,
links_for_expo.link_name,
links_for_expo.link
FROM
links_for_expo
JOIN expo_details ON expo_details.id = links_for_expo.expo_details_id
{$log_filter} AND `is_online` = 'NO'");
$db->execute();
$table_data = $db->resultSet();
$table_structure = array(
  "rows" => json_encode($table_data),
  "columns" => json_encode(array(
    'id' => '',
    'expo_name' => 'Expo name',
    'link_name' => 'Link name',
    'link' => 'Link'
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
    showDataTable(rows,columns, mainDataTableId,tableName,option={
      isWitheditButton: true,
      isWithAddButton: true,
      isWithDropdownButton: true,
      isWithDropdownButton1: true,
      paging: false,
      isWithdeleteButton: true,
    });
     // Edit record
    $(mainDataTableId).on('click', 'td.editor-edit', function (e) {
      var rowObject = JSON. parse($(this).attr("rowdata"));
      $("#edit-exhibitors").val(rowObject['exhibitors_name']);
      $("#edit-id").val(rowObject['id']);
      console.log(rowObject['expo_id']);
       //for selecting name
       $('#expo_name option[data ="'+rowObject["expo_name"]+'"]').prop('selected', true);
       $("#logo_storage").val(rowObject['link_name']);
      $("#package_link").val(rowObject['link']);
    });
    $(".delete-button").click(function(){
      var id = $(this).closest("tr").get(0).id;
      $("#delete-input").val(id);
    });
    $("#datatable-main tbody tr td:nth-child(1)").each(function() {
    var tdData = $(this).text();
    $(this).html(
      `
      <span class="invisible">${tdData}<span>
      `
      );
    }); 

    console.log(columns);
    var columnArr = Object.keys(columns);

    $("#datatable-main tbody tr").each(function() {
      var element = $(this);
      console.log(element);
      var rowObject = {};
      var i = 0;
      element.children('td').each(function () {
        var textData = $(this).text().trim();
        rowObject[columnArr[i]] = textData;
        if(i == 4){
          $(this).attr("rowdata",JSON.stringify(rowObject));
        }
        i++;
      });
    
  });
});
</script>
</body>