<?php
    // setcookie("user_name_log_in", "", time() - 3600);
    unset($_COOKIE['user_name_log_in']); 
    setcookie('user_name_log_in', null, -1, '/'); 
    header('location: ../index.php');
?>