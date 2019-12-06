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
$user_obj = new user($con,$user_name);
include('classes/notification.php');
$notification_obj=new notification($con,$user_name);
$num_notification=$notification_obj->num_notification($user_name);

// get user loged in pdp
 
$pdp = $user_obj->get_profile_pic();
   
?>
<link rel="stylesheet" type="text/css" href="css/reaction.css" />
<link rel="stylesheet" href="dist/ui/trumbowyg.min.css">
<script src="dist/trumbowyg.min.js"></script>

<body style="background-color: #DAE0E6;overflow-x: hidden;">


    <section class='main-page-main'>
        <!--start navigation bar -->
        <nav id="main-nav">
            <div class="user-main">
                <a class="user-name-menu"><img src="images/icons/bars.png" style="height:2rem;width:2rem;" alt=""><span
                        class="user-name-menu-span"><?php echo $user_obj->get_first_last_name() ?></span></a>
            </div>
            </div>
            </div>
            <div class="search-main">
                <img src="images/icons/loop.png" alt="" class="fa-search" style='height:2.1rem;'>

                <!-- <i class=" fas fa-search" style="color:#222222;"></i> -->
                <input type="text" class="input-search input-search-main" placeholder="Search for a question">
            </div>
            <div class="navigation-icons">
                <a href="main.php" class="home_icon"><img src="images/icons/home.png" alt=""></a>
                <div class="notification_bell notification_container ">
                    <img src="images/icons/notification.png" alt="" class="fa-bell dropbtn"
                        style="width:4rem;height:4rem;" onclick="drop_down_notification_function()">
                    <!-- show the number of notification -->
                    <?php 
                if ($num_notification>0) {
                    echo "<span class='notification_bell_num'>$num_notification</span>";
                }
                ?>

                    <div id='myDropdown' class='dropdown-content' style="overflow-y: scroll; height:375px;">
                        <div class='dropdown_notification_header'><span>Notification</span></div>

                        <?php
                echo($notification_obj->load_notification());                
                ?>

                    </div>
                </div>
                <a href="settings.php" class="fa-cog"><img src="images/icons/settings.png" alt=""></a>
                <a href="create-post.php"><img src="images/icons/pencil.png" alt=""></a>
                <a href="classes/log_out.php" class="fa-sign-out-alt"><img src="images/icons/logout.png" alt=""></a>
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
                    <div class='create-post-botton-btn' style="padding: 0">
                        <img src="images/icons/comment.png" alt="" style="height:3rem;margin-right: 2rem;">
                    </div>
                </div>
                <hr style='margin:.5rem 3rem'>
                <div class='post_show_comments_container'>
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
                                    <h4 class='post_title post_title_".$row['id']." hyphens'>".$row['title']."</h4>
                                    <span class='commen_css_post_span commen_css_post_span_".$row['id']." hyphens'>$body </span>
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
                    <img src='images/green_flag.png' style='height: 1.8rem;' alt=''>
					</span>
					<span class='like-details'>".$query_num_likes."</span>
					</div>
					<div class='like-stat' style='margin-left:2rem;'> <!-- Like statistic container-->
					<span class='dislike-emo'> <!-- like emotions container -->
                    <img src='images/red_flag.png' style='height: 1.8rem;' alt=''>
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
                    
                        <div id="trumbowyg-demo"></div>

                    <div class="reply_button_div">
                        <input type='submit' class='submit_comment submit_comment_<?php echo $post_id?>' value='Reply'
                            style='margin:1rem 0 2rem 0rem;'>
                    </div>

                    <!-- Initialize Quill editor -->

                    <h2>Answers</h2>
                    <div class="answear_container">
                        <?php
                         $post='';
                         $query_load_comment=mysqli_query($con,"SELECT * FROM comments WHERE post_id='$post_id' order by id asc");
                         if (mysqli_num_rows($query_load_comment)>0) {
                  
                             while($row=mysqli_fetch_array($query_load_comment)){
                                if (strstr($row['comment_reported_by'],$user_name)==false) {
                                 $posted_by=$row['posted_by'];
                                 $body=$row['comment_body'];
                                 $date_time=$row['date_added'];
                                 $id=$row['id'];
                                 $post_id=$row['post_id'];
                                 $date_time_now = date('Y-m-d H:i:s');                 
                                 $body = wordwrap($body,150,"<br>\n");
                                 $uesr_obj= new user($con,$posted_by);
                                 $user_profile_pic =$row['user_profile_pic'];
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
                 
                                     $post= "<div class='comment_".$row['id']."'>
                                     <div class='top-post'>
                                     <div class='post-body'>
                                     <div class='post-body-user-image'>
                                     <div class='color-post-body'></div>
                                 
                                 </div>
                                          <div class=' post-body-text'>
                                 
                                 <div class='user-name-timer'>
                                 <div class='image-name-post'>
                                     <a href='#'><img src='".$user_profile_pic."'  class='images-user-post' ></a>
                                         <div class='time_name_post'>
                                             <a href='#'><span class='user-name-post'>$posted_by</span></a>
                                             <span class='timer-post'>$time_message</span>
                                         </div>   
                                 </div>
                                 <div class='dropdown_comment'>
                                 <img class='ellipsis_img_comment ellipsis_img_comment_".$row['id']."' src='images/ellipsis.png' style='height:2rem'>
                                 <div id='more_option_comment_div more_option_comment_div_".$row['id']."' class='dropdown-content_more_option_comment dropdown-content_more_option_comment_".$row['id']."'>";
                                 if ($row['posted_by']==$user_name) {
                                     $post.="<div class='delete_comment_div delete_comment_div_".$row['id']."'><i class='far fa-times-circle' style='font-size: 1.3rem;'></i><span class='report_button_comment'>delete</span></div>";
                                 }else{
                                     $post.="<div class='report_comment_div report_comment_div_".$row['id']."'><i class='fas fa-ban' style='font-size: 1.3rem;'></i><span class='report_button_comment'>Report</span></div>";
                                 }
                                 $post.="</div>
                                 </div>
                             </div>
                                 <h4 class='title_review_create_comment'></h4>
                                 <span class='commen_css_comment_span' style='font-size: 1.3rem;font-weight: bold;padding-left: 2rem;'> $body</span>
                                 <div class='show_all_search_result_content_tags'>
                                 
                                 </div>";
                                 
                                 
                                 $post.="
                                         </div>
                                     </div>
                                     </div>
                                 
                                     <!-- <div class='likes_and_bottom_post".$row['id']."'>
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
                                         <form action='show_comments.php?post_id=".$row['id']."' method='POST' >
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
              
                <div class='ads first-ads' style="margin-top:0rem">
                    <span> advertisment</span>
                </div>
                
               
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
                    <div class="botton-footer"><a href="#">created with &#128151; by khoubaib Boughalmi</a></div>

                </div>
            </div>
    </section>
    <div class='empty-main-content2'></div>


    <div class='slide-menu-wraper'>
        <div class='slide-menu'>
            <div class="close_slide">
                +
            </div>
            <div class='slide-menu-header'>
                <h3>Account info</h3>

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
                <p><?php echo $user_obj->followers() .' Follower'?></p>
            </div>
            <hr>

            <div class='slide-menu-options'>
                <div class="slide-menu-option">
                    <img src="images/icons/home.png" alt="" style="height:2.1rem;">
                    <a href="main.php">
                        <p>Home Page</p>
                    </a>
                </div>
                <div class="slide-menu-option">
                    <img src="images/icons/user.png" alt="" style="height:2.1rem;">
                    <a href="profile.php?user_profile=<?php echo $user_name?>">
                        <p>Profile Page</p>
                    </a>
                </div>

                <div class="slide-menu-option">
                    <a href="create-post.php">
                        <img src="images/icons/pencil.png" alt="" style="height:2.1rem;">
                        <p>Create A Post</p>
                    </a>
                </div>
                <div class="slide-menu-option">
                    <a href="settings.php">
                        <img src="images/icons/settings.png" alt="" style="height:2.1rem;">
                        <p>User Settings</p>
                    </a>
                </div>
                <div class="slide-menu-option">
                    <img src="images/icons/mark.png" alt="" style="height:2.1rem;">
                    <a href="marked_post_page.php?user_profile=<?php echo $user_name?>">
                        <p>Marked Post</p>
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
                    <a href='classes/log_out.php'>
                        <p style='margin-left:0;'>Log Out</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="main_search_container">

        <div class="main_search_box_container">

            <div class="main_search_result_header">
                <span>Search results</span>
            </div>
            <div class="main_search_result_content_all">

            </div>

        </div>
    </div>
    <script>
        // display the slide bar
        function display_slide(x) {
            if (x.matches) { // If media query matches
                $('.user-name-menu').click(function () {
                    $('.slide-menu').css('display', 'block')
                })
            }
        }

        $('.close_slide').click(function () {
            $('.slide-menu').css('display', 'none')

        })

        var x = window.matchMedia("(max-width: 1100px)")
        display_slide(x) // Call listener function at run time
        x.addListener(display_slide) // Attach listener function on state changes

        document.querySelector('.user-name-menu').addEventListener('click', function () {
            document.querySelector('.slide-menu-wraper').style.display = 'block';
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

        // show and hide main search results 
        $('.input-search-main').focus(function () {
            $('.main_search_container').css('display', 'block')
            $('.main_search_result_content_all').html(
                '<div><img src="images/search_loop.jpg" style="width:25rem;height:26rem;margin-left: 19rem;"alt=""></div>'
            )

        })
        // transition: background-color .3s;
        $('.main-content').click(function () {
            $('.main_search_container').css('display', 'none')

        })

        // show main search result 
        $(".input-search-main").keyup(function () {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            var input_search_val = $(this).val()

            if (input_search_val.length > 0) {

                if (keycode == '13') {
                    window.location.replace("show_all_search_results.php?q=" + input_search_val);
                }
                $.post("ajax/main_search_result_ajax.php", {

                    input_search_val: input_search_val


                }, function (data) {
                    $('.main_search_box_container').html(data)
                })
            } else {
                $('.main_search_result_content_all').html(
                    '<div><img src="images/search_loop.jpg" style="width:25rem;height:26rem;margin-left: 19rem;"alt=""></div>'
                )

            }

        })


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
                        post_id: post_marked_id,
                        user_name_logged_in: user_name_logged_in

                    },
                    error: function () {
                        alert('error');
                    },
                    success: function (data) {
                        $('#bottom_post_componment_mark_post_' + post_marked_id).html(data)
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

        // toggle comment ellipsis
        $('.ellipsis_img_comment').click(function () {
            var ellipsis_id = $(this).attr('class');
            var ellipsis_id = ellipsis_id.slice(42);
            $(".dropdown-content_more_option_comment_" + ellipsis_id).toggle("show");
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

        // submit comment
        $('.submit_comment').click(function () {
            var post_id = $(this).attr('class');
            var post_id = post_id.slice(30);
            var body = $('#trumbowyg-demo').html()
            var user_name_logged_in = '<?php echo $user_name?>';
            var user_to = $('.user_name_posted').text();
            var pdp = '<?php echo $pdp ?>'
            $.ajax({
                url: 'ajax/create_comment.php',
                type: 'POST',
                data: {
                    post_id: post_id,
                    body: body,
                    user_to: user_to,
                    user_name_logged_in: user_name_logged_in,
                    pdp: pdp
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

            // alert(post_id.match(/[^/]*/i)[0])
        })

        // dropdown menu notification

        function drop_down_notification_function() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function (event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }

        // notification bell was clicked update notification view
        document.querySelector('.notification_bell').addEventListener("click", function () {

            document.querySelector(".notification_bell_num").style.display = "none";

        })

        // notification  was opened update notification opened
        $('.dropdown_notification_container').click(function () {

            var notification_id = $(this).attr('class')
            var notification_id = notification_id.substr(70);

            var notification_type = $(this).attr('class')
            var notification_type = notification_type.substr(64, 5);
        })
    </script>
</body>

</html>