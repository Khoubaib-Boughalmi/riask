<link rel="manifest" href="../js/manifest.json"></link>

<?php

require '../db.php';
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
    
    echo "<script>document.querySelector('.follow___$user_clicked_name').style.cssText ='background-color: #EB3434;border:.2rem solid #EB3434;transition: background-color .5s;';
    document.querySelector('.follow___$user_clicked_name').innerHTML='Infollow';
    document.querySelector('.follow___$user_clicked_name').classList.add('span-button_profile_infollow');
    document.querySelector('.follow___$user_clicked_name').classList.add('infollow_$user_clicked_name');
    document.querySelector('.follow___$user_clicked_name').classList.remove('span-button__profile__follow');
    document.querySelector('.follow___$user_clicked_name').classList.remove('follow___$user_clicked_name');
    
    // user click infollow directly after following
    $('.span-button_profile_infollow').click(function(){
        
    })
    </script>";
}
?>