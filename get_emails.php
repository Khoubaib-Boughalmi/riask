<?php
    $con = mysqli_connect('localhost','root','','riask');
    if(mysqli_connect_errno()){
        echo 'connection failled';
    }
    if (isset($_POST['suggestion'])) {
        $email_pasta =$_POST['suggestion'];
        $query_email = mysqli_query($con,"SELECT email FROM users WHERE email='$email_pasta'");
        echo mysqli_num_rows($query_email);
    }
  
?>