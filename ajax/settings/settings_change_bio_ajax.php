<?php

$con = mysqli_connect('localhost','root','','riask');
if(mysqli_connect_errno()){
    echo 'connection failled';

}

if (isset($_POST['user_logged_in'])) {
    $user_logged_in=$_POST['user_logged_in'];
}
if (isset($_POST['bio'])) {
    $bio=$_POST['bio'];
}

$bio = strip_tags($bio);
$bio = mysqli_real_escape_string($con,$bio);
$bio = ucfirst(strtolower($bio));
if (trim ($bio," \t\n\r\0\x0B")!='') {
    $update_name=mysqli_query($con,"UPDATE `users` SET user_bio='$bio' where user_name='$user_logged_in'");
}

?>