<?php
session_start();
include('conf/config.php');
if (isset($_POST['confirm_reset_password'])) {
    /* Confirm Password */
    $error = 0;
    // Check if the 'new_password' is set and not empty
    if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
        //Sanitize and hash the confirm password using md5 and sha1
        $new_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['new_password']))));
    } else {
        // Set an error flag and message if new password is empty
        $error = 1;
        $err = "New Password Cannot Be Empty";
    }
    // Check if the 'confirm_password' is set and not empty
    if (isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])) {
        $confirm_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['confirm_password']))));
    } else {
        $error = 1;
        $err = "Confirmation Password Cannot Be Empty";
    }
/* This code checks if the 'new_password' and 'confirm_password' 
fields are set and not empty. It sanitizes and hashes the passwords
 using md5 and sha1 (though using stronger password hashing methods 
 is recommended). It sets an error flag and message if any of the 
 passwords are empty or if they don't match. Further processing based 
 on the specific requirements would follow in the subsequent code.*/


        // Check if there are no errors
    if (!$error) {
        // Get the email from the session
        $email = $_SESSION['email'];
        // Select admin information based on the email
        $sql = "SELECT * FROM  iB_admin  WHERE email = '$email'";
        $res = mysqli_query($mysqli, $sql);
        // Check if there is a matching admin
        if (mysqli_num_rows($res) > 0) {
            // Fetch the admin data
            $row = mysqli_fetch_assoc($res);
            // Check if the new password matches the confirmation password
            if ($new_password != $confirm_password) {
                $err = "Password Does Not Match";
            } else {
                // Update the admin password
                $email = $_SESSION['email'];
                $query = "UPDATE iB_admin SET  password =? WHERE email =?";
                $stmt = $mysqli->prepare($query);
                // Bind parameters to the prepared statement (s for string)
                $rc = $stmt->bind_param('ss', $new_password, $email);
                $stmt->execute();
                // Check if the statement was executed successfully
                if ($stmt) {
                    $success = "Password Changed" && header("refresh:1; url=pages_index.php");
                } else {
                    $err = "Please Try Again Or Try Later";
                }
            }
        }
    }
}

/* Persisit System Settings On Brand */
$ret = "SELECT * FROM `iB_SystemSettings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($auth = $res->fetch_object()) {
?>

<!--This code checks for no errors and then proceeds to fetch the admin's 
information based on the email from the session. It checks if there is a 
matching admin, verifies that the new password matches the confirmation 
password, and then updates the admin's password in the database. 
The success message is set, and the page is redirected after 1 second if 
the password update is successful. If any issues occur during the process, 
an error message is set. Adjust the code as needed for your specific 
requirements. -->




    <!DOCTYPE html>
    <html>
    <?php include("dist/_partials/head.php"); ?>

    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <p><?php echo $auth->sys_name; ?> - <?php echo $auth->sys_tagline; ?></p>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <?php
                    $email  = $_SESSION['email'];
                    $ret = "SELECT * FROM  iB_admin  WHERE email = '$email'";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    while ($row = $res->fetch_object()) {
                    ?>
                        <p class="login-box-msg"><?php echo $row->name; ?> Please Enter And Confirm Your Password</p>
                    <?php
                    } ?>
                    <form method="POST">
                        <div class="input-group mb-3">
                            <input type="password" required name="new_password" class="form-control" placeholder="New Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" required name="confirm_password" class="form-control" placeholder="Confirm Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" name="confirm_reset_password" class="btn btn-success btn-block">Reset Password</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <p class="mt-3 mb-1">
                        <!--           <a href="pages_staff_index.php">Login</a>
 -->
                    </p>

                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="lugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>

    </body>

    </html>
<?php
} ?>