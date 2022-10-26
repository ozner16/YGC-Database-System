<?php

if (isset($_POST['edit_submit'])) {
  
  $edit_id = $_POST['edit_id'];
  $location = $_POST['edit_location'];
  $pub_mats = $_POST['edit_pub_mats'];
  $send_pitch_deck = $_POST['edit_send_pitch_deck'];
  $comp_updates = $_POST['edit_comp_updates'];
  $time_sched = $_POST['edit_meet_sched'];
  $letter_intent = $_POST['edit_letter_intent'];
  $floor_plan = $_POST['edit_floor_plan'];
  $MOA = $_POST['edit_MOA'];
  $start_exe = $_POST['edit_start_exe'];
  $end_exe = $_POST['edit_end_exe'];
  $title_event = $_POST['title_event'];
  $status = $_POST['status'];
  $db->query("UPDATE `bd_transaction` SET `event_id` = '$location',`pubmats_id` = '$pub_mats',
  company_update_id = '$comp_updates', status_id = '$status',event_category_id = '$title_event',
  letter_of_intent = '$letter_intent',pitch_deck = '$send_pitch_deck', floor_plan = '$floor_plan',
  MOA = '$MOA', meeting_sched = '$time_sched', start_execution = '$start_exe',end_execution = '$end_exe'
   WHERE `id`= '$edit_id'");
 $db->execute();
 $db->closeStmt();
 $_SESSION["success"] = "Data has been updated successfully";
}
?>
<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Business</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./business-development-index.php" method="post">
        <div class="modal-body">
          <div class="container"> 
          <input type="hidden" class="form-control" name="edit_id" id="edit_id">
          <input type="hidden" class="form-control" name="edit_person" id="edit_person">
          <input type="hidden" class="form-control" name="edit_point_location" id="edit_point_location">
        <div class="row mt-2">
            <div class="col">
        
              <label for="point_person">Point Person</label><br>
              <div class="input-group">
              <select name="edit_point_person" id="edit_point_person"  class="form-select" disabled>
            
                      <?php
                      $db->query("SELECT e.id AS eid, e.point_person_id, e.company_name, e.location, pp.name AS pname,
                       pp.email, pp.contact_number FROM `point_person` AS pp 
                       LEFT JOIN `event` AS e ON e.point_person_id = pp.id
                        WHERE point_person_category_id > '2' AND 
                        NOT e.company_name = 'NULL' GROUP BY e.point_person_id;");
                      $db->execute();
                      $status_point = $db->resultSet();
                      $row_point_person = $db->fetch();
                      $db->closeStmt(); 
                      $point_person_id =  $row_point_person["eid"];
                      $db->query("SELECT * FROM `point_person` as p LEFT JOIN `event` AS e ON e.point_person_id = p.id WHERE point_person_category_id > '2' AND not e.company_name = 'NULL'");
                      $db->execute();
                      $status_query_all = $db->resultSet();
                      //Fetch_status($status_query_all);
                      $db->closeStmt(); 
                      foreach ($status_point as $row) {
                        ?>
                        <option value="<?= $row->eid?>" data="<?= $row->pname ?>"><?= $row->pname?></option>
                        <?php
                      };
                      ?>
                    </select>
                <span class="input-group-text"><i class="fas fa-user-tie"></i><span>
              </div>
            </div> <!-- col closing -->
            
            <div class="col">
              <label for="company">Company</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="edit_company_name" id="edit_company_name" disabled>
                <span class="input-group-text"><i class="fas fa-solid fa-location-crosshairs"></i><span>
              </div>
            </div> 
          </div>

            <div class="row mt-2">
            <div class="col">
              <label for="location">Location</label><br>
              <div class="input-group">
                <select class="form-control" name="edit_location" id="edit_location">
                </select>
                <span class="input-group-text"><i class="fas fa-solid fa-location-crosshairs"></i><span>
              </div>
            </div> <!-- col closing -->

            <div class="col">
              <label for="contact">Contact Number</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="edit_contact" id="edit_contact" disabled>
                <span class="input-group-text"><i class="fas far fa-address-book"></i><span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="email">Email</label><br>
              <div class="input-group">
                <input type="text" class="form-control" name="edit_email" id="edit_email" disabled>
                <span class="input-group-text"><i class="fas fa-envelope"></i><span>
              </div>
            </div> <!-- col closing -->

                <div class="col">
                  <label for="letter_intent">Letter Intent</label><br>
                  <div class="input-group">
                                    <select class="form-select" name="edit_letter_intent" id="edit_letter_intent">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                    <span class="input-group-text"><i class="fas fa-envelope-open-text"></i></span>
                  </div>
                </div>
              </div>

              <div class="row mt-2">
                <div class="col">
                  <label for="send_pitch_deck">Send Pitch Deck</label><br>
                  <div class="input-group">
                    <select name="edit_send_pitch_deck" id="edit_send_pitch_deck"  class="form-select" >
               
                      <option value="YES">Yes</option>
                      <option value="NO">No</option>
                    </select>
                    <span class="input-group-text"><i class="fas far fa-object-group"></i></span>
                  </div>
                </div>

                <div class="col">
                  <label for="pod_mats">Pub Mats</label><br>
                  <div class="input-group">
                  <select name="edit_pub_mats" id="edit_pub_mats"  class="form-select" >
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
                  <select name="edit_comp_updates" id="edit_comp_updates"  class="form-select" >
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
                <input type="datetime" class="form-control" name="edit_meet_sched"  id="edit_meet_sched">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i><span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
                <div class="col">
                  <label for="floor_plan">Floor Plan</label><br>
                  <div class="input-group">
                  <select name="edit_floor_plan" id="edit_floor_plan"  class="form-select" >
                  
                      <option value="YES">Yes</option>
                      <option value="NO">No</option>
                    </select>
                    <span class="input-group-text"><i class="fas fa-expand-arrows-alt"></i></span>
                  </div>
                </div>

                <div class="col">
                  <label for="MOA">MOA</label><br>
                  <div class="input-group">
                  <select name="edit_MOA" id="edit_MOA"  class="form-select" >
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
                <input type="date" class="form-control" name="edit_start_exe" id="edit_start_exe">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i><span>
              </div>
            </div> <!-- col closing -->
            
            <div class="col">
              <label for="execution">End Excecution</label><br>
              <div class="input-group">
                <input type="date" class="form-control" name="edit_end_exe" id="edit_end_exe">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i><span>
              </div>
              </div> 
            </div> <!-- col closing -->
            <div class="row mt-2">  
          <div class="col">
              <label for="contact">Title Event</label><br>
              <div class="input-group">
              <select name="title_event" id="edit_title_event"  class="form-select" >
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
              <select name="status" id="edit_status"  class="form-select" >
              <option value="" selected="true" disabled="disabled"></option>
                      <?php
                      $db->query("SELECT * FROM `bd_status`;");
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
          <button type="submit" class="btn btn-primary ms-auto" name="edit_submit">Save Changes</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>


<script>
     (function() {
  $(document).ready(function() {
 
var status_query = JSON.parse('<?php print_r(json_encode($status_query_all)); ?>');
const modal1   =document.getElementById('editModal');
modal1.addEventListener('show.bs.modal', function(event) { 
  console.log(status_query);
  setTimeout(function(){
    var id = $("#edit_person").val();
    console.log(id);
    console.log ($("#edit_person"));
    for (let i = 0; i < status_query.length; i++) {
      const status = status_query[i];
      if (status.point_person_id == id) {
        //alert(status);
        $("#add_company").val(status.company_name);
        $("#email").val(status.email);
        $("#contact").val(status.contact_number);
        $('#edit_location').empty();
        for (let j = 0; j < status_query.length; j++) {
          const status_two = status_query[j];
          if (status_two.company_name == status.company_name) {
            //alert(status_two.id);
            var selected_flag = "";
            if($("#edit_point_location").val() == status_two.location){
              selected_flag  = "selected";
            }
            $('#edit_location').append("<option "+selected_flag+" value='"+status_two.id+"'>"+status_two.location+"</option>")
            
          }
        }
      }
      
    }
   }, 100);
    
  
 });
});
})();
</script>