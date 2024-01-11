<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];
//update logged in user account
// Check if the form with the name 'update_account' has been submitted
if (isset($_POST['update_account'])) {
    // Retrieve values from the submitted form data
    $name = $_POST['name'];
    $admin_id = $_SESSION['admin_id'];
    $email = $_POST['email'];
    //insert into certain table in database
    // Prepare an SQL query to update data in the 'iB_admin' table
    $query = "UPDATE iB_admin  SET name=?, email=? WHERE  admin_id=?";
    // Prepare the SQL statement for execution
    $stmt = $mysqli->prepare($query);
    // Bind parameters to the prepared statement
    $rc = $stmt->bind_param('ssi', $name, $email, $admin_id);
    // Execute the prepared statement
    $stmt->execute();
    //declare a varible which will be passed to alert function
    // Check if the statement was executed successfully
    if ($stmt) {
        // If successful, set a success message
        $success = "Account Updated";
    } else {
        // If unsuccessful, set an error message
        $err = "Please Try Again Or Try Later";
    }
}
/* The code retrieves the user's input from the submitted form ($name, $admin_id, and $email).
It constructs an SQL query to update the 'iB_admin' table where the 'admin_id' matches the session's 'admin_id'.
The query is prepared using $mysqli->prepare().
Parameters are bound to the prepared statement using $stmt->bind_param() (s for string, i for integer).
The prepared statement is executed with $stmt->execute().
If the execution is successful, a success message is set. 
Otherwise, an error message is set. Note that the check if ($stmt) 
might not be entirely accurate for checking success. 
Typically, you would check for errors using $stmt->error or similar methods.*/
//change password
// Check if the form with the name 'change_password' has been submitted
if (isset($_POST['change_password'])) {
    // Hash the user-provided password using md5
    $password = sha1(md5($_POST['password']));
    // Retrieve the admin_id from the session
    $admin_id = $_SESSION['admin_id'];
    // Prepare an SQL query to update the password in the 'iB_admin' table
    $query = "UPDATE iB_admin  SET password=? WHERE  admin_id=?";
    // Prepare the SQL statement for execution
    $stmt = $mysqli->prepare($query);
    //bind paramaters to the prepared statement
    $rc = $stmt->bind_param('si', $password, $admin_id);
    // Execute the prepared statement
    $stmt->execute();
    //declare a varible which will be passed to alert function
    if ($stmt) {
        $success = "Password Updated";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}
/* The code hashes the user-provided password using both md5.
The admin_id is retrieved from the session.
An SQL query is prepared to update the 'password' field in the 'iB_admin' table where the 'admin_id' matches the session's 'admin_id'.
Parameters are bound to the prepared statement using $stmt->bind_param() (s for string, i for integer).
The prepared statement is executed with $stmt->execute().
If the execution is successful, a success message is set. 
Otherwise, an error message is set. Again, checking for errors using $stmt->error or similar methods would be more accurate.*/


?>
<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php include("dist/_partials/head.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("dist/_partials/nav.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("dist/_partials/sidebar.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header with logged in user details (Page header) -->
            <?php
            // Retrieve admin_id from the session
            $admin_id = $_SESSION['admin_id'];
            // Prepare an SQL query to select all columns from the 'iB_admin' table where admin_id matches the session's admin_id
            $ret = "SELECT * FROM  iB_admin  WHERE admin_id = ? ";
            // Prepare the SQL statement for execution
            $stmt = $mysqli->prepare($ret);
            // Bind parameter to the prepared statement (i for integer)
            $stmt->bind_param('i', $admin_id);
            // Execute the prepared statement
            $stmt->execute(); //ok
            $res = $stmt->get_result();// Get the result set
            while ($row = $res->fetch_object()) {
                //set automatically logged in user default image if they have not updated their pics
                // Check if the user has not updated their profile picture
                if ($row->profile_pic == '') {
                    $profile_picture = "

                        <img class='img-fluid'
                        src='dist/img/user_icon.png'
                        alt='User profile picture'>

                        ";
                } else {
                    // If the user has updated their profile picture, use the provided image
                    $profile_picture = "

                        <img class=' img-fluid'
                        src='dist/img/$row->profile_pic'
                        alt='User profile picture'>

                        ";
                }
            ?>
            <!--
                Admin_id is retrieved from the session.
An SQL query is prepared to select all columns from the 'iB_admin' table where admin_id matches the session's admin_id.
Parameters are bound to the prepared statement using $stmt->bind_param() (i for integer).
The prepared statement is executed with $stmt->execute().
The result set is obtained using $stmt->get_result().
Inside the while loop, it checks if the user has updated their profile picture. 
If not, a default image is used; otherwise, the user's provided image is used.
The HTML for the profile picture is stored in the $profile_picture variable.
             -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1><?php echo $row->name; ?> Profile</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="pages_account.php">Profile</a></li>
                                    <li class="breadcrumb-item active"><?php echo $row->name; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">

                                <!-- Profile Image -->
                                <div class="card card-purple card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <?php echo $profile_picture; ?>
                                        </div>

                                        <h3 class="profile-username text-center"><?php echo $row->name; ?></h3>

                                        <p class="text-muted text-center">@Admin iBanking </p>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Email: </b> <a class="float-right"><?php echo $row->email; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Number: </b> <a class="float-right"><?php echo $row->number; ?></a>
                                            </li>

                                        </ul>

                                    </div>                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->

                              
                            </div>

                            <!-- /.col -->
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#update_Profile" data-toggle="tab">Update Profile</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#Change_Password" data-toggle="tab">Change Password</a></li>
                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <!-- / Update Profile -->
                                            <div class="tab-pane active" id="update_Profile">
                                                <form method="post" class="form-horizontal">
                                                    <div class="form-group row">
                                                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="name" required class="form-control" value="<?php echo $row->name; ?>" id="inputName">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                        <div class="col-sm-10">
                                                            <input type="email" name="email" required value="<?php echo $row->email; ?>" class="form-control" id="inputEmail">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName2" class="col-sm-2 col-form-label">Number</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" required readonly name="number" value="<?php echo $row->number; ?>" id="inputName2">
                                                        </div>
                                                    </div>                                                    
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button name="update_account" type="submit" class="btn btn-outline-success">Update Account</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- /Change Password -->
                                            <div class="tab-pane" id="Change_Password">
                                                <form method="post" class="form-horizontal">
                                                    <div class="form-group row">
                                                        <label for="inputName" class="col-sm-2 col-form-label">Old Password</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" class="form-control" required id="inputName">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail" class="col-sm-2 col-form-label">New Password</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" name="password" class="form-control" required id="inputEmail">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName2" class="col-sm-2 col-form-label">Confirm New Password</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" class="form-control" required id="inputName2">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button type="submit" name="change_password" class="btn btn-outline-success">Change Password</button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                            <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                    </div><!-- /.card-body -->
                                </div>
                                <!-- /.nav-tabs-custom -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->

            <?php } ?>
        </div>        <!-- /.content-wrapper -->
        <?php include("dist/_partials/footer.php"); ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
</body>

</html>