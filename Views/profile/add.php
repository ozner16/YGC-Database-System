<div class="modal fade" id="addModal" tabindex="3" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Add User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form action="/action_page.php">
          <label for="fname">FIRST NAME</label><br>
          <input type="text" id="fname" name="fname" style="width:460px;"><br><br>
          <label for="mname">MIDDLE NAME</label><br>
          <input type="text" id="mname" name="mname" style="width:460px;"><br><br>
          <label for="lname">LASTNAME</label><br>
          <input type="text" id="lname" name="lname" style="width:460px;"><br><br>
          <label for="GENDER"> GENDER </label><br>
          <select class="" style="width:460px;">
            <option value="GENDER" disabled selected hidden> </option>
            <option>Male</option>
            <option>Female</option>
          </select> <br><br>
          <label for="birthday">BIRTHDAY</label><br>
          <input type="date" id="birthday" name="birthday" style="width:460px;">
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>