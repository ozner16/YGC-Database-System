<?php
require_once "../../Controllers/Database.php";

$db = new Database();


if (isset($_POST["submit"])) {

  if(!empty($_POST['media_partner-name']) && !empty($_POST['media_partner-email']) && 
    !empty($_POST['media_partner-fb_page']) && !empty($_POST['media_partner-website']) && !empty($_POST['media_partner-location'])
    && !empty($_POST['media_partner-point_person']) && !empty($_POST['media_partner-status']))
    {

      $company_name = $_POST["media_partner-name"];
      $email = $_POST["media_partner-email"];
      $fb_page = $_POST["media_partner-fb_page"];
      $website = $_POST["media_partner-website"];
      $location = $_POST["media_partner-location"];
      $point_person = $_POST["media_partner-point_person"];
      $status = $_POST["media_partner-status"];

      $db->query("SELECT * FROM media_partners WHERE company_name='$company_name';");
      $db->execute();
      $db->closeStmt(); 
      if (sizeof($db->resultSet()) === 0){
        $db->query("INSERT INTO media_partners (partnership_status_id, point_person_id, company_name, email, facebook_page, website, refprovince_id)
        VALUES ( '{$status}','{$point_person}','{$company_name}' , '{$email}', '{$fb_page}', '{$website}', '{$location}' );");
        $db->execute();
        $db->closeStmt();
      $_SESSION["success-card"] = "Media partner successfully added.";
      } 
      else {
        $_SESSION["failed-card"] = "Media partner is already in the database!";
      }
      

    }

}

?>
<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Media Partner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./index.php" method="post">
                <div class="modal-body">
                    <div class="modal-container">
                        <div class="row mt-2">
                            <div class="col">
                                <label for="media_partner-name">Company Name</label><br />
                                <div class="input-group">
                                    <input type="text" name="media_partner-name" class="form-control" />
                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                </div>
                            </div>
                        </div>

                        <div clas="row mt-2">
                            <div class="col">
                                <label for="media_partner-email">Email</label><br />
                                <div class="input-group">
                                    <input type="text" name="media_partner-email" class="form-control" />
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="media_partner-fb_page">Facebook Page</label><br />
                                <div class="input-group">
                                    <input type="text" name="media_partner-fb_page" class="form-control" />
                                    <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="media_partner-website">Website</label><br />
                                <div class="input-group">
                                    <input type="text" name="media_partner-website" class="form-control" />
                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="media_partner-location">Location Covered</label><br />
                                <div class="input-group">
                                    <!-- <input type="text" name="media_partner-location" class="form-control" /> -->
                                    <select name="media_partner-location" id="edit-media_partner-location" class="form-select">
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
                                            <span class="input-group-text"><i class="fas fa-solid fa-location-crosshairs"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="media_partner-point_person">Point Person</label><br />
                                <div class="input-group">
                                    <select name="media_partner-point_person" id="media_partner-point_person" class="form-select">
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
                                <label for="media_partner-status">Partnership Status</label><br />
                                <div class="input-group">
                                    <select name="media_partner-status" id="media_partner-status" class="form-select">
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
