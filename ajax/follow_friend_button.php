<?php

$con = mysqli_connect('localhost','root','','riask');
if(mysqli_connect_errno()){
    echo 'connection failled';

}

if (isset($_POST['user_clicked_name'])) {
    $user_clicked_name=$_POST['user_clicked_name'];
}
if (isset($_POST['user_name_logged_in'])) {
    $user_name_logged_in=$_POST['user_name_logged_in'];
}

$query_user_logged_in=mysqli_query($con,"SELECT * from users where user_name='$user_name_logged_in'");
$query_user_logged_in_array=mysqli_fetch_array($query_user_logged_in);
$user_logged_in_following=$query_user_logged_in_array['followers'];
if (strstr($user_logged_in_following,$user_clicked_name)==false) {
    $new_user_logged_in_following=$user_logged_in_following.','.$user_clicked_name;
    $update_followers=mysqli_query($con,"UPDATE `users` SET `followers`='$new_user_logged_in_following' WHERE user_name='$user_name_logged_in'");
    $old_followed_num = mysqli_query($con,"SELECT * from users where user_name='$user_clicked_name'");
    $old_followed_arr = mysqli_fetch_array($old_followed_num);
    $new_followed_num = (int)$old_followed_arr['followed_by'] + 1;
    $update_followers=mysqli_query($con,"UPDATE `users` SET `followed_by`='$new_followed_num' WHERE user_name='$user_clicked_name'");
    
    echo "<script>document.querySelector('.follow_$user_clicked_name').style.cssText ='background-color: rgb(42, 206, 69);border:.2rem solid rgba(42, 206, 69, 0.87);transition: opacity 1.5s;color: #fff;opacity:0;';</script>";
    echo'followed';
}
?>

