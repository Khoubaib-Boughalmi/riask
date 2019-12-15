<link rel="manifest" href="/../../js/manifest.json"></link>

<?php
   require '../db.php';
    if(mysqli_connect_errno()){
        echo 'connection failled';
    }
    if (isset($_POST['email'])) {
        $email_val =$_POST['email'];
    }
    
    $query_email = mysqli_query($con,"SELECT email FROM users WHERE email='$email_val'"); 
    $num_rows= mysqli_num_rows($query_email);
    if ($num_rows>0) {
        echo "<span>Email already used</span>";
    }
        
?>