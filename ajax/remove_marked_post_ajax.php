<?php
   require '../db.php';
    if(mysqli_connect_errno()){
        echo 'connection failled';
    
    }

    
    
    if (isset($_POST['post_id'])) {
        $post_id=$_POST['post_id'];
    }
    
    if (isset($_POST['user_name_logged_in'])) {
        $user_name_logged_in=$_POST['user_name_logged_in'];
    }
    $delete_query=mysqli_query($con,"DELETE FROM `marked_post` WHERE post_id='$post_id' and marked_by ='$user_name_logged_in'");
    echo "<img src='images/icons/mark.png' alt=''  style='height:2.1rem;';>

    <span style='color:#222222;' class='span-icon-name'>Mark</span>";
?>