<?php
$region_select = "All Region";

if (isset($_GET["selected_region"])) $region_select = $_GET["selected_region"];
?>
<section class="d-flex gap-2 py-3">
<form id="region-filter-form" action="./index.php" method="GET" class="d-flex gap-2">
<select class="form-select w-max onchange-form-submit" name="selected_region" id = "selected_region">
<option value="<?php $filter_region ?>">All Regions</option>
            <?php 
             $db->query("SELECT * from business group by region");
              $db->execute();
              $status_query = $db->resultSet();
              $db->closeStmt();
              foreach ($status_query as $row){ 
              ?>
              <option <?= $row->region == $region_select ? "selected" : ""  ?>  value="<?= $row->region ?>" ><?= $row->region ?></option>
             <?php 
             } ;
             ?>
              </select>
</form>
</section>
<script>
  $(document).ready(function() {
    $("#selected_region").change(function() {
      $("#region-filter-form").submit();
      console.log($("#region-filter-form"));
    });
  });
</script>