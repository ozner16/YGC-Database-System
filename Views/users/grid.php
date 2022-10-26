<?php
session_start();
require_once "../../Templates/header_view.php";
require_once "../../Controllers/Functions.php";
setTitle("User Accounts");
require_once "../../Controllers/Database.php";
$db = new Database();
require_once("./add.php");

$table_name = "User Accounts";
$filter_department = null;
if (isset($_GET["selected_department"])) {
  $filter_department = $_GET["selected_department"];
}

$active_accounts_query = "SELECT * from users WHERE date_activated IS NOT NULL";
if ($filter_department && $filter_department != "All Department") {
  $active_accounts_query = $active_accounts_query . " AND department='{$filter_department}'";
}
$db->query($active_accounts_query);
$db->execute();
$active_accounts = $db->resultSet();
$db->closeStmt();

$unctivated_accounts_query = "SELECT * from users WHERE date_activated IS NULL";
if ($filter_department && $filter_department != "All Department") {
  $unctivated_accounts_query = $unctivated_accounts_query . " AND department='{$filter_department}'";
}
$db->query($unctivated_accounts_query);
$db->execute();
$unactivated_accounts = $db->resultSet();
$db->closeStmt();
$unactivated_accounts_copy_text = "";
?>
<?php require_once("./add.php"); ?>

<?php require_once "../../Templates/sidebar.php"; ?>
<div class="main-content w-100">
  <h4 class="py-2"><?= $table_name ?></h4>
  <?php
  if (isset($_SESSION["success-card"])) { ?>
    <div class="alert alert-success text-success">
      <?php
      echo $_SESSION["success-card"];
      unset($_SESSION["success-card"]);
      ?>
    </div> <?php
          }
            ?>

  <div>
    <?php require_once "./filters.php"; ?>
  </div>
  <div>
    <ul class="nav nav-tabs flex-row justify-content-start">
      <li class="nav-item">
        <a class="nav-link " href="./index.php">Table View</a>
      </li>
      <li class="nav-item ">
        <a class="nav-link active" aria-current="page" href="./grid.php">Grid View</a>
      </li>
    </ul>
  </div>
  <div class="p-4 shadow-sm table-container container ">
    <section class="row equal mb-4">
      <div class="py-1 col-12 mb-3 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
          Add User Accounts
        </button>
      </div>
      <div class="bg-secondary text-white py-1 col-12 mb-3 rounded shadow-sm">
        <span>Unactivated Accounts</span>
      </div>
      
      <?php if ($unactivated_accounts) : ?>
        <?php if (sizeof($unactivated_accounts) > 0) : ?>
          <div class="col-12 d-flex justify-content-end mb-3">
            <button id="unactivated-copy-text" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#unactivated-copy-text-modal">
              <i class="fa-solid fa-clipboard mx-2"></i>
              <span>Copy List as Text</span>
            </button>
          </div>
        <?php endif ?>
        <?php foreach ($unactivated_accounts as $account) :
          $acc_full_name = "{$account->last_name}, {$account->first_name}";
          $unactivated_accounts_copy_text = "{$unactivated_accounts_copy_text} {$account->id} - {$acc_full_name} | {$account->user_type} | {$account->department} \n";
        ?>
          <div class="p-2 col-12 col-md-4 col-lg-3 col-xl-2 ">
            <div class="shadow-sm p-3 col-12 h-100">
              <img src="../../Assets/img/profiles/<?= $account->profile_file_name ?>" height="90" width="90" class="mb-2 d-block mx-auto" alt="...">
              <div class="card-body d-flex flex-column gap-1">
                <h6 class="card-title text-center"><?= $acc_full_name ?></h6>
                <h6 class="card-title text-center"><?= "{$account->id}" ?></h6>
                <h6 class="card-title text-center text-secondary text-capitalize fs-d"><?= "{$account->department}" ?></h6>
                <h6 class="card-title text-center text-secondary text-capitalize"><?= "{$account->user_type}" ?></h6>
                <span class="badge bg-warning mx-auto d-block w-max fs-c">Unactived</span>
              </div>
            </div>
          </div>
        <?php endforeach ?>
      <?php else : ?>
        <h3 class="text-center text-secondary my-3">No Record</h3>
      <?php endif ?>
    </section>

    <section class="row equal mb-4">
      <div class="bg-success text-white py-1 col-12 mb-3 rounded shadow-sm">
        <span>Activated Accounts</span>
      </div>
      
      <?php if ($active_accounts) : ?>
        <?php foreach ($active_accounts as $account) :
          $acc_full_name = "{$account->last_name}, {$account->first_name}";
        ?>
          <div class="p-2 col-12 col-md-4 col-lg-3 col-xl-2 ">
            <div class="shadow-sm p-3 col-12 h-100">
              <img src="../../Assets/img/profiles/<?= $account->profile_file_name ?>" height="90" width="90" class="mb-2 d-block mx-auto" alt="...">
              <div class="card-body d-flex flex-column gap-1">
                <h6 class="card-title text-center"><?= $acc_full_name ?></h6>
                <h6 class="card-title text-center"><?= "{$account->id}" ?></h6>
                <h6 class="card-title text-center text-secondary text-capitalize fs-d"><?= "{$account->department}" ?></h6>
                <h6 class="card-title text-center text-secondary text-capitalize"><?= "{$account->user_type}" ?></h6>
                <span class="badge bg-warning mx-auto d-block w-max fs-c">Unactived</span>
              </div>
            </div>
          </div>
        <?php endforeach ?>
      <?php else : ?>
        <h3 class="text-center text-secondary my-3">No Record</h3>
      <?php endif ?>
    </section>


  </div>
</div>

<!-- Copied Modal -->
<div class="modal fade modal-auto-clear" id="unactivated-copy-text-modal" tabindex="-1" aria-labelledby="unactivated-copy-text-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Copied</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        List of Activated Account Copied to Clipboard
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<script src="../../Assets/js/datatables_functions.js"></script>
<script>
  $(document).ready(function() {
    var tableName = "<?= $table_name ?>";
    var unactivated_accounts_copy_text = `<?= $unactivated_accounts_copy_text ?>`;
    $("#unactivated-copy-text").click(function() {
      navigator.clipboard.writeText(unactivated_accounts_copy_text);
    });
    $('.modal-auto-clear').on('shown.bs.modal', function() {
      $(this).delay(1000).fadeOut(200, function() {
        $(this).modal('hide');
      });
    })
  });
</script>
</body>