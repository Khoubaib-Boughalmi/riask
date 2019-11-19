<?php
  require 'db.php';
  
    if (isset($_POST['suggestion'])) {
        $email =$_POST['suggestion'];
        $query_email = mysqli_query($con,"SELECT email FROM users WHERE email='$email'");
        echo mysqli_num_rows($query_email);
    }
  
?>