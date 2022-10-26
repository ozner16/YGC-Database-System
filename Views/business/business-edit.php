<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";

$db = new Database();

if (isset($_POST["editBusiness"])) {
  $business_id = $_POST["business-id"];
  $business_status = $_POST['business-status']; // We need to convert the status into id. 
  $business_name = $_POST['business-name'];
  $branch = $_POST['branch'];
  $region = $_POST['region']; //faulty
  $business_owner = $_POST['business-owner']; 
  $business_fb_page = $_POST['business-fb-page']; 
  $business_email = $_POST['business-email']; 
  $business_website = $_POST['business-website']; 
  $business_address = $_POST['business-address']; 
  $contact_number = $_POST['contact-number']; 
  $missing_info = $_POST['missing-info'];  //faulty
  $on_website = $_POST['on-website']; //faulty
  $certificate_sent = $_POST['certificate-sent']; //faulty 
  $id_card_sent = $_POST['id-card-sent']; //faulty
  // Point Person Adding Details
  // $point_person_name = $_POST['point-person-name']; 
  // $point_person_contact = $_POST['point-person-contact']; 
  // $point_person_email = $_POST['point-person-email']; 
  // ----------------------------------------------------------------
  $founding_date = date('Y-m-d',strtotime($_POST['founding-date']));
  $sub_business = $_POST['sub-businesses']; 

  // Upload the business logo
  $notes = $_POST['notes'];
  $business_logo_old = $_POST['business-logo-old'];
  $business_logo = $_FILES['business-logo']; 
  $business_logo_extract_tmp_name = extract_tmp_name($business_logo);
  $business_logo_extract_size = extract_size($business_logo);
  $business_logo_extract_error = extract_error($business_logo);
  $business_logo_extract_name = extract_name($business_logo);
  $business_logo_extract_ext = extract_ext($business_logo_extract_name);
  $allowedExtension = array('jpg', 'jpeg', 'png');
  $is_member = $_POST["is-member"];

  $db->query("SELECT `id` FROM `business_status` WHERE `status` = '$business_status'");
  $db->execute();
  $db->closeStmt();
  $business_status_id = $db->resultSet();
  $business_status_id = $business_status_id[0]->id;
  

  
  if(empty($business_logo_old) && !empty($business_logo_extract_name)){
    // If there is no exisiting logo and they want to add one, they will go here.
    if (check_file_extension($business_logo_extract_ext,$allowedExtension)){
      if (check_upload_error($business_logo_extract_error)){
        if(check_file_size($business_logo_extract_size)){
            $location = "../../Assets/img/business_logo/";
            $business_logo_renamed = rename_file($business_logo_extract_ext);
            $business_logo_Upload_Destination = file_Destination($location, $business_logo_renamed);

            $db->query("UPDATE business SET `status_id`='$business_status_id',`business_name`='$business_name',`branch` ='$branch',
            `region` ='$region',`business_owner`='$business_owner',`business_fbpage`='$business_fb_page',
            `business_email`='$business_email',`business_website`='$business_website',`business_address`='$business_address',`contact_number`='$contact_number',`missing_info`='$missing_info',`notes`='$notes',`on_website`='$on_website',`certificate_sent`='$certificate_sent',`id_card_sent`='$id_card_sent',`birthday`='$founding_date',`sub_business`='$sub_business',`is_a_member`='$is_member',`business_logo`='$business_logo_Upload_Destination'
            WHERE `id` = '$business_id'");
        
            // Unfinished Query
            $db->execute();
            $db->closeStmt();
            move_uploaded_file($business_logo_extract_tmp_name, $business_logo_Upload_Destination);
            $_SESSION["success-business"] = "Successfully updated business information and logo upload";
        } else{
          $_SESSION["success-business"] = "The Business Logo file is too large!";
        }
      } else{
        $_SESSION["success-business"] = "An error occurred while uploading the business logo.";
      }
    } else {
      $_SESSION["success-business"] = "The update was unsuccessful. The Business Logo file has an invalid extension.";
    }
  } else if (!empty($business_logo_old) && empty($business_logo_extract_name)){
     // There is an existing logo and the user don't want to change it but wants to edit other stuff
     // They go here.
    $db->query("UPDATE business SET `status_id`='$business_status_id',`business_name`='$business_name',`branch` ='$branch',
    `region` ='$region',`business_owner`='$business_owner',`business_fbpage`='$business_fb_page',
    `business_email`='$business_email',`business_website`='$business_website',`business_address`='$business_address',`contact_number`='$contact_number',`missing_info`='$missing_info',`notes`='$notes',`on_website`='$on_website',`certificate_sent`='$certificate_sent',`id_card_sent`='$id_card_sent',`birthday`='$founding_date',`sub_business`='$sub_business',`is_a_member`='$is_member'
    WHERE `id` = '$business_id'");

   // Unfinished Query: still can't update the business status which is really important.
    $db->execute();
    $db->closeStmt();
    $_SESSION["success-business"] = "Business information was successfully updated.";
  }else if(empty($business_logo_old) && empty($business_logo_extract_name)){
    // There is no existing logo and the user don't want to upload one. They only want to edit other stuff
     // They go here.
    $db->query("UPDATE business SET `status_id`='$business_status_id',`business_name`='$business_name',`branch` ='$branch',
    `region` ='$region',`business_owner`='$business_owner',`business_fbpage`='$business_fb_page',
    `business_email`='$business_email',`business_website`='$business_website',`business_address`='$business_address',`contact_number`='$contact_number',`missing_info`='$missing_info',`notes`='$notes',`on_website`='$on_website',`certificate_sent`='$certificate_sent',`id_card_sent`='$id_card_sent',`birthday`='$founding_date',`sub_business`='$sub_business',`is_a_member`='$is_member'
    WHERE `id` = '$business_id'");

    // Unfinished Query: still can't update the business status which is really important.
    $db->execute();
    $db->closeStmt();
    $_SESSION["success-business"] = "Business information was successfully updated. The business logo is still missing.";
  }else{
    // There is an exiting logo and they want to change it along with other stuff. They will go here.
      if (check_file_extension($business_logo_extract_ext,$allowedExtension)){
        if (check_upload_error($business_logo_extract_error)){
          if(check_file_size($business_logo_extract_size)){
              $business_logo_old;
              if(!unlink($business_logo_old)){
                echo "Error in deleting old logo";
              } else {
                $location = "../../Assets/img/business_logo/";
                $business_logo_renamed = rename_file($business_logo_extract_ext);
                $business_logo_Upload_Destination = file_Destination($location, $business_logo_renamed);
    
                $db->query("UPDATE business SET `status_id`='$business_status_id',`business_name`='$business_name',`branch` ='$branch',
                `region` ='$region',`business_owner`='$business_owner',`business_fbpage`='$business_fb_page',
                `business_email`='$business_email',`business_website`='$business_website',`business_address`='$business_address',`contact_number`='$contact_number',`missing_info`='$missing_info',`notes`='$notes',`on_website`='$on_website',`certificate_sent`='$certificate_sent',`id_card_sent`='$id_card_sent',`birthday`='$founding_date',`sub_business`='$sub_business',`is_a_member`='$is_member',`business_logo`='$business_logo_Upload_Destination'
                WHERE `id` = '$business_id'");
            
                // Unfinished Query: still can't update the business status which is really important.
                $db->execute();
                $db->closeStmt();
                move_uploaded_file($business_logo_extract_tmp_name, $business_logo_Upload_Destination);
                $_SESSION["success-business"] = "Successfully updated business information and the logo has been successfully replaced.";
              }
          } else{
            $_SESSION["success-business"] = "The Business Logo file is too large!";
          }
        } else{
          $_SESSION["success-business"] = "An error occurred while uploading the business logo.";
        }
    } else {
      $_SESSION["success-business"] = "The update was unsuccessful. The Business Logo file has an invalid extension.";
    }
  }
}
?>

<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mr-2" id="addModalLabel">Edit Business</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="./index.php" class="align-items center" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
      <div class="container">
          <input type="hidden" name="is-member" id="is-a-member">
          <div class="row mt-2">
            <div class="col">
              <label for="business-name">Business Name</label><br>
              <div class="input-group">
                <input type="hidden" class="form-control" id="get-business-id" name="business-id">
                <input type="text" class="form-control" id="edit-business-name" name="business-name">
                <span class="input-group-text"><i class="fas fa-address-card pt-0 mr-3"></i></span>
              </div>
            </div><!-- col closing -->
          </div><!-- row closing -->

          <div class="row mt-2">
                <div class="col">
                  <label for="branch">Branch</label><br>
                  <div class="input-group">
                    <input type="text" class="form-control" id="edit-branch" name="branch" required>
                    <span class="input-group-text"><i class="fas fa-solid fa-building"></i></span>
                  </div>
                </div><!-- col closing -->
              </div><!-- row closing -->
              
          <div class="row mt-2">
            <div class="col">
              <label for="region">Region</label><br>
              <div class="input-group">
                <select name="region" id="edit-region"  class="form-select" required>
                  <option value="" selected="true" disabled="disabled"></option>
                  <option value="Region 1">Region 1</option>
                  <option value="Region 2">Region 2</option>
                  <option value="Region 3">Region 3</option>
                  <option value="Region 4-A">Region 4-A</option>
                  <option value="Region 5">Region 5</option>
                  <option value="Region 6">Region 6</option>
                  <option value="Region 7">Region 7</option>
                  <option value="Region 8">Region 8</option>
                  <option value="Region 9">Region 9</option>
                  <option value="Region 10">Region 10</option>
                  <option value="Region 11">Region 11</option>
                  <option value="Region 12">Region 12</option>
                  <option value="Region 13">Region 13</option>
                  <option value="BARMM">BARMM</option>
                  <option value="NCR">NCR</option> 
                  <option value="CAR">CAR</option> 
                  <option value="MIMAROPA">MIMAROPA</option> 
                </select>
                <span class="input-group-text"><i class="fas fa-solid fa-location-dot"></i></span>
              </div>
            </div><!-- col closing -->

            <div class="col">
              <label for="status">Business Status</label><br>
              <div class="input-group"> 
                <select id="edit-business-status-name" name="business-status" class="form-select" required>
                  <option value="" selected disabled></option>
                  <?php
                  $db->query("SELECT `status` FROM business_status;");
                  $db->execute();
                  $status_query = $db->resultSet();
                  $db->closeStmt();
                  foreach ($status_query as $row) {
                    ?>
                    <option value="<?= $row->status?>"><?= $row->status?></option>
                    <?php
                  };
                  ?>
                </select>
                <span class="input-group-text"><i class="fas fa-solid fa-user-gear"></i></span>
              </div>
            </div><!-- col closing -->
          </div><!-- row closing -->
          
          <div class="row mt-2">
            <div class="col">                
              <div class="text-center">
                <img id="edit_frame" src="" width="120px" height="120px">
              </div>
              <label for="business-logo">Business Logo</label><br>
              <div class="input-group">
                <input type="hidden" class="form-control" id="edit-business-logo" name="business-logo-old">
                <input type="file" onchange="previewEdit()" class="form-control" id="" name="business-logo">
                <span class="input-group-text"><i class="fas fa-file-image pt-0 mr-3"></i></span>
              </div> 
            </div><!-- col closing -->
          </div><!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="business-owner">Business Owner</label><br>
              <div class="input-group">
                <input type="text" class="form-control" id="edit-business-owner" name="business-owner">
                <span class="input-group-text"><i class="fas fa-user-tie pt-0 mr-3"></i></span>
              </div>
            </div><!-- col closing -->

            <div class="col">
              <label for="business-fb-page">Business FB Page</label><br>
              <div class="input-group">
                <input type="text" class="form-control" id="edit-business-fb-page" name="business-fb-page">
                <span class="input-group-text"><i class="fab fa-facebook-square pt-0 mr-3"></i></span>
              </div>
            </div><!-- col closing -->
          </div><!-- row closing -->

          <div class="row mt-2">
            <div class="col">  
              <label for="business-email">Business Email</label><br>
              <div class="input-group">
                <input type="text" class="form-control" id="edit-business-email" name="business-email">
                <span class="input-group-text"><i class="fas fa-envelope pt-0 mr-3"></i></span>
              </div>
            </div><!-- col closing -->
              
            <div class="col">
              <label for="business-website">Business Website</label><br>
              <div class="input-group">
                <input type="text" class="form-control" id="edit-business-website" name="business-website">
                <span class="input-group-text"><i class="fas fa-globe pt-0 mr-3"></i></span>
              </div>
            </div><!-- col closing -->
          </div><!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="address">Address</label><br>
              <div class="input-group">
                <input type="text" class="form-control" id="edit-address" name="business-address">
                <span class="input-group-text"><i class="fas fa-map-marker-alt pt-0 mr-3"></i></span>
              </div>
            </div><!-- col closing -->

            <div class="col">
              <label for="contact-number">Contact Number</label><br>
              <div class="input-group">
                <input type="text" class="form-control" id="edit-contact-number" name="contact-number" pattern="[0-9]+">
                <span class="input-group-text"><i class="fas fa-phone pt-0 mr-3"></i></span>
              </div>
            </div><!-- col closing -->
          </div><!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label class="ml-2" for="missing-info">Missing Info</label><br>
              <div class="input-group">
                <input type="text" class="form-control" id="edit-missing-info" name="missing-info">
                <span class="input-group-text"><i class="fas fa-solid fa-info"></i></span>
              </div>
            </div><!-- col closing -->

            <div class="col">
              <label for="on-website">On Website</label><br>
                <div class="input-group">
                  <select id="edit-on-website" name="on-website" class="form-select" required>
                      <option value="" selected disabled></option>
                      <option value="YES">YES</option>
                      <option value="NO">NO</option>
                  </select>
                  <span class="input-group-text"><i class="fas fa-solid fa-file-circle-question"></i></span>
                </div>
            </div><!-- col closing -->
          </div><!-- row closing -->

          <div class="row mt-2">  
            <div class="col">
              <label for="certificate-sent">Certificate Sent</label><br>
                <div class="input-group">
                <select id="edit-certificate-sent" name="certificate-sent" class="form-select" required>
                    <option value="" selected disabled></option>
                    <option value="YES">YES</option>
                    <option value="NO">NO</option>
                </select>
              <span class="input-group-text"><i class="fas fa-solid fa-certificate"></i></span>
              </div>
            </div><!-- col closing -->

            <div class="col">
              <label for="id-card-sent">Id Card Sent</label><br> 
                <div class="input-group">
                  <select id="edit-id-card-sent" name="id-card-sent" class="form-select" required>
                      <option value="" selected disabled></option>
                      <option value="YES">YES</option>
                      <option value="NO">NO</option>
                  </select>
                  <span class="input-group-text"><i class="fas fa-regular fa-id-badge"></i></span>
                </div>
            </div><!-- col closing -->
          </div><!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="founding-date">Founding Date</label><br>
              <div class="input-group">
                <input type="date" class="form-control" id="edit-founding-date" name="founding-date">
                <span class="input-group-text"><i class="fas fa-calendar-alt pt-0 mr-3"></i></span>
              </div>
            </div><!-- col closing -->

            <div class="col">
              <label for="sub-businesses">Sub Businesses</label><br>
              <div class="input-group">
                <input type="text" class="form-control" id="edit-sub-businesses" name="sub-businesses">
                <span class="input-group-text"><i class="fas fa-sitemap pt-0 mr-3"></i></span>
              </div>
            </div><!-- col closing -->
          </div><!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="notes">Notes</label><br>
              <textarea type="text" rows="4" class="form-control" id="edit-notes" name="notes"></textarea>
            </div><!-- col closing -->
          </div><!-- row closing -->

          </div><!-- modal-body closing -->
          <div class="modal-footer w-100">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary ms-auto" name="editBusiness">Save Changes</button>
          </div>
      </form>
      </div>
    </div>
  </div>
</div>

<script>
  function previewEdit() {
    edit_frame.src=URL.createObjectURL(event.target.files[0]);
  }
</script>