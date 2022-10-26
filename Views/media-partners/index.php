<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle("Media Partners");
require_once "../../Controllers/Database.php";
$db = new Database();
$table_name = "Media Partners";
allow_all_fully_authenticated();
?>



<?php require_once "../../Templates/sidebar.php"; ?>
<?php require_once("./edit.php"); ?>
<?php require_once("./add.php"); ?>
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
    <table id="datatable-main" class="table table-striped" style="width:100%"></table>
  </div>
</div>

<?php

$db->query("SELECT media_partners.id, media_partners.company_name, media_partners.email, media_partners.facebook_page, media_partners.website, refprovince.provDesc, media_partnership_status.status, point_person.name FROM media_partnership_status,media_partners, point_person, refprovince WHERE 
media_partners.partnership_status_id = media_partnership_status.id AND media_partners.point_person_id = point_person.id AND media_partners.refprovince_id = refprovince.id;");
$db->execute();
$table_data = $db->resultSet();
$accounts = array(
  "rows" => json_encode($table_data),
  "columns" => json_encode(array(
    "id" => "",
    'company_name' => 'Company Name',
    'email' => 'Email',
    'facebook_page' => 'Facebook Page',
    'website' => 'Website',
    'provDesc' => 'Location Covered',
    'name' => 'Point Person Name',
    'status' => 'Partnership Status',
      ))
  );
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
      isWithdeleteButton: false,
    });
     // Edit record
    $(mainDataTableId).on('click', 'td.editor-edit', function (e) {
      var rowObject = JSON.parse($(this).attr("rowdata"));
      $("#edit-id").val(rowObject['id']);
      $("#edit-media_partner-name").val(rowObject['company_name']);
      $("#edit-media_partner-email").val(rowObject['email']);
      $("#edit-media_partner-fb_page").val(rowObject['facebook_page']);
      $("#edit-media_partner-website").val(rowObject['website']);
      // $("#edit_media_partner_location").val(rowObject['location_covered']);
      $("#edit_media_partner_location option:contains(" + rowObject['provDesc'] + ")").attr('selected', 'selected');
      $("#edit_media_partner_point_person option:contains(" + rowObject['name'] + ")").attr('selected', 'selected');
      $("#edit_media_partner_status option:contains(" + rowObject['status'] + ")").attr('selected', 'selected');
   
    });
   
    var columnArr = Object.keys(columns);
    console.log(columnArr);
    $(".delete-button").click(function(){

      var id = $(this).closest("tr").get(0).id;
      console.log(id);
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

    $("#datatable-main tbody tr").each(function() {
      var element = $(this);
      //console.log(element);
      var rowObject = {};
      var i = 0;
      element.children('td').each(function () {
        var textData = $(this).text().trim();
            console.log(textData);
           rowObject[columnArr[i]] = textData;
           if(i==8){
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