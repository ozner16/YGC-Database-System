<?php
   $table_name = "Business Development";
   session_start();
   require_once "../../Templates/header_view.php";
   require_once "../../Controllers/Functions.php";
   setTitle($table_name);
   require_once "../../Controllers/Database.php";
   $db = new Database();
   allow_all_fully_authenticated();
   ?>
<?php require_once "../../Templates/sidebar.php"; ?>
<?php require_once("./business-development-add.php"); ?>
<?php require_once("./business-development-edit.php"); ?>
<?php
   if (isset($_SESSION["success"])) { ?>
<div class="alert alert-success text-success">
   <?php
      echo $_SESSION["success"];
      unset($_SESSION["success"]);
      ?>
</div>
<?php
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
                <a class="nav-link active" href="./business-development-index.php"><i class="fa-solid fa-building-shield" data-toggle="tooltip" data-placement="top" title="Business Development"></i></a>
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
</div>
<?php
   $db->query("SELECT bd.id AS bdid, bd.event_id, bd.pubmats_id, bd.company_update_id,
    bd.status_id, bd.event_category_id, bd.letter_of_intent, bd.pitch_deck, bd.floor_plan, 
    bd.MOA, bd.meeting_sched, bd.start_execution, bd.end_execution,e.id as eid,e.point_person_id,
    e.company_name,e.location,pp.id as person_id ,pp.name as
    pname,pp.email,pp.contact_number,pc.id,pc.pubmats_cat,cu.id,cu.company_update_name,s.id,
    s.color as scolor,s.status_name,ec.event_cat_name as cat_name
    FROM `bd_transaction` AS bd JOIN `event` AS e ON bd.event_id = e.id 
    RIGHT JOIN `point_person` as pp ON e.point_person_id = pp.id 
    JOIN `pubmats_category` AS pc ON bd.pubmats_id = pc.id 
    JOIN `company_update` AS cu ON bd.company_update_id = cu.id
    JOIN `bd_status` AS s ON bd.status_id = s.id 
    JOIN `event_category` as ec ON ec.id = bd.event_category_id
    WHERE NOT bd.id = 'NULL';");
   $db->execute();
   $table_data = $db->resultSet();
   $table_structure = array(
    "rows" => json_encode($table_data),
    "columns" => json_encode(array(
    'scolor' => 'Flag',
    'status_name' => 'Status',
    'cat_name' => 'Title',
    'pname' => 'Name',
    'email' => 'Email',
    'contact_number' => 'Contact Number',
    'company_name' => 'Company Name',
    'location' => 'Location',
    'letter_of_intent' => 'Letter of Intent',
    'pubmats_cat' => 'Pubmats',
    'pitch_deck' => 'Pitch Deck',
    'company_update_name' => 'Company Update',
    'meeting_sched' => 'Meeting Schedule',
    'MOA' => 'MOA',
    'floor_plan' => 'Floor Plan',
    'start_execution' => 'Start Execution',
    'end_execution' => 'End Execution',
    'eid' => '',
    'bdid' => '',
    'person_id' => '',
    ))
   );
   ?>
<script src="../../Assets/js/datatables_functions.js"></script>
<script>
   $(document).ready(function() {
     var tableName = "<?= $table_name ?>";
     var editor;
     var columns = JSON.parse('<?php print_r($table_structure["columns"]); ?>');
     var rows = ObjectsToDataTableArray(JSON.parse('<?php print_r($table_structure["rows"]); ?>'), Object.keys(columns));
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
       var rowObject = JSON. parse($(this).attr("rowdata"));
       $("#edit_id").val(rowObject['bdid']);
       $("#edit_person").val(rowObject['person_id']);
       $('#edit_point_person option[data ="'+rowObject["pname"]+'"]').prop('selected', true);
       $("#edit_company_name").val(rowObject['company_name']);
       $("#edit_contact").val(rowObject['contact_number']);
       $("#edit_email").val(rowObject['email']);
       $("#edit_letter_intent").val(rowObject['letter_of_intent']);
       $("#edit_send_pitch_deck").val(rowObject['pitch_deck']);
       $("#edit_pub_mats option:contains(" + rowObject['pubmats_cat'] + ")").attr('selected', 'selected');
       $("#edit_comp_updates option:contains(" + rowObject['company_update_name'] + ")").attr('selected', 'selected');
       $("#edit_meet_sched").val(rowObject['meeting_sched']);
       $("#edit_floor_plan").val(rowObject['floor_plan']);
       $("#edit_start_exe").val(rowObject['start_execution']);
       $("#edit_MOA").val(rowObject['MOA']);
       $("#edit_end_exe").val(rowObject['end_execution']);
       $("#edit_title_event option:contains("+ rowObject['cat_name'] + ")").attr('selected', 'selected');
       $("#edit_status option:contains(" + rowObject['status_name'] + ")").attr('selected', 'selected');
       $("#edit_location option:contains(" + rowObject['location'] + ")").attr('selected', 'selected');
     });
     
   
     $("#datatable-main tbody tr td:nth-child(1)").each(function() {
       var color = $(this).text();
       $(this).html(
         `
           <div class="color-code-badge shadow-sm" style="background-color:${color}"></div>
           <span class="invisible">${color}</span>
         `
       );
     });
     $("#datatable-main tbody tr td:nth-child(18)").each(function() {
       var data = $(this).text();
       $(this).html(
         `
           <span class="invisible">${data}</span>
         `
       );
     });
     $("#datatable-main tbody tr td:nth-child(19)").each(function() {
       var data = $(this).text();
       $(this).html(
         `
           <span class="invisible">${data}</span>
         `
       );
     });
     $("#datatable-main tbody tr td:nth-child(20)").each(function() {
       var data = $(this).text();
       $(this).html(
         `
           <span class="invisible">${data}</span>
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
         if(i == 20){
           $(this).attr("rowdata",JSON.stringify(rowObject));
         }
         i++;
       });
     });
   });
</script>
</body>