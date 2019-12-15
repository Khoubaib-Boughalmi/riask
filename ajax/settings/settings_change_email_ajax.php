<link rel="manifest" href="/../../js/manifest.json"></link>

<?php

require '../../db.php';
if(mysqli_connect_errno()){
    echo 'connection failled';

}

if (isset($_POST['user_logged_in'])) {
    $user_logged_in=$_POST['user_logged_in'];
}
if (isset($_POST['email'])) {
    $email=$_POST['email'];
}

$email = strip_tags($email);
$email = mysqli_real_escape_string($con,$email);

$email = str_replace(" ","",$email);
$email =strtolower($email);

if (trim ($email," \t\n\r\0\x0B")!='') {
    $update_name=mysqli_query($con,"UPDATE `users` SET email='$email' where user_name='$user_logged_in'");
}
?>