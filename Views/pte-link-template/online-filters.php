<?php
$region_select = "All Online links";
if (isset($_GET["selected_region"])) $region_select = $_GET["selected_region"];
?>
<section class="d-flex gap-2 py-3">

<form id="advance_filter" action="./online_links_index.php" method="GET" class="d-flex gap-2">
<select class="form-select w-max onchange-form-submit" name="selected_region" id="selected_region" >
<option value="<?php $filter_region ?>">All Online links</option>
            <?php 
             $db->query("SELECT * from expo_details  where `is_online` = 'YES' group by expo_name");
              $db->execute();
              $status_query = $db->resultSet();
              $db->closeStmt();
              foreach ($status_query as $row){ 
              ?>
              <option <?= $row->expo_name == $region_select ? "selected" : ""  ?>  value="<?= $row->expo_name ?>"><?= $row->expo_name ?></option>
             <?php 
             } ;
             ?>
              </select>
</form>
</section>

<script>
  $(document).ready(function() {
    $("#selected_region").change(function() {
      $("#advance_filter").submit();
      console.log($("#advance_filter"));
    });
  });
</script>