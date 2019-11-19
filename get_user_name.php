<?php
 require 'db.php';
    if (isset($_POST['suggestion'])) {
        $user_name =$_POST['suggestion'];
        $query_user_name = mysqli_query($con,"SELECT user_name FROM users WHERE user_name='$user_name'");
        echo mysqli_num_rows($query_user_name);
    }
  
?>