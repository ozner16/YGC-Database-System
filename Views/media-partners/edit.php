<?php
require_once "../../Controllers/Database.php";

$db = new Database();

if (isset($_POST['editmedia'])) {

  $idedit = $_POST['edit-id'];
  $name = $_POST["media_partner_name"];
  $email = $_POST["media_partner_email"];
  $page = $_POST["media_partner_fb_page"];
  $website = $_POST["media_partner_website"];
  $location = $_POST['edit_media_partner_location'];
  $status = $_POST['edit_media_partner_status'];
  $partner = $_POST['edit_media_partner_point_person'];

  $db->query("SELECT * FROM media_partners WHERE company_name='$name';");
      $db->execute();
      $db->closeStmt(); 
      if (sizeof($db->resultSet()) === 0){
        $db->query("UPDATE media_partners SET `company_name` ='$name', `email` ='$email',
        `facebook_page` ='$page' ,`website` ='$website',
        `refprovince_id` ='$location', `point_person_id` = '$partner',`partnership_status_id` = '$status' WHERE `id` = '$idedit';");
        $db->execute();
        $db->closeStmt();
        $_SESSION["success-card"] = "Media Partner successfully updated.";
      } 
      else {
        $_SESSION["failed-card"] = "Media partner is already exists!";
      }
}

?>
<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    Edit Media Partner
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./index.php" method="POST">
                <div class="modal-body">
                    <div class="container">
                        <div class="row mt-2">
                            <div class="col">
                                <label for="media_partner-name">Company Name</label>
                                <br />
                                <input type="hidden" id="edit-id" name="edit-id" class="form-control" />
                                <div class="input-group">
                                    <input type="text" name="media_partner_name" id="edit-media_partner-name" class="form-control" />
                                    <span class="input-group-text">
                                        <i class="fas fa-building"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="media_partner-email">Email</label>
                                <br />
                                <div class="input-group">
                                    <input type="text" name="media_partner_email" id="edit-media_partner-email" class="form-control" />
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="media_partner-fb_page">Facebook Page</label>
                                <br />
                                <div class="input-group">
                                    <input type="text" name="media_partner_fb_page" id="edit-media_partner-fb_page" class="form-control" />
                                    <span class="input-group-text">
                                        <i class="fab fa-facebook"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="media_partner-website">Website</label>
                                <br />
                                <div class="input-group">
                                    <input type="text" name="media_partner_website" id="edit-media_partner-website" class="form-control" />
                                    <span class="input-group-text">
                                        <i class="fas fa-globe"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="media_partner-location">Location Covered</label>
                                <br />
                                <div class="input-group">
                                    <!-- <input type="text" name="edit_media_partner_location" id="edit_media_partner_location" class="form-control" /> -->
                                    <select name="edit_media_partner_location" id="edit_media_partner_location" class="form-select">
                                            <?php
                                            
                                                $db->query("SELECT * FROM refprovince;");
                                                $db->execute();
                                                $position_query = $db->resultSet();
                                                $db->closeStmt();
                                                ?>
                                                <option value="" selected disabled></option>
                                                <?php
                                                foreach ($position_query as $row) {
                                            ?>
                                            
                                                <option value="<?= $row->id?>"><?= $row->provDesc?></option>

                                                <?php
                                                };
                                                    ?>

                                            </select>
                                    <span class="input-group-text">
                                        <i class="fas fa-solid fa-location-crosshairs"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form mt-2">
                            <div class="col">
                                <label for="media_partner-point_person">Point Person</label>
                                <br />
                                <div class="input-group">
                                    <select name="edit_media_partner_point_person" id="edit_media_partner_point_person" class="form-select">
                                    <?php
                                        $db->query("SELECT * FROM point_person WHERE point_person_category_id=2;");
                                        $db->execute();
                                        $position_query = $db->resultSet();
                                        $db->closeStmt();
                                        foreach ($position_query as $row) { ?>
                                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                        <?php 
                                        };
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="media_partner-status">Partnership Status</label>
                                <br />
                                <div class="input-group">
                                    <select name="edit_media_partner_status" id="edit_media_partner_status" class="form-select">
                                    <?php
                                      $db->query("SELECT * FROM media_partnership_status;");
                                      $db->execute();
                                      $position_query = $db->resultSet();
                                      $db->closeStmt();
                                      foreach ($position_query as $row) { ?>
                                      <option value="<?= $row->id ?>"><?= $row->status ?></option>
                                      <?php 
                                      };
                                      ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" name="editmedia">
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

