<?php
require '../db.php';
 if(mysqli_connect_errno()){
     echo 'connection failled';
 
 }
 include('../classes/notification.php');
 $timezone=  date_default_timezone_set('Africa/Tunis');
 
 if (isset($_POST['user_name_logged_in'])) {
     $user_name= $_POST['user_name_logged_in'];
}
 
$notification_obj = new notification($con,$user_name);
            
if (isset($_POST['user_to'])) {
    $user_to = $_POST['user_to'];
}

if (isset($_POST['body'])) {
    $body = $_POST['body'];
}

if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
}


 $body=mysqli_real_escape_string($con,$body);
 $check_empty_body = preg_replace('/\s+/', '', $body); //Deltes all spaces 

$body = wordwrap($body,150,"<br>\n");

 $date_submited=date('Y-m-d H:i:s');
 if ($check_empty_body !='') {
     // insert into db
     $insert_db_query=mysqli_query($con,"INSERT INTO `comments`(`id`, `posted_by`, `posted_to`, `date_added`, `removed`, `post_id`, `comment_body`)
                                                 VALUES ('','$user_name','$user_to','$date_submited','no','$post_id','$body')");
    
    // push notification

    if ($user_name!=$user_to) {
        $notification_obj->insert_notification($post_id,$user_to,'comment','');
    }
    
    $return_id=mysqli_insert_id($con);
    
    $post= "<div class='post_$return_id'>
    <div class='top-post'>
    <div class='post-body'>
    <div class='post-body-user-image'>
    <div class='color-post-body'></div>

</div>
         <div class=' post-body-text'>

<div class='user-name-timer'>
<div class='image-name-post'>
    <a href='#'><img src='images/steve.jpg'  class='images-user-post' ></a>
        <div class='time_name_post'>
            <a href='#'><span class='user-name-post'>$user_name</span></a>
            <span class='timer-post'>Just now</span>
        </div>   
</div>
<div class='dropdown_post'>
    <img class='ellipsis_img_post ellipsis_img_post' src='images/ellipsis.png'>
    <div id='more_option_post_div more_option_post_div' class='dropdown-content_more_option_post dropdown-content_more_option_post'>
       <div class='delete_post_div delete_post_div'><i class='far fa-times-circle' style='font-size: 1.3rem;'></i><span class='report_button_post'>delete</span></div>
                                           
   </div>
    </div>
</div>
<h4 class='title_review_create_post'></h4>
<span class='commen_css_post_span'> $body</span>
<div class='show_all_search_result_content_tags'>

</div>";


$post.=" 
        </div>
    </div>
    </div>

    <div class='likes_and_bottom_post$return_id'>
    <div class='likes_dislikes_display_number'>
    <div class='like-stat'> <!-- Like statistic container-->
    <span class='like-emo'> <!-- like emotions container -->
    <i class='fas fa-flag' style='font-size:1.8rem ;color:#0080008c;'></i>
    </span>
    <span class='like-details'>0</span>
    </div>
    <div class='like-stat' style='margin-left:2rem;'> <!-- Like statistic container-->
    <span class='dislike-emo'> <!-- like emotions container -->
    <i class='fas fa-flag' style='font-size:1.8rem ;color:#FF6B6B;'></i>
    </span>
    <span class='like-details'>0</span>
    </div>
    </div>
    <hr><div class='bottom-post'>
    <div class='bottom_post_like_0'>
    <div class='riask-reaction'>
    <span class='like-btn' style='display:flex'> 
    <span class='like-btn-emo like-btn-default '></span>
    <span class='like-btn-text'>Like</span>        
    </span>
     </div>
    </div>
    <div class='bottom_post_componment_like_' id='comment_0'>
        <form action='show_comments.php?post_id=$return_id' method='POST' >
                <i class='far fa-comment-alt ' style='font-size:1.6rem;'></i>
            <input type='submit' value='Comments' name='span-icon-name'class='span-icon-name'>
            </form>
        </div>
        <div class='bottom_post_componment_mark_post' id='bottom_post_componment_mark_post_0'>
            <i class='far fa-bookmark' style='font-size:1.6rem;'></i>

            <span style='' class='span-icon-name'>Mark</span>
        </div>
        
        </div>
        <hr>
    </div>
</div>"; 
echo $post;

}else{
echo 'no posts to show';
}
?>