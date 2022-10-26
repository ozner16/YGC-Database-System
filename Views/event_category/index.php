<?php
$table_name = "Event Category";
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle($table_name);
require_once "../../Controllers/Database.php";
$db = new Database();
allow_specific_user_only(["web admin"]);
?>

<?php require_once("./edit.php"); ?>
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

  <h4 class="py-2"><?= $table_name ?></h4>
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


$db->query("SELECT * from event_category;");
$db->execute();
$table_data = $db->resultSet();
$table_structure = array(
  "rows" => json_encode($table_data),
  "columns" => json_encode(array(
    'event_cat_name' => 'Event Category',
    'id' => '',
  ))
);

?>
<script src="../../Assets/js/datatables_functions.js"></script>
<script>
  $(document).ready(function() {
    var tableName = "<?= $table_name ?>";
    var editor;
    var columns = JSON.parse('<?php print_r($table_structure["columns"]); ?>');
    var rows = ObjectsToDataTableArray(JSON.parse('<?php print_r($table_structure["rows"]); ?>'), Object.keys(columns));
    var mainDataTableId = "#datatable-main";
    showDataTable(rows, columns, mainDataTableId, tableName, option = {
      isWitheditButton: true,
      isWithAddButton: true,
      isWithDropdownButton: true,
      isWithDropdownButton1: true,
      paging: false,
      isWithdeleteButton: false,
    });
     // Edit record
    $(mainDataTableId).on('click', 'td.editor-edit', function (e) {

      var rowObject = JSON.parse($(this).attr("rowdata"));
      $("#edit_id").val(rowObject['id']);
      $("#edit_category").val(rowObject['event_cat_name']);
     
      
    });
    var table = $('#datatable-main').DataTable();

    $("#datatable-main tbody tr td:nth-child(2)").each(function() {
      var tdData = $(this).text();
      $(this).html(
        `
        <span class="invisible">${tdData}<span>
        `
        );
      });
 
    $('#datatable-main tbody').on('mouseenter', 'td', function () {
     var colIdx = table.cell(this).index().column;

     $(table.cells().nodes()).removeClass('highlight');
     $(table.column(colIdx).nodes()).addClass('highlight');
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
            console.log(textData);
           rowObject[columnArr[i]] = textData;
           if(i==2){
            $(this).attr("rowdata",JSON.stringify(rowObject));
           }
           i++;
      });
    });
  });
</script>
</body>