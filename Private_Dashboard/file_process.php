<?php
// connect to the database
require_once("include/connection.php");
// Uploads files
if (isset($_POST['save'])) { // if save button on the form is clicked
    // name of the uploaded file
    
    $user = $_POST['email'];
    $filename = $_FILES['myfile']['name'];
    // $Admin = $_FILES['admin']['name'];
    
    // destination of the file on the server
    $destination = '../uploads/' . $filename;
    
    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    
    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];
    
    if (!in_array($extension, ['pdf', 'docx', 'doc', 'pptx', 'ppt', 'xlsx', 'xls', 'odt', 'zip', 'csv', 'dwg', 'bak', 'log', 'txt', 'png', 'jpeg', 'jpg', 'gif', 'png'])) {
        echo 
        '<script type="text/javascript">
        alert("File extension must be: .pdf, .docx, .doc, .pptx, .ppt, .xlsx, .xls, .odt, .zip .csv .dwg .bak .log .txt .png .jpeg .jpg .gif .PNG"); 
        window.location = "add_files.php";
        </script>';
    } elseif ($_FILES['myfile']['size'] > 200000000) { // file shouldn't be larger than 1Megabyte
        echo "File too large!";
    } else{
        
        $query=mysqli_query($conn,"SELECT * FROM `upload_files` WHERE `name` = '$filename'")or die(mysqli_error($conn));
        $counter=mysqli_num_rows($query);
        
        if ($counter == 1) { 
            echo 
            '<script type = "text/javascript">
            alert("Files already taken");
            window.location = "view_userfile.php";
            </script>';
        }

        date_default_timezone_set("asia/manila");
        $time = date("M-d-Y h:i A",strtotime("+0 HOURS"));
        
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO upload_files (name, size, download, timers, admin_status, email) VALUES ('$filename', $size, 0, '$time', 'Admin', '$user')";
            if (mysqli_query($conn, $sql)) {
                echo 
                '<script type = "text/javascript">
                        alert("File Upload Successfully");
                        setTimeout(function() {
                            window.location.href = "view_userfile.php";
                        }, 1000); // Redirect to view_userfile.php after 1 seconds
                    </script>';
            }
        } else {
            echo "Failed Upload files!";
        }
    }
}