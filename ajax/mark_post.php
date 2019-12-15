<link rel="manifest" href="/../js/manifest.json"></link>

<?php

require '../db.php';
if(mysqli_connect_errno()){
    echo 'connection failled';

}

$post_marked_id=$_POST['post_marked_id'];
$title=$_POST['title'];
$body=$_POST['body'];
$tags=$_POST['tags'];
$user_name_logged_in=$_POST['user_name_logged_in'];

$query_post_marked=mysqli_query($con,"SELECT * FROM marked_post WHERE post_id='$post_marked_id' and marked_by='$user_name_logged_in'");
$query_post_marked_num_rows=mysqli_num_rows($query_post_marked);

if ($query_post_marked_num_rows == 0) {
    $query_post_marked_insert=mysqli_query($con,"INSERT INTO `marked_post`(`id`, `post_id`, `marked_by`, `title`, `body`, `tags`) VALUES ('','$post_marked_id','$user_name_logged_in','$title','$body','$tags')");

    echo" <img src='images/icons/mark_green.png' alt=''  style='height:2.1rem;';>

    <span style='color:#73b973;' class='span-icon-name'>Marked</span>";
}


?>