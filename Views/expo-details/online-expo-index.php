<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle("Online Expo");
require_once "../../Controllers/Database.php";
$db = new Database();
$table_name = "Online Expo";
allow_all_fully_authenticated();
?>


<?php require_once "../../Templates/sidebar.php"; ?>
<?php require_once("./online-expo-edit.php"); ?>
<?php require_once("./online-expo-add.php"); ?>
<?php require_once("./online-expo-delete.php"); ?>
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
    if (isset($_SESSION["success-online"])) { ?>
        <div class="alert alert-success text-success">
            <?php
            echo $_SESSION["success-online"];
            unset($_SESSION["success-online"]);
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
    <!-- Script for toggle -->
    <div>
        <ul class="nav nav-tabs flex-row justify-content-start">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="./index.php"><i class="fa-solid fa-e" data-toggle="tooltip" data-placement="top" title="Expo Details"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="./online-expo-index.php"><i class="fa-solid fa-users-rectangle" data-toggle="tooltip" data-placement="top" title="Online Expo"></i></a>
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
<?php
$db->query("SELECT
expo_slots.id,
expo_slots.expo_id,
expo_details.expo_name,
business.business_name,
business.business_owner,
business.business_fbpage,
business.business_email,
business.contact_number,
expo_slots.package_link,
expo_slots.logo_storage_for_online
FROM
business 
JOIN business_status ON business.status_id = business_status.id
JOIN expo_slots ON business.id = expo_slots.business_id
JOIN expo_details ON expo_slots.expo_id = expo_details.id
WHERE expo_details.is_online = 'YES';");
$db->execute();
$table_data_1 = $db->resultSet();
allow_all_authenticated_only();

$accounts = array(
  "rows" => json_encode($table_data_1),
  "columns" => json_encode(array(
    "id" => "",
    'expo_name' => 'Expo Name',
    'business_name' => 'Business name',
    'business_owner' => 'Business owner',
    'business_fbpage' => 'Business FB page',
    'business_email' => 'Business Email',
    'contact_number' => 'Contact number',
    'logo_storage_for_online' => 'Logo Storage',
    'package_link' => 'Package link'
    ))
);


$db->closeStmt();
//print_r($accounts["rows"]);
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
       console.log(rowObject['expo_id']);
       //for selecting name
       $('#expo_name option[data ="'+rowObject["expo_name"]+'"]').prop('selected', true);
       $('#business_name option[data ="'+rowObject["business_name"]+'"]').prop('selected', true);
      //end select

       $("#logo_storage").val(rowObject['logo_storage_for_online']);
      $("#package_link").val(rowObject['package_link']);
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
        if(i == 9){
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