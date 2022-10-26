<?php

if (isset($_POST["submit"])) {
 $location = $_POST['location'];
 $pub_mats = $_POST['pub_mats'];
 $send_pitch_deck = $_POST['send_pitch_deck'];
 $comp_updates = $_POST['comp_updates'];
 $time_sched = $_POST['time_sched'];
 $letter_intent = $_POST['letter_intent'];
 $floor_plan = $_POST['floor_plan'];
 $MOA = $_POST['MOA'];
 $start_exe = $_POST['start_exe'];
 $end_exe = $_POST['end_exe'];
 $title_event = $_POST['title_event'];
 $status = $_POST['status'];
 $db->query("INSERT INTO bd_transaction (`event_id`,`pubmats_id`,`company_update_id`,`status_id`,`event_category_id`,`letter_of_intent`,`pitch_deck`,`floor_plan`,`MOA`,`meeting_sched`,`start_execution`,`end_execution`)
 VALUES  ( '{$location}','{$pub_mats}', '{$comp_updates}','{$status}','{$title_event}','{$letter_intent}','{$send_pitch_deck}','{$floor_plan}','{$MOA}','{$time_sched}','{$start_exe}','{$end_exe}' );");
$db->execute();
$db->closeStmt();
$_SESSION["success"] = "Data has been added successfully.";
}


?>
<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add Business</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./business-development-index.php" method="post">
        <div class="modal-body">
          <div class="container"> 
        <div class="row mt-2">
            <div class="col">
              <label for="point_person">Point Person</label><br>
              <div class="input-group">
                 <select name="add_point_person" id="add_point_person"  class="form-select" >
              <option value="" selected="true" disabled="disabled"></option>
                      <?php
                      $db->query("SELECT e.id AS eid, e.point_person_id, e.company_name, e.location, pp.name AS pname,
                       pp.email, pp.contact_number FROM `point_person` AS pp 
                       LEFT JOIN `event` AS e ON e.point_person_id = pp.id
                        WHERE point_person_category_id > '2' AND 
                        NOT e.company_name = 'NULL' GROUP BY e.point_person_id;");
                      $db->execute();
                      $status_query = $db->resultSet();
                      $db->closeStmt(); 
                      $db->query("SELECT * FROM `point_person` as p LEFT JOIN `event` AS e ON e.point_person_id = p.id WHERE point_person_category_id > '2' AND not e.company_name = 'NULL'");
                      $db->execute();
                      $status_query_all = $db->resultSet();
                      $db->closeStmt(); 
                      foreach ($status_query as $row) {
                        ?>
                        <option value="<?= $row->eid?>"><?= $row->pname?></option>
                        <?php
                      };
                      ?>
                    </select>
              </div>
            </div> <!-- col closing -->
            
            <div class="col">
              <label for="company">Company</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="add_company" id = "add_company" disabled>
                <span class="input-group-text"><i class="fas fa-solid fa-location-crosshairs"></i><span>
              </div>
            </div> 
          </div>

            <div class="row mt-2">
            <div class="col">
              <label for="location">Location</label><br>
              <div class="input-group">
              <select name="location" id="location"  class="form-select" required>
              </select>
                <span class="input-group-text"><i class="fas fa-solid fa-location-crosshairs"></i><span>
              </div>
            </div> <!-- col closing -->

            <div class="col">
              <label for="contact">Contact Number</label><br>
              <div class="input-group">
                
                <input type="text" class="form-control" name="contact" id="contact" disabled>
                <span class="input-group-text"><i class="fas far fa-address-book"></i><span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="email">Email</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="email" id="email" disabled>
                <span class="input-group-text"><i class="fas fa-envelope"></i><span>
              </div>
            </div> <!-- col closing -->

                <div class="col">
                  <label for="letter_intent">Letter Intent</label><br>
                  <div class="input-group">
                    <select name="letter_intent" id="letter_intent"  class="form-select" required>
                      <option value="" selected="true" disabled="disabled"></option>
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
                    <span class="input-group-text"><i class="fas fa-envelope-open-text"></i></span>
                  </div>
                </div>
              </div>

              <div class="row mt-2">
                <div class="col">
                  <label for="send_pitch_deck">Send Pitch Deck</label><br>
                  <div class="input-group">
                    <select name="send_pitch_deck" id="send_pitch_deck"  class="form-select" required>
                      <option value="" selected="true" disabled="disabled"></option>
                      <option value="YES">Yes</option>
                      <option value="NO">No</option>
                    </select>
                    <span class="input-group-text"><i class="fas far fa-object-group"></i></span>
                  </div>
                </div>

                <div class="col">
                  <label for="pod_mats">Pub Mats</label><br>
                  <div class="input-group">
                    <select name="pub_mats" id="pub_mats"  class="form-select" required>
                   
                     <option value="" selected="true" disabled="disabled"></option>
                      <?php
                      $db->query("SELECT * FROM `pubmats_category`;");
                      $db->execute();
                      $status_query = $db->resultSet();
                      $db->closeStmt(); 
                      foreach ($status_query as $row) {
                        ?>
                        <option value="<?= $row->id?>"><?= $row->pubmats_cat ?></option>
                        <?php
                      };
                      ?>
                   
                    </select>
                    <span class="input-group-text"><i class="fas fa-scroll"></i></span>
                  </div>
                </div>
              </div>

              <div class="row mt-2">
                <div class="col">
                  <label for="comp_updates">Company Updates</label><br>
                  <div class="input-group">
                  <select name="comp_updates" id="comp_updates"  class="form-select" required>
                  <option value="" selected="true" disabled="disabled"></option>
                      <?php
                      $db->query("SELECT * FROM `company_update`;");
                      $db->execute();
                      $status_query = $db->resultSet();
                      $db->closeStmt(); 
                      foreach ($status_query as $row) {
                        ?>
                        <option value="<?= $row->id?>"><?= $row->company_update_name ?></option>
                        <?php
                      };
                      ?>
                    </select>
                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                  </div>
                </div>

            <div class="col">
              <label for="schedule">Meeting Schedule</label><br>
              <div class="input-group">
                <input type="datetime-local" class="form-control" name="time_sched">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i><span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
                <div class="col">
                  <label for="floor_plan">Floor Plan</label><br>
                  <div class="input-group">
                  <select name="floor_plan" id="floor_plan"  class="form-select" required>
                      <option value="" selected="true" disabled="disabled"></option>
                      <option value="YES">Yes</option>
                      <option value="NO">No</option>
                    </select>
                    <span class="input-group-text"><i class="fas fa-expand-arrows-alt"></i></span>
                  </div>
                </div>

                <div class="col">
                  <label for="MOA_label">MOA</label><br>
                  <div class="input-group">
                  <select name="MOA" id="MOA"  class="form-select" required>
                      <option value="" selected="true" disabled="disabled"></option>
                      <option value="APPROVED">Approved</option>
                      <option value="REVISION">Revision</option>
                      <option value="ONGOING">Ongoing</option>
                      <option value="PENDING">Pending</option>
                    </select>
                    <span class="input-group-text"><i class="fas fa-file-contract"></i></span>
                  </div>
                </div>
              </div>

            <div class="row mt-2">
            <div class="col">
              <label for="execution">Start Excecution</label><br>
              <div class="input-group">
                <input type="date" class="form-control" name="start_exe">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i><span>
              </div>
            </div> <!-- col closing -->
            
            <div class="col">
              <label for="execution">End Excecution</label><br>
              <div class="input-group">
                <input type="date" class="form-control" name="end_exe">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i><span>
              </div>
              </div> 
            </div> <!-- col closing -->
            <div class="row mt-2">  
          <div class="col">
              <label for="contact">Title Event</label><br>
              <div class="input-group">
              <select name="title_event" id="title_event"  class="form-select" required>
              <option value="" selected="true" disabled="disabled"></option>
                      <?php
                      $db->query("SELECT * FROM `event_category`;");
                      $db->execute();
                      $status_query = $db->resultSet();
                      $db->closeStmt(); 
                      foreach ($status_query as $row) {
                        ?>
                        <option value="<?= $row->id?>"><?= $row->event_cat_name?></option>
                        <?php
                      };
                      ?>
                    </select>

                <span class="input-group-text"><i class="fas far fa-address-book"></i><span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->
            <div class="row mt-2">
            <div class="col">
              <label for="promotion-status">Status</label><br>
              <div class="input-group">
              <select name="status" id="status"  class="form-select" required>
              <option value="" selected="true" disabled="disabled"></option>
                      <?php
                      $db->query("SELECT * FROM `bd_status` WHERE NOT status_name = 'DONE';");
                      $db->execute();
                      $status_query = $db->resultSet();
                      $db->closeStmt(); 
                      foreach ($status_query as $row) {
                        ?>
                        <option value="<?= $row->id?>"><?= $row->status_name?></option>
                        <?php
                      };
                      ?>
                    </select>
                <span class="input-group-text"><i class="fas fa-info"></i><span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->


        </div>
        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ms-auto" name="submit">Submit</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>
<script>
    (function() {
  $(document).ready(function() {
 
    var status_query = JSON.parse('<?php print_r(json_encode($status_query_all)); ?>');
    $('#add_point_person').on('change', function() {
    console.log(status_query);
    var id = this.value;
    for (let i = 0; i < status_query.length; i++) {
      const status = status_query[i];
      if (status.id == id) {
        //alert(status);
        $("#add_company").val(status.company_name);
        $("#email").val(status.email);
        $("#contact").val(status.contact_number);
        $('#location').empty();
        for (let j = 0; j < status_query.length; j++) {
          const status_two = status_query[j];
          if (status_two.company_name == status.company_name) {
            //alert(status_two.id);
            $('#location').append("<option value='"+status_two.id+"'>"+status_two.location+"</option>")
          }
        }
      }
      
    }
    if ($("#location option:selected").text() == "ONLINE") {
    $("#title_event option:contains(WEBINAR)").attr('selected', 'selected');
    $("#title_event").attr("disabled",true);
  }else{
    $("#title_event").attr("disabled",false);
  }
});

$('#location').on('change', function() {
  console.log($("#location option:selected").text());
  if ($("#location option:selected").text() == "ONLINE") {
    $("#title_event option:contains(WEBINAR)").attr('selected', 'selected');

  }
  
});
  });
})();
</script>