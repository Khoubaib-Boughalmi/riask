<link rel="manifest" href="../js/manifest.json"></link>

<?php
    $user_name=$_POST['user_name'];
    setcookie('user_name_log_in', $user_name, time() + (86400 * 30 * 30), "/"); // 86400 = 1 day
    // header('Location: main.php');
    if (isset($_COOKIE['user_name_log_in'])) {
        echo '1';
    }else{
        setcookie('user_name_log_in', $user_name, time() + (86400 * 30 * 30), "/"); // 86400 = 1 day
        echo '1';

    }

?>