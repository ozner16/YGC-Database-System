<?php
$table_name = "PTE Templates";
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle($table_name);
require_once "../../Controllers/Database.php";
$db = new Database();
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
<?php
    if (isset($_SESSION["success-pte"])) { ?>
        <div class="alert alert-success text-success">
            <?php
            echo $_SESSION["success-pte"];
            unset($_SESSION["success-pte"]);
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
              <a class="nav-link active" aria-current="page" href="./index.php"><i class="fas fa-plane" data-toggle="tooltip" data-placement="top" title="PTE Template Link"></i></a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="./on-site_index.php"><i class="fas fa-paperclip" data-toggle="tooltip" data-placement="top" title="Onsite Links"></i></a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="./online_links_index.php"><i class="fas fa-link" data-toggle="tooltip" data-placement="top" title="Online Links"></i></a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="./magazine_index.php"><i class="fas fa-book-open" data-toggle="tooltip" data-placement="top" title="Magazine"></i></a>
          </li>
      </ul>
  </div>
  <div class="p-4 shadow-sm table-container">
      <table id="datatable-main" class="table table-striped" style="width: 100%;"></table>
  </div>
</div>

<!-- End of Script for toggle -->

<?php require_once("./edit.php"); ?>
<?php require_once("./add.php"); ?>
<?php require_once("./delete.php"); ?>

<div>
</div>

<?php

$db->query("SELECT * FROM pte_templates ;");
$db->execute();
$table_data = $db->resultSet();
$table_structure = array(
  "rows" => json_encode($table_data),
  "columns" => json_encode(array(
    'id' => '',
    'link_name' => 'Link name',
    'link' => 'Link'
  ))
);
$db->closeStmt();

?>
<script src="../../Assets/js/datatables_functions.js"></script>
<script>
  $(document).ready(function() {
    var tableName = "<?= $table_name ?>";
    var editor;
    var columns = JSON.parse('<?php print_r($table_structure["columns"]); ?>');
    var rows = ObjectsToDataTableArray(JSON.parse('<?php print_r($table_structure["rows"]); ?>'), Object.keys(columns));
    var mainDataTableId = "#datatable-main";
    showDataTable(rows,columns, mainDataTableId,tableName, option={
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
      console.log(rowObject['id']);
       //for selecting name
      // $('#expo_name option[data ="'+rowObject["expo_name"]+'"]').prop('selected', true);
       $("#logo_storage").val(rowObject['link_name']);
      $("#package_link").val(rowObject['link']);
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
        if(i == 3){
          $(this).attr("rowdata",JSON.stringify(rowObject));
        }
        i++;
      });
    
  })
    
  });
</script>
</body>