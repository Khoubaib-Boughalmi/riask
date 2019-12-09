<?php
require 'db.php';
if(mysqli_connect_errno()){
    echo 'connection failled';

}

$like_id=$_POST['like_id_val'];
$user_name_logged_in_val=$_POST['user_name_logged_in_val'];
$liked_text_val=$_POST['liked_text_val'];
$user_profile_pic=$_POST['user_profile_pic'];
$post_title=$_POST['post_title'];
$user_to=$_POST['user_to'];


//  delete old like in casse user click twise
// select post with id that user clicked on like
// $select_post_query=mysqli_query($con,"SELECT * FROM posts WHERE id='$like_id'");
// $fetch_array_post_before=mysqli_fetch_array($select_post_query);
// $num_likes=$fetch_array_post_before['likes'];
// $title=$fetch_array_post_before['title'];
// $user_liked_list=$fetch_array_post_before['users_liked'];

// if (strstr($user_liked_list,$user_name_logged_in_val) == false) {

    $delete_like_query=mysqli_query($con,"DELETE FROM likes WHERE post_id='$like_id' and user_name='$user_name_logged_in_val'");

// insert new value of likes in tabele 
$insert_like_query=mysqli_query($con,"INSERT INTO `likes`(`id`, `user_name`, `post_id`, `is_like`, `is_dislike`) VALUES('','$user_name_logged_in_val','$like_id','yes','no')");
// select table post with new value of lieks
// $select_post_query=mysqli_query($con,"SELECT * FROM posts WHERE id='$like_id'");
// $fetch_array_post_before=mysqli_fetch_array($select_post_query);
// $num_likes=$fetch_array_post_before['likes'];
// $num_likes=((int)$num_likes+1);
// update the value of likes after reducing it
// $user_liked_list = $user_liked_list.','.$user_name_logged_in_val.',';

// $increase_like_query=mysqli_query($con,"UPDATE `posts` SET `likes`= '$num_likes',`users_liked`='$user_liked_list' WHERE id='$like_id'");



// insert notification
include('classes/notification.php');
$notification_obj=new notification($con,$user_name_logged_in_val);
// $user_to=$fetch_array_post_before['added_by'];
if (($user_name_logged_in_val!=$user_to)) {
    $notification_obj->insert_notification($like_id,$user_to,'like',$post_title,$user_profile_pic);
}

echo "<div class='riask-reaction'>
        <span class='like-btn'> 
        <span class='like-btn-emo like-btn-like like_".$like_id."'></span>
        <span class='like-btn-text like_btn_".$like_id."' style='color:#73B973;'> Liked</span>
                <ul class='reactions-box'> 
                            <button class='reaction reaction-like reaction-like_like' data-reaction='Like' name='like' id='like".$like_id."'></button>
                        <button class='reaction  reaction-love reaction-love_like' data-reaction='love' id='dislike".$like_id."' name='dislike'></button> 
                </ul>
            </span>
         </div>";
                            // }else{
                            //     echo "<div class='riask-reaction'>
                            // <span class='like-btn'> 
                            // <span class='like-btn-emo like-btn-like like_".$like_id."'></span>
                            // <span class='like-btn-text like_btn_".$like_id."' style='color:#73B973;'> Liked</span>
                            //         <ul class='reactions-box'> 
                            //                     <button class='reaction reaction-like reaction-like_like' data-reaction='Like' name='like' id='like".$like_id."'></button>
                            //                 <button class='reaction  reaction-love reaction-love_like' data-reaction='love' id='dislike".$like_id."' name='dislike'></button> 
                            //         </ul>
                            //     </span>
                            //  </div>";
                            // }



?>

<script>
    $(".reaction-love").click(function (event) {

        var user_name_logged_in = '<?php echo $user_name_logged_in_val?>';
        var full_like_id = $(this).attr('id');
        var dislike_id = full_like_id.slice(7, full_like_id.len);
        var liked_text_val = $('.bottom_post_like_' + dislike_id + ' .like_btn_' + dislike_id).text()
        var user_profile_pic = '<?php echo $user_profile_pic?>';
        var post_title = '<?php echo $post_title ?>';
        var user_to = '<?php echo $user_to ?>';
        $.ajax({
            url: 'dislike_clicked.php',
            type: 'POST',
            data: {
                like_id_val: dislike_id,
                user_name_logged_in_val: user_name_logged_in,
                liked_text_val: liked_text_val,
                user_profile_pic: user_profile_pic,
                post_title: post_title,
                user_to: user_to
            },
            async: false,
            cache: false,
            error: function () {
                alert('error');
            },
            success: function (data) {
                $('.bottom_post_like_' + dislike_id).html(data);

            }
        })

        $.ajax({
            url: 'ajax/like_clicked_update_ui_ajax.php',
            type: 'POST',
            data: {
                like_id_val: dislike_id
            },
            async: false,
            cache: false,
            error: function () {
                alert('error');
            },
            success: function (data) {
                $('#likes_dislikes_display_number_' + dislike_id).html(data);

            }
        })
    });
    // remove like 
    $('.like-btn-text').click(function () {
        var like_id = $(this).attr('class');
        like_id = like_id.slice(23);
        var user_name_logged_in = '<?php echo $user_name_logged_in_val?>';
        var num_like_text_val = $(this).text()
        var like_val_class = $('.like_btn_' + like_id).text(); //DISLIKED, LIKED, LIKE
        var like_btn_text_val = $(this).text()
        var user_profile_pic = '<?php echo $user_profile_pic ?>';
        var post_title = '<?php echo $post_title ?>';
        var user_to = '<?php echo $user_to ?>';

        // alert(like_val_class)
        $.ajax({
            url: 'ajax/remove_like.php',
            type: 'POST',
            data: {
                like_id: like_id,
                user_name_logged_in: user_name_logged_in,
                like_val_class: like_val_class,
                like_btn_text_val: like_btn_text_val,
                user_profile_pic: user_profile_pic,
                post_title: post_title,
                user_to: user_to

            },
            async: false,
            cache: false,
            error: function () {
                alert('error');
            },
            success: function (data) {
                $('.bottom_post_like_' + like_id).html(data);
                if (like_val_class == 'Disliked') {

                    var liked_text_val = $('.like-details_disliked_' + like_id).text()
                    liked_text_val = parseInt(liked_text_val) - 1;
                    $('.like-details_disliked_' + like_id).text(liked_text_val)

                }
                if (like_val_class == ' Liked') {
                    var liked_text_val = $('.like-details_liked_' + like_id).text()
                    liked_text_val = parseInt(liked_text_val) - 1;
                    $('.like-details_liked_' + like_id).text(liked_text_val)
                }
            }
        })
    })
</script>