<?php

define("header",true);
include('header.php');
if (isset($_SESSION['user_name_log_in'])) {
    $user_name=$_SESSION['user_name_log_in'];
}else{
    header('location: index.php');
}

if (isset($_GET['post_id'])) {
    # code...
    $post_id=$_GET['post_id'];
 
}

include_once('like_dislike.php');
$like_dislike_obj=new likes_dislikes($con,$user_name);

$query_likes=mysqli_query($con,"SELECT * FROM likes where post_id='$post_id' and is_like='yes'");
$query_dislikes=mysqli_query($con,"SELECT * FROM likes where post_id='$post_id' and is_dislike='yes'");

$query_num_likes=mysqli_num_rows($query_likes);
$query_num_dislikes=mysqli_num_rows($query_dislikes);

if (isset($_GET['opened_from_notification'])) {
    $is_opened_from_notification=$_GET['opened_from_notification'];
    $is_opened_from_notification = substr($is_opened_from_notification,0,4);
    //once comment page opend notification with same post id disepear
    if ($is_opened_from_notification=='true') {
        $opened_query = mysqli_query($con, "UPDATE notifications SET opened='yes' WHERE user_to='$user_name' AND link LIKE '%=$post_id'");
    }
 
}
include_once('classes/user.php');

   
?>
<link rel="stylesheet" type="text/css" href="css/reaction.css" />
<link rel="stylesheet" href="dist/ui/trumbowyg.min.css">
<script src="dist/trumbowyg.min.js"></script>

<body style="background-color: #DAE0E6;overflow-x: hidden;">


    <section class='main-page-main'>
        <!--start navigation bar -->
        <nav id='main-nav'>
            <div class='user-main'>
                <a class="user-name-menu"><i class="fas fa-bars" style="font-size:1.8rem;"></i><span
                        class="user-name-menu-span">pasta 69</span></a>
            </div>

            </div>
            </div>
            <div class='search-main'>
                <i class=' fas fa-search' style='color:#222222;'></i>
                <input type='text' class='input-search input-search-main' placeholder='Search'>
            </div>
            <div class='navigation-icons'>
                <a href='#'><i class='fas fa-home'></i></a>
                <a href='#'><i class='far fa-bell'></i></a>
                <a href='#' class='fa-cog'><i class='fas fa-cog'></i></a>
                <a href='#'><i class='fas fa-pencil-alt'></i></a>
                <a href='#' class='fa-sign-out-alt'><i class='fas fa-sign-out-alt'></i></a>
            </div>

        </nav>
        <!--end navigation bar -->

        <!-- main content -->

        <div class='main-content'>
            <div class='empty-main-content1 empty-create-post'>
            </div>

            <div class='post post-create-post' style=''>
                <div class='post-header-create-post'>
                    <h2>Show Comments</h2>
                    <hr>
                    <div class='create-post-botton-btn'>

                    </div>
                </div>
                <div class='post_show_comments_container' style='border-radius:.2rem;padding:0rem 3rem;'>
                    <script></script>
                    <?php
                         $post='';
                         $query_load_comment=mysqli_query($con,"SELECT * FROM posts WHERE id='$post_id'");
                         if (mysqli_num_rows($query_load_comment)>0) {
                  
                             while($row=mysqli_fetch_array($query_load_comment)){
                                 $user_name_added_by=$row['added_by'];
                                 $body=$row['body'];
                                 $date_time=$row['date_added'];
                                 $likes=$row['likes'];
                                 $id=$row['id'];
                                $title =$row['title'];
                                $user_obj=new user($con,$user_name_added_by);

                                 $date_time_now = date('Y-m-d H:i:s');
                 
                                     $start_date = new DateTime($date_time); //Time of post
                                     $end_date = new DateTime($date_time_now); //Current time
                                     $interval = $start_date->diff($end_date); //Difference between dates 
                                     if($interval->y >= 1) {
                                         if($interval == 1)
                                             $time_message = $interval->y . ' year ago'; //1 year ago
                                         else 
                                             $time_message = $interval->y . ' years ago'; //1+ year ago
                                     }
                                     else if ($interval-> m >= 1) {
                                         if($interval->d == 0) {
                                             $days = ' ago';
                                         }
                                         else if($interval->d == 1) {
                                             $days = $interval->d . ' day ago';
                                         }
                                         else {
                                             $days = $interval->d . ' days ago';
                                         }
                 
                 
                                         if($interval->m == 1) {
                                             $time_message = $interval->m . ' month'. $days;
                                         }
                                         else {
                                             $time_message = $interval->m . ' months'. $days;
                                         }
                 
                                     }
                                     else if($interval->d >= 1) {
                                         if($interval->d == 1) {
                                             $time_message = 'Yesterday';
                                         }
                                         else {
                                             $time_message = $interval->d . ' days ago';
                                         }
                                     }
                                     else if($interval->h >= 1) {
                                         if($interval->h == 1) {
                                             $time_message = $interval->h . ' hour ago';
                                         }
                                         else {
                                             $time_message = $interval->h . ' hours ago';
                                         }
                                     }
                                     else if($interval->i >= 1) {
                                         if($interval->i == 1) {
                                             $time_message = $interval->i . ' minute ago';
                                         }
                                         else {
                                             $time_message = $interval->i . ' minutes ago';
                                         }
                                     }
                                     else {
                                         if($interval->s < 30) {
                                             $time_message = 'Just now';
                                         }
                                         else {
                                             $time_message = $interval->s . ' seconds ago';
                                         }
                                     }
                 
                                    
                    $post= "<div class='post_".$row['id']."'>
					<div class='top-post'>
					<div class='post-body'>
						<div class='post_empty'>

						</div>
						<div class=' post-body-text'>

							<div class='user-name-timer'>
							<div class='image-name-post'>
								<a href='profile.php?user_profile=$user_name_added_by'><img src='".$user_obj->get_profile_pic()."'  class='images-user-post' ></a>
									<div class='time_name_post'>
										<a href='profile.php?user_profile=$user_name_added_by'><span class='user-name-post user_name_posted'>$user_name_added_by</span></a>
										<span class='timer-post'>$time_message</span>
									</div>   
							</div>
							<div class='dropdown_post'>
                                        <img class='ellipsis_img_post ellipsis_img_post_".$row['id']."' src='images/ellipsis.png'>
                                        <div id='more_option_post_div more_option_post_div_".$row['id']."' class='dropdown-content_more_option_post dropdown-content_more_option_post_".$row['id']."'>";
                                        if ($row['added_by']==$user_name) {
                                            $post.="<div class='delete_post_div delete_post_div_".$row['id']."'><i class='far fa-times-circle' style='font-size: 1.3rem;'></i><span class='report_button_post'>delete</span></div>";
                                        }else{
                                            $post.="<div class='report_post_div report_post_div_".$row['id']."'><i class='fas fa-ban' style='font-size: 1.3rem;'></i><span class='report_button_post'>Report</span></div>";
                                        }
                                        $post.="</div>
                                        </div>
                                    </div>
                                    <h4 class='post_title post_title_".$row['id']."'>".$row['title']."</h4>
                                    <span class='commen_css_post_span commen_css_post_span_".$row['id']."'>$body </span>
                                    <div class='show_all_search_result_content_tags'>";
                                    $str = $row['post_tags'];
                                    $arr=explode(',',$str);
                                    $val=count($arr);
                                    $i=0;
                                    for($i=0;$i<$val-1;$i++){
                                    $post.='<span class="span_tag_value span_tag_value_'.$row["id"].'">'.$arr[$i].'</span>';
                                    }  


								   $post.=" </div>
						</div>
					</div>
					</div>
					<div class='likes_and_bottom_post".$id."'>
					<div class='likes_dislikes_display_number' id='likes_dislikes_display_number_".$id."'>
					<div class='like-stat'> <!-- Like statistic container-->
					<span class='like-emo'> <!-- like emotions container -->
					<i class='fas fa-flag' style='font-size:1.8rem ;color:#0080008c;'></i>
					</span>
					<span class='like-details'>".$query_num_likes."</span>
					</div>
					<div class='like-stat' style='margin-left:2rem;'> <!-- Like statistic container-->
					<span class='dislike-emo'> <!-- like emotions container -->
					<i class='fas fa-flag' style='font-size:1.8rem ;color:#FF6B6B;'></i>
					</span>
					<span class='like-details'>".$query_num_dislikes."</span>
					</div>
					 </div>
					".$like_dislike_obj->display_likes($id,$title)."
					</div>
				</div>";
                echo $post;
                         }

                         }
                     ?>



                </div>
                <div class='show_answeares' style='padding:3rem;'>
                    <h2 id='reply-show-replies'>Reply</h2>
                    <!-- Create the editor container -->
                    <div class='description-create-post'>
                        <h3 class='h3-create-post'>Tell us more about your question</h3>
                        <h4 class='h4-create-post' style='margin-top:2rem;'>Your description gives people the
                            information they need to help you answer your question.</h4>

                        <div id="trumbowyg-demo"></div>

                    </div>
                    <div class="reply_button_div">
                        <input type='submit' class='submit_comment submit_comment_<?php echo $post_id?>' value='Reply'
                            style='margin:1rem 0 2rem 0rem;'>
                    </div>

                    <!-- Initialize Quill editor -->

                    <h2>Answears</h2>
                    <div class="answear_container">
                        <?php
                         $post='';
                         $query_load_comment=mysqli_query($con,"SELECT * FROM comments WHERE post_id='$post_id'");
                         if (mysqli_num_rows($query_load_comment)>0) {
                  
                             while($row=mysqli_fetch_array($query_load_comment)){
                                 $posted_by=$row['posted_by'];
                                 $body=$row['comment_body'];
                                 $date_time=$row['date_added'];
                                 $id=$row['id'];
                                 $post_id=$row['post_id'];
                                 $date_time_now = date('Y-m-d H:i:s');                 
                                 $body = wordwrap($body,150,"<br>\n");
                                 $uesr_obj= new user($con,$posted_by);
                                     $start_date = new DateTime($date_time); //Time of post
                                     $end_date = new DateTime($date_time_now); //Current time
                                     $interval = $start_date->diff($end_date); //Difference between dates 
                                     if($interval->y >= 1) {
                                         if($interval == 1)
                                             $time_message = $interval->y . ' year ago'; //1 year ago
                                         else 
                                             $time_message = $interval->y . ' years ago'; //1+ year ago
                                     }
                                     else if ($interval-> m >= 1) {
                                         if($interval->d == 0) {
                                             $days = ' ago';
                                         }
                                         else if($interval->d == 1) {
                                             $days = $interval->d . ' day ago';
                                         }
                                         else {
                                             $days = $interval->d . ' days ago';
                                         }
                 
                 
                                         if($interval->m == 1) {
                                             $time_message = $interval->m . ' month'. $days;
                                         }
                                         else {
                                             $time_message = $interval->m . ' months'. $days;
                                         }
                 
                                     }
                                     else if($interval->d >= 1) {
                                         if($interval->d == 1) {
                                             $time_message = 'Yesterday';
                                         }
                                         else {
                                             $time_message = $interval->d . ' days ago';
                                         }
                                     }
                                     else if($interval->h >= 1) {
                                         if($interval->h == 1) {
                                             $time_message = $interval->h . ' hour ago';
                                         }
                                         else {
                                             $time_message = $interval->h . ' hours ago';
                                         }
                                     }
                                     else if($interval->i >= 1) {
                                         if($interval->i == 1) {
                                             $time_message = $interval->i . ' minute ago';
                                         }
                                         else {
                                             $time_message = $interval->i . ' minutes ago';
                                         }
                                     }
                                     else {
                                         if($interval->s < 30) {
                                             $time_message = 'Just now';
                                         }
                                         else {
                                             $time_message = $interval->s . ' seconds ago';
                                         }
                                     }
                 
                                     $post= "<div class='post_".$row['id']."'>
                                     <div class='top-post'>
                                     <div class='post-body'>
                                     <div class='post-body-user-image'>
                                     <div class='color-post-body'></div>
                                 
                                 </div>
                                          <div class=' post-body-text'>
                                 
                                 <div class='user-name-timer'>
                                 <div class='image-name-post'>
                                     <a href='#'><img src='".$user_obj->get_profile_pic()."'  class='images-user-post' ></a>
                                         <div class='time_name_post'>
                                             <a href='#'><span class='user-name-post'>$user_name</span></a>
                                             <span class='timer-post'>$time_message</span>
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
                                 
                                     <div class='likes_and_bottom_post".$row['id']."'>
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
                                         <form action='show_comments.php?post_id=".$row['id']."' method='POST' >
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
                           
                         }
                         }else{
                         echo 'no posts to show';
                     }
                     ?>

                    </div>
                </div>
            </div>
            <!-- **************** -->
            <div class='side'>
                <div class='tags' style='font-size:3rem;margin-top:0rem'>
                    <div class='header-side'>
                        <h3 class='header-side-text'>Tags that you may like</h3>
                    </div>
                    <div class='tags-friend-content' style='display flex;flex-direction:column;'>
                        <div class=''><img src='images/phpimg.png' alt=''><a href='#'>PHP</a></div>
                        <hr>
                        <div class=''><img src='images/java.webp' alt=''><a href='#'>Java</a></div>
                        <hr>
                        <div class=''><img src='images/cpp.png' alt=''><a href='#'>Cpp</a></div>
                    </div>
                    <div class='span-button'> <a href='#'>Show more</a></div>
                </div>
                <div class='ads first-ads'>
                    <span> advertisment</span>
                </div>
                <div class='follow-friend'>
                    <div class='header-side'>
                        <h3 class='header-side-text'>Search for a friend</h3>
                    </div>
                    <div class='tags-friend-content' style='display flex;flex-direction:column;'>
                        <div class='input-friends-content'><input class='input-search input-search-friend-content'
                                type='text' placeholder='search here'></div>
                        <div class=''><img src='images/phpimg.png' alt=''><a href='#'>PHP</a></div>
                        <hr>
                        <div class=''><img src='images/java.webp' alt=''><a href='#'>Java</a></div>
                        <hr>
                        <div class=''><img src='images/cpp.png' alt=''><a href='#'>Cpp</a></div>
                        <hr>
                        <div class=''><img src='images/java.webp' alt=''><a href='#'>Java</a></div>
                        <hr>
                        <div class=''><img src='images/phpimg.png' alt=''><a href='#'>PHP</a></div>
                        <hr>
                    </div>
                    <div class='span-button'> <a href='#'>Show more</a></div>
                </div>
                <!-- <div class='create-post-side'>
                     <div class='header-side header-side-create-post-side'>
                         <h3 class='header-side-text header-side-text-create-post'>Share something with the world</h3>
                     </div>
                     <div class='button-create-post'>
                         <div class='span-button span-button-create-post'> <a href='#'>Create a Post</a></div>
                     </div>
                 </div> -->

                <div class='ads second-ads'>
                    <span> advertisment</span>
                </div>
                <div class='footer'>
                    <div class='top-footer'>
                        <div class='top-footer1'>
                            <div class=''><a href='#'>Help</a></div>
                            <div class=''><a href='#'>About</a></div>
                            <div class=''><a href='#'>Terms</a></div>
                        </div>
                        <div class='top-footer2'>
                            <div class=''><a href='#'>Join Our Team</a></div>
                            <div class=''><a href='#'>Privacy Policy</a></div>
                            <div class=''><a href='#'>&copy;2019 Riask</a></div>
                        </div>
                    </div>
                    <div class='botton-footer'><a href='#'>created with &#10084; by khoubaib Boughalmi</a></div>

                </div>
            </div>
    </section>
    <div class='empty-main-content2'></div>
                     

    <div class='slide-menu-wraper'>
        <div class='slide-menu'>
            <div class='slide-menu-header'>
                <h3>Account info</h3>
                <a href='#'>
                    <p class='slide-menu-header-close'>+</p>
                </a>
            </div>
            <hr>
            <?php 
                $user_obj=new user($con,$user_name);
            ?>
            <div class='slide-menu-profile-pic'>
                <img src='<?php echo $user_obj->get_profile_pic() ?>' alt='' style='width:4.3rem;'>
                <a href='profile.php?user_profile=<?php echo $user_obj->get_user_name()?>'>
                    <p><?php echo $user_obj->get_first_last_name() ?></p>
                </a>
            </div>
            <div class='number-posts'>
                <p><?php echo $user_obj->followers() .'Follower'?></p>
            </div>
            <hr>

            <div class='slide-menu-options'>
                <div class='slide-menu-option'>
                    <a href='profile.php?user_profile=<?php echo $user_obj->get_user_name()?>'>
                        <i class='fas fa-user' style='font-size:1.8rem;'></i>
                            <p>My Profile</p>
                        </a>
                </div>
                <div class='slide-menu-option'>
                    <a href="main.php">
                        <i class='fas fa-home' style='font-size:1.8rem;'></i>
                            <p>Home</p>
                        </a>
                </div>
                <div class='slide-menu-option'>
                    <a href="create-post.php">
                        <i class='fas fa-pencil-alt' style='font-size:1.8rem;'></i>
                            <p>Create A Post</p>
                        </a>
                </div>
                <div class='slide-menu-option'>
                    <a href="settings.php">
                        <i class='fas fa-cog' style='font-size:1.8rem;'></i>
                            <p>User Settings</p>
                        </a>
                </div>
                <hr>
                <div class='slide-menu-option'>
                    <a href='#'>
                        <p style='margin-left:0;'>Settings And Privacy</p>
                    </a>
                </div>
                <div class='slide-menu-option'>
                    <a href='#'>
                        <p style='margin-left:0;'>Help</p>
                    </a>
                </div>
                <div class='slide-menu-option'>
                    <a href='#'>
                        <p style='margin-left:0;'>Log Out</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('.user-name-menu').addEventListener('click', function () {
            document.querySelector('.slide-menu-wraper').style.display = 'block';
        });

        document.querySelector('.slide-menu-header-close').addEventListener('click', function () {
            document.querySelector('.slide-menu-wraper').style.display = 'none';
        });

        $('#trumbowyg-demo').trumbowyg({
            btns: [
                ['undo', 'redo'], // Only supported in Blink browsers
                ['formatting'],
                ['strong', 'em'],
                ['superscript', 'subscript'],
                ['link'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['unorderedList', 'orderedList'],
                ['horizontalRule'],
                ['removeformat'],
            ]
        });

        // to reload page when user click back button

        window.onpopstate = function () {
            location.reload();
        }

        // to prevent resubmition of post method when user reload page
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // like button clicked
        $(".reaction-like").click(function (event) {

            var user_name_logged_in = '<?php echo $user_name?>';
            var full_like_id = $(this).attr('id');
            var like_id = full_like_id.slice(4, full_like_id.len);
            var liked_text_val = $('.bottom_post_like_' + like_id + ' .like_btn_' + like_id).text()


            $.ajax({
                url: 'like_clicked.php',
                type: 'POST',
                data: {
                    like_id_val: like_id,
                    user_name_logged_in_val: user_name_logged_in,
                    liked_text_val: liked_text_val
                },
                async: false,
                cache: false,
                error: function () {
                    alert('error');
                },
                success: function (data) {
                    $('.bottom_post_like_' + like_id).html(data);

                }
            })

            $.ajax({
                url: 'ajax/like_clicked_update_ui_ajax.php',
                type: 'POST',
                data: {
                    like_id_val: like_id
                },
                async: false,
                cache: false,
                error: function () {
                    alert('error');
                },
                success: function (data) {
                    $('#likes_dislikes_display_number_' + like_id).html(data);

                }
            })
        });

        $(".reaction-love").click(function (event) {

            var user_name_logged_in = '<?php echo $user_name?>';
            var full_like_id = $(this).attr('id');
            var dislike_id = full_like_id.slice(7, full_like_id.len);
            var liked_text_val = $('.bottom_post_like_' + dislike_id + ' .like_btn_' + dislike_id).text()
            $.ajax({
                url: 'dislike_clicked.php',
                type: 'POST',
                data: {
                    like_id_val: dislike_id,
                    user_name_logged_in_val: user_name_logged_in,
                    liked_text_val: liked_text_val

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

        // mark post
        $('.bottom_post_componment_mark_post').click(function () {
            var all_tags = '';
            var post_marked_id = $(this).attr('id');
            post_marked_id = post_marked_id.slice(33);
            var user_name_logged_in = '<?php echo $user_name?>';
            var body = $('.commen_css_post_span_' + post_marked_id).text();
            var title = $('.post_title_' + post_marked_id).text();
            var tags = $('.span_tag_value_' + post_marked_id).each(function () {
                tags = $(this).text() + ',';
                all_tags = all_tags.concat(tags);
            })
            var mark_full_id = $(this).attr('id');
            var mark_text_value = $('#bottom_post_componment_mark_post_' + post_marked_id + ' .span-icon-name')
                .text();
            if (mark_text_value == 'Mark') {
                // mark the post
                $.post("ajax/mark_post.php", {
                    post_marked_id: post_marked_id,
                    user_name_logged_in: user_name_logged_in,
                    body: body,
                    title: title,
                    tags: all_tags
                }, function (data) {
                    $('#bottom_post_componment_mark_post_' + post_marked_id).html(data)
                    simpleNotify.notify('Post has been saved successfully &#128516;', 'good');

                })
            } else {
                // remove the mark

                $.ajax({
                    url: 'ajax/remove_marked_post_ajax.php',
                    type: 'POST',
                    data: {
                        post_id:post_marked_id,
                        user_name_logged_in: user_name_logged_in

                    },
                    error: function () {
                        alert('error');
                    },
                    success: function (data) {
                        $('#bottom_post_componment_mark_post_'+post_marked_id).html(data)
                    }
                })
            }
        })
        // toggle between hiding and showing the dropdown content 

        $('.ellipsis_img_post').click(function () {
            var ellipsis_id = $(this).attr('class');
            var ellipsis_id = ellipsis_id.slice(36);
            $(".dropdown-content_more_option_post_" + ellipsis_id).toggle("show");
        })
        // report a post
        $('.report_post_div').click(function () {
            var report_id = $(this).attr('class');
            var report_id = report_id.slice(32);
            var user_name_logged_in = '<?php echo $user_name?>';
            $.ajax({
                url: 'ajax/report_post_ajax.php',
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
        $('.delete_post_div').click(function () {
            var post_id = $(this).attr('class');
            var post_id = post_id.slice(32);
            var user_name_logged_in = '<?php echo $user_name?>';
            $.ajax({
                url: 'ajax/delete_post_ajax.php',
                type: 'POST',
                data: {
                    post_id: post_id
                },
                error: function () {
                    alert('error');
                },
                success: function (data) {
                    $('.post_' + post_id).hide('slow', function () {
                        $('.post_' + post_id).remove();
                    });
                }
            })
        })

        $('.submit_comment').click(function () {
            var post_id = $(this).attr('class');
            var post_id = post_id.slice(30);
            var body = $('#trumbowyg-demo').html()
            var user_name_logged_in = '<?php echo $user_name?>';
            var user_to = $('.user_name_posted').text();
            $.ajax({
                url: 'ajax/create_comment.php',
                type: 'POST',
                data: {
                    post_id: post_id,
                    body: body,
                    user_to: user_to,
                    user_name_logged_in: user_name_logged_in,
                },
                error: function () {
                    alert('error');
                },
                success: function (data) {
                    simpleNotify.notify('Comment created successfully &#128522;', 'good');
                    $(".answear_container").append(data);
                    $("html, body").animate({
                        scrollTop: $(document).height() - $(window).height()
                    });

                }
            })

            // alert(user_to)

        })
    </script>
</body>

</html>