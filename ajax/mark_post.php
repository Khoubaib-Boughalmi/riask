<?php

$con = mysqli_connect('localhost','root','','riask');
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

    echo" <i class='far fa-bookmark' style='font-size:1.6rem;color:green'></i>

           <span class='span-icon-name' style='color:green'>Marked</span>";
}


?>