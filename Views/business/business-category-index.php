<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle("Business Category");
require_once "../../Controllers/Database.php";
$db = new Database();
$table_name = "Business Category";
$filter_region = null;
if (isset($_GET["selected_business"])) {
  $filter_region = $_GET["selected_business"];
}
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
<?php require_once("./business-category-add.php"); ?>
<?php require_once("./business-category-edit.php"); ?>
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
  <?php require_once("./business-category-filters.php"); ?>
    <!-- Script for toggle -->
  <div>
    <ul class="nav nav-tabs flex-row justify-content-start">
      <li class="nav-item">
            <a class="nav-link" aria-current="page" href="./index.php"><i class="fa-solid fa-building" data-toggle="tooltip" data-placement="top" title="Business"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./membership-details-index.php"><i class="fa-solid fa-building-circle-check" data-toggle="tooltip" data-placement="top" title="Membership Details"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="./business-category-index.php"><i class="fa-solid fa-filter" data-toggle="tooltip" data-placement="top" title="Business Category"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./region-index.php"><i class="fa-solid fa-map-location-dot" data-toggle="tooltip" data-placement="top" title="Business in each Region"></i></a>
        </li>
    </ul>
  </div>
  <div class="p-4 shadow-sm table-container">
    <table id="datatable-main" class="table table-striped" style="width:100%"></table>
  </div>
</div>
   
  <!-- End of Script for toggle -->
<?php
$log_filter = "";
if ($filter_region && $filter_region != "All Business" ) $log_filter = "WHERE business.business_name LIKE CONCAT('{$filter_region}' )";
$db->query("SELECT 
business_category.id AS business_category_id,
business.id AS business_id,
business.business_name,
category.id AS category_id,
category.category_name
FROM `business_category` 
JOIN `business` ON business_category.business_id = business.id
JOIN `category` ON business_category.category_id = category.id {$log_filter}");
$db->execute();
$table_data = $db->resultSet();
$accounts = array(
  "rows" => json_encode($table_data),
  "columns" => json_encode(array(
    'business_name' => 'Business Name',
    'category_name' => 'Category Name',
    'business_category_id' => '',
    'business_id' => '',
    'category_id' => '',
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
      $("#business_category_id").val(rowObject['business_category_id']);
      $("#business_id").val(rowObject['business_id']);
      $("#business_name").val(rowObject['business_name']);
      $("#category_id").val(rowObject['category_id']);
      $("#category_name").val(rowObject['category_name']);
    });
    $(".delete-button").click(function(){
      var id = $(this).closest("tr").get(0).id;
      $("#delete_business_category_id").val(id);
      
    });
    $("#datatable-main tbody tr td:nth-child(3)").each(function() {
      var business_category_id = $(this).text();
      $(this).html(
        `
          <span class="invisible" style="width:0px; position:absolute;">${business_category_id}<span>
        `
      );
    });
    $("#datatable-main tbody tr td:nth-child(4)").each(function() {
      var business_category_id = $(this).text();
      $(this).html(
        `
          <span class="invisible" style="width:0px; position:absolute;">${business_category_id}<span>
        `
      );
    });
    $("#datatable-main tbody tr td:nth-child(5)").each(function() {
      var business_category_id = $(this).text();
      $(this).html(
        `
          <span class="invisible" style="width:0px; position:absolute;">${business_category_id}<span>
        `
      );
    });
    // var dt = $('#datatable-main').DataTable();
    // //hide the first column
    // dt.column(2).visible(false);


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