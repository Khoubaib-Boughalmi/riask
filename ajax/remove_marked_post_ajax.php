<?php
    $con = mysqli_connect('localhost','root','','riask');
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
    echo "<i class='far fa-bookmark' style='font-size:1.6rem;'></i>

    <span style='' class='span-icon-name'>Mark</span>";
?>