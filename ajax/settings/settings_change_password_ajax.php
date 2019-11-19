<?php

require '../../db.php';
if(mysqli_connect_errno()){
    echo 'connection failled';

}

if (isset($_POST['user_logged_in'])) {
    $user_logged_in=$_POST['user_logged_in'];
}
if (isset($_POST['new_password'])) {
    $new_password=$_POST['new_password'];
}



$new_password = strip_tags($new_password);
$new_password = mysqli_real_escape_string($con,$new_password);

$new_password=md5($new_password);

if(trim($new_password," \t\n\r\0\x0B")!=''){
$update_name=mysqli_query($con,"UPDATE `users` SET password='$new_password' where user_name='$user_logged_in'");
}
?>