<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle("Business");
require_once "../../Controllers/Database.php";
$db = new Database();
$table_name = "Business";
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
<?php require_once("./business-add.php"); ?>
<?php require_once("./business-edit.php"); ?>

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
    <!-- Script for toggle -->
    <div>
        <ul class="nav nav-tabs flex-row justify-content-start">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./index.php"><i class="fa-solid fa-building" data-toggle="tooltip" data-placement="top" title="Business"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./membership-details-index.php"><i class="fa-solid fa-building-circle-check" data-toggle="tooltip" data-placement="top" title="Membership Details"></i></a>
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
business.id AS business_id,
business.business_name,
business.business_owner,
business.branch,
business.region,
business_status.id AS status_id,
business_status.color AS status_color,
business_status.status AS status_name,
membership_details.member_since,
membership_details.membership_renewal,
membership_details.membership_expiration,
point_person.name,
point_person_position.position,
business.business_fbpage, 
business.business_email,
business.business_website,
business.business_address,
business.contact_number,
business.missing_info,
business.notes,
business.on_website,
business.certificate_sent,
business.id_card_sent,
business.birthday,
business.sub_business,
business.is_a_member,
business.business_logo
FROM
business
LEFT JOIN business_status ON business.status_id = business_status.id
LEFT JOIN membership_details ON membership_details.business_id = business.id 
LEFT JOIN point_person ON business.point_person_id = point_person.id
LEFT JOIN point_person_position ON point_person.position_id = point_person_position.id;");
$db->execute();
$table_data = $db->resultSet();
 
$accounts = array(
  "rows" => json_encode($table_data),
  "columns" => json_encode(array(
    'status_color' => 'Flag',
    'status_name' => 'Status',
    'is_a_member' => 'Member',
    'business_logo' => 'Logo',
    'business_name' => 'Name',
    'business_owner' => 'Owner',
    'branch' => 'Branch',
    'region' => 'Region',
    'member_since' => 'Member Since',
    'membership_renewal' => 'Membership Renewal',
    'membership_expiration' => 'Membership Expiration',
    'name' => 'Point Person',
    'position' => 'Position',
    'business_fbpage' => 'Facebook Page',
    'business_email' => 'Email',
    'business_website' => 'Website',
    'business_address' => 'Address',
    'contact_number' => 'Contact Number',
    'missing_info' => 'Missing Info',
    'notes' => 'Notes',
    'on_website' => 'On Website',
    'certificate_sent' => 'Certificate Sent',
    'id_card_sent' => 'ID Card Sent',
    'birthday' => 'Founding Date',
    'sub_business' => 'Sub-Businesses',
    'status_id' => '',
    'business_id' => '',
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
      // alert("Test");
      var rowObject = JSON. parse($(this).attr("rowdata"));
      $("#get-business-id").val(rowObject['business_id']);
      $("#edit-business-name").val(rowObject['business_name']);
      $("#edit-branch").val(rowObject['branch']);
      $("#edit-region").val(rowObject['region']);
      $("#edit-business-status-id").val(rowObject['status_id']);
      $("#edit-business-status-name").val(rowObject['status_name']);
      $("#edit-business-logo").val(rowObject['business_logo']);
      $("#edit-business-owner").val(rowObject['business_owner']);
      $("#edit-business-fb-page").val(rowObject['business_fbpage']);
      $("#edit-business-email").val(rowObject['business_email']);
      $("#edit-business-website").val(rowObject['business_website']);
      $("#edit-address").val(rowObject['business_address']);
      $("#edit-contact-number").val(rowObject['contact_number']);
      $("#edit-missing-info").val(rowObject['missing_info']);
      $("#edit-on-website").val(rowObject['on_website']);
      $("#edit-certificate-sent").val(rowObject['certificate_sent']);
      $("#edit-id-card-sent").val(rowObject['id_card_sent']);
      $("#edit-founding-date").val(rowObject['birthday']);
      $("#edit-sub-businesses").val(rowObject['sub_business']);
      $("#edit-notes").val(rowObject['notes']);
      $("#is-a-member").val(rowObject['is_a_member']);
    });

    // hiding data from the table
    $("#datatable-main tbody tr td:nth-child(4)").each(function() {
      var tdData = $(this).text();
      $(this).html(
        `
        <img class="business-logo" src="${tdData}">
        <span class="invisible" style="width:1px; position:absolute;">${tdData}</span>
        `
        );
      });

    $("#datatable-main tbody tr td:nth-child(1)").each(function() {
      // show the value as a color
      var color = $(this).text();
      $(this).html(
      `
        <div class="color-code-badge shadow-sm" style="background-color:${color}"></div>
        <span class="invisible">${color}</span>
      `
    );
    });
    $("#datatable-main tbody tr td:nth-child(26)").each(function() {
      var tdData = $(this).text();
      $(this).html(
        `
        <span class="invisible">${tdData}</span>
        `
        );
      });
    $("#datatable-main tbody tr td:nth-child(27)").each(function() {
    var tdData = $(this).text();
    $(this).html(
      `
      <span class="invisible">${tdData}</span>
      `
      );
    });
    // end of hiding data from the table


    var table = $('#datatable-main').DataTable();
    table.draw();
 
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
        if(i == 27){
          $(this).attr("rowdata",JSON.stringify(rowObject));
        }
        i++;
      });
    });
    table.draw();
  });
</script>
</body>