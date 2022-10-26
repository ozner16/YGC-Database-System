<?php
$table_name = "Media Partners List";
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle($table_name);
require_once "../../Controllers/Database.php";
$db = new Database();
allow_all_fully_authenticated();
?>

<?php require_once("./media-partners-list-edit.php"); ?>
<?php require_once("./media-partners-list-add.php"); ?>
<?php require_once("./media-partners-list-delete.php"); ?>


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
                <a class="nav-link" href="./onsite-expo-index.php"><i class="fa-solid fa-people-group" data-toggle="tooltip" data-placement="top" title="Onsite Expo"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="./media-partners-list-index.php"><i class="fa-solid fa-rectangle-ad" data-toggle="tooltip" data-placement="top" title="Media Partners List"></i></a>
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
<!-- End of Script for toggle -->
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


$db->query("SELECT media_partners_list.id, expo_details.expo_name, media_partners.company_name, partnership_processing_status.pp_status, promotion_status.prom_status,media_partners_list.is_MOA,media_partners_list.link_MOA,media_partners_list.fb_post,media_partners_list.twitter_post,media_partners_list.ig_post,media_partners_list.website_post FROM media_partners_list, expo_details,media_partners,partnership_processing_status,
promotion_status WHERE media_partners_list.expo_details_id = expo_details.id AND media_partners_list.media_partner_id = media_partners.id AND media_partners_list.partnership_status_id = partnership_processing_status.id AND media_partners_list.promotion_status_id = promotion_status.id;");
$db->execute();
$table_data = $db->resultSet();
$table_structure = array(
  "rows" => json_encode($table_data),
  "columns" => json_encode(array(
    'id' => '',
    'expo_name' => 'Expo Name',
    'company_name' => 'Media Partner',
    'pp_status' => 'Partnership Status',
    'prom_status' => 'Promotion Status',
    'is_MOA' => 'MOA',
    'link_MOA' => 'Link for MOA',
    'fb_post' => 'Facebook post link',
    'twitter_post' => 'Twitter post link',
    'ig_post' => 'Instagram post link',
    'website_post' => 'Website post link',
   
    
   
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

      var rowObject = JSON.parse($(this).attr("rowdata"));
      $("#edit-id").val(rowObject['id']);
      $("#edit-expo-name option:contains(" + rowObject['expo_name'] + ")").attr('selected', 'selected');
      $("#edit-company-name option:contains(" + rowObject['company_name'] + ")").attr('selected', 'selected');
      $("#edit-partnership_status option:contains(" + rowObject['pp_status'] + ")").attr('selected', 'selected');
      $("#edit-promotion_status option:contains(" + rowObject['prom_status'] + ")").attr('selected', 'selected');
      $("#edit-is-moa option:contains(" + rowObject['is_MOA'] + ")").attr('selected', 'selected');
      $("#edit-moa-link").val(rowObject['link_MOA']);
      $("#edit-fb-post").val(rowObject['fb_post']);
      $("#edit-twitter-post").val(rowObject['twitter_post']);
      $("#edit-ig-post").val(rowObject['ig_post']);
      $("#edit-website-post").val(rowObject['website_post']);
     
      
    });
    var table = $('#datatable-main').DataTable();
 
    $('#datatable-main tbody').on('mouseenter', 'td', function () {
     var colIdx = table.cell(this).index().column;

     $(table.cells().nodes()).removeClass('highlight');
     $(table.column(colIdx).nodes()).addClass('highlight');
    });

    $("#datatable-main tbody tr td:nth-child(1)").each(function() {
    var tdData = $(this).text();
    $(this).html(
      `
      <span class="invisible">${tdData}<span>
      `
      );
    });

    var columnArr = Object.keys(columns);
    
    $(".delete-button").click(function(){

      var id = $(this).closest("tr").get(0).id;
    
      $("#delete-input").val(id);

    });
    $("#datatable-main tbody tr").each(function() {
      var element = $(this);
      //console.log(element);
      var rowObject = {};
      var i = 0;
      element.children('td').each(function () {
        var textData = $(this).text().trim();
           
           rowObject[columnArr[i]] = textData;
           if(i==11){
            $(this).attr("rowdata",JSON.stringify(rowObject));
           }
           i++;
      });
    });
  });
</script>
</body>