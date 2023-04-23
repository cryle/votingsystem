<?php
    require_once("admin/inc/config.php");

    $fetchingElections = mysqli_query($db, "SELECT * FROM election") or die(mysqli_error($db));
    while($data = mysqli_fetch_assoc($fetchingElections))
    {
        $starting_date = $data['starting_date'];
        $ending_date = $data['ending_date'];
        $curr_date = date("Y-m-d");
        $election_id = $data['id'];
        $status = $data['status'];

        if($status == "Active")
        {
            $date1 = date_create($curr_date);
            $date2 = date_create($ending_date);
            $diff = date_diff($date1, $date2);
            $diff->format("%R%a");


            if((int)$diff->format("%R%a") < 0) {
                
                mysqli_query($db, "UPDATE election SET status = 'Expired' WHERE id = '".$election_id."' ") or die(mysqli_error($db));

            }
        } else if($status = "Inactive") 
        {
            $date1 = date_create($curr_date);
            $date2 = date_create($starting_date);
            $diff = date_diff($date1, $date2);
            $diff->format("%R%a");

            if((int)$diff->format("%R%a") <= 0) {
                mysqli_query($db, "UPDATE election SET status = 'Active' WHERE id = '".$election_id."' ") or die(mysqli_error($db));
            }
        }

    }

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="./assets/css/login.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
</head>

<body>
    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <img src="./assets/images/logo.png" alt="Logo">
                    </div>
                </div>

                <?php
                    if(isset($_GET['sign-up']))
                    {
                    ?>
                    <div class="d-flex justify-content-center form_container">
                    <form action="" method="POST" autocomplete="off">
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="su_id_no" class="form-control input_user" placeholder="School ID No">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="text" name="su_username" class="form-control input_pass" placeholder="Username">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="su_password" class="form-control input_pass" placeholder="Password">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="su_retype_password" class="form-control input_pass" placeholder="Retype Password">
                        </div>
                        <div class="d-flex justify-content-center mt-3 login_container">
                            <button type="submit" name="sign_up_btn" class="btn login_btn">Sign Up</button>
                        </div>
                    </form>
                </div>

                <div class="mt-4">
                    <div class="d-flex justify-content-center links text-white">
                        Already have an account? <a href="index.php" class="ml-2">Sign In</a>
                    </div>
                </div>
                    <?php
                    } else {
                    ?>
                    <div class="d-flex justify-content-center form_container">
                    <form method="POST" action="" autocomplete="off">
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" name="su_id_no" class="form-control input_user"placeholder="School ID No.">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="password" name="su_password" class="form-control input_pass" placeholder="Password">
                        </div>
                        <div class="d-flex justify-content-center mt-3 login_container">
                            <button type="submit" name="loginBtn" class="btn login_btn">Login</button>
                        </div>
                    </form>
                </div>

                <div class="mt-4">
                    <div class="d-flex justify-content-center links text-white">
                        Don't have an account?  <a href="?sign-up=1" class="ml-2"> Sign Up</a>
                    </div>
                </div>
                    <?php
                    }
                ?>

                <?php
                    if(isset($_GET['registered']))
                    {
                    ?>
                        <span class="bg-white text-success text-center my-3">Your account has been created successfully!</span>
                    <?php
                    } else if(isset($_GET['invalid']))
                    {
                    ?>
                        <span class="bg-white text-danger text-center my-3">Passwords do not matched</span>
                    <?php
                    } else if(isset($_GET['not_registered']))
                    {
                    ?>
                        <span class="bg-white text-warning text-center my-3">Sorry, you are not registered!</span>
                    <?php
                    } else if(isset($_GET['invalid_access']))
                    {
                    ?>
                        <span class="bg-white text-danger text-center my-3">Invalid username or password!</span>
                    <?php
                    } else if(isset($_GET['duplicate']) && $_GET['duplicate'] == 1)
                    {
                        ?>
                            <span class="bg-white text-danger text-center my-3">There is already an account registered with that ID.</span>
                        <?php
                    }

                ?>
                
            </div>
        </div>
    </div>

    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>

</body>

</html>


<?php
    require_once("./admin/inc/config.php");

    if(isset($_POST['sign_up_btn'])) {
    $su_id_no = mysqli_real_escape_string($db, $_POST['su_id_no']);
    $su_username = mysqli_real_escape_string($db, $_POST['su_username']);
    $su_password = mysqli_real_escape_string($db, sha1($_POST['su_password']));
    $su_retype_password = mysqli_real_escape_string($db, sha1($_POST['su_retype_password']));
    $user_role = "voter";

    // check if su_id_no already exists in the database
    $query = mysqli_query($db, "SELECT * FROM users WHERE su_id_no = '".$su_id_no."'");
    if(mysqli_num_rows($query) > 0) {
        ?>
        <script> location.assign("index.php?sign-up=1&duplicate=1"); </script>
        <?php
    } else {
        if($su_password == $su_retype_password) {
            mysqli_query($db, "INSERT INTO users (su_id_no, su_username, su_password, user_role) VALUES ('".$su_id_no."', '".$su_username."', '".$su_password."', '".$user_role."') ") or die(mysqli_error($db));
            ?>
            <script> location.assign("index.php?sign-up=1&registered=1"); </script>
            <?php
        } else {
            ?>
            <script> location.assign("index.php?sign-up=1&invalid=1"); </script>
            <?php
        }
    }
} else if(isset($_POST['loginBtn'])) {
        $su_id_no = mysqli_real_escape_string($db, $_POST['su_id_no']);
        $su_password = mysqli_real_escape_string($db, sha1($_POST['su_password']));

        $fetchingData = mysqli_query($db, "SELECT * FROM users WHERE su_id_no = '".$su_id_no."'") or die(mysqli_error($db));

        if(mysqli_num_rows($fetchingData) > 0) {
            $data = mysqli_fetch_assoc($fetchingData);

            if($su_id_no == $data['su_id_no'] AND $su_password == $data['su_password']) {
                session_start();
                $_SESSION['user_role'] = $data['user_role'];
                $_SESSION['su_username'] = $data['su_username'];
                $_SESSION['user_id'] = $data['id'];

                if($data['user_role'] == "Admin")
                {
                    $_SESSION['key'] = "AdminKey";
                ?>
                    <script>location.assign("admin/index.php?homepage=1");</script>
                <?php
                } else {
                    $_SESSION['key'] = "VotersKey";
                ?>
                    <script>location.assign("voters/index.php");</script>
                <?php
                }
            } else {
            ?>
            <script> location.assign("index.php?invalid_access=1"); </script>

            <?php
            }
        } else
        {
        ?>
            <script> location.assign("index.php?sign-up=1&not_registered=1"); </script>
        <?php
        }
    }

?>