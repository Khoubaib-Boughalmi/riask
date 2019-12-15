<link rel="manifest" href="/../js/manifest.json"></link>

<?php
session_start();
require '../db.php';

    if (isset($_POST['email_pop_up_val'])) {
        $email_pop_up_val=$_POST['email_pop_up_val'];
    }
    if (isset($_POST['password_pop_up_val'])) {
        $password_pop_up_val=$_POST['password_pop_up_val'];
    }

    $email_pop_up_val=filter_var($email_pop_up_val,FILTER_SANITIZE_EMAIL);
    $password_pop_up_val = md5($password_pop_up_val);

    $query_log_in=mysqli_query($con,"SELECT * FROM users WHERE email='$email_pop_up_val' AND password ='$password_pop_up_val'");

    $num_query_log_in=mysqli_num_rows($query_log_in);
    if ($num_query_log_in == 1) {
        $row=mysqli_fetch_array($query_log_in);
        $user_name_log_in=$row['user_name'];
        $user_closed=$row['user_closed'];
        if($user_closed == 'yes'){
            $user_closed_update=mysqli_query($con,"UPDATE users SET user_closed='no' WHERE email='$user_email_log_in'");
        }
        // $_SESSION['user_name_log_in']=$user_name_log_in;
        setcookie('user_name_log_in', $user_name_log_in, time() + (86400 * 30 * 30), "/"); // 86400 = 1 day

        echo $num_query_log_in;
    }
    else{
        echo $num_query_log_in;
    }

?>