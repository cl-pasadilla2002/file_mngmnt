<!DOCTYPE html>
<html lang="en">
    <?php
    // Inialize session
    session_start();
    error_reporting(0);
    require_once("include/connection.php");
    $id = mysqli_real_escape_string($conn,$_GET['id']);
    // Check, if username session is NOT set then this page will jump to login page
    if (!isset($_SESSION['admin_user'])) {
        header('Location: index.html');
    } else{
        $uname=$_SESSION['admin_user'];
        // $desired_dir="user_data/$uname/";
    }
    ?>
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Admin Logged History</title>
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="css/mdb.min.css" rel="stylesheet">
        <!-- Your custom styles (optional) -->
        <link href="css/style.min.css" rel="stylesheet">
        
        <script src="js/jquery-1.8.3.min.js"></script>
        <link rel="stylesheet" type="text/css" href="medias/css/dataTable.css" />
        <script src="medias/js/jquery.dataTables.js" type="text/javascript"></script>
        
        <!-- end table-->
        <script type="text/javascript" charset="utf-8">
        $(document).ready(function(){
            $('#dtable').dataTable({
                "aLengthMenu": [[5, 10, 15, 25, 50, 100 , -1], [5, 10, 15, 25, 50, 100, "All"]],
                "iDisplayLength": 10
                //"destroy":true;
            });
        });
        </script>
        
        <style>
        select[multiple], select[size] {
            height: auto;
            width: 20px;
        }
        .pull-right {
            float: right;
            margin: 2px !important;
        }
        .map-container{
            overflow:hidden;
            padding-bottom:56.25%;
            position:relative;
            height:0;
        }
        .map-container iframe{
            left:0;
            top:0;
            height:100%;
            width:100%;
            position:absolute;
        }
        .welcome-message{
            margin-top: 10px;
            margin-right: 10px;
        }
        .md-form.mb-4 select{
            padding: 10px;
        }
        .toggle-password{
            position: absolute;
            right: 10px;
            top: 35%;
            cursor: pointer;
        }
            #loader{
                position: fixed;
                left: 0px;
                top: 0px;
                width: 100%;
                height: 100%;
                z-index: 9999;
                background: url('img/lg.flip-book-loader.gif') 50% 50% no-repeat rgb(249,249,249);
                opacity: 1;
            }
        </style>
        
        <script src="jquery.min.js"></script>
        <script type="text/javascript">
        $(window).on('load', function(){
            // Remove Timeout
            setTimeout(function(){
                $('#loader').fadeOut('slow');  
            });
            // Remove The Timeout
            // $('#loader').fadeOut('slow'); 
        });
        </script>
    </head>
    
    <!-- Body Start Here -->
    <body style="background-color: #A4B6D8;">

    <!-- Start Project here-->
    <!-- Main Navigation -->
    <header>
        <!-- Navbar -->
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark scrolling-navbar" style="background-color: #3D59AB; color: white;">
            <div class="container-fluid">
                <!-- Brand -->
                <a class="navbar-brand waves-effect" href="#">
                    <strong class="blue-text"></strong>
                </a>
                <!-- Collapse -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Links -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Start Here -->
                    <ul class="navbar-nav mr-auto">
                        <!--<li class="nav-item active">
                            <a class="nav-link waves-effect" href="#">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link waves-effect" href="#">About MDB                                
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link waves-effect" href="#">Free download                                
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link waves-effect" href="#">Free tutorials                                
                            </a>
                        </li> -->
                    </ul> <!-- Left End Here -->
                    
                    <?php 
                    require_once("include/connection.php");
                    $id = mysqli_real_escape_string($conn,$_SESSION['admin_user']);
                    $r = mysqli_query($conn,"SELECT * FROM admin_login where id = '$id'") or die (mysqli_error($con));
                    $row = mysqli_fetch_array($r);
                    $id=$row['admin_user'];
                    // $fname=$row['fname'];
                    // $lname=$row['lname'];
                    ?>
                    
                    <!-- Right Start Here -->
                    <ul class="navbar-nav nav-flex-icons">
                        <li class="text-white welcome-message">Welcome! <?php echo ucwords(htmlentities($id)); ?></li>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link border border-light rounded waves-effect">
                                <i class="far fa-user-circle"></i> SignOut
                            </a>
                        </li>
                    </ul> <!-- Right End Here -->
                </div> <!-- Links End Here -->
            </div>
        </nav> <!-- Navbar End Here -->

        <!-- <div id="loader"></div> -->
        
        <!-- Sidebar Start Here -->
        <div class="sidebar-fixed position-fixed" style="background-color: #F0F0F0;">
            <a class="logo-wrapper waves-effect d-flex justify-content-center">
                <img src="img/1.png" class="img-fluid align-self-center" style="width: 80px; height: 500px;" alt="">
            </a>
            <div class="list-group list-group-flush">
                <!-- DASHBOARD -->
                <a href="dashboard.php" class="list-group-item list-group-item-action waves-effect shadow">
                    <i class="fas fa-chart-pie mr-3"></i>Dashboard
                </a>
                <a href="#" class="list-group-item list-group-item-action waves-effect shadow"  data-toggle="modal" data-target="#modalRegisterForm">
                    <i class="fas fa-user mr-3"></i>Add Admin
                </a>
                <a href="view_admin.php" class="list-group-item list-group-item-action waves-effect shadow">
                    <i class="fas fa-users"></i> View Admin
                </a>
                <a href="#" class="list-group-item list-group-item-action waves-effect shadow" data-toggle="modal" data-target="#modalRegisterForm2">
                    <i class="fas fa-user mr-3"></i>Add User
                </a>
                <a href="view_user.php" class="list-group-item list-group-item-action waves-effect shadow">
                    <i class="fas fa-users"></i>  View User
                </a>
                <a href="add_document.php" class="list-group-item list-group-item-action waves-effect shadow">
                    <i class="fas fa-file-medical"></i> Add Document
                </a>
                <a href="view_userfile.php" class="list-group-item list-group-item-action waves-effect shadow">
                    <i class="fas fa-folder-open"></i> View User File
                </a>
                <a href="admin_log.php" class="list-group-item active waves-effect shadow">
                    <i class="fas fa-chalkboard-teacher"></i> Admin logged
                </a>
                <a href="user_log.php" class="list-group-item list-group-item-action waves-effect shadow">
                    <i class="fas fa-chalkboard-teacher"></i> User logged
                </a>
                <!--<a href="#" class="list-group-item list-group-item-action waves-effect">
                    <i class="fas fa-money-bill-alt mr-3"></i>Orders
                </a>-->
            </div>
        </div>
    </header>
    
    <!-- Add Admin Modal -->
    <div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="create_Admin.php" method="POST">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">
                            <i class="fas fa-user-plus"></i> Add Admin Employee
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body mx-3">
                        <!-- Material Input Name -->
                        <div class="md-form mb-5">
                            <i class="fas fa-user prefix grey-text"></i>
                            <input type="text" id="orangeForm-name-Admin" name="name" class="form-control validate" required="">
                            <label data-error="wrong" data-success="right" for="orangeForm-name-Admin">NAME</label>
                        </div>
                        <!-- Material Input Email -->
                        <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <input type="email" id="orangeForm-email-Admin" name="admin_user" class="form-control validate" required="">
                            <label data-error="wrong" data-success="right" for="orangeForm-email-Admin">EMAIL</label>
                        </div>
                        <!-- Material Input Password -->
                        <div class="md-form mb-4">
                            <i class="fas fa-lock prefix grey-text"></i>
                            <input type="password" id="orangeForm-pass-Admin" name="admin_password" class="form-control validate" required="">
                            <!-- For Password Toggle --> 
                            <i class="fa fa-eye-slash" id="togglePassword-Admin" style="position: absolute; right: 20px; top: 35%; cursor: pointer;"></i>
                            <label data-error="wrong" data-success="right" for="orangeForm-pass-Admin">PASSWORD</label>
                        </div>
                        <!-- Material Input User Status -->
                        <div class="md-form mb-4">
                            <i class="fas fa-user prefix grey-text"></i>
                            <input type="text" id="orangeForm-US-Admin" name="admin_status" class="form-control validate" required="">
                            <label data-error="wrong" data-success="right" for="orangeForm-US-Admin">USER STATUS</label>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button class="btn btn-lg" name="reg" style="background-color: #546B33; color: white;">SIGN UP</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!--JavaScript To Toggle Password Visibility-->
	<script>
    $(document).ready(function() {
        $("#togglePassword-Admin").click(function() {
            var passField = $("#orangeForm-pass-Admin");
            var passToggle = $("#togglePassword-Admin");
            if (passField.attr("type") === "password") {
                passField.attr("type", "text");
                passToggle.removeClass("fa-eye-slash").addClass("fa-eye");
            } else {
                passField.attr("type", "password");
                passToggle.removeClass("fa-eye").addClass("fa-eye-slash");
            }
        });
    });
    </script>
    <!-- End of Admin Modal -->

    <!--Add User Modal-->
    <div class="modal fade" id="modalRegisterForm2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="create_user.php" method="POST">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">
                            <i class="fas fa-user-plus"></i> Add User Employee
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body mx-3">
                        <!-- Material Input Name -->
                        <div class="md-form mb-5">
                            <i class="fas fa-user prefix grey-text"></i>
                            <input type="text" id="orangeForm-name-User" name="name" class="form-control validate">
                            <label data-error="wrong" data-success="right" for="orangeForm-name-User">NAME</label>
                        </div>
                        <!-- Material Input Email -->
                        <div class="md-form mb-5">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <input type="email" id="orangeForm-email-User" name="email_address" class="form-control validate" required="">
                            <label data-error="wrong" data-success="right" for="orangeForm-email-User">EMAIL</label>
                        </div>
                        <!-- Material Input Password -->
                        <div class="md-form mb-4">
                            <i class="fas fa-lock prefix grey-text"></i>
                            <input type="password" id="orangeForm-pass-User" name="user_password" class="form-control validate" required="">
                            <!-- For Password Toggle --> 
                            <i class="fa fa-eye-slash" id="togglePassword-User" style="position: absolute; right: 20px; top: 35%; cursor: pointer;"></i> 
                            <label data-error="wrong" data-success="right" for="orangeForm-pass-User">PASSWORD</label>
                        </div>
                        <!-- Material Input User Status -->
                        <div class="md-form mb-4">
                            <i class="fas fa-user prefix grey-text"></i>
                            <input type="text" id="orangeForm-US-User" name="user_status" class="form-control validate" required="">
                            <label data-error="wrong" data-success="right" for="orangeForm-US-User">USER STATUS</label>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-lg" name="reguser" style="background-color: #546B33; color: white;">SIGN UP</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript To Toggle Password Visibility -->
    <script>
    $(document).ready(function() {
        $("#togglePassword-User").click(function() {
            var passField = $("#orangeForm-pass-User");
            var passToggle = $("#togglePassword-User");
            if (passField.attr("type") === "password") {
                passField.attr("type", "text");
                passToggle.removeClass("fa-eye-slash").addClass("fa-eye");
            } else {
                passField.attr("type", "password");
                passToggle.removeClass("fa-eye").addClass("fa-eye-slash");
            }
        });
    });
    </script>
    <!--End User Modal-->
    
    <!--</header>-->
    
    <!--Main Navigation-->
    <div id="loader"></div>
    
    <!--Main layout-->
    <main class="pt-5 mx-lg-5">
        <div class="container-fluid mt-5">
            <!-- Heading Start Here -->
            <div class="card mb-4 wow fadeIn">
                <!--Card Content Start Here -->
                <div class="card-body d-sm-flex justify-content-between">
                    <h4 class="mb-2 mb-sm-0 pt-1">
                        <a href="dashboard.php">Home Page</a>
                        <span>/</span>
                        <span>Admin Logged History</span>
                    </h4>
                    <!--<form class="d-flex justify-content-center">
                        <input type="search" placeholder="Type your query" aria-label="Search" class="form-control">
                        <button class="btn btn-primary btn-sm my-0 p" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form> -->
                </div> <!--Card Content End Here -->
            </div> <!-- Heading Ends Here -->
            
            <div class="text-right">
                <a href="add_document.php"><button type="button" class="btn btn-default" style="background-color: #688243 !important; color: white;"><i class="fas fa-chevron-circle-left"></i> Document</button></a>
                <!--<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalRegisterForm">Add File</button> -->
                <!--<a href="add_document.php"><button type="button" class="btn btn-info"><i class="fas fa-chevron-circle-left"></i>  Document</button></a>-->
            </div>  
            
            <hr>
            
            <div class="card col-md-12">
                <table id="dtable" class = "table table-striped" style="">
                    <thead>
                        <!-- <th>ID</th> -->
                        <th>USER LOGGED</th>    
                        <th>IP</th>
                        <th>HOST</th>
                        <th>ACTION</th> 
                        <th>TIME IN</th>
                        <th>ACTION</th> 
                        <th>TIME OUT</th>
                    </thead>
                    <br/><br/>
                    <tbody>
                        <?php 
                        require_once("include/connection.php");
                        $query = mysqli_query($conn,"SELECT * from history_log1") or die (mysqli_error($conn));
                        while($file=mysqli_fetch_array($query)){
                            //  $id =  $file['id'];
                            $name =  $file['admin_user'];
                            $ip =  $file['ip'];
                            $host =  $file['host'];
                            $action =  $file['action'];
                            $logintime =  $file['login_time'];
                            $actions =  $file['actions'];
                            $logouttime =  $file['logout_time'];
                        ?>
                        <tr>
                            <!-- <td><?php echo  $id; ?></td> -->
                            <td><?php echo $name; ?></td>
                            <td><?php echo $ip; ?></td>
                            <td><?php echo $host; ?></td>
                            <td><?php echo $action; ?></td>
                            <td><?php echo $logintime; ?></td>
                            <td><?php echo $actions; ?></td>
                            <td><?php echo $logouttime; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
            <!--<hr>-->
            
            <!-- Copyright Start Here -->    
            <div class="footer-copyright py-3">
                <p>All right Reserved &copy; <?php echo date('Y');?></p>
            </div><!-- Copyright End Here -->
            </footer> <!-- Footer End Here -->
            
            <!-- SCRIPTS -->
            <!-- JQuery -->
            <script type="text/javascript" src="js/jquery-3.4.0.min.js"></script>
            <!-- Bootstrap tooltips -->
            <script type="text/javascript" src="js/popper.min.js"></script>
            <!-- Bootstrap core JavaScript -->
            <script type="text/javascript" src="js/bootstrap.min.js"></script>
            <!-- MDB core JavaScript -->
            <script type="text/javascript" src="js/mdb.min.js"></script>
            
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css"/>   
            <script type="text/javascript" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/1.0.3/css/dataTables.responsive.css">
            <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/1.0.3/js/dataTables.responsive.js"></script>
    </body>
</html>