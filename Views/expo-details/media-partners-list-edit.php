<?php
require_once "../../Controllers/Database.php";

$db = new Database();
if (isset($_POST['edit-mp_list'])) {

      $id = $_POST["id"];
      $expo_name = $_POST['expo-name'];
      $company_name = $_POST['company-name'];
      $partnership_status = $_POST['partnership_status'];
      $promotion_status = $_POST['promotion_status'];
      $is_moa = $_POST['is-moa'];
      $moa_link = $_POST['moa-link'];
      $fb_post = $_POST['fb-post'];
      $twitter_post = $_POST['twitter-post'];
      $ig_post = $_POST['ig-post'];
      $website_post = $_POST['website-post'];

      $db->query("SELECT * FROM media_partners_list WHERE expo_details_id='$expo_name'
      AND media_partner_id='$company_name';");
      $db->execute();
      $db->closeStmt(); 
      if (sizeof($db->resultSet()) === 0){
        $db->query("UPDATE `media_partners_list` SET `expo_details_id` ='$expo_name', `media_partner_id` ='$company_name', `partnership_status_id` ='$partnership_status', 
        `promotion_status_id` ='$promotion_status', `is_MOA` ='$is_moa', `link_MOA` ='$moa_link', `fb_post` ='$fb_post', `twitter_post` ='$twitter_post', 
        `ig_post` ='$ig_post', `website_post` ='$website_post' WHERE `id`= '$id';");
       $db->execute();
       $db->closeStmt();
       $_SESSION["success-card"] = "Data has been updated successfully.";
      } 
      else {
        $_SESSION["failed-card"] = "Media partner's details is already exists!";
      }
      

   
  

   //echo("<script>console.log('PHP: " . $expo_name . "');</script>");
}
?>

<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Edit Media Partners List</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="./media-partners-list-index.php" method="POST">
        <div class="modal-body">
            <input type="hidden" id="edit-id" name="id" style="width:460px;margin-bottom:12px;">
            <h5 style="margin-bottom: 20px;">Expo and Media Partner details</h5> 
         <div class="container">
          <div class="row mt-2">
            <div class="col">
              <label for="expo-name">Expo Name</label><br>
              <div class="input-group">
              <select name="expo-name" id="edit-expo-name" class="form-select">
              <?php
              
                $db->query("SELECT * FROM expo_details;");
                $db->execute();
                $position_query = $db->resultSet();
                $db->closeStmt();
                          
                foreach ($position_query as $row) {
              ?>
                <option value="<?=$row->id?>"><?=$row->expo_name?></option>

                  <?php
                  };
                    ?>

              </select>
              <span class="input-group-text"><i class="fas fa-address-card"></i></span>
              </div>
            </div>

              <div class="col">
              <label for="company-name">Media Partner Name</label><br>
              <div class="input-group">
              <select name="company-name" id="edit-company-name" class="form-select">
              <?php
              
                $db->query("SELECT * FROM media_partners;");
                $db->execute();
                $position_query = $db->resultSet();
                $db->closeStmt();
                          
                foreach ($position_query as $row) {
              ?>
                <option value="<?= $row->id?>"><?= $row->company_name?></option>

                  <?php
                  };
                    ?>

              </select>
              <span class="input-group-text"><i class="fas fa-address-card"></i></span>
              </div>
            </div>
          </div>

              <div class="row mt-2">
                <div class="col">
              <label for="partnership_status">Partnership Status</label><br>
              <div class="input-group">
              <select name="partnership_status" id="edit-partnership_status" class="form-select">
              <?php
              
                $db->query("SELECT * FROM partnership_processing_status;");
                $db->execute();
                $position_query = $db->resultSet();
                $db->closeStmt();
                          
                foreach ($position_query as $row) {
              ?>
                <option value="<?= $row->id?>"><?= $row->pp_status?></option>

                  <?php
                  };
                    ?>

              </select>
              <span class="input-group-text"><i class="fas fa-info"></i></span>
              </div>
            </div>

              <div class="col">
              <label for="promotion_status">Promotion Status</label><br>
              <div class="input-group">
              <select name="promotion_status" id="edit-promotion_status" class="form-select">
              <?php
              
                $db->query("SELECT * FROM promotion_status;");
                $db->execute();
                $position_query = $db->resultSet();
                $db->closeStmt();
                          
                foreach ($position_query as $row) {
              ?>
                <option value="<?= $row->id?>"><?= $row->prom_status?></option>

                  <?php
                  };
                    ?>

              </select>
              <span class="input-group-text"><i class="fas fa-info"></i></span>
              </div>
            </div>
          </div>

          <br>

            <h5 style="margin-bottom: 20px;">Requirements details</h5>

              <div class="row mt-2">
                <div class="col">
              <label for="is-moa">Is MOA</label><br>
              <div class="input-group">
              <select name="is-moa" id="edit-is-moa" class="form-select">
                  <option value="YES">YES</option>
                  <option value="NO">NO</option>
              </select>
              </div>
            </div>

              <div class="col">
              <label for="moa-link">Link of MOA</label><br>
              <div class="input-group"> 
              <input type="text"  name="moa-link" id="edit-moa-link" class="form-control">
              <span class="input-group-text"><i class="fas fa-link"></i></span>
              </div>
            </div>
          </div>

            <div class="row mt-2">
              <div class="col">
            <label for="fb-post">Facebook Post Link</label><br>
            <div class="input-group">
            <input type="text"  name="fb-post" id="edit-fb-post" class="form-control">
            <span class="input-group-text"><i class="fab fa-facebook"></i></span>
            </div>
          </div>

              <div class="col">
              <label for="twitter-post">Twitter Post Link</label><br>
              <div class="input-group"> 
              <input type="text"  name="twitter-post" id="edit-twitter-post" class="form-control">
              <span class="input-group-text"><i class="fab fa-twitter"></i></span>
              </div>
            </div>
          </div>

            <div class="row mt-2">
              <div class="col">
            <label for="ig-post">Instagram Post Link</label>
            <div class="input-group">
            <input type="text"  name="ig-post" id="edit-ig-post" class="form-control">
            <span class="input-group-text"><i class="fab fa-instagram"></i></span>
            </div>
          </div>

              <div class="col">
              <label for="website-post">Website Post Link</label>
              <div class="input-group"> 
              <input type="text"  name="website-post" id="edit-website-post" class="form-control">
              <span class="input-group-text"><i class="fas fa-globe"></i></span>
            </div>
          </div> 
        </div> 

        </div>
        </div> <!-- modal-body closing -->
        <div class="modal-footer w-100">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ms-auto" name="edit-mp_list">Save changes</button>
        </div> <!-- modal-footer closing -->
      </form>
    </div>
  </div>
</div>