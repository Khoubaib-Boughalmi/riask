<?php
if(isset($_POST['submit_log_in'])){
    $user_email_log_in=filter_var($_POST["user_email_log_in"],FILTER_SANITIZE_EMAIL);
    $_SESSION["user_email_log_in"] = $user_email_log_in;

    $user_password_log_in = $_POST["user_password_log_in"];
    $user_password_log_in = md5($user_password_log_in);

    $query_log_in=mysqli_query($con,"SELECT * FROM users WHERE email='$user_email_log_in' AND password ='$user_password_log_in'");

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

        header('location: main.php');
        exit();
    }else{
        ?>
            <script>
                simpleNotify.notify('Email or Password are incorrect','danger');
                $('.user-email').css('border','.15rem solid red');
                $('.user-password').css('border','.15rem solid red');
                // $('.user-email').val()= ;
                document.querySelector('.user-email').value='<?php echo $user_email_log_in ?>'
            </script>
        <?php
    }
}
?>