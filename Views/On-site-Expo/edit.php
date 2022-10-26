<?php
error_reporting(0);
ini_set('display_errors', 0);
if ($_SERVER["REQUEST_METHOD"]=="POST") {
  if (isset($_POST["edit-on-site"])) {
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $databaseName = "wsap_db";

    $connect = mysqli_connect($hostname, $username, $password, $databaseName);
    $expo_s_id = $_POST["id"];
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


    $ql1 = mysqli_query($connect, "SELECT requirement_id FROM expo_slots WHERE id = '$expo_s_id'");
    $row1 = mysqli_fetch_array($ql1);
    $requirement_id = $row1['requirement_id'];

    $ql2 = mysqli_query($connect, "SELECT package_id FROM expo_slots WHERE id = '$expo_s_id'");
    $row2 = mysqli_fetch_array($ql2);
    $package_id = $row2['package_id'];

    $sql = ("UPDATE requirement_for_expo_slot SET is_MOA = '$req_moa', is_certificate = '$req_cert', is_id = '$req_id', is_added_in_gc = '$req_add_in_gc', suppliers_briefing = '$req_supp_brief', floor_layout = '$req_floor', magazine = '$req_magazine', teaser_video = '$req_teaser', exhibitor_poster = '$req_exhibitor', purchasing_form = '$req_purchase', SOA = '$req_soa', acknowledgement_receipt = '$req_receipt', exdeal = '$req_exdeal', ingres = '$req_ingress', engres = '$req_engress' WHERE id = '$requirement_id'");
    if ($connect->query($sql) == TRUE) { 
      //echo '<script> alert('.$expo_s_id.')</script>';       
    } else {
      echo "Error: " . $sql . "<br>" . $connect->error;
    }
    
    $sql1 = ("UPDATE expo_slots SET package_id ='$package_id', slot_status ='$status', slot_name ='$slot_name'  WHERE id = '$expo_s_id'");
    if ($connect->query($sql1) == TRUE) {  
      $_SESSION["success-on-site"] = "On-site expo successfully updated.";
      echo '<script> window.location.href="/WSAP_DATABASE/Views/On-site-expo/index.php" </script>';
    } else {
      echo "Error: " . $sql1 . "<br>" . $connect->error;
    }
    mysqli_close($connect);

  
  }
}
?>


<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Onsite Expo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./index.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="container">
                        <div class="row mt-2">
                            <div class="col">
                                <label for="expo-name">Expo Name</label><br />
                                <div class="input-group">
                                    <input type="hidden" class="form-control" name="id" id="edit-id" />
                                    <select class="form-select" name="expo_name" id="expo_name" disabled>
                                        <?php
                                        $db->query("SELECT ed.id,es.expo_id,ed.expo_name FROM expo_slots as es LEFT JOIN expo_details as ed ON ed.id = es.expo_id WHERE ed.is_online = 'NO' GROUP BY es.expo_id; "); $db->execute();
                                        $position_query = $db->resultSet(); $db->closeStmt(); foreach ($position_query as $row) { ?>

                                        <!-- for selecting data -->
                                        <option value="<?= $row->id?>" data="<?= $row->expo_name ?>"><?= $row->expo_name ?></option>

                                        <?php
                                        };
                                       ?>
                                    </select>
                                </div>
                            </div>
                            <!-- col closing -->
                        </div>
                        <!-- row closing -->

                        <div class="row mt-2">
                            <div class="col">
                                <label for="business-name">Business Name</label><br />
                                <div class="input-group">
                                    <select class="form-select" name="business_name" id="business_name" disabled>
                                        <?php
                                        $db->query("SELECT * FROM business;"); $db->execute(); $position_query = $db->resultSet(); $db->closeStmt(); foreach ($position_query as $row) { ?>
                                        <option value="<?= $row->id?>" data="<?= $row->business_name ?>"><?= $row->business_name?></option>
                                        <?php
                                      };
                                     ?>
                                    </select>
                                </div>
                            </div>

                        <div class="col">
                            <label for="package">Package</label><br />
                            <div class="input-group">
                                <select class="form-select" name="package" id="package">
                                    <?php
                    $db->query("SELECT * FROM package;"); $db->execute(); $position_query = $db->resultSet(); $db->closeStmt(); foreach ($position_query as $row) { ?>
                                    <option value="<?= $row->id?>" data="<?= $row->package_name ?>"><?= $row->package_name?></option>
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
                                    <select class="form-select" name="req_add_gc" id="is_added_in_gc">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>

                        <div class="col">
                            <label for="logo_posted_link">Invited to Suppliers briefing</label><br />
                            <div class="input-group">
                            <select class="form-select" name="req_supp_brief" id="suppliers_briefing">
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
                                    <select class="form-select" name="req_id" id="is_ID">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>

                        <div class="col">
                            <label for="MOA_link">Flooy Layout</label><br />
                            <div class="input-group">
                                    <select class="form-select" name="req_floor" id="floor_layout">
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
                                    <select class="form-select" name="req_magazine" id="magazine">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>

                        <div class="col">
                            <label for="cert_link">Teaser Video</label><br />
                            <div class="input-group">
                            <select class="form-select" name="req_Teaser" id="teaser_video">
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
                                    <select class="form-select" name="req_exhibitor" id="exhibitor_poster">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>

                        <div class="col">
                            <label for="id_posted_link">Cerficate</label><br />
                            <div class="input-group">
                            <select class="form-select" name="req_cert" id="is_certificate">
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
                                    <select class="form-select" name="req_moa" id="is_MOA">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>

                        <div class="col">
                            <label for="id_posted_link">Purchasing Form</label><br />
                            <div class="input-group">
                            <select class="form-select" name="req_purchasing_form" id="purchasing_form">
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
                                    <select class="form-select" name="req_SOA" id="SOA">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>

                        <div class="col">
                            <label for="id_posted_link">Acknowledgement Receipt</label><br />
                            <div class="input-group">
                            <select class="form-select" name="req_receipt" id="acknowledgement_receipt">
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
                                    <select class="form-select" name="req_exdeal" id="exdeal">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>

                        <div class="col">
                            <label for="id_posted_link">Ingress</label><br />
                            <div class="input-group">
                            <select class="form-select" name="req_ingress" id="ingres">
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
                                    <select class="form-select" name="req_engress" id="engres">
                                        <option value="YES">Yes</option>
                                        <option value="NO">No</option>
                                    </select>
                                </div>
                            </div>

                    

                        <div class="row mt-2">
                        <div class="col">
                            <label for="slot_name">Slot Name:</label><br />
                            <div class="input-group">
                                <input type="text" class="form-control" name="slot_name" id="slot_name" />
                                <span class="input-group-text"><i class="fas fa-address-card pt-0 mr-3"></i></span>
                            </div>
                        </div>

                    
                        <div class="col">
                            <label for="slot">Status:</label><br />
                            <div class="input-group">
                                <select class="form-select" name="slot_status" id="status">
                                    <?php
                                    $db->query("SELECT * FROM slot_status;"); $db->execute(); $position_query = $db->resultSet(); $db->closeStmt(); foreach ($position_query as $row) { ?>
                                    <option value="<?= $row->id?>" data="<?= $row->status ?>"><?= $row->status?></option>
                                    <?php
                                   };
                                   ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
                    <div class="modal-footer w-100">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="edit-on-site" class="btn btn-primary ms-auto">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

