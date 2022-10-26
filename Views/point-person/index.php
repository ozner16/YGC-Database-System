<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle("User Accounts");
require_once "../../Controllers/Database.php";
$db = new Database();
$table_name = "Point Person";
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
?>  <?php
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
$db->query("SELECT 
point_person.id as pid,
point_person_position.position,
point_person.name,
point_person.contact_number,
point_person.email,
point_person.id,
point_person_category.id,
point_person_category.category_name as cat_name
FROM `point_person` 
JOIN point_person_position ON point_person.position_id = point_person_position.id
JOIN point_person_category ON point_person.point_person_category_id = point_person_category.id;");
$db->execute();
$table_data = $db->resultSet();
 
$accounts = array(
  "rows" => json_encode($table_data),
  "columns" => json_encode(array(
    'pid' => '',
    'position' => 'Position',
    'name' => 'Point Person Name',
    'contact_number' => 'Contact Number',
    'email' => 'Email',
    'cat_name' => 'Contact Person for'

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
    $(mainDataTableId).on('click', 'td.editor-edit', function (e) {
      // alert("Test");
      var rowObject = JSON. parse($(this).attr("rowdata"));
      $("#point-person-id").val(rowObject['pid']);
      $("#point-person-name").val(rowObject['name']);
      $("#point-person-contact-number").val(rowObject['contact_number']);
      $("#point-person-email").val(rowObject['email']);
      $('#point_person_record_for [data ="'+rowObject["cat_name"]+'"]').prop('selected', true);
      $('#point-person-position [data ="'+rowObject["position"]+'"]').prop('selected', true);
    });

    $(".delete-button").click(function(){
      var id = $(this).closest("tr").get(0).id;
      $("#delete-point-person-id").val(id);
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
        if(i == 6){
          $(this).attr("rowdata",JSON.stringify(rowObject));
        }
        i++;
      });
    
  })
  
  $("#datatable-main tbody tr td:nth-child(1)").each(function() {
    var tdData = $(this).text();
    $(this).html(
      `
      <span class="invisible">${tdData}<span>
      `
      );
    }); 
  });
</script>
</body>