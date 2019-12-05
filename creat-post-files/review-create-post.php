<?php
require '../db.php';

if (isset($_POST['user_logged_in'])) {
    $user_name = $_POST['user_logged_in'];
}
$query_load_user=mysqli_query($con,"SELECT * FROM users where user_name='$user_name'");
$user_array=mysqli_fetch_array($query_load_user);
$timezone=  date_default_timezone_set('Africa/Tunis');

?>
<div class='review_create_post'>
<h3 class="h3-create-post">This is a preview about your post</h3>
    <h4 class="h4-create-post" style="margin-top:2rem;">Click Finish to post</h4>
                            <div class='top-post'>
                            <div class='post-body'>
                                <div class='post_empty'>

                                </div>
                                
                                <div class=' post-body-text'>

                                    <div class='user-name-timer'>
                                    <div class='image-name-post'>
                                        <a href='#'><img src='<?php echo $user_array['profile_pic']?>'  class='images-user-post' ></a>
                                            <div class='time_name_post'>
                                                <a href='#'><span class='user-name-post'><?php echo $user_array['user_name']?></span></a>
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
                                    <h4 class="title_review_create_post">title</h4>
                                    <span class='commen_css_post_span'> </span>
                                    <div class='show_all_search_result_content_tags'>
                              
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class='likes_and_bottom_post_0'>
                            <div class='likes_dislikes_display_number' id='likes_dislikes_display_number_0' style="margin:2rem;">
                            <div class='like-stat'> <!-- Like statistic container-->
							<span class='like-emo'> <!-- like emotions container -->
                            <img src="images/green_flag.png" style="width:1.8rem;" alt="">							</span>
							<span class='like-details'>0</span>
                            </div>
                            <div class='like-stat' style='margin-left:2rem;'> <!-- Like statistic container-->
							<span class='dislike-emo'> <!-- like emotions container -->
                            <img src="images/red_flag.png" style="width:1.8rem;" alt="">							</span>
							</span>
							<span class='like-details'>0</span>
                            </div>
                             </div>
                             <hr>

<div class='bottom-post'>
            <div class='bottom_post_like_0'>
            <div class='riask-reaction'>
            <span class='like-btn' style="display:flex"> 
            <span class='like-btn-emo like-btn-default '><img src="images/empty_flag.png" style='width:2.4rem;' alt=""></span>
            <span class='like-btn-text'>Like</span>        
            </span>
             </div>
            </div>
            <div class='bottom_post_componment_like_' id='comment_0'>
                <form action='show_comments.php?post_id=$post_id' method='POST' >
                <img src="images/comment.png" style='width:2.4rem;' alt=""></span>
                    <input type='submit' value='Comments' name='span-icon-name'class='span-icon-name'>
                    </form>
                </div>
                <div class='bottom_post_componment_mark_post' id='bottom_post_componment_mark_post_0'>
                <img src="images/mark.png" style='width:2.4rem;' alt=""></span>
                    <span class='span-icon-name'>Mark</span>
                </div>
                
                </div>
                <hr>
                </div>
                </div>
    <br>
        <div class="next_privious_botton_flex">
        <span class="next_previous_button_create_post previous_botton_title">Previous</span>
        <span class="next_previous_button_create_post finish_botton_title">Finish</span>
    </div>
<script>

            $('.previous_botton_title').click(function(){
                var user_logged_in = '<?php echo $user_name; ?>';
                $.ajax({
                url: 'creat-post-files/description-create-post.php',
                type: 'POST',
                data:{
                user_logged_in:user_logged_in
                },
                error: function(){
                    alert('error');
                },
                success:function (data) {
                    $('.ajax-insert').html(data);
                    
                }
                })
                
                $('.botton3').removeClass('active_btn_tag');
                    $('.botton2').addClass('active_btn_tag');
            })
    
            $('.title_review_create_post').html(sessionStorage.getItem("title"));
            $('.commen_css_post_span').html(sessionStorage.getItem("body"))
            var tags_str=sessionStorage.getItem("tags");
            tab_tags = tags_str.split(",");
            for (let i = 0; i < tab_tags.length-1; i++) {
                $('.show_all_search_result_content_tags').append('<span>'+tab_tags[i]+'</span>');
                
            }

            $('.finish_botton_title').click(function(){
                var user_logged_in = '<?php echo $user_name; ?>';
                var body = sessionStorage.getItem("body");
                var tags = sessionStorage.getItem("tags");
                var title = sessionStorage.getItem("title");
                var selected_category_val = sessionStorage.getItem("selected_category_val");
                $.ajax({
                url: 'submit_post.php',
                type: 'POST',
                data:{
                user_logged_in:user_logged_in,
                body:body,
                title:title,
                tags:tags,
                selected_category_val:selected_category_val
                },
                error: function(){
                    alert('error');
                },
                success:function (data) {
                    window.location.replace("main.php");
                    
                }
                })
                
            })
</script>