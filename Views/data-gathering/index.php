<?php
$table_name = "Data Gathering";
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle($table_name);
require_once "../../Controllers/Database.php";
$db = new Database();
allow_all_fully_authenticated();
$filter_region = null;
if (isset($_GET["selected_region"])) {
  $filter_region = $_GET["selected_region"];
}
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
    if (isset($_SESSION["success-data_gathering"])) { ?>
        <div class="alert alert-success text-success">
            <?php
            echo $_SESSION["success-data_gathering"];
            unset($_SESSION["success-data_gathering"]);
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
<div class="py-4 w-100">

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
if ($filter_region && $filter_region != "All Online links" ) $log_filter = "WHERE expo_name LIKE CONCAT('{$filter_region}' )";
$db->query("SELECT 
expo_data_gathering.id,
expo_details.expo_name,
business.business_name,
business.business_address,
business.business_fbpage,
business.business_email,
business.contact_number,
data_blasting.blasting_type,
data_blasting.blasting_date,
data_blasting.response
FROM
expo_data_gathering
JOIN expo_details ON expo_details.id = expo_data_gathering.expo_id
JOIN business ON business.id = expo_data_gathering.business_id
JOIN data_blasting ON data_blasting.id = expo_data_gathering.data_blasting_id
{$log_filter}");
$db->execute();
$table_data = $db->resultSet();
$table_structure = array(
  "rows" => json_encode($table_data),
  "columns" => json_encode(array(
    'id' => '',
    'expo_name' => 'Expo name',
    'business_name' => 'Business name',
    'business_address' => 'Business address',
    'business_fbpage' => 'Business FB page',
    'business_email' => 'Business email',
    'contact_number' => 'Contact number',
    'blasting_type' => 'Blasting type',
    'blasting_date' => 'Date',
    'response' => 'Response'
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
       $('#business_name option[data ="'+rowObject["business_name"]+'"]').prop('selected', true);
       $("#blasting_type").val(rowObject['blasting_type']);
      $("#blasting_date").val(rowObject['blasting_date']);
      $("#response").val(rowObject['response']);
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

    var table = $('#datatable-main').DataTable();
 
    $('#datatable-main tbody').on('mouseenter', 'td', function () {
     var colIdx = table.cell(this).index().column;

     $(table.cells().nodes()).removeClass('highlight');
     $(table.column(colIdx).nodes()).addClass('highlight');
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
        if(i == 10){
          $(this).attr("rowdata",JSON.stringify(rowObject));
        }
        i++;
      });
    
  })
    
  });
</script>
</body>