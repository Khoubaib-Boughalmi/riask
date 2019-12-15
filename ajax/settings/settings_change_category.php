<link rel="manifest" href="../../js/manifest.json"></link>

<?php

require '../../db.php';
if(mysqli_connect_errno()){
    echo 'connection failled';

}

if (isset($_POST['user_logged_in'])) {
    $user_logged_in=$_POST['user_logged_in'];
}
if (isset($_POST['tag_value'])) {
    $tag_value=$_POST['tag_value'];
}

    $update_category=mysqli_query($con,"UPDATE `users` SET categories='$tag_value' where user_name='$user_logged_in'");

?>