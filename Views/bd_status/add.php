<?php
   require_once "../../Controllers/Database.php";
   $db = new Database();
   if (isset($_POST["submit"])) {
     $status = $_POST["status"];
     $color = $_POST["color"];
   
     $db->query("SELECT * FROM bd_status WHERE `status_name` ='$status' OR color='$color';");
     $db->execute();
     $db->closeStmt(); 
     if (sizeof($db->resultSet()) === 0){
       $db->query("INSERT INTO bd_status (`status_name` , `color`)
       VALUES ( '{$status}' , '{$color}');");
       $_SESSION["success"] = "Data has been added successfully.";
       $db->execute();
       $db->closeStmt();
     }
     else{
       $_SESSION["failed-card"] = "Data has been updated successfully.";
     }
   }
   
   ?>
<section>
   <div class="modal fade modal-lg" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="addModalLabel">Add Status</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./index.php" method="POST">
               <div class="modal-body">
                  <div class="container">
                     <div class="row mt-2">
                        <div class="col">
                           <label for="status" class="form-label">Status</label>
                           <div class="input-group">
                              <input type="text" class="form-control" name="status">
                              <span class="input-group-text border"><i class="fas fa-info pt-0 mr-3"></i></span>
                           </div>
                        </div>
                     </div>
                     <div class="row mt-2">
                        <div class="col">
                           <label for="color" class="form-label">Status color</label>
                           <input type="color" required class="form-control"  name="color" id="color" aria-describedby="color">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer w-100">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" name="submit" class="btn btn-primary ms-auto" >Submit</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>