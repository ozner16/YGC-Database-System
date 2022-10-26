<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle("User Accounts");
require_once "../../Controllers/Database.php";
$db = new Database();
$table_name = "Point Person Position";
// allow_all_authenticated_only();
allow_specific_user_only(["web admin"]);
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
<?php require_once("./add.php"); ?>
<?php require_once("./edit.php"); ?>
<?php
    if (isset($_SESSION["success-business"])) { ?>
        <div class="alert alert-success text-success">
            <?php
            echo $_SESSION["success-business"];
            unset($_SESSION["success-business"]);
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
    <table id="datatable-main" class="table table-striped w-100"></table>
  </div>
</div>

<div>
</div>


<?php
$db->query("SELECT *  FROM point_person_position;");
$db->execute();
$table_data = $db->resultSet();
 
$accounts = array(
  "rows" => json_encode($table_data),
  "columns" => json_encode(array(
    'id' => '',
    'position' => 'Position'
    ))
);
$db->closeStmt();

?>
<script src="../../Assets/js/datatables_functions.js"></script>
<script>
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
  })
  
  $(document).ready(function() {
    var tableName = "<?= $table_name ?>";
    var editor;
    var columns = JSON.parse('<?php print_r($accounts["columns"]); ?>');
    var rows = ObjectsToDataTableArray(JSON.parse('<?php print_r($accounts["rows"]); ?>'), Object.keys(columns));
    var mainDataTableId = "#datatable-main";
    showDataTable(rows,columns, mainDataTableId,tableName, option={
      isWitheditButton: true,
      isWithAddButton: true,
      isWithDropdownButton: true,
      isWithDropdownButton1: true,
      paging: false,
      isWithdeleteButton: false,
    });
    
     // Edit record
    $("#datatable-main tbody tr td:nth-child(1)").each(function() {
    var tdData = $(this).text();
    $(this).html(
      `
      <span class="invisible">${tdData}<span>
      `
      );
    });
    $(mainDataTableId).on('click', 'td.editor-edit', function (e) {
      // alert("Test");
      var rowObject = JSON. parse($(this).attr("rowdata"));
      $("#point-person-position-id").val(rowObject['id']);
      $("#point-person-position").val(rowObject['position']);
    });
    $(".delete-button").click(function(){
      var id = $(this).closest("tr").get(0).id;
      $("#delete-point-person-id").val(id);
      
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