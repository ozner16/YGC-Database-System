<?php
require_once "../../Controllers/Database.php";
require_once "../../Controllers/Functions.php";

$db = new Database();

if (isset($_POST["addBusiness"])) {
  $business_status = $_POST['business-status']; // faulty 
  $business_name = str_replace("'","`",$_POST['business-name']); 
  $branch = $_POST['branch'];
  $region = $_POST['region']; //faulty
  $business_owner = str_replace("ñ","&ntilde",$_POST['business-owner']);
  $business_fb_page = $_POST['business-fb-page']; 
  $business_email = $_POST['business-email']; 
  $business_website = $_POST['business-website']; 
  $business_address = str_replace("'","`",$_POST['business-address']);
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
  $business_logo = $_FILES['business-logo']; 
  $business_logo_extract_tmp_name = extract_tmp_name($business_logo);
  $business_logo_extract_size = extract_size($business_logo);
  $business_logo_extract_error = extract_error($business_logo);
  $business_logo_extract_name = extract_name($business_logo);
  $business_logo_extract_ext = extract_ext($business_logo_extract_name);
  $allowedExtension = array('jpg', 'jpeg', 'png');
  $is_member = "NO";

  if (!isset($business_logo) || $business_logo_extract_error != 0){
    // cover_image is empty (and not an error)
    $db->query("SELECT * FROM business WHERE `business_name`='$business_name'
    AND `region`='$region' AND `business_owner`='$business_owner';");
    $db->execute();
    $db->closeStmt(); 
    if (sizeof($db->resultSet()) === 0){
      $db->query("INSERT INTO business(status_id, business_name, branch, region, business_owner, business_fbpage, business_email, business_website, business_address, contact_number, missing_info, notes, on_website, certificate_sent, id_card_sent, birthday, sub_business,is_a_member) VALUES ('$business_status','$business_name','$branch','$region','$business_owner',
      '$business_fb_page','$business_email','$business_website','$business_address','$contact_number',
      '$missing_info', '$notes','$on_website','$certificate_sent','$id_card_sent','$founding_date',
      '$sub_business','$is_member');");
      $db->execute();
      $db->closeStmt();

      $_SESSION["success-business"] = "Business information was successfully inserted into the database. However business logo is missing.";
      } else {
        $_SESSION["failed"] = "Business information is already in the database!";
      }
  } else {
    if (check_file_extension($business_logo_extract_ext,$allowedExtension)){
      if (check_upload_error($business_logo_extract_error)){
        if(check_file_size($business_logo_extract_size)){
          $db->query("SELECT * FROM business WHERE business_name='$business_name'
          AND region='$region' AND business_owner='$business_owner';");
          $db->execute();
          $db->closeStmt(); 
          if (sizeof($db->resultSet()) === 0){
            $location = "../../Assets/img/business_logo/";
            $business_logo_renamed = rename_file($business_logo_extract_ext);
            $business_logo_Upload_Destination = file_Destination($location, $business_logo_renamed);
    
            $db->query("INSERT INTO business(status_id, business_name, branch, region, business_owner, business_fbpage, business_email, business_website, business_address, contact_number, missing_info, notes, on_website, certificate_sent, id_card_sent, birthday, sub_business,is_a_member, business_logo) VALUES ('$business_status','$business_name','$branch','$region','$business_owner',
            '$business_fb_page','$business_email','$business_website','$business_address','$contact_number',
            '$missing_info', '$notes','$on_website','$certificate_sent','$id_card_sent','$founding_date',
            '$sub_business','$is_member','$business_logo_Upload_Destination');");
            $db->execute();
            $db->closeStmt();
    
            move_uploaded_file($business_logo_extract_tmp_name, $business_logo_Upload_Destination);
            $_SESSION["success-business"] = "Data has been added successfully.";
            } else {
              $_SESSION["failed"] = "Business information is already in the database!";
            }
        } else{
          $_SESSION["failed"] = "The Business Logo file is too large!";
        }
      } else{
        $_SESSION["failed"] = "An error occurred while uploading the business logo.";
      }
    } else {
      $_SESSION["failed"] = "The update was unsuccessful. The Business Logo file has an invalid extension.";
    }
  }
}
?>


<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add Business</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="./index.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="container">
              <div class="row mt-2">
                <div class="col">
                  <label for="business-name">Business Name</label><br>
                  <div class="input-group">
                    <input type="text" name="business-name" class="form-control" required>
                    <span class="input-group-text border"><i class="fas fa-address-card pt-0 mr-3"></i></span>
                  </div>
                </div>
              </div>

              <div class="row mt-2">
                <div class="col">
                  <label for="branch">Branch</label><br>
                  <div class="input-group">
                    <input type="text" class="form-control" name="branch" required>
                    <span class="input-group-text"><i class="fas fa-solid fa-building"></i></span>
                  </div>
                </div>
              </div>
              
              <div class="row mt-2">
                <div class="col">
                  <label for="region">Region</label><br>
                  <div class="input-group">
                    <select name="region" id="region"  class="form-select" required>
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
                </div>

                <div class="col">
                  <label for="status">Business Status</label><br>
                  <div class="input-group">
                    <select name="business-status" id="status"  class="form-select" required>
                      <option value="" selected="true" disabled="disabled"></option>
                      <?php
                      $db->query("SELECT `id`,`status` FROM business_status;");
                      $db->execute();
                      $status_query = $db->resultSet();
                      $db->closeStmt();
                      foreach ($status_query as $row) {
                        ?>
                        <option value="<?= $row->id?>"><?= $row->status?></option>
                        <?php
                      };
                      ?>
                    </select>
                    <span class="input-group-text"><i class="fas fa-solid fa-user-gear"></i></span>
                  </div>
                </div>
              </div>

              <div class="row mt-2">
                <div class="col">                
                  <div class="text-center">
                    <img id="add_frame" src="" width="120px" height="120px">
                  </div>
                  <label for="business-logo">Business Logo</label><br>
                    <div class="input-group">
                      <input type="file" onchange="previewAdd()" onerror="this.onerror=null; this.src='../../Assets/img/default-picture/logo-Placeholder.png'" class="form-control" name="business-logo">
                      <span class="input-group-text"><i class="fas fa-file-image pt-0 mr-3"></i></span>
                    </div> 
                </div>
              </div>
       
              <div class="row mt-2">
                <div class="col">
                  <label for="business-owner">Business Owner</label><br>
                  <div class="input-group">
                    <input type="text" class="form-control" name="business-owner" required>
                    <span class="input-group-text"><i class="fas fa-user-tie pt-0 mr-3"></i></span>
                  </div>
                </div>

                <div class="col">
                  <label for="business-fb-page">Business FB Page</label><br>
                  <div class="input-group">
                    <input type="text" class="form-control" name="business-fb-page" required>
                    <span class="input-group-text"><i class="fab fa-facebook-square pt-0 mr-3"></i></span>
                  </div>
                </div>
              </div>

              <div class="row mt-2">
                <div class="col">  
                  <label for="business-email">Business Email</label><br>
                  <div class="input-group">
                    <input type="text" class="form-control" name="business-email" required>
                    <span class="input-group-text"><i class="fas fa-envelope pt-0 mr-3"></i></span>
                  </div>
                </div>
                  
                <div class="col">
                  <label for="business-website">Business Website</label><br>
                  <div class="input-group">
                    <input type="text" class="form-control" name="business-website" required>
                    <span class="input-group-text"><i class="fas fa-globe pt-0 mr-3"></i></span>
                  </div>
                </div>
              </div>

              <div class="row mt-2">
                <div class="col">
                  <label for="address">Address</label><br>
                  <div class="input-group">
                    <input type="text" class="form-control" name="business-address" required>
                    <span class="input-group-text"><i class="fas fa-map-marker-alt pt-0 mr-3"></i></span>
                  </div>
                </div>

                <div class="col">
                  <label for="contact-number">Contact Number</label><br>
                  <div class="input-group">
                    <input type="text" class="form-control" name="contact-number" pattern="[0-9]+" required>
                    <span class="input-group-text"><i class="fas fa-phone pt-0 mr-3"></i></span>
                  </div>
                </div>
              </div>

              <div class="row mt-2">
                <div class="col">
                  <label class="ml-2" for="missing-info">Missing Info</label><br>
                  <div class="input-group">
                    <input type="text" class="form-control" name="missing-info">
                    <span class="input-group-text"><i class="fas fa-solid fa-info"></i></span required>
                  </div>
                </div>

                <div class="col">
                  <label for="on-website">On Website</label><br>
                    <div class="input-group">
                      <select name="on-website" class="form-select" required>
                          <option value="" selected disabled></option>
                          <option value="YES">YES</option>
                          <option value="NO">NO</option>
                      </select>
                      <span class="input-group-text"><i class="fas fa-solid fa-file-circle-question"></i></span>
                    </div>
                </div>
              </div>

              <div class="row mt-2">  
                <div class="col">
                  <label for="certificate-sent">Certificate Sent</label><br>
                    <div class="input-group">
                    <select name="certificate-sent" class="form-select" required>
                        <option value="" selected disabled></option>
                        <option value="YES">YES</option>
                        <option value="NO">NO</option>
                    </select>
                  <span class="input-group-text"><i class="fas fa-solid fa-certificate"></i></span>
                  </div>
                </div>

                <div class="col">
                  <label for="id-card-sent">Id Card Sent</label><br> 
                    <div class="input-group">
                      <select name="id-card-sent" class="form-select" required>
                          <option value="" selected disabled></option>
                          <option value="YES">YES</option>
                          <option value="NO">NO</option>
                      </select>
                      <span class="input-group-text"><i class="fas fa-regular fa-id-badge"></i></span>
                    </div>
                </div>
              </div>

              <div class="row mt-4">
                <div class="col">
                  <label for="founding-date">Founding Date</label><br>
                  <div class="input-group">
                    <input type="date" class="form-control" name="founding-date" required>
                    <span class="input-group-text"><i class="fas fa-calendar-alt pt-0 mr-3"></i></span>
                  </div>
                </div>

                <div class="col">
                  <label for="sub-businesses">Sub Businesses</label><br>
                  <div class="input-group">
                    <input type="text" class="form-control" name="sub-businesses" required>
                    <span class="input-group-text"><i class="fas fa-sitemap pt-0 mr-3"></i></span>
                  </div>
                </div>
              </div>

              <div class="row mt-2">
                <div class="col">
                  <label for="notes">Notes</label><br>
                  <textarea type="text" rows="4" class="form-control" name="notes" required></textarea>
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="addBusiness" class="btn btn-primary ms-auto">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function previewAdd() {
    add_frame.src=URL.createObjectURL(event.target.files[0]);
  }
</script>