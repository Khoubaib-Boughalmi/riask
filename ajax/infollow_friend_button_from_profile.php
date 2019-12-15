<link rel="manifest" href="/../js/manifest.json"></link>

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
$user_logged_in_following_list=$query_user_logged_in_array['followers'];
$user_clicked_comma = ','.$user_clicked_name;
if (strstr($user_logged_in_following_list,$user_clicked_comma)==true) {
    $array = explode(',', $user_logged_in_following_list);
    $key = array_search($user_clicked_name, $array);
    unset($array[$key]);
    $new_followers = implode(',',$array);
    // $new_followers=str_replace($user_clicked_comma, '',$user_logged_in_following_list);
    $update_followers=mysqli_query($con,"UPDATE `users` SET `followers`='$new_followers' WHERE user_name='$user_name_logged_in'");
    $old_followed_num = mysqli_query($con,"SELECT * from users where user_name='$user_clicked_name'");
    $old_followed_arr = mysqli_fetch_array($old_followed_num);
    $new_followed_num = (int)$old_followed_arr['followed_by'] - 1;
    $update_followers=mysqli_query($con,"UPDATE `users` SET `followed_by`='$new_followed_num' WHERE user_name='$user_clicked_name'");
        echo "
        <script>
        document.querySelector('.infollow_$user_clicked_name').innerHTML='Follow';
        document.querySelector('.infollow_$user_clicked_name').style.cssText ='background-color: #15AF2F;border:.2rem solid #15AF2F;transition: background-color .5s;';
        document.querySelector('.infollow_$user_clicked_name').classList.add('span-button__profile__follow');
        document.querySelector('.infollow_$user_clicked_name').classList.add('follow___$user_clicked_name');
        document.querySelector('.infollow_$user_clicked_name').classList.remove('span-button_profile_infollow');
        document.querySelector('.infollow_$user_clicked_name').classList.remove('infollow_$user_clicked_name');
        </script>";
    }
?>
