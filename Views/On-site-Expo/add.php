<?php
if ($_SERVER["REQUEST_METHOD"]=="POST") {
  if (isset($_POST["add-on-site"])) {
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $databaseName = "wsap_db";

    $connect = mysqli_connect($hostname, $username, $password, $databaseName);
    $expo_id = $_POST["expo_name"];
    $business_id = $_POST["business_name"];
    $package = $_POST["package"];
    $req_add_in_gc = $_POST["req_add_gc"];
    $req_supp_brief = $_POST["req_supp_brief"];
    $req_floor = $_POST["req_floor"];
    $req_magazine = $_POST["req_magazine"];
    $req_teaser = $_POST["req_Teaser"];
    $req_exhibitor = $_POST["req_exhibitor"];
    $req_moa = $_POST["req_moa"];
    $req_cert = $_POST["req_cert"];
    $req_id = $_POST["req_id"];
    $req_purchase = $_POST["req_purchasing_form"];
    $req_soa = $_POST["req_SOA"];
    $req_receipt = $_POST["req_receipt"];
    $req_exdeal = $_POST["req_exdeal"];
    $req_ingress = $_POST["req_ingress"];
    $req_engress = $_POST["req_engress"];
    $slot_name = $_POST["slot_name"];
    $status = $_POST["slot_status"];

   // $logo_status = $_POST["logo_status"];
    //check if slow count is full
    $ql = mysqli_query($connect, "SELECT MAX(slot_number) FROM expo_slots WHERE expo_id = '$expo_id';");
    $row = mysqli_fetch_array($ql);
    $check_max = $row['MAX(slot_number)'];

    $ql1 = mysqli_query($connect, "SELECT slot_count FROM expo_details WHERE id = '$expo_id';");
    $row1 = mysqli_fetch_array($ql1);
    $check_maxcount = $row1['slot_count'];
   // echo '<script> alert('.$check_maxcount.')</script>';

    if($check_max == $check_maxcount){
      $_SESSION["success-on-site"] = "SLOT IS FULL.";
     // echo '<script> window.location.href="/WSAP_DATABASE/Views/On-site-expo/index.php" </script>';
    }
    elseif($check_max != $check_maxcount){

      //check if slot number starts with 1 or 0
        $q = mysqli_query($connect, "SELECT slot_number FROM expo_slots WHERE slot_number = '1' and expo_id = '$expo_id';");
        $row3 = mysqli_fetch_array($q);
        $check_user = $row3['slot_number'];
        if($check_user == 1)
        {
          //selects largest number then increment
          $q1 = mysqli_query($connect, "SELECT MAX(slot_number) FROM expo_slots JOIN expo_details on expo_details.id = expo_slots.expo_id  WHERE expo_id='$expo_id';");
          $row2 = mysqli_fetch_array($q1);
          $check_count = $row2['MAX(slot_number)'];
          $new_count = $check_count + 1;
          //echo '<script> alert('.$new_count.')</script>';

          $sql = "INSERT INTO requirement_for_expo_slot ( is_MOA, is_certificate, is_id, is_added_in_gc, suppliers_briefing, floor_layout, magazine, teaser_video, exhibitor_poster, purchasing_form, SOA, acknowledgement_receipt, exdeal, ingres, engres )
          VALUES ( '$req_moa', '$req_cert', '$req_id', '$req_add_in_gc','$req_supp_brief', '$req_floor', '$req_magazine', '$req_teaser', '$req_exhibitor', '$req_purchase', '$req_soa', '$req_receipt', '$req_exdeal', '$req_ingress','$req_engress' )";

            if ($connect->query($sql) == TRUE) {
                //echo '<script> alert("Panalo")</script>';
            } else {
              echo "Error: " . $sql . "<br>" . $connect->error;
             // echo '<script> alert("Talo")</script>';
            }

            $sql1 = "INSERT INTO expo_slots (
              expo_id,
              business_id,
              package_id,
              requirement_id,
              slot_status,
              slot_name,
              slot_number

            )  VALUES (
              '$expo_id',
              '$business_id',
              '$package',
              (SELECT MAX(id) FROM requirement_for_expo_slot),
              '$status',
              '$slot_name',
              '$new_count'
              
              )";

          if ($connect->query($sql1) == TRUE) {
            $_SESSION["success-on-site"] = "On-site expo successfully added.";
            echo '<script> window.location.href="/WSAP_DATABASE/Views/On-site-expo/index.php" </script>';
          } else {
            echo "Error: " . $sql1 . "<br>" . $connect->error;
          }
          }elseif($check_user == 0){
          $count = 1;
          $sql = "INSERT INTO requirement_for_expo_slot ( is_MOA, is_certificate, is_id, is_added_in_gc, suppliers_briefing, floor_layout, magazine, teaser_video, exhibitor_poster, purchasing_form, SOA, acknowledgement_receipt, exdeal, ingres, engres )
          VALUES ( '$req_moa', '$req_cert', '$req_id', '$req_add_in_gc','$req_supp_brief', '$req_floor', '$req_magazine', '$req_teaser', '$req_exhibitor', '$req_purchase', '$req_soa', '$req_receipt', '$req_exdeal', '$req_ingress','$req_engress' )";

            if ($connect->query($sql) == TRUE) {
              
            } else {
              echo "Error: " . $sql . "<br>" . $connect->error;
            }

            $sql1 = "INSERT INTO expo_slots (
              expo_id,
              business_id,
              package_id,
              requirement_id,
              slot_status,
              slot_name,
              slot_number
            )  VALUES (
              '$expo_id',
              '$business_id',
              '$package',
              (SELECT MAX(id) FROM requirement_for_expo_slot),
              '$status',
              '$slot_name',
              '$count'
              
              )";

          if ($connect->query($sql1) == TRUE) {
            $_SESSION["success-on-site"] = "On-site expo successfully added.";
            echo '<script> window.location.href="/WSAP_DATABASE/Views/On-site-expo/index.php" </script>';
          } else {
            echo "Error: " . $sql1 . "<br>" . $connect->error;
          }
        }
        mysqli_close($connect);
    }

  /**$db->query("INSERT INTO requirement_for_expo_slot (is_logo_posted, is_MOA, is_certificate, is_id, logo_storage, MOA_storage, certificate_storage, ID_storage)
    VALUES ( '{$req_logo}' , '{$req_moa}', '{$req_cert}', '{$req_id}', '{$logo_link}', '{$moa_link}', '{$cert_link}', '{$id_link}');");
  $db->execute();
  $db->closeStmt();*/
  //$_SESSION["success-card"] = "requirements successfully added.";
  
}
}




?>
<div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Onsite Expo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="./index.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="container">
                        <div class="row mt-2">
                            <div class="col">
                                <label for="expo-name">Expo Name</label><br />
                                <div class="input-group">
                                    <select class="form-select" name="expo_name">
                                        <?php
                                           $db->query("SELECT * FROM expo_details WHERE is_online = 'NO';"); $db->execute(); $position_query = $db->resultSet(); $db->closeStmt(); foreach ($position_query as $row) { ?>
                                        <option value="<?= $row->id?>"><?= $row->expo_name?></option>
                                        <?php
                                          };
                                          ?>
                                    </select>
                                </div>
                            </div><!-- col closing -->
                        </div><!-- row closing -->

                        <div class="row mt-2">
                            <div class="col">
                                <label for="business-name">Business Name</label><br />
                                <div class="input-group">
                                    <select class="form-select" name="business_name">
                                        <?php
                                          $db->query("SELECT * FROM business;"); $db->execute(); $position_query = $db->resultSet(); $db->closeStmt(); foreach ($position_query as $row) { ?>
                                        <option value="<?= $row->id?>"><?= $row->business_name?></option>
                                        <?php
                                              };
                                            ?>
                                    </select>
                                </div>
                            </div>

                        <div class="col">
                            <label for="package">Package</label><br />
                            <div class="input-group">
                                <select class="form-select" name="package">
                                    <?php
                                          $db->query("SELECT * FROM package;"); $db->execute(); $position_query = $db->resultSet(); $db->closeStmt(); foreach ($position_query as $row) { ?>
                                    <option value="<?= $row->id?>"><?= $row->package_name?></option>
                                    <?php
                                            };
                                          ?>
                                </select>
                            </div>
                        </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="require">Already Added in GC</label><br />
                                <div class="input group">
                                    <select class="form-select" name="req_add_gc">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>

                        <div class="col">
                            <label for="logo_posted_link">Invited to Suppliers briefing</label><br />
                            <div class="input-group">
                            <select class="form-select" name="req_supp_brief">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                            </div>
                        </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="require">ID Cards</label><br />
                                <div class="input-group">
                                    <select class="form-select" name="req_id">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>

                        <div class="col">
                            <label for="MOA_link">Flooy Layout</label><br />
                            <div class="input-group">
                                    <select class="form-select" name="req_floor">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                            </div>
                        </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="require">Magazine Poster</label><br />
                                <div class="input-group">
                                    <select class="form-select" name="req_magazine">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>

                        <div class="col">
                            <label for="cert_link">Teaser Video</label><br />
                            <div class="input-group">
                            <select class="form-select" name="req_Teaser">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                            </div>
                           </div>
                         </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="require">Exhibitor Poster</label><br />
                                <div class="input-group">
                                    <select class="form-select" name="req_exhibitor">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>

                        <div class="col">
                            <label for="id_posted_link">Cerficate</label><br />
                            <div class="input-group">
                            <select class="form-select" name="req_cert">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                            </div>
                          </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="require">MOA</label><br />
                                <div class="input-group">
                                    <select class="form-select" name="req_moa">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>

                        <div class="col">
                            <label for="id_posted_link">Purchasing Form</label><br />
                            <div class="input-group">
                            <select class="form-select" name="req_purchasing_form">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                            </div>
                          </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="require">SOA</label><br />
                                <div class="input-group">
                                    <select class="form-select" name="req_SOA">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>

                        <div class="col">
                            <label for="id_posted_link">Acknowledgement Receipt</label><br />
                            <div class="input-group">
                            <select class="form-select" name="req_receipt">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                            </div>
                          </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="require">Exchange Deal</label><br />
                                <div class="input-group">
                                    <select class="form-select" name="req_exdeal">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>

                        <div class="col">
                            <label for="id_posted_link">Ingress</label><br />
                            <div class="input-group">
                            <select class="form-select" name="req_ingress">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                            </div>
                          </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="require">Engress</label><br />
                                <div class="input-group">
                                    <select class="form-select" name="req_engress">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>

                      

                        <div class="row mt-2">
                            <div class="col">
                                <label for="slot_name">Slot Name:</label><br />
                                <div class="input-group">
                                    <input type="text" class="form-control" name="slot_name" />
                                    <span class="input-group-text"><i class="fas fa-address-card pt-0 mr-3"></i></span>
                                </div>
                            </div>

                            <div class="col">
                                <label for="slot">Status:</label><br />
                                <div class="input-group">
                                    <select class="form-select" name="slot_status">
                                        <?php
                                                $db->query("SELECT * FROM slot_status;"); $db->execute(); $position_query = $db->resultSet(); $db->closeStmt(); foreach ($position_query as $row) { ?>
                                        <option value="<?= $row->id?>"><?= $row->status?></option>
                                        <?php
                                                };
                                              ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                            <!-- col closing -->
                        </div>
                    </div>
                    <!-- modal-body -->
                    <div class="modal-footer w-100">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add-on-site" class="btn btn-primary ms-auto">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

