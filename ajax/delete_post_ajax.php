<link rel="manifest" href="/../js/manifest.json"></link>

<?php
   require '../db.php';
    if(mysqli_connect_errno()){
        echo 'connection failled';
    
    }

    
    if (isset($_POST['post_id'])) {
        $post_id=$_POST['post_id'];
    }

    $delete_query=mysqli_query($con,"DELETE FROM `posts` WHERE id='$post_id'")
?>