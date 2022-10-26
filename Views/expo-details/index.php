<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle("Expo Details");
require_once "../../Controllers/Database.php";
$db = new Database();
$table_name = "Expo Details";
allow_all_fully_authenticated();
?>


<?php require_once "../../Templates/sidebar.php"; ?>
<?php require_once("./expo-details-delete.php"); ?>
<?php require_once("./expo-details-add.php"); ?>
<?php require_once("./expo-details-edit.php"); ?>
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
if (isset($_SESSION["success-expo-details"])) { ?>
        <div class="alert alert-success text-success">
            <?php
            echo $_SESSION["success-expo-details"];
            unset($_SESSION["success-expo-details"]);
            ?>
        </div> <?php } ?>
<?php if (isset($_SESSION["failed"])) { ?>
      <div class="alert alert-danger text-danger">
      <?php
      echo $_SESSION["failed"];
      unset($_SESSION["failed"]);
      ?>
        </div> 
        <?php } ?>


<div class="main-content w-100">
    <h4 class="py-2"><?= $table_name ?></h4>
    <!-- Script for toggle -->
    <div>
        <ul class="nav nav-tabs flex-row justify-content-start">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./index.php"><i class="fa-solid fa-e" data-toggle="tooltip" data-placement="top" title="Expo Details"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./online-expo-index.php"><i class="fa-solid fa-users-rectangle" data-toggle="tooltip" data-placement="top" title="Online Expo"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./onsite-expo-index.php"><i class="fa-solid fa-people-group" data-toggle="tooltip" data-placement="top" title="Onsite Expo"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./media-partners-list-index.php"><i class="fa-solid fa-rectangle-ad" data-toggle="tooltip" data-placement="top" title="Media Partners List"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./data-gathering-index.php"><i class="fa-solid fa-file-arrow-down" data-toggle="tooltip" data-placement="top" title="Data Gathering"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./business-development-index.php"><i class="fa-solid fa-building-shield" data-toggle="tooltip" data-placement="top" title="Business Development"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./company-list-index.php"><i class="fa-solid fa-clipboard-list" data-toggle="tooltip" data-placement="top" title="Company List"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./package-index.php"><i class="fa-solid fa-box-archive" data-toggle="tooltip" data-placement="top" title="Package"></i></a>
            </li>
        </ul>
    </div>
    <div class="p-4 shadow-sm table-container">
        <table id="datatable-main" class="table table-striped" style="width: 100%;"></table>
    </div>
</div>
<!-- End of Script for toggle -->

<div>
</div>

    

<?php


$db->query("SELECT * FROM expo_details");
$db->execute();
$table_data = $db->resultSet();

$accounts = array(
  "rows" => json_encode($table_data),
  "columns" => json_encode(array(
    'id' => "",
    'expo_name' => 'Expo Name',
    'expo_location' => 'Expo Location',
    'expo_date' => 'Expo Date',
    'expo_poster' => 'Expo Poster',
    'slot_count' => 'Slot Count',
    'promotion_packages' => 'Promotion packages',
    'is_online' => 'Online'
    ))
);
$db->closeStmt();
?>

<script src="../../Assets/js/datatables_functions.js"></script>
<script>
  $(document).ready(function() {
    var tableName = "<?= $table_name ?>";
    var editor;
    var columns = JSON.parse('<?php print_r($accounts["columns"]); ?>');
    var rows = ObjectsToDataTableArray(JSON.parse('<?php print_r($accounts["rows"]); ?>'), Object.keys(columns));
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
      //  console.log(rowObject['expo_id']);

       $("#expo_name").val(rowObject['expo_name']);
       $("#expo_location").val(rowObject['expo_location']);
       $("#expo_date").val(rowObject['expo_date']);
       $("#expo_poster").val(rowObject['expo_poster']);
       $("#slot_count").val(rowObject['slot_count']);
       $("#promotion_packages").val(rowObject['promotion_packages']);
       $("#is_online").val(rowObject['is_online']);
    });

    $(".delete-button").click(function(){
      var id = $(this).closest("tr").get(0).id;
      $("#delete-input").val(id);
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
        if(i == 8){
          $(this).attr("rowdata",JSON.stringify(rowObject));
        }
        i++;
      });
      
    }); 
      $("#datatable-main tbody tr td:nth-child(1)").each(function() {
      var tdData = $(this).text();
      $(this).html(
        `
        <span class="invisible">${tdData}</span>
        `
        );
      });
  });
</script>
</body>