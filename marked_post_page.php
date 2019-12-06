<?php
define("header",true);
include('header.php');
if (isset($_GET['user_profile'])) {
    $user_profile=$_GET['user_profile'];
}

if (isset($_SESSION['user_name_log_in'])) {
    $user_name_logged_in=$_SESSION['user_name_log_in'];

}else{
    header('location: index.php');
}
include('classes/user.php');
$user_obj=new user($con,$user_name_logged_in);

include('classes/marked_post_page_class.php');
$marked_obj=new marked($con,$user_name_logged_in);

include('classes/notification.php');
$notification_obj=new notification($con,$user_name_logged_in);

$num_notification=$notification_obj->num_notification($user_name_logged_in);

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

        <div class="main-content">
            <div class="empty-main-content1 empty-create-post">

            </div>

            <div class="post post-create-post">
                <div class="post-header-create-post">
                    <h2>Marked Posts</h2>
                    <img src="images/icons/mark.png" style='width:3rem;height:3rem;margin: 0 2.5rem;' alt="">
                </div>
                <hr style="margin: 0rem 3rem;">
                <div class="profile_post_container" style="display:block">
                    <?php
            $marked_obj->load_post($con,$user_profile);
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
                            <img src="<?php echo $user_obj->get_profile_pic()?>" alt=""
                                id="image_profile">
                        </div>
                        <div class="user_profile_info">
                            <p class="user_profile_info_name">@<?php echo $user_profile?></p>
                        </div>

                        <p class="user_profile_info_posts_followers">Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Alias dolorem modi culpa. Facere dignissimos labore sit nisi fugit quaerat sapiente.
                        </p>
                    </div>
                    <?php
                     if($user_profile==$user_name_logged_in){
                        echo '
                        <div class="span_botton_container_profile">
                        <span class="span-button span-button_profile" >Create a post</span>
                        </div>';

                     }else{
                         header('location: main.php');
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
                        <div class="slide-menu-profile-pic" style="display:flex;">
                            <a href="<?php echo 'profile.php?user_profile='.$user_obj->get_user_name() ?>"><img
                                    src="<?php echo $user_obj->get_profile_pic() ?>" alt="" style="width:4.3rem;"></a>
                            <a href="<?php echo 'profile.php?user_profile='.$user_obj->get_user_name() ?>">
                                <p><?php echo $user_obj->get_first_last_name()?></p>
                            </a>
                        </div>
                        <div class="number-posts">
                            <p><?php echo $user_obj->followers();
                 if ($user_obj->followers() == 0 || $user_obj->followers() == 1 ) {
                    echo ' Follower';
                }else{
                    echo ' Followers';

                }
                ?></p>
                        </div>
                        <hr>

                        <div class="slide-menu-options">
                            <div class="slide-menu-option">
                                <img src="images/icons/home.png" alt="" style="height:2.1rem;">
                                <a href="main.php">
                                    <p>Home Page</p>
                                </a>
                            </div>
                            <div class="slide-menu-option">
                                <img src="images/icons/user.png" alt="" style="height:2.1rem;">
                                <a href="profile.php?user_profile=<?php echo $user_name_logged_in?>">
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
                                <a href="marked_post_page.php?user_profile=<?php echo $user_name_logged_in?>">
                                    <p>Marked Post</p>
                                </a>
                            </div>

                            <hr>
                            <div class="slide-menu-option">
                                <a href="#">
                                    <p style="margin-left:0;">Settings And Privacy</p>
                                </a>
                            </div>
                            <div class="slide-menu-option">
                                <a href="#">
                                    <p style="margin-left:0;">Help</p>
                                </a>
                            </div>
                            <div class="slide-menu-option">
                                <a href="#">
                                    <p style="margin-left:0;">Log Out</p>
                                </a>
                            </div>
                        </div>
                    </div>
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
        document.querySelector('.user-name-menu').addEventListener("click", function () {
            document.querySelector('.slide-menu-wraper').style.display = "block";
        });

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


        $(document).ready(function () {
            var count = 10;
            var user_profile_name = '<?php echo $user_profile?>';

            $('.show_more_button').click(function () {
                count = count + 10;
                // change it to append if that is possible
                $('.profile_post_container').load("load_posts_profile.php", {
                    count_posts: count,
                    user_profile: user_profile_name

                })
            });
        })

        // create post
        $('.ellipsis_img_post').click(function () {
            var ellipsis_id = $(this).attr('class');
            var ellipsis_id = ellipsis_id.slice(36);
            $(".dropdown-content_more_option_post_" + ellipsis_id).toggle("show");
        })

        $('.remove_post_div').click(function () {
            var post_id = $(this).attr('class');
            var post_id = post_id.slice(32);
            var user_name_logged_in = '<?php echo $user_name_logged_in?>';
            $.ajax({
                url: 'ajax/remove_marked_post_ajax.php',
                type: 'POST',
                data: {
                    post_id: post_id,
                    user_name_logged_in: user_name_logged_in
                },
                error: function () {
                    alert('error');
                },
                success: function (data) {
                    $('.show_all_search_result_content_' + post_id).hide('slow', function () {
                        $('.show_all_search_result_content_' + post_id).remove();
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