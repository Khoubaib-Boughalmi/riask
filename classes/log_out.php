<?php
    setcookie("user_name_log_in", "", time() - 3600);

    header('location: ../index.php');
?>