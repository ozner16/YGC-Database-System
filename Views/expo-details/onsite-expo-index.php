<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle("Onsite Expo");
require_once "../../Controllers/Database.php";
$db = new Database();
allow_all_fully_authenticated();
$table_name = "Onsite Confirmed Expo";

?>



<?php require_once "../../Templates/sidebar.php"; ?>
<?php require_once("./onsite-expo-delete.php"); ?>
<?php require_once("./onsite-expo-edit.php"); ?>
<?php require_once("./onsite-expo-add.php"); ?>
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
    if (isset($_SESSION["success"])) { ?>
        <div class="alert alert-success text-success">
            <?php
            echo $_SESSION["success"];
            unset($_SESSION["success"]);
            ?>
        </div> <?php
      }
?>
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
                <a class="nav-link" aria-current="page" href="./index.php"><i class="fa-solid fa-e" data-toggle="tooltip" data-placement="top" title="Expo Details"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./online-expo-index.php"><i class="fa-solid fa-users-rectangle" data-toggle="tooltip" data-placement="top" title="Online Expo"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="./onsite-expo-index.php"><i class="fa-solid fa-people-group" data-toggle="tooltip" data-placement="top" title="Onsite Expo"></i></a>
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
expo_details.expo_name,
business.business_name,
business.business_owner,
business.business_fbpage,
business.business_email,
business.business_website,
business.contact_number,
package.package_name,
slot_status.status,
expo_slots.slot_name,
expo_slots.slot_number,


requirement_for_expo_slot.is_MOA,
requirement_for_expo_slot.is_certificate,
requirement_for_expo_slot.is_ID,

requirement_for_expo_slot.is_added_in_gc,
requirement_for_expo_slot.suppliers_briefing,
requirement_for_expo_slot.floor_layout,
requirement_for_expo_slot.magazine,

requirement_for_expo_slot.teaser_video,
requirement_for_expo_slot.exhibitor_poster,
requirement_for_expo_slot.purchasing_form,
requirement_for_expo_slot.SOA,

requirement_for_expo_slot.acknowledgement_receipt,
requirement_for_expo_slot.exdeal,
requirement_for_expo_slot.ingres,
requirement_for_expo_slot.engres
FROM
business
JOIN business_status ON business.status_id = business_status.id
JOIN expo_slots ON business.id = expo_slots.business_id
JOIN expo_details ON expo_slots.expo_id = expo_details.id
JOIN package ON expo_slots.package_id = package.id
JOIN slot_status ON slot_status.id = expo_slots.slot_status
JOIN requirement_for_expo_slot ON requirement_for_expo_slot.id = expo_slots.requirement_id

WHERE expo_details.is_online = 'NO';");
$db->execute();
$table_data = $db->resultSet();

$accounts = array(
  "rows" => json_encode($table_data),
  "columns" => json_encode(array(
    "id" => "",
    'expo_name' => 'Expo Name',
    'business_name' => 'Business name',
    'business_owner' => 'Business owner',
    'business_fbpage' => 'Business FB page',
    'business_email' => 'Business Email',
    'business_website' => 'Business Website',
    'contact_number' => 'Contact number',
    'package_name' => 'Package name',
    'status' => 'Status',
    'slot_name' => 'Booth name',
    'is_added_in_gc' => 'Already Added in GC',
    'suppliers_briefing' => 'Attended Suppliers Briefing',
    'is_ID' => 'ID posted',
    'floor_layout' => 'Floor Layout',
    'magazine' => 'Magazine Poster',  
    'teaser_video' => 'Teaser Video',
    'exhibitor_poster' => 'Exhibitor Poster',
    'is_certificate' => 'Certificate',
    'is_MOA' => 'MOA',
    'purchasing_form' => 'Purchasing Form',
    'SOA' => 'SOA' , 
    'acknowledgement_receipt' => 'Acknowledgement Receipt',
    'exdeal' => 'Exchange Deal',
    'ingres' => 'Ingress',
    'engres' => 'Engress' 
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
       $('#package_name option[data ="'+rowObject["package_name"]+'"]').prop('selected', true);
       $('#status option[data ="'+rowObject["status"]+'"]').prop('selected', true);
       //$("#is_MOA edit-is-moa option:contains(" + rowObject['is_MOA'] + ")").attr('selected', 'selected');
      //end select
      $("#slot_name").val(rowObject["slot_name"]);
  
      $("#is_MOA").val(rowObject["is_MOA"]);
      $("#is_certificate").val(rowObject["is_certificate"]);
      $("#is_ID").val(rowObject["is_ID"]);

      $("#is_added_in_gc").val(rowObject["is_added_in_gc"]);
      $("#suppliers_briefing").val(rowObject["suppliers_briefing"]);
      $("#floor_layout").val(rowObject["floor_layout"]);
      $("#magazine").val(rowObject["magazine"]);
      $("#teaser_video").val(rowObject["teaser_video"]);

      $("#exhibitor_poster").val(rowObject["exhibitor_poster"]);
      $("#purchasing_form").val(rowObject["purchasing_form"]);
      $("#SOA").val(rowObject["SOA"]);
      $("#acknowledgement_receipt").val(rowObject["acknowledgement_receipt"]);
      $("#exdeal").val(rowObject["exdeal"]);

      $("#ingres").val(rowObject["ingres"]);
      $("#engres").val(rowObject["engres"]);
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
        if(i == 26){
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