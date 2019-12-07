<?php
 require 'db.php';
 if(mysqli_connect_errno()){
     echo 'connection failled';
 
 }
 $timezone=  date_default_timezone_set('Africa/Tunis');

 if (isset($_POST['user_logged_in'])) {
     $user_name = $_POST['user_logged_in'];
}
    include('classes/user.php');
    $user_obj=new user($con,$user_name);
    
if (isset($_POST['tags'])) {
    $tags = $_POST['tags'];
}

if (isset($_POST['title'])) {
    $title = $_POST['title'];
}

if (isset($_POST['selected_category_val'])) {
    $selected_category_val = $_POST['selected_category_val'];
}

if (isset($_POST['body'])) {
    $body = $_POST['body'];
}


 $body=mysqli_real_escape_string($con,$body);
 $check_empty_body = preg_replace('/\s+/', '', $body); //Deltes all spaces 

 $tags=strip_tags($tags);
 $tags=mysqli_real_escape_string($con,$tags);
 $check_empty_tags = preg_replace('/\s+/', '', $tags); //Deltes all spaces 

 $title=strip_tags($title);
 $title=mysqli_real_escape_string($con,$title);
 $check_empty_title = preg_replace('/\s+/', '', $title); //Deltes all spaces 




 $date_submited=date('Y-m-d H:i:s');
 if (($check_empty_tags !='') && ($check_empty_title !='') && ($check_empty_body !='')) {
     $user_name_val=$user_obj->get_user_name();
     // insert into db
     $insert_db_query=mysqli_query($con,"INSERT INTO `posts`(`id`, `title`, `body`, `added_by`, `date_added`, `deleted`, `user_closed`, `likes`, `dislikes`, `users_liked`, `users_disliked`, `post_tags`, `repored_by`,`category`) VALUES ('','$title','$body','$user_name','$date_submited','no','no','0','0','','','$tags','','$selected_category_val')");
     $return_id=mysqli_insert_id($con);
     // update number of postes posted by the user
     $num_post=$user_obj->number_of_posts();
     $num_post++;
     $update_query=mysqli_query($con,"UPDATE users SET number_posts='$num_post' WHERE user_name='$user_name_val'");
    //  select category table
    $select_category=mysqli_query($con,"SELECT * from category WHERE category_val='$selected_category_val'");
    $select_category_array = mysqli_fetch_array($select_category);
    $category_num_post = $select_category_array['num_post'];
    $category_num_post++;
    $update_query_category=mysqli_query($con,"UPDATE category SET num_post='$category_num_post' where category_val ='$selected_category_val'");

}
?>