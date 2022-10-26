<?php
session_start();
require_once "./Controllers/Functions.php";
require_once "./Controllers/Database.php";
$db = new Database();
allow_anonymous_only("./Views/dashboard");
if (isset($_POST["sign_in"])) {
    $post_id = trim($_POST["id"]);

    // $db->query("SELECT * FROM users WHERE id = '{$post_id}';");
    $db->query("SELECT
	s.id,
    s.last_name,
    s.first_name,
    s.user_type,
    s.profile_file_name,
    s.password,
    s.date_activated,
    cp.comp_position
FROM
    users s,
    company_positions cp
WHERE
    s.com_position_id = cp.id AND s.id = '{$post_id}';");

    $db->execute();
    $logged_in_user = $db->fetch();
    if (sizeof($db->resultSet()) > 0){
        $_SESSION['logged_in_id'] = trim($_POST["id"]);
        $_SESSION['logged_in_profile_file_name'] = $logged_in_user["profile_file_name"];
        $_SESSION['logged_in_full_name'] = "{$logged_in_user["first_name"]} {$logged_in_user["last_name"]}";
        $_SESSION['logged_in_user_type'] = $logged_in_user["user_type"];
        $_SESSION['logged_in_password'] = $logged_in_user["password"];
        $_SESSION['logged_in_date_activated'] = $logged_in_user["date_activated"];
        $_SESSION['logged_in_user_company_position'] = $logged_in_user["comp_position"];
        if (!empty($_POST["id"]) && empty($_POST["password"]) && empty($logged_in_user["password"])) {
            redirect("./Views/profile/password-reset.php");
            die();
        }

        if ($db->rowCount() == 0 || !password_verify($_POST["password"], $logged_in_user["password"])) {
            unset_logged_in_session();
            $_SESSION["error"] = "Invalid User Id or Password.";
            $_SESSION["state_id"] = $_POST["id"];
        } else {
            if($logged_in_user["date_activated"] == null){
                redirect("./Views/profile/setup.php");
            }else{
                redirect("./Views/dashboard");
            }
        }
    }
    else {
        $_SESSION["error"] = "Invalid user ID or password";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YUSON GOC Database | Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Muli:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style-with-prefix.css">
    <link rel="icon" href="./Assets/img/brand_logo/YUSON GOC Logo.png">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="././Assets/css/style.css">

</head>

<body class="login-form-bg">
    <div class="login-form rounded shadow-lg p-4">
        <div class="text-center">
            <img src="./Assets/img/brand_logo/YUSON GOC Logo.png" alt="" width="220" height="220">
            <div class="p-1 pb-0">
                <!-- <h4 class="title">YUSON GROUP OF COMPANIES</h4> -->
            </div>
            <?php
            if (isset($_SESSION["error"])) { ?>
                <div class="alert alert-danger text-danger">
                    <?php
                    echo $_SESSION["error"];
                    unset($_SESSION["error"]);
                    ?>
                </div> <?php
                    }
                        ?>
        </div>
        <!-- form-login -->
        <form class="d-flex flex-column pt-2 px-1" method="post">
            <div>
                <input name="id" type="text" value="<?= isset($_SESSION["state_id"]) ? $_SESSION["state_id"] : '' ?>" class="form-control" placeholder="User ID">
                <?php unset($_SESSION["state_id"]); ?>
            </div>
            <div class="mt-2">
                <input name="password" type="password" class="form-control" placeholder="Password">
            </div>
            <div class="text-center mt-4">
                <button type="submit" name="sign_in" class="btn btn-warning w-100">Sign in</button>
            </div>
            
        </form>
        <div class="text-center mt-4" style="line-height: 14px;">
            <h6 class="fw-bold fs-f">Developed by: WSAP Interns</h6>
            <p class="m-0 fs-e">IT Department</p>
            <p class="m-0 fs-e">Web Development Team</p>
            <div class="text-center mt-4">
                <button type="button" class="btn btn-warning w-30" onclick="window.location.href = 'index.php';">Home</button>
            </div>
        </div>
    </div>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>