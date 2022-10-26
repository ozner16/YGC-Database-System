<div class="modal fade modal-lg" id="editModal" tabindex="3" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">


        <h5 class="modal-title" id="editModalLabel">Edit User</h5>
        <div class="form-check form-switch mt-2">
          <label class="form-check-label" for="flexSwitchCheckDefault">Active Status</label>
          <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      
      <form action="add.php">
        <div class="modal-body"> 
          <div class="row mt-2">
            <div class="col">
              <label for="fname">First Name</label><br>
              <div class="input-group">
                <input type="text" class="form-control">
                <span class="input-group-text border"><i class="fas fa-solid fa-address-card"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="mname">Middle Name</label><br>
              <div class="input-group">
                <input type="text" class="form-control">
                <span class="input-group-text border"><i class="fas fa-solid fa-address-card"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="lname">Last Name</label><br>
              <div class="input-group">
                <input type="text" class="form-control">
                <span class="input-group-text border"><i class="fas fa-solid fa-address-card"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="gender">Gender</label><br>
              <div class="input-group"> 
              <select class="form-control">
                <option value="GENDER" disabled selected hidden></option>
                <option>Male</option>
                <option>Female</option>
                </select>
                <span class="input-group-text border"><i class="fas fa-solid fa-mars-and-venus"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->

          <div class="row mt-2">
            <div class="col">
              <label for="bday">birthdate</label><br>
              <div class="input-group">
                <input type="date" class="form-control">
                <span class="input-group-text border"><i class="fas fa-solid fa-calendar-days"></i></span>
              </div>
            </div> <!-- col closing -->
          </div> <!-- row closing -->



      </div><!-- modal-body closing -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>