<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle("Membership Details");
require_once "../../Controllers/Database.php";
$db = new Database();
$table_name = "Membership Details";
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
<?php require_once("./membership-details-add.php"); ?>
<?php require_once("./membership-details-edit.php"); ?>
<?php
    if (isset($_SESSION["success-member-addition"])) { ?>
        <div class="alert alert-success text-success">
            <?php
            echo $_SESSION["success-member-addition"];
            unset($_SESSION["success-member-addition"]);
            ?>
        </div> <?php
            }
?>

<div class="main-content w-100">
    <h4 class="py-2"><?= $table_name ?></h4>
    <!-- Script for toggle -->
    <div>
        <ul class="nav nav-tabs flex-row justify-content-start">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="./index.php"><i class="fa-solid fa-building" data-toggle="tooltip" data-placement="top" title="Business"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="./membership-details-index.php"><i class="fa-solid fa-building-circle-check" data-toggle="tooltip" data-placement="top" title="Membership Details"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./business-category-index.php"><i class="fa-solid fa-filter" data-toggle="tooltip" data-placement="top" title="Business Category"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./region-index.php"><i class="fa-solid fa-map-location-dot" data-toggle="tooltip" data-placement="top" title="Business in each Region"></i></a>
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
  membership_details.id,
  membership_details.business_id,
  business.business_name,
  membership_details.member_since,
  membership_details.membership_renewal,
  membership_details.membership_expiration
  FROM
  membership_details
  RIGHT JOIN business ON membership_details.business_id = business.id
  WHERE business.is_a_member='YES';");
  $db->execute();
  $table_data = $db->resultSet();
  $accounts = array(
    "rows" => json_encode($table_data),
    "columns" => json_encode(array(
      "business_name" => "Business Name",
      "member_since" => "Member Since",
      "membership_renewal" => "Membership Renewal Date",
      "membership_expiration" => "Membership Expiration Date",
      "id" => "",
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
    showDataTable(rows,columns, mainDataTableId,tableName, option = {
      isWitheditButton: true,
      isWithAddButton: true,
      isWithDropdownButton: true,
      isWithDropdownButton1: true,
      paging: false,
      isWithdeleteButton: false,
    });
     // Edit record
    $(mainDataTableId).on('click', 'td.editor-edit', function (e) {
      var rowObject = JSON. parse($(this).attr("rowdata"));
      $("#edit-membership-details-id").val(rowObject['id']);
      $("#edit-business-name").val(rowObject['business_name']);
      $("#edit-member-since").val(rowObject['member_since']);
      $("#edit-membership-renewal").val(rowObject['membership_renewal']);
      $("#edit-membership-expiration").val(rowObject['membership_expiration']); 
    });
    var table = $('#datatable-main').DataTable();

    $("#datatable-main tbody tr td:nth-child(5)").each(function() {
      var rowDataHidden = $(this).text();
      $(this).html(
        `
          <span class="invisible" style="width:0px; position:absolute;">${rowDataHidden}</span>
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
      console.log(element);
      var rowObject = {};
      var i = 0;
      element.children('td').each(function () {
        var textData = $(this).text().trim();
        rowObject[columnArr[i]] = textData;
        if(i == 5){
          $(this).attr("rowdata",JSON.stringify(rowObject));
        }
        i++;
      });
    });
  });
</script>
</body>