<?php

define("header",true);
include('header.php');
?>
<link rel="stylesheet" type="text/css" href="css/reaction.css" />

<!-- jQuery for Reaction system -->
<?php
include('classes/user.php');
include('classes/post.php');
include_once('like_dislike.php');
include('classes/notification.php');
include('classes/load_friends_suggestion_default.php');
include('classes/load_category_main.php');
if (isset($_SESSION['user_name_log_in'])) {
    $user_name=$_SESSION['user_name_log_in'];
    $query_log_in=mysqli_query($con,"SELECT * FROM users WHERE user_name ='$user_name'");
    $row=mysqli_fetch_array($query_log_in);
}
else{
    header('location: index.php');
}
$user_obj=new user($con,$user_name);
// get all user followed by user logged in
$followers_list = $user_obj->follower_list();
$categories_list = $user_obj->get_categories();
$post_obj=new post($con,$user_name,$categories_list);
$notification_obj=new notification($con,$user_name);
$load_friends_suggestion_default_obj=new load_friends_default($con,$user_name);
$category_obj=new category_main($con);



$num_notification=$notification_obj->num_notification($user_name);

if (isset($_POST['submit_test'])) {
    $post_obj->submit_post($_POST['text_area']);
}
?>

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
        <a id="button-back-top"><img src="images/icons/arrow_top.png" style="width:3.5rem" alt=""></a>

        <div class="main-content main-content_main_page">
            <div class="empty-main-content1">

            </div>
            <div class="post">
                <form action="" method="POST">
                    <input type="hidden" name='hidden_id_val'>
                </form>
                <div class="post-container">
                    <div class="top-header-post">
                        <div class="top-header-post_top">
                            <h4>Home</h4>
                            <img src="images/brain_logo.png" alt="" style="width:6rem">
                        </div>
                        <div class="top-header-post_bottom">
                            <hr>
                        </div>
                    </div>


                    <div class="load_post">
                        <?php $post_obj->load_post()?>
                    </div>

                    <!-- var first_name ='<?php echo $_SESSION['userData']['first_name']?>';
                        var last_name ='<?php echo $_SESSION['userData']['last_name']?>';
                        var email='<?php echo $_SESSION['userData']['email']?>'; -->
                    <!-- !!!!!!!!!!!!!!!!!!!!! -->
                    <button class="show_more_button related">show more</button>
                </div>
            </div>
            <!-- **************** -->
            <div class="side">
                <div class="follow-friend">
                    <div class="header-side">
                        <h3 class="header-side-text">Search for a friend</h3>
                    </div>
                    <div class="tags-friend-content" style="display flex;flex-direction:column;">
                        <div class="input-friends-content"><input class="input-search input-search-friend-content"
                                type="text" placeholder="search here"></div>
                        <!-- <div class=""><img src="images/phpimg.png" alt=""><a href="#">PHP</a></div>
                        <hr>
                        <div class=""><img src="images/java.webp" alt=""><a href="#">Java</a></div>
                        <hr>
                        <div class=""><img src="images/cpp.png" alt=""><a href="#">Cpp</a></div>
                        <hr>
                        <div class=""><img src="images/java.webp" alt=""><a href="#">Java</a></div>
                        <hr>
                        <div class=""><img src="images/phpimg.png" alt=""><a href="#">PHP</a></div>
                        <hr> -->
                        <div class="load_suggestion_container">
                            <?php
                           $load_friends_suggestion_default_obj->load_friends_default_function();
                        ?>
                        </div>
                    </div>
                    <div class="span-button suggested_friend_show_more_button"> <a href="#">Show more</a></div>
                </div>

                <div class="ads first-ads">
                    <span> advertisment</span>
                    <!-- <img src="images/ads2.jpg" alt=""> -->
                </div>

                <div class="tags" style="font-size:3rem;">
                    <div class="header-side">
                        <h3 class="header-side-text">Tags that you may like</h3>
                    </div>
                    <div class="tags-friend-content" style="display flex;flex-direction:column;">
                        <div class="tags_name tags_name_maths"><img src="images/phpimg.png" alt=""><a href="#">PHP</a></div>
                        <hr>
                        <div class="tags_name tags_name_computer_science"><img src="images/java.webp" alt=""><a href="#">Java</a></div>
                        <hr>
                        <div class="tags_name tags_name_big_data"><img src="images/cpp.png" alt=""><a href="#">Cpp</a></div>
                        <hr>
                    </div>
                    <div class="span-button show_more_categories"> <a href="#">Show more</a></div>
                </div>
                <!-- <div class="create-post-side">
                    <div class="header-side header-side-create-post-side">
                        <h3 class="header-side-text header-side-text-create-post">Share something with the world</h3>
                    </div>
                    <div class="button-create-post">
                        <div class="span-button span-button-create-post"> <a href="#">Create a Post</a></div>
                    </div>
                </div> -->

                <div class="ads second-ads">
                    <span> advertisment</span>
                    <!-- <img src="images/ads.png" alt=""> -->
                </div>
                <div class="footer">
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
    <!-- <div class="empty-main-content2"></div> -->
    <div class="slide-menu-wraper">
        <div class="slide-menu">
            <div class="close_slide">
                +
            </div>
            <div class="slide-menu-profile-pic" style="display:flex;">
                <a href="<?php echo 'profile.php?user_profile='.$user_obj->get_user_name()?>"><img
                        src="<?php echo $user_obj->get_profile_pic()?>" alt=""></a>
                <a href="<?php echo 'profile.php?user_profile='.$user_obj->get_user_name()?>">
                    <p><?php echo $user_obj->get_first_name().' '.$user_obj->get_last_name()?></p>
                </a>
            </div>
            <div class="number-posts">
                <p><?php echo $user_obj->followers();?> Followers</p>
            </div>
            <hr>

            <div class="slide-menu-options">
                <div class="slide-menu-option slide-menu-option_loading_option" style="margin-bottom:0.5rem">
                    <span><i class="fas fa-sort-amount-down" style="font-size:1.8rem;"></i>
                        <p>Sort post by</p>
                    </span>
                </div>
                <div class="slide-menu-option_options">
                    <!-- <div class="slide-menu-options_content">
                        <input type="radio" name='option_post' value="radio_post_related" style="cursor:pointer" checked>
                        <p class="slide-menu-options_content_paragraph" >show related posts</p>
                        </div>
                    <div class="slide-menu-options_content">
                <input type="radio" name='option_post' value="radio_post_friend" style="cursor:pointer" >
                        <p class="slide-menu-options_content_paragraph" >show firends posts</p>
                        </div>
                    <div class="slide-menu-options_content">
                        <input type="radio" name='option_post' value="radio_post_all" style="cursor:pointer" >
                        <p class="slide-menu-options_content_paragraph" >show all posts</p>
                        </div>
                        <div class="slide-menu-options_content_done">
                            Done
                        </div> -->

                    <label class="slide-menu-options_content">Show related post
                        <input type="radio" checked="checked" name="option_post" value="radio_post_related">
                        <span class="checkmark_show_post_option"></span>
                    </label>
                    <label class="slide-menu-options_content">Show friends post
                        <input type="radio" name="option_post" value="radio_post_friend">
                        <span class="checkmark_show_post_option"></span>
                    </label>
                    <label class="slide-menu-options_content">Show all posts
                        <input type="radio" name="option_post" value="radio_post_all">
                        <span class="checkmark_show_post_option"></span>
                    </label>
                    <div class="slide-menu-options_content_done">
                        <img src="images/blue_arrow_right.png" alt="" style='width:3.5rem'>
                    </div>

                </div>
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
                <div class="slide-menu-option suggested_friend_show_more_button_slide">
                    <img src="images/icons/follower.png" alt="" style="height:2.1rem;">
                    <a href="#">
                        <p>show more friends</p>
                    </a>
                </div>
                <div class="slide-menu-option">
                    <img src="images/icons/mark.png" alt="" style="height:2.1rem;">
                    <a href="marked_post_page.php?user_profile=<?php echo $user_name?>">
                        <p>Marked Post</p>
                    </a>
                </div>
                <hr>
                <div class="slide-menu-option">

                    <p style="margin-left:0;">Settings And Privacy</p>
                    </a>
                </div>
                <div class="slide-menu-option">

                    <p style="margin-left:0;">Help</p>
                    </a>
                </div>
                <div class="slide-menu-option">
                    <a href="classes/log_out.php">
                        <p style="margin-left:0;">Log Out</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="show_more_friends_popup_containner">
        <div class="show_more_friends_box">
            <div class="show_more_friends_box_header">
                <div class='empty_show_more_friends_box_header'></div>
                <div class="input_search_friend_div">
                    <input type="text" class="input_search_friend" placeholder="Search">
                </div>
                <div class="closing_botton_show_more_friends_div">
                    <span class="closing_botton_show_more_friends">+</span>
                </div>
            </div>

            <div class="load_friend_search_container">
                <div class="load_friend_search_container_top">

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
    <div class="log_in_pop_up_container">
        <div class="log_in_pop_up" style="padding : 5rem 0rem">
            <div class="close_log_in">
                +
            </div>
            <div class="log_in_pop_up_body" style="padding : 1rem 0rem">
                <!-- function load category -->
                <?php $category_obj->load_category() ?>
                
            </div>
        </div>
    </div>
    <script>
        $('.load_category_search_div').click(function(){
            var category_name = $(this).attr('class');
            var category_name = category_name.slice(30);

            alert(category_name)

        })
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

        var btn = $('#button-back-top');

        $(window).scroll(function () {
            if ($(window).scrollTop() > 600) {
                btn.addClass('show');
            } else {
                btn.removeClass('show');
            }
        });

        btn.on('click', function (e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, '300');
        });

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
            // alert(liked_text_val)

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
            // alert(liked_text_val)
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

        // remove like 
        $('.like-btn-text').click(function () {
            var like_id = $(this).attr('class');
            like_id = like_id.slice(23);
            var user_name_logged_in = '<?php echo $user_name?>';
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
                    if (like_val_class == 'Disliked') {
                        var liked_text_val = $('.like-details_disliked_' + like_id).text()
                        liked_text_val = parseInt(liked_text_val) - 1;
                        $('.like-details_disliked_' + like_id).text(liked_text_val)

                    } else if (like_val_class == 'Liked') {
                        var liked_text_val = $('.like-details_liked_' + like_id).text()
                        liked_text_val = parseInt(liked_text_val) - 1;
                        $('.like-details_liked_' + like_id).text(liked_text_val)
                        // alert('diliked')   
                    }
                }
            })
        })

        //    search for a friend
        $('.input-search-friend-content').keyup(function () {
            var user_logged_in = '<?php echo $user_name?>'
            var input_val = $(this).val();
            if (input_val.length > 0) {
                $.post("ajax/load_friend_suggestion_ajax.php", {
                    suggestion: input_val,
                    user_logged_in: user_logged_in
                }, function (data) {
                    $('.load_suggestion_container').html(data)
                })
            } else {
                $('.load_suggestion_container').html(
                    '<div><img src="images/search_friend.jpg" style="width:23rem;height: 20rem"alt=""></div>'
                )

            }

        })

        // user clicked on follow friend button

        $('.follow_friend_button').click(function () {
            var user_name_logged_in = '<?php echo $user_name?>';

            var user_clicked_name = $(this).attr('class')
            var user_clicked_name = user_clicked_name.substr(28);
            $.post("ajax/follow_friend_button.php", {
                user_clicked_name: user_clicked_name,
                user_name_logged_in: user_name_logged_in
            }, function (data) {
                $('.follow_' + user_clicked_name).html(data);
            })
        })


        $('.suggested_friend_show_more_button').click(function () {
            document.querySelector('.show_more_friends_popup_containner').style.display = 'block'
        })
        $('.closing_botton_show_more_friends').click(function () {
            document.querySelector('.show_more_friends_popup_containner').style.display = 'none'
        })
        $('.suggested_friend_show_more_button_slide').click(function () {
            document.querySelector('.show_more_friends_popup_containner').style.display = 'block'
        })

        // show more categoties
        $('.show_more_categories').click(function () {
            document.querySelector('.log_in_pop_up_container').style.display = 'block'

        })

        $('.close_log_in').click(function () {
            document.querySelector('.log_in_pop_up_container').style.display = 'none'

        })


        $('.suggested_friend_show_more_button_slide').click(function () {
            document.querySelector('.show_more_friends_popup_containner').style.display = 'block'
        })
        $('.suggested_friend_show_more_button, .suggested_friend_show_more_button_slide').click(function () {

            // insert value of suggeted input in search input by default
            var input_suggestion_val = $('.input-search-friend-content').val();
            $('.input_search_friend').val(input_suggestion_val)
            var user_name_logged_in = '<?php echo $user_name?>';

            var input_search_friend_val = $('.input_search_friend').val();
            if (input_search_friend_val.length > 0) {

                $.post("ajax/load_friend_search_ajax.php", {
                    suggestion: input_search_friend_val,
                    user_logged_in: user_name_logged_in
                }, function (data) {
                    $('.load_friend_search_container_top').html(data)
                })
            } else {
                $('.load_friend_search_container_top').html(
                    '<div><img src="images/search_friend.jpg" style="width:40rem"alt=""></div>')

            }
            $('.input_search_friend').keyup(function () {

                var input_search_friend_val = $('.input_search_friend').val();
                if (input_search_friend_val.length > 0) {

                    $.post("ajax/load_friend_search_ajax.php", {
                        suggestion: input_search_friend_val,
                        user_logged_in: user_name_logged_in
                    }, function (data) {
                        $('.load_friend_search_container_top').html(data)
                    })
                } else {
                    $('.load_friend_search_container_top').html(
                        '<div><img src="images/search_friend.jpg" style="width:40rem"alt=""></div>'
                    )

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
            if (input_search_val.length > 0) {

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

        // show more option post

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
                        simpleNotify.notify(
                            'We will check this post as soon as possible &#128522;',
                            'attention');

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
                        simpleNotify.notify('Post has been deleted &#128533;', 'attention');
                        $('.post_' + post_id).remove();


                    });
                }
            })
        })

        // loading post options
        var count_post_option_friend = 10
        var count_post_option_related = 10
        var count_post_option_all = 10

        // load results after user clicked on show more
        $('.show_more_button').click(function () {
            var full_class_show_more = $(this).attr('class');
            var class_show_more = full_class_show_more.slice(17);

            if (class_show_more == 'related') {
                var user_name_logged_in = '<?php echo $user_name?>'
                count_post_option_related = count_post_option_related + 10;
                var categories_list = '<?php echo $categories_list ?>'


                $.ajax({
                    url: 'load_post_options/load_post_related.php',
                    type: 'POST',
                    data: {
                        count_post_option_related: count_post_option_related,
                        user_name_logged_in: user_name_logged_in,
                        categories_list: categories_list
                    },

                    error: function () {
                        alert('error');
                    },
                    success: function (data) {
                        $('.load_post').html(data);
                    }
                })
            }
            if (class_show_more == 'all') {
                count_post_option_all = count_post_option_all + 10
                var user_name_logged_in = '<?php echo $user_name?>'
                var categories_list = '<?php echo $categories_list ?>'

                $.ajax({
                    url: 'load_post_options/load_post_all.php',
                    type: 'POST',
                    data: {
                        count_post_option_all: count_post_option_all,
                        user_name_logged_in: user_name_logged_in,
                        categories_list: categories_list
                    },

                    error: function () {
                        alert('error');
                    },
                    success: function (data) {
                        $('.load_post').html(data);

                    }
                })
            }
            if (class_show_more == 'friend') {
                count_post_option_friend = count_post_option_friend + 10
                var user_name_logged_in = '<?php echo $user_name?>'
                var followers_list = '<?php echo $followers_list ?>'

                $.ajax({
                    url: 'load_post_options/load_post_friend.php',
                    type: 'POST',
                    data: {
                        count_post_option_friend: count_post_option_friend,
                        user_name_logged_in: user_name_logged_in,
                        followers_list: followers_list
                    },

                    error: function () {
                        alert('error');
                    },
                    success: function (data) {
                        $('.load_post').html(data);

                    }
                })
            }
        })


        // show results after user clickeck on done
        $('.slide-menu-options_content_done').click(function () {
            window.scrollTo(0, 0);

            var user_name_logged_in = '<?php echo $user_name?>'
            var checked_val = $("input[name='option_post']:checked").val();
            checked_val = checked_val.slice(11);


            var full_class_show_more = $('.show_more_button').attr('class');
            var class_show_more = full_class_show_more.slice(17);
            $('.show_more_button').removeClass(class_show_more)
            $('.show_more_button').addClass(checked_val)
            var class_show_more_after = full_class_show_more.slice(17);

            if (checked_val == 'friend') {

                var followers_list = '<?php echo $followers_list ?>'
                count_post_option_friend = 10

                $.ajax({
                    url: 'load_post_options/load_post_friend.php',
                    type: 'POST',
                    data: {
                        count_post_option_friend: count_post_option_friend,
                        user_name_logged_in: user_name_logged_in,
                        followers_list: followers_list
                    },

                    error: function () {
                        alert('error');
                    },
                    success: function (data) {
                        $('.load_post').html(data);
                    }
                })
            } else if (checked_val == 'related') {
                var categories_list = '<?php echo $categories_list ?>'
                count_post_option_related = 10

                $.ajax({
                    url: 'load_post_options/load_post_related.php',
                    type: 'POST',
                    data: {
                        count_post_option_related: count_post_option_related,
                        user_name_logged_in: user_name_logged_in,
                        categories_list: categories_list
                    },

                    error: function () {
                        alert('error');
                    },
                    success: function (data) {
                        $('.load_post').html(data);

                    }
                })
            } else if (checked_val == 'all') {
                var categories_list = '<?php echo $categories_list ?>'
                count_post_option_all = 10
                $.ajax({
                    url: 'load_post_options/load_post_all.php',
                    type: 'POST',
                    data: {
                        count_post_option_all: count_post_option_all,
                        user_name_logged_in: user_name_logged_in,
                        categories_list: categories_list
                    },

                    error: function () {
                        alert('error');
                    },
                    success: function (data) {
                        $('.load_post').html(data);

                    }
                })
            }

        })
        $('.tags_name').click(function(){
            var full_class = $(this).attr('class');
            var full_class = full_class.slice(20);
            if (full_class =='maths') {
                $.ajax({
                    url: 'load_post_options/load_post_all.php',
                    type: 'POST',
                    data: {
                        full_class: full_class
                    },

                    error: function () {
                        alert('error');
                    },
                    success: function (data) {
                        $('.load_post').html(data);

                    }
                })
            }else if(full_class =='big_data'){

            }else if (full_class =='computer_science') {
                
            }
            // else if (condition) {
                
            // }else if(){

            // }else if (condition) {
                
            // }

        })
    </script>
</body>

</html>