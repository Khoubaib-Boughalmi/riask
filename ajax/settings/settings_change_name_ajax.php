<link rel="manifest" href="/../../js/manifest.json"></link>

<?php

require '../../db.php';
if(mysqli_connect_errno()){
    echo 'connection failled';

}

if (isset($_POST['user_logged_in'])) {
    $user_logged_in=$_POST['user_logged_in'];
}
if (isset($_POST['new_first_name'])) {
    $new_first_name=$_POST['new_first_name'];
}
if (isset($_POST['new_last_name'])) {
    $new_last_name=$_POST['new_last_name'];
}


$new_first_name = strip_tags($new_first_name);
$new_first_name = mysqli_real_escape_string($con,$new_first_name);
$new_first_name = str_replace(" ","",$new_first_name);
$new_first_name = ucfirst(strtolower($new_first_name));


$new_last_name = strip_tags($new_last_name);
$new_last_name = mysqli_real_escape_string($con,$new_last_name);
$new_last_name = str_replace(" ","",$new_last_name);
$new_last_name = ucfirst(strtolower($new_last_name));

if ((trim($new_first_name," \t\n\r\0\x0B")!='')&&(trim($new_last_name," \t\n\r\0\x0B")!='')) {
$update_name=mysqli_query($con,"UPDATE `users` SET first_name='$new_first_name', last_name='$new_last_name' where user_name='$user_logged_in'");
}
?>

