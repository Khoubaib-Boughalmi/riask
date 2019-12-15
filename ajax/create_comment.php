<link rel="manifest" href="/../js/manifest.json"></link>

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
if (isset($_POST['pdp'])) {
    $pdp = $_POST['pdp'];
}


 $body=mysqli_real_escape_string($con,$body);
 $check_empty_body = preg_replace('/\s+/', '', $body); //Deltes all spaces 

$body = wordwrap($body,150,"<br>\n");

$date_submited=date('Y-m-d H:i:s');
if ($check_empty_body !='') {
    // insert into db
    // $body = mysqli_real_escape_string($con,$body);

    $insert_db_query="INSERT INTO `comments`(`id`, `posted_by`, `posted_to`, `date_added`, `removed`, `post_id`, `comment_body`, `user_profile_pic`)
                                                 VALUES ('','$user_name','$user_to','$date_submited','no','$post_id','$body','$pdp')";
    
    // $body = htmlspecialchars($body, ENT_QUOTES);
    
    // push notification

    if ($user_name!=$user_to) {
        $notification_obj->insert_notification($post_id,$user_to,'comment','',$pdp);
    }
    if ($con->query($insert_db_query) === TRUE) {
    $return_id=$con->insert_id;
    }
    
    $post= "<div class='comment_$return_id'>
    <div class='top-post'>
    <div class='post-body'>
    <div class='post-body-user-image'>
    <div class='color-post-body'></div>

</div>
         <div class=' post-body-text'>

<div class='user-name-timer'>
<div class='image-name-post'>
    <a href='#'><img src='$pdp'  class='images-user-post' ></a>
        <div class='time_name_post'>
            <a href='#'><span class='user-name-post'>$user_name</span></a>
            <span class='timer-post'>Just now</span>
        </div>   
</div>
<div class='dropdown_comment'>
<img class='ellipsis_img_comment ellipsis_img_comment__".$return_id."' src='images/ellipsis.png' style='height:2rem'>
<div id='more_option_comment_div more_option_comment_div_".$return_id."' class='dropdown-content_more_option_comment dropdown-content_more_option_comment_".$return_id."'>
<div class='delete_comment_div delete_comment_div_".$return_id."'><i class='far fa-times-circle' style='font-size: 1.3rem;'></i><span class='report_button_comment'>delete</span></div>

   </div>
    </div>
</div>
<h4 class='title_review_create_post'></h4>
<span class='commen_css_post_span hyphens'> $body</span>
<div class='show_all_search_result_content_tags'>

</div>";


    $post.="
    </div>
    </div>
    </div>

    <!-- <div class='likes_and_bottom_post".$post_id."'>
    <div class='likes_dislikes_display_number'>
    <div class='like-stat'> 
    <span class='like-emo'> 
    <i class='fas fa-flag' style='font-size:1.8rem ;color:#0080008c;'></i>
    </span>
    <span class='like-details'>0</span>
    </div>
    <div class='like-stat' style='margin-left:2rem;'> 
    <span class='dislike-emo'>
    <i class='fas fa-flag' style='font-size:1.8rem ;color:#FF6B6B;'></i>
    </span>
    <span class='like-details'>0</span>
    </div>
    </div> -->
    <hr>
    <!-- <div class='bottom-post_comment'>
    <div class='bottom_post_like_0'>
    <div class='riask-reaction'>
    <span class='like-btn' style='display:flex'> 
    <span class='like-btn-emo like-btn-default '></span>
    <span class='like-btn-text'>Like</span>        
    </span>
    </div>
    </div>
    <div class='bottom_post_componment_like_' id='comment_0'>
    <form action='show_comments.php?post_id=".$post_id."' method='POST' >
            <i class='far fa-comment-alt ' style='font-size:1.6rem;'></i>
        <input type='submit' value='Comments' name='span-icon-name'class='span-icon-name'>
        </form>
    </div>
    </div>
    <hr>
    </div> -->
    </div>"; 
echo $post;

}
?>
<script>

    // toggle comment ellipsis
    $('.ellipsis_img_comment').click(function () {
            var ellipsis_id = $(this).attr('class');
            var ellipsis_id = ellipsis_id.slice(43);
            ellipsis_id = ellipsis_id.match(/[^/]*/i)[0]
            $(".dropdown-content_more_option_comment_" + ellipsis_id).toggle("show");
            // alert(ellipsis_id)
        })
        // report a comment
        $('.report_comment_div').click(function () {
            var report_id = $(this).attr('class');
            var report_id = report_id.slice(38);
            var user_name_logged_in = '<?php echo $user_name?>';
            $.ajax({
                url: 'ajax/report_comment_ajax.php',
                type: 'POST',
                data: {
                    report_id: report_id,
                    user_name_logged_in: user_name_logged_in
                },
                error: function () {
                    alert('error');
                },
                success: function (data) {
                    $('.post_' + report_id).hide('slow', function () {
                        $('.post_' + report_id).remove();
                    });
                }
            })
        })
        $('.delete_comment_div').click(function () {
            var post_id = $(this).attr('class');
            var post_id = post_id.slice(38);
            var user_name_logged_in = '<?php echo $user_name?>';
            $.ajax({
                url: 'ajax/delete_comment_ajax.php',
                type: 'POST',
                data: {
                    post_id: post_id
                },
                error: function () {
                    alert('error');
                },
                success: function (data) {
                    $('.comment_' + post_id).hide('slow', function () {
                        $('.comment_' + post_id).remove();
                    });
                }
            })
            // alert(post_id)
        })
</script>