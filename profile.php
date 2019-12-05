<?php
define("header",true);
include('header.php');
if (isset($_GET['user_profile'])) {
    $user_profile=$_GET['user_profile'];
}
include('classes/profile_posts.php');

if (isset($_SESSION['user_name_log_in'])) {
    $user_name_logged_in=$_SESSION['user_name_log_in'];
    
}else{
    header('location: index.php');
}
include('classes/user.php');
$user_profile =ucfirst($user_profile);
$user_obj=new user($con,$user_profile);
$user_logged_in_obj = new user($con,$user_name_logged_in);

// get user profile pic 
$user_profile_pic = $user_obj->get_profile_pic();
$user_profile_obj=new profile_posts($con,$user_name_logged_in,$user_profile,$user_profile_pic);
include('classes/notification.php');
$notification_obj=new notification($con,$user_name_logged_in);
$num_notification=$notification_obj->num_notification($user_name_logged_in);


?>
<link rel="stylesheet" type="text/css" href="css/reaction.css" />
<!-- jQuery for Reaction system -->

<body style="background-color: #DAE0E6;overflow-x: hidden;">

     
    <section class="main-page-main">
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
                    <img src="images/icons/notification.png" alt="" class="fa-bell dropbtn" style="width:4rem;height:4rem;" onclick="drop_down_notification_function()">
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

<div class="main-content">
    <div class="empty-main-content1 empty-create-post">
        
        </div>
        
        <div class="post post-create-post">
            <div class="post-header-create-post">
                <h2>Profile</h2>
                <img src="images/icons/user.png"  style='width:3rem;height:3rem;margin: 0 2.5rem;' alt="">
            </div>
            <hr style="margin: 0rem 3rem;">
            <div class="profile_post_container">
                <?php
            $user_profile_obj->load_profile_posts($con,$user_profile,$user_name_logged_in,$user_profile_pic);
            ?>
            </div>
        </div>
            <!-- **************** -->
            <div class="side" style="width:31rem">
                <div class="tags_profile" style="font-size:3rem;">
                    <div class="header-side">
                        <h3 class="header-side-text">Public profile info</h3>
                    </div>
                    <div class="tags-friend-content profile-content-info" style="display: flex;flex-direction:column;">
                        <div class="image_profile">
                        <img src="<?php echo $user_obj->get_profile_pic()?>" alt="" id="image_profile">
                        </div>
                        <div class="user_profile_info">
                            <p class="user_profile_info_name">@<?php echo $user_profile?></p>
                        </div>
                  
                            <p class="user_profile_info_posts_followers"><?php echo $user_obj->get_bio()?></p>
                    </div>
                    <?php
                     if($user_profile==$user_name_logged_in){
                        echo '<div class="span_botton_container_profile">
                        <a href="create-post.php">
                        <span class="span-button span-button_profile" style="height:2rem;width: 27rem;">Create Post</span>
                        </a>
                        </span>
                        </div>';

                     }
                     else if($user_obj->is_friend($user_profile)){
                        echo '
                        <div class="span_botton_container_profile">
                        <span class="span-button span-button_profile span-button_profile_infollow infollow_'.$user_profile.'">Infollow</span>
                        </div>';
                        //  if (isset($_POST['span-button_profile_infollow'])) {
                        //     $old_followers=$row['followers'];
                        //     $user_profile_comma=','.$user_profile.',';
                        //     $new_followers=str_replace($user_profile_comma, '',$old_followers);
                        //     $query_update_followers=mysqli_query($con,"UPDATE `users` SET `followers`='$new_followers'WHERE user_name='$user_name_logged_in'");
                        //     echo "<script>location.reload();</script>";
                        // }
                       
                     }else if($user_obj->is_friend($user_profile)==false){
                        echo '
                        <div class="span_botton_container_profile"><span class="span-button span-button_profile span-button__profile__follow follow___'.$user_profile.'">Follow</span></div>';

                        // if (isset($_POST['span-button_profile_follow'])) {
                        //     $old_followers=$row['followers'];
                        //     $new_followers=$old_followers.','.$user_profile.',';
                        //     $query_update_followers=mysqli_query($con,"UPDATE `users` SET `followers`='$new_followers'WHERE user_name='$user_name_logged_in'");
                        //     echo "<script>location.reload();</script>";
                        // }


                     }
                     ?>
                </div>
                <div class="footer-create-post">
                    <div class="top-footer">
                        <div class="top-footer1">
                            <div class=""><a href="#">Help</a></div>
                            <div class=""><a href="#">About</a></div>
                            <div class=""><a href="#">Terms</a></div>
                        </div>
                        <div class="top-footer2">
                            <div class=""><a href="#">Join Our Team</a></div>
                            <div class=""><a href="#">Privacy Policy</a></div>
                            <div class=""><a href="#">&copy;2019 Riask</a></div>
                        </div>
                    </div>
                    <div class="botton-footer"><a href="#">created with &#128151; by khoubaib Boughalmi</a></div>

                </div>
            </div>
        </section>
        <div class="empty-main-content2"></div>
        
       
    <div class="slide-menu-wraper">
        <div class="slide-menu">
        <div class="close_slide">
                +
            </div>
            <div class="slide-menu-header">
                <h3>Account info</h3>
            </div>
            <hr>
            <div class="slide-menu-profile-pic">
                <a href="<?php echo 'profile.php?user_profile='.$user_logged_in_obj->get_user_name()?>"><img
                        src="<?php echo $user_logged_in_obj->get_profile_pic()?>" alt=""></a>
                <a href="<?php echo 'profile.php?user_profile='.$user_logged_in_obj->get_user_name()?>">
                    <p><?php echo $user_logged_in_obj->get_first_name().' '.$user_logged_in_obj->get_last_name()?></p>
                </a>            </div>
            <div class="number-posts">
            <p><?php echo $user_logged_in_obj->followers();?> Followers</p>
            </div>
            <hr>
    
            <div class="slide-menu-options">
                <div class="slide-menu-option">
                    <img src="images/icons/home.png" alt=""  style="height:2.1rem;">
                    <a
                        href="main.php">
                        <p>Home Page</p>
                    </a>
                </div>
                <div class="slide-menu-option">
                    <img src="images/icons/user.png" alt=""  style="height:2.1rem;">
                    <a
                        href="profile.php?user_profile=<?php echo $user_name_logged_in?>">
                        <p>Profile Page</p>
                    </a>
                </div>
                
                <div class="slide-menu-option">
                    <a href="create-post.php">
                    <img src="images/icons/pencil.png" alt=""  style="height:2.1rem;">
                    <p>Create A Post</p>
                    </a>
                </div>
                <div class="slide-menu-option">
                    <a href="settings.php">
                        <img src="images/icons/settings.png" alt=""  style="height:2.1rem;">
                        <p>User Settings</p>
                    </a>
                </div>
                <div class="slide-menu-option">
                    <img src="images/icons/mark.png" alt=""  style="height:2.1rem;">
                    <a
                    href="marked_post_page.php?user_profile=<?php echo $user_name_logged_in?>">
                    <p>Marked Post</p>
                    </a>
                </div>
                <?php if ($user_name_logged_in == $user_profile) {
                    echo '<div class="slide-menu-option followed_list">
                    <img src="images/icons/users.png" alt=""  style="height:2.1rem;">
                        <a href="#"><p>Followed list</p></a>
                    </div>
                    <hr>';
                }?>
                
                <div class="slide-menu-option">
                    <a href="#"><p style="margin-left:0;">Settings And Privacy</p></a>
                </div>
                <div class="slide-menu-option">
                <a href="#"><p style="margin-left:0;">Help</p></a>
            </div>
                <div class="slide-menu-option">
                <a href="classes/log_out.php"><p style="margin-left:0;">Log Out</p></a>
                </div>
            </div>
        </div>
    </div>
    <div class="show_more_friends_popup_containner">
        <div class="show_more_friends_box">
            <div class="show_more_friends_box_header" style="padding: 2rem 0rem 2rem 0;">
                <div class='empty_show_more_friends_box_header'></div>
                     <h3 class="followed_list_header_title">Followed list</h3>
                <div class="closing_botton_show_more_friends_div">
                    <span class="closing_botton_show_more_friends">+</span>
                </div>
            </div>

            <div class="load_friend_search_container">
                <div class="load_friend_search_container_top">
                    <?php
                        echo $user_logged_in_obj->load_followed_list($user_logged_in_obj->follower_list());
                    ?>
                    
                    
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

document.querySelector('.user-name-menu').addEventListener("click", function() {
	document.querySelector('.slide-menu-wraper').style.display = "block";
});



    // like button clicked
    $(".reaction-like").click(function (event) {

var user_name_logged_in = '<?php echo $user_profile?>';
var full_like_id = $(this).attr('id');
var like_id = full_like_id.slice(4, full_like_id.len);
var liked_text_val = $('.bottom_post_like_'+like_id+' .like_btn_'+like_id).text()
// alert(liked_text_val)

$.ajax({
    url: 'like_clicked.php',
    type: 'POST',
    data: {
        like_id_val: like_id,
        user_name_logged_in_val: user_name_logged_in,
        liked_text_val:liked_text_val
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

var user_name_logged_in = '<?php echo $user_profile?>';
var full_like_id = $(this).attr('id');
var dislike_id = full_like_id.slice(7, full_like_id.len);
var liked_text_val = $('.bottom_post_like_'+dislike_id+' .like_btn_'+dislike_id).text()
// alert(liked_text_val)
$.ajax({
    url: 'dislike_clicked.php',
    type: 'POST',
    data: {
        like_id_val: dislike_id,
        user_name_logged_in_val: user_name_logged_in,
        liked_text_val:liked_text_val
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
var user_name_logged_in = '<?php echo $user_profile?>';
var num_like_text_val = $(this).text()
var like_val_class = $('.like_btn_' + like_id).text(); //DISLIKED, LIKED, LIKE
// alert(like_val_class)
$.ajax({
    url: 'ajax/remove_like.php',
    type: 'POST',
    data: {
        like_id: like_id,
        user_name_logged_in: user_name_logged_in,
        like_val_class: like_val_class
    },
    async: false,
    cache: false,
    error: function () {
        alert('error');
    },
    success: function (data) {
        $('.bottom_post_like_' + like_id).html(data);
        if (like_val_class == 'Disliked'){
            var liked_text_val = $('.like-details_disliked_'+like_id).text()
            liked_text_val = parseInt(liked_text_val)-1;
             $('.like-details_disliked_'+like_id).text(liked_text_val)

        }else if(like_val_class == 'Liked') {
            var liked_text_val = $('.like-details_liked_'+like_id).text()
            liked_text_val = parseInt(liked_text_val)-1;
            $('.like-details_liked_'+like_id).text(liked_text_val)
            // alert('diliked')   
        }
    }
})
})
// marked
$('.bottom_post_componment_mark_post').click(function () {
            var all_tags = '';
            var post_marked_id = $(this).attr('id');
            post_marked_id = post_marked_id.slice(33);
            var user_name_logged_in = '<?php echo $user_profile?>';
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
// infollow ajax
$('.span-button_profile').click(function(){
   var text_value = $(this).text();
   if (text_value == 'Follow') {
    var user_name_logged_in = '<?php echo $user_name_logged_in?>';
                var user_clicked_name = $(this).attr('class')
                var user_clicked_name = user_clicked_name.substr(70);
                $.post("ajax/follow_friend_button_from_profile.php", {
                    user_clicked_name: user_clicked_name,
                    user_name_logged_in: user_name_logged_in
                }, function (data) {
                    $('.follow___' + user_clicked_name).html(data);
                })
   }else{
    var user_name_logged_in = '<?php echo $user_name_logged_in?>';
                var user_clicked_name = $(this).attr('class')
                var user_clicked_name = user_clicked_name.substr(70);
                $.post("ajax/infollow_friend_button_from_profile.php", {
                    user_clicked_name: user_clicked_name,
                    user_name_logged_in: user_name_logged_in
                }, function (data) {
                    $('.infollow_' + user_clicked_name).html(data);
                })
   }
})
$('.followed_list').click(function () {

    document.querySelector('.show_more_friends_popup_containner').style.display = 'block'
    })


    $('.closing_botton_show_more_friends').click(function () {
    document.querySelector('.show_more_friends_popup_containner').style.display = 'none'
 
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
            var user_name_logged_in = '<?php echo $user_profile?>';
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
                        simpleNotify.notify(
                            'We will check this post as soon as possible &#128522;',
                            'attention');

                    });
                }
            })
        })
        // delete a post
    
        $('.delete_post_div').click(function () {
            var post_id = $(this).attr('class');
            var post_id = post_id.slice(32);
            var user_name_logged_in = '<?php echo $user_profile?>';
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
            var input_search_val = $(this).val()
                var keycode = (event.keyCode ? event.keyCode : event.which);
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
</script>
   
</body>

</html>