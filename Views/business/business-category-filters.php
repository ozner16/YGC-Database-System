<?php
$region_select = "All Business";
if (isset($_GET["selected_business"])) $region_select = $_GET["selected_business"];
?>
<section class="d-flex gap-2 py-3">

<form id="advance_filter" action="./business-category-index.php" method="GET" class="d-flex gap-2">
<select class="form-select w-max onchange-form-submit" name="selected_business" id="selected_business">
<option value="<?php $filter_region ?>">All Business</option>
            <?php 
             $db->query("SELECT * from business GROUP BY business_name");
              $db->execute();
              $status_query = $db->resultSet();
              $db->closeStmt();
              foreach ($status_query as $row){ 
              ?>
              <option <?= $row->business_name == $region_select ? "selected" : ""  ?>  value="<?= $row->business_name ?>"><?= $row->business_name ?></option>
             <?php 
             } ;
             ?>
              </select>
</form>
</section>

<script>
  $(document).ready(function() {
    $("#selected_business").change(function() {
      $("#advance_filter").submit();
      console.log($("#advance_filter"));
    });
  });
</script>
