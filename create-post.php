<?php
define("header",true);
include('header.php');

if (isset($_SESSION['user_name_log_in'])) {
    $user_name=$_SESSION['user_name_log_in'];
}else{
    header('location: index.php');
}
include('classes/user.php');
$user_obj = new user($con,$user_name);

include('classes/notification.php');
$notification_obj=new notification($con,$user_name);
$num_notification=$notification_obj->num_notification($user_name);


?>
<link rel="stylesheet" href="dist/ui/trumbowyg.min.css">
<script src="dist/trumbowyg.min.js"></script>

<body style="background-color: #DAE0E6;overflow-x: hidden;">


    <section class="main-page-main">
        <!--start navigation bar -->
        <nav id="main-nav">
            <div class="user-main">
                <a class="user-name-menu"><i class="fas fa-bars" style="font-size:1.8rem;"></i><span
                        class="user-name-menu-span"><?php echo $user_obj->get_first_last_name() ?></span></a>
            </div>
            </div>
            </div>
            <div class="search-main">
                <i class=" fas fa-search" style="color:#222222;"></i>
                <input type="text" class="input-search input-search-main" placeholder="Search for a question">
            </div>
            <div class="navigation-icons">
                <a href="main.php"><i class="fas fa-home"></i></a>
                <div class="notification_bell notification_container ">
                    <i class="far fa-bell dropbtn" onclick='drop_down_notification_function()'></i>
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
                <a href="settings.php" class="fa-cog"><i class="fas fa-cog"></i></a>
                <a href="create-post.php"><i class="fas fa-pencil-alt"></i></a>
                <a href="classes/log_out.php" class="fa-sign-out-alt"><i class="fas fa-sign-out-alt"></i></a>
            </div>

        </nav>
        <!--end navigation bar -->

        <!-- main content -->

        <div class="main-content" style=" grid-template-columns: min-content 1fr min-content;">
            <div class="empty-main-content1 empty-create-post">

            </div>

            <div class="post post-create-post">
                <div class="post-header-create-post"style='padding:2rem;border-radius: 3.2rem;background-color:#fff'>
                <div class="post-header-create-post_header">
                    <h2 style='padding: .5rem'>Create a Post</h2>
                    <i class="fas fa-pencil-alt"  style="font-size:2.5rem;"></i>

                </div>
                    <hr>
                    <div class="create-post-botton-btn">
                        <i class="fas fa-tag btn-create-post botton1 active_btn_tag" style="font-size:2.5rem;"></i>
                        <i class="fas fa-file-alt btn-create-post botton2" style="font-size:2.5rem;"></i>
                        <i class="fas fa-binoculars btn-create-post botton3" style="font-size:2.5rem;"></i>
                    </div>
                </div>
                <div class="ajax-insert">
                    <div class="create-post-tags-title">
                        <div class="create-post-tags-title-container">
                            <div class="create-post-tags">
                                <h3 class="h3-create-post">What languages, technologies, and/or frameworks is your
                                    question about?</h3>
                                <h4 class="h4-create-post">Tags help the right people find and answer your question.
                                </h4>
                                <div class="input-create-post-div input-create-post-tags">
                                    <div class="top_tag">
                                        <!-- <span class='tags_value'>php<span class="delete_tag">+</span></span>
                        <span class='tags_value'>java<span class="delete_tag">+</span></span>-->

                                    </div>
                                    <input type="text" class="create-post-tags-input" placeholder="eg: php java c#">
                                    <div class="bottom_tag">
                                        <span class="delete_tag">+</span>

                                    </div>
                                </div>
                                <div class='results_container_tags' style="">
                                    <p class="tags_create_post"></p>
                                </div>

                            </div>

                            <div class="create-post-title">
                                <h3 class="h3-create-post">What languages, technologies, and/or frameworks is your
                                    question about?</h3>
                                <h4 class="h4-create-post">Tags help the right people find and answer your question.
                                </h4>
                                <div class="input-create-post-div input-create-post-title">

                                    <input type="text" class="create-post-title-input" placeholder="eg: php java c#">
                                    <div class="bottom_tag">
                                        <span class="delete_title">+</span>

                                    </div>
                                </div>
                                <div class='results_container_title' style="">
                                    <p class="title_create_post"></p>
                                </div>

                                <div class="next_previous_button_create_post next_botton_tags_title">Next</div>
                            </div>
                        </div>
                        <div class="create-post-tags-title-container-empty"></div>
                    </div>
                </div>
            </div>

            <!-- **************** -->
            <div class="side" style="margin-right:0rem;">
                <div class="tags" style="font-size:3rem;margin-top:0">
                    <div class="header-side">
                        <h3 class="header-side-text">Tags that you may like</h3>
                    </div>
                    <div class="tags-friend-content" style="display flex;flex-direction:column;">
                        <div class="tags_name"><img src="images/phpimg.png" alt=""><a href="#">PHP</a></div>
                        <hr>
                        <div class="tags_name"><img src="images/java.webp" alt=""><a href="#">Java</a></div>
                        <hr>
                        <div class="tags_name"><img src="images/cpp.png" alt=""><a href="#">Cpp</a></div>
                    </div>
                    <div class="span-button"> <a href="#">Show more</a></div>
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
                    <div class="botton-footer"><a href="#">created with &#10084; by khoubaib Boughalmi</a></div>

                </div>
            </div>
    </section>
    <div class="empty-main-content2"></div>


    <div class="slide-menu-wraper">
        <div class="slide-menu">
            <div class="slide-menu-header">
                <h3>Account info</h3>
                <a href="#">
                    <p class="slide-menu-header-close">+</p>
                </a>
            </div>
            <hr>
            <div class="slide-menu-profile-pic">
                <img src="<?php echo $user_obj->get_profile_pic()?>" alt="" style="width:4.3rem;">
                <a href="">
                    <p><?php echo $user_obj->get_first_last_name() ?></p>
                </a>
            </div>
            <div class="number-posts">
                <p><?php echo $user_obj->followers()?> Follower</p>
            </div>
            <hr>

            <div class="slide-menu-options">
                <div class="slide-menu-option">
                    <a href="profile.php?user_profile=<?php echo $user_obj->get_user_name() ?>">
                    <i class="fas fa-user" style="font-size:1.8rem;"></i>
                        <p>My Profile</p>
                    </a>
                </div>
                <div class="slide-menu-option">
                    <a href="marked_post_page.php?user_profile=<?php echo $user_obj->get_user_name() ?>">
                    <i class="far fa-bookmark" style="font-size:1.8rem;"></i>
                        <p>Marked post</p>
                    </a>
                </div>
             
                <div class="slide-menu-option">
                    <a href="settings.php">
                    <i class="fas fa-cog" style="font-size:1.8rem;"></i>
                        <p>Settings</p>
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

    <script>
        document.querySelector('.user-name-menu').addEventListener("click", function () {
            document.querySelector('.slide-menu-wraper').style.display = "block";
        });

        document.querySelector('.slide-menu-header-close').addEventListener("click", function () {
            document.querySelector('.slide-menu-wraper').style.display = "none";
        });

        $(document).ready(function () {

            // $('.botton1').click(function () {
            //     var user_logged_in = '';
            //     $.ajax({
            //         url: 'creat-post-files/tags-create-post.php',
            //         type: 'POST',
            //         data: {
            //             user_logged_in: user_logged_in
            //         },
            //         error: function () {
            //             alert('error');
            //         },
            //         success: function (data) {
            //             $('.ajax-insert').html(data);

            //         }
            //     })

            //     // $.get('creat-post-files/tags-create-post.php',function(data){
            //     //     $('.ajax-insert').html(data);
            //     // })
            //     $('svg').removeClass('active_btn_tag');
            //     $(this).addClass('active_btn_tag');
            // })
            $('.next_botton_tags_title').click(function () {
                var title_value = $('.create-post-title-input').val();
                var title_length = title_value.length;
                if ($('.tags_value').length>0 ) {
                    if (title_length>10) {
                        var user_logged_in = '<?php echo $user_name; ?>';
                var tags;
            var all_tags = '';
            $('.tags_value').each(function () {
                tags = $(this).attr('class') + ',';
                tags = tags.substr(22);
                tags=tags.trim()
                all_tags = all_tags.concat(tags);
            })
            all_tags=all_tags.trim()
            sessionStorage.setItem("tags", all_tags);
            var title = $('.create-post-title-input').val()
            title=title.trim()
            sessionStorage.setItem("title", title);

            $('.tags_title').html(all_tags)
                $.ajax({
                    url: 'creat-post-files/description-create-post.php',
                    type: 'POST',
                    data: {
                        user_logged_in: user_logged_in
                    },
                    error: function () {
                        alert('error');
                    },
                    success: function (data) {
                        $('.ajax-insert').html(data);

                    }
                })

                $('.botton1').removeClass('active_btn_tag');
                $('.botton2').addClass('active_btn_tag');
            }else{
                        simpleNotify.notify('Title should be at least 10 charcters', 'danger');
                    }
                }
                    
                
                else{
                    simpleNotify.notify('There must be at least one tag', 'danger');

                }
            })
            // $('.botton3').click(function () {
            //     var user_logged_in = ';
            //     $.ajax({
            //         url: 'creat-post-files/review-create-post.php',
            //         type: 'POST',
            //         data: {
            //             user_logged_in: user_logged_in
            //         },
            //         error: function () {
            //             alert('error');
            //         },
            //         success: function (data) {
            //             $('.ajax-insert').html(data);

            //         }
            //     })

            //     $('svg').removeClass('active_btn_tag');
            //     $(this).addClass('active_btn_tag');
            // })


            //         $('#trumbowyg-demo').trumbowyg({
            //     btns: [
            //         ['undo', 'redo'], // Only supported in Blink browsers
            //         ['formatting'],
            //         ['strong', 'em'],
            //         ['superscript', 'subscript'],
            //         ['link'],
            //         ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            //         ['unorderedList', 'orderedList'],
            //         ['horizontalRule'],
            //         ['removeformat'],
            //         ['fullscreen']
            //     ]
            // });


            $('.create-post-tags-input').keyup(function () {
                var tag_val = $('.create-post-tags-input').val();
                var user_logged_in = '<?php echo $user_name ;?>';
                $('.results_container_tags').css('display', 'flex');

                $.ajax({
                    url: 'get_tags.php',
                    type: 'POST',
                    data: {
                        tag: tag_val,
                        user_logged_in: user_logged_in
                    },
                    error: function () {
                        alert('error');
                    },
                    success: function (data) {
                        $('.tags_create_post').html(data);

                    }
                })

                if (tag_val.length == 0) {
                    $('.results_container_tags').css('display', 'none')
                }
            });

        });
        $('.delete_tag').click(function () {
            $('.top_tag').html('');
        })
        // ***********************************************
        $('.create-post-title-input').keyup(function () {
            var title_val = $('.create-post-title-input').val();
            var user_logged_in = '<?php echo $user_name ;?>';

            $.ajax({
                url: 'get_title.php',
                type: 'POST',
                data: {
                    title: title_val,
                    user_logged_in: user_logged_in
                },
                error: function () {
                    alert('error');
                },
                success: function (data) {
                    $('.title_create_post').html(data);
                }
            })
            $('#tags_title').html('<?php echo $user_name; ?>');

            if (title_val.length == 0) {
                $('.results_container_title').css('display', 'none')
            }
        });

        $('.delete_title').click(function () {
            $('.create-post-title-input').val('');

        })


        // $('.next_botton_tags_title').click(function () {
        //     var tags;
        //     var all_tags = '';
        //     $('.tags_value').each(function () {
        //         tags = $(this).attr('class') + ',';
        //         tags = tags.substr(22)
        //         all_tags = all_tags.concat(tags);
        //     })
        //     sessionStorage.setItem("tags", all_tags);
        //     var title = $('.create-post-title-input').val()
        //     sessionStorage.setItem("title", title);

        //     $('.tags_title').html(all_tags)



        // })
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

    </script>

</body>

</html>