<?php

define("header",true);
include('header.php');
include('classes/user.php');

include('classes/notification.php');
if (isset($_SESSION['user_name_log_in'])) {
    $user_name=$_SESSION['user_name_log_in'];
    $query_log_in=mysqli_query($con,"SELECT * FROM users WHERE user_name ='$user_name'");
    $row=mysqli_fetch_array($query_log_in);
}else{
    header('location: index.php');
}
$user_obj=new user($con,$user_name);

$notification_obj=new notification($con,$user_name);
$num_notification=$notification_obj->num_notification($user_name);
include('classes/load_category_settings.php');
$category = new category($con,$user_name);
?>
<script src="js/md5.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/reaction.css" />
<!-- jQuery for Reaction system -->


<body style="background-color: #DAE0E6;overflow-x: hidden;">
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
                <img src="images/icons/notification.png" alt="" class="fa-bell dropbtn" style="width:4rem;height:4rem;"
                    onclick="drop_down_notification_function()">
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
    <div class="setting_page_container" style='display:grid;grid-template-columns:min-content 1fr;'>
        <div class="setting_container">
            <div class="setting_header">
                <span>Account Settings</span>
            </div>

            <span class="setting_title">General Account Settings</span>
            <div class="setting_grid change_first_last_name">
                <div class="setting_name">Name</div>
                <div class="setting_value setting_value_name"><?php echo($user_obj->get_first_last_name()) ?></div>
                <div class="setting_change_value setting_change_value_name"><span
                        class="setting_change_value_span">Change</span></div>
            </div>
            <div class="setting_grid toggel_conatiner_setting_page toggel_conatiner_setting_page_name">
                <div class="setting_name">Name</div>
                <div class="setting_value">
                    <form method="POST">
                        <table>
                            <tr>
                                <td><label for="">First Name</label></td>
                                <td><input type="text"
                                        class="setting_value_input_field setting_value_input_field_first_name"
                                        value="<?php echo($user_obj->get_first_name()) ?>" required></td>
                            </tr>
                            <tr>
                                <td><label for="">Last Name</label></td>
                                <td><input type="text"
                                        class="setting_value_input_field setting_value_input_field_last_name"
                                        name="setting_value_input_field_last_name"
                                        value="<?php echo($user_obj->get_last_name()) ?>" required></td>
                            </tr>
                            <tr class="submit_setting_page">
                                <td class="submit_setting_page_content">
                                    <span class="submit_setting_value_name">Submit</span>
                                    <span class="cancel_setting_change_value_name"
                                        style='margin:0rem .5rem'>Cancel</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="setting_change_value"></div>

            </div>
            <hr>
            <div class="setting_grid change_bio">
                <div class="setting_name">Bio</div>
                <div class="setting_value">Lorem, ipsum dolor sit amet consectetur bloom...</div>
                <div class="setting_change_value_bio"><span class="setting_change_value_span">Change</span></div>
            </div>
            <div class="setting_grid toggel_conatiner_setting_page toggel_conatiner_setting_page_bio">
                <div class="setting_name">Bio</div>
                <div class="setting_value">
                    <form method="POST">
                        <table>
                            <tr>
                                <td><label for="">biography</label></td>
                                <td><textarea rows="4" cols="25" name="setting_value_textarea"
                                        class='setting_value_textarea'
                                        required><?php echo ($user_obj->get_bio())?></textarea></td>
                            </tr>

                            <tr class="submit_setting_page">
                                <td class="submit_setting_page_content">
                                    <span class="submit_setting_value_text-area">Submit</span>
                                    <span class="cancel_setting_change_value_bio"
                                        style='margin:0rem .5rem'>Cancel</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="setting_change_value"></div>

            </div>
            <hr>
            <div class="setting_grid change_profile_pic">
                <div class="setting_name">Profile picture</div>
                <div class="setting_value" style="text-align: center;"></div>
                <div class="setting_change_value_profile_pic"><span class="setting_change_value_span">Change</span>
                </div>
            </div>
            <div class="setting_grid toggel_conatiner_setting_page toggel_conatiner_setting_page_profile_pic">
                <div class="setting_name">Profile picture</div>
                <div class="setting_value">
                    <form method="POST" enctype='multipart/form-data'>
                        <table>
                            <tr>
                                <td><input type='file' name='imagefile'></td>
                            </tr>

                            <tr class="submit_setting_page">
                                <td class="submit_setting_page_content">
                                    <input type="submit" name="submit_setting_value_profile_pic"
                                        class="submit_setting_value_profile_pic" value="Submit">
                                    <!-- <span class="submit_setting_value_profile_pic">Submit</span> -->
                                    <span class="cancel_setting_change_value_profile_pic"
                                        style='margin:0rem .5rem'>Cancel</span>
                                </td>
                            </tr>
                        </table>

                    </form>
                </div>
                <div class="setting_change_value ">
                    <img src="" class="setting_change_value_profile_pic_display_img_preview"
                        style="display:none;width: 10rem;height: 10rem;margin-bottom: 2rem;" />
                </div>

            </div>
            <hr>
            <div class="setting_grid change_category">
                <div class="setting_name">Change category</div>
                <div class="setting_value" style="text-align: center;"></div>
                <div class="setting_change_value_category"><span class="setting_change_value_span">Change</span>
                </div>
            </div>
            <div class="setting_grid toggel_conatiner_setting_page toggel_conatiner_setting_page_category">
                <div class="setting_name">Change category</div>
                <div class="setting_value setting_value_category">
                    <form method="POST">
                        <table>
                            <tr>
                                <td>
                                    <dl class="dropdown_step2">

                                        <dt>
                                            <a href="#" style="border: .1rem solid grey;width: 25rem;">
                                                <span class="hida">Select</span>
                                                <p class="multiSel"></p>
                                            </a>
                                        </dt>

                                        <dd>
                                            <div class="mutliSelect">
                                                <ul style="width: 26rem;">
                                                    <?php $category->load_category() ?>
                                                </ul>
                                            </div>
                                        </dd>
                                    </dl>
                                    <div class="scroling-div scroling-div-step2-register">
                                        <div style="height:80px;width:90%;border:1px solid #ccc;overflow:auto;">
                                            <p class="scroling-div-step2-register-body"></p>
                                        </div>
                                    </div>


                                </td>
                            </tr>

                            <tr class="submit_setting_page">
                                <td class="submit_setting_page_content">
                                <span class="submit_setting_value_category">Submit</span>
                                    <!-- <span class="submit_setting_value_category">Submit</span> -->
                                    <span class="cancel_setting_change_value_category"
                                        style='margin:0rem .5rem'>Cancel</span>
                                </td>
                            </tr>
                        </table>

                    </form>
                </div>
                <div class="setting_change_value ">
                    <!-- <img src="" class="setting_change_value_profile_pic_display_img_preview" style="display:none;width: 10rem;height: 10rem;margin-bottom: 2rem;" /> -->
                </div>

            </div>
            <hr>
            <span class="setting_title">Security and connection</span>
            <div class="setting_grid change_email">
                <div class="setting_name">Email</div>
                <div class="setting_value setting_value_email"><?php echo $user_obj->get_email()?></div>
                <div class="setting_change_value_email"><span class="setting_change_value_span">Change</span></div>
            </div>
            <div class="setting_grid toggel_conatiner_setting_page toggel_conatiner_setting_page_email">
                <div class="setting_name">Email</div>
                <div class="setting_value">
                    <form method="POST">
                        <table>
                            <tr>
                                <td class="email_already_used" colspan="2"></td>
                            </tr>
                            <tr>
                                <td><label for="">Email</label></td>
                                <td><input type="email" class="setting_value_input_field setting_value_input_email"
                                        placeholder="exemple@exemple.com" required></td>
                            </tr>
                            <tr>
                                <td><label for=""> repeat Email </label></td>
                                <td><input type="email"
                                        class="setting_value_input_field setting_value_input_repeat_email" value=""
                                        required></td>
                            </tr>

                            <tr class="submit_setting_page">
                                <td class="submit_setting_page_content">
                                    <span class="submit_setting_value_email"
                                        name='submit_setting_value_email'>Submit</span>
                                    <span class="cancel_setting_change_value_email"
                                        style='margin:0rem .5rem'>Cancel</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="setting_change_value"></div>

            </div>
            <hr>
            <div class="setting_grid change_password">
                <div class="setting_name">Password</div>
                <div class="setting_value">*********</div>
                <div class="setting_change_value_password"><span class="setting_change_value_span">Change</span></div>
            </div>
            <div class="setting_grid toggel_conatiner_setting_page toggel_conatiner_setting_page_password">
                <div class="setting_name">Password</div>
                <div class="setting_value">
                    <form method="POST">
                        <table>
                            <tr>
                                <td><label for="">Old password</label></td>
                                <td><input type="password"
                                        class="setting_value_input_field setting_value_input_old_password"
                                        name='setting_value_input_old_password' required></td>
                            </tr>
                            <tr>
                                <td><label for="">New password </label></td>
                                <td><input type="password"
                                        class="setting_value_input_field setting_value_input_new_password" value=""
                                        required></td>
                            </tr>
                            <tr>
                                <td><label for="">Repeat password </label></td>
                                <td><input type="password"
                                        class="setting_value_input_field setting_value_input_repeat_password" value=""
                                        required></td>
                            </tr>
                            <tr class="submit_setting_page">
                                <td class="submit_setting_page_content">
                                    <span class="submit_setting_value_password">Submit</span>
                                    <span class="cancel_setting_change_value_password"
                                        style='margin:0rem .5rem'>Cancel</span>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="setting_change_value"></div>

            </div>

            <hr style="margin-bottom: 4rem;">
        </div>

        <div class="slide-menu-wraper">
            <div class="slide-menu slide_menu_setting">
                <div class="slide-menu-header">
                    <h3>Account info</h3>
                    <a href="#">
                        <p class="slide-menu-header-close">+</p>
                    </a>
                </div>
                <hr>
                <div class="slide-menu-profile-pic">
                    <a href="profile.php?user_profile=<?php echo $user_obj->get_user_name()?>">
                        <img src="<?php echo $user_obj->get_profile_pic()?>" alt="" style="width:4.3rem;">
                    </a>
                    <a href="profile.php?user_profile=<?php echo $user_obj->get_user_name()?>">
                        <p><?php echo $user_obj->get_first_last_name() ?></p>
                    </a>
                </div>
                <div class="number-posts">
                    <p><?php echo $user_obj->followers()?> Follower</p>
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
                    <div class="slide-menu-option followed_list">
                        <img src="images/icons/users.png" alt="" style="height:2.1rem;">
                        <a href="#">
                            <p>followed list</p>
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

    <div class="main_search_container">

        <div class="main_search_box_container">

            <div class="main_search_result_header">
                <span>Search results</span>
            </div>
            <div class="main_search_result_content_all">

            </div>
        </div>
    </div>
    <?php
    $filename_rand = $user_name;

if(isset($_POST['submit_setting_value_profile_pic'])){
   
  // Getting file name
  $filename = $_FILES['imagefile']['name'];
  $filename = $filename_rand.$filename;
  // Valid extension
  $valid_ext = array('png','jpeg','jpg');

  // Location
  $location = "C:/xampp/htdocs/riask/images/users_profile_pic/".$filename;
  

  // file extension
  $file_extension = pathinfo($location, PATHINFO_EXTENSION);
  $file_extension = strtolower($file_extension);

  // Check extension
  if(in_array($file_extension,$valid_ext)){

    // Compress Image
    compressImage($_FILES['imagefile']['tmp_name'],$location,80 );

  }else{
    echo "Invalid file type.";
    echo "<script>simpleNotify.notify('please choose a valid image', 'danger');</script>";
  }
}

// Compress image
function compressImage($source, $destination, $quality) {

  $info = getimagesize($source);
  if ($info['mime'] == 'image/jpeg') 
    $image = imagecreatefromjpeg($source);

  elseif ($info['mime'] == 'image/gif') 
    $image = imagecreatefromgif($source);

  elseif ($info['mime'] == 'image/png') 
    $image = imagecreatefrompng($source);

  imagejpeg($image, $destination, $quality);

}

?>


    <script>
        //notification script
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


        // show and hide main search results 
        $('.input-search-main').focus(function () {
            $('.main_search_container').css('display', 'block')
            $('.main_search_result_content_all').html(
                '<div><img src="images/search_loop.jpg" style="width:25rem;height:26rem;margin-left: 19rem;"alt=""></div>'
            )

        })
        // transition: background-color .3s;
        $('.main-content_settings_page').click(function () {
            $('.main_search_container').css('display', 'none')

        })
        $('.slide-menu-wraper').click(function () {
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

        // toggel name
        $(".setting_change_value_name").click(function () {
            // $('.setting_change_value_name').toggle();
            $(".toggel_conatiner_setting_page_name").css('display', 'grid');
            $(".change_first_last_name").css('display', 'none');

        })

        $('.cancel_setting_change_value_name').click(function () {
            $(".toggel_conatiner_setting_page_name").css('display', 'none');
            $(".change_first_last_name").css('display', 'grid');



        })
        // toggle bio
        $(".setting_change_value_bio").click(function () {
            // $('.setting_change_value_bio').toggle();
            $(".toggel_conatiner_setting_page_bio").css('display', 'grid');
            $(".change_bio").css('display', 'none');

        })

        $('.cancel_setting_change_value_bio').click(function () {
            $(".toggel_conatiner_setting_page_bio").css('display', 'none');
            $(".change_bio").css('display', 'grid');
        })
        $('.setting_value_textarea').focus(function () {
            $(this).css('background', '#fff')
        })

        $('.setting_value_textarea').focusout(function () {
            $(this).css('background', 'whitesmoke')
        })

        // toggle profile pic 

        $(".setting_change_value_profile_pic").click(function () {
            // $('.setting_change_value_bio').toggle();
            $(".toggel_conatiner_setting_page_profile_pic").css('display', 'grid');
            $(".change_profile_pic").css('display', 'none');

        })

        $('.cancel_setting_change_value_profile_pic').click(function () {
            $(".toggel_conatiner_setting_page_profile_pic").css('display', 'none');
            $(".change_profile_pic").css('display', 'grid');
        })

        // toggle category
        $(".setting_change_value_category").click(function () {
            // $('.setting_change_value_bio').toggle();
            $(".toggel_conatiner_setting_page_category").css('display', 'grid');
            $(".change_category").css('display', 'none');

        })

        $('.cancel_setting_change_value_category').click(function () {
            $(".toggel_conatiner_setting_page_category").css('display', 'none');
            $(".change_category").css('display', 'grid');
        })
        // toggle email

        $(".setting_change_value_email").click(function () {
            // $('.setting_change_value_email').toggle();
            $(".toggel_conatiner_setting_page_email").css('display', 'grid');
            $(".change_email").css('display', 'none');

        })

        $('.cancel_setting_change_value_email').click(function () {
            $(".toggel_conatiner_setting_page_email").css('display', 'none');
            $(".change_email").css('display', 'grid');
        })

        // toggle password
        $(".setting_change_value_password").click(function () {
            // $('.setting_change_value_email').toggle();
            $(".toggel_conatiner_setting_page_password").css('display', 'grid');
            $(".change_password").css('display', 'none');

        })

        $('.cancel_setting_change_value_password').click(function () {
            $(".toggel_conatiner_setting_page_password").css('display', 'none');
            $(".change_password").css('display', 'grid');
        })


        // update user first and last name
        $('.submit_setting_value_name').click(function () {
            var new_first_name = $('.setting_value_input_field_first_name').val();
            var new_last_name = $('.setting_value_input_field_last_name').val();
            var user_logged_in = '<?php echo $user_name?>';
            if ((new_first_name.length > 2 && new_first_name.length < 24) && (new_last_name.length > 2 &&
                    new_last_name.length < 24)) {
                $.ajax({
                    url: 'ajax/settings/settings_change_name_ajax.php',
                    type: 'POST',
                    data: {
                        new_first_name: new_first_name,
                        new_last_name: new_last_name,
                        user_logged_in: user_logged_in
                    },
                    error: function () {
                        alert('error try again');
                    },
                    success: function (data) {
                        $('.setting_value_name').html(new_first_name + ' ' + new_last_name);
                        $('.user_first_last_name').html(new_first_name + ' ' + new_last_name);
                        $('.user-name-menu-span').html(new_first_name + ' ' + new_last_name);
                        $('.setting_value_input_field_first_name').css('border',
                            '.2rem solid green')
                        $('.setting_value_input_field_last_name').css('border', '.2rem solid green')
                        // notification
                        simpleNotify.notify('First and last name has been updated', 'good');


                    }
                })
                $(".toggel_conatiner_setting_page_name").css('display', 'none');
                $(".change_first_last_name").css('display', 'grid');

            } else {
                $('.setting_value_input_field_first_name').css('border', '.2rem solid red')
                $('.setting_value_input_field_last_name').css('border', '.2rem solid red')
                simpleNotify.notify('First or Last are too short or too long', 'danger');

                // notification
            }
        })

        // update user bio

        $('.submit_setting_value_text-area').click(function () {
            var bio = $('.setting_value_textarea').val();
            var user_logged_in = '<?php echo $user_name?>';
            $.ajax({
                url: 'ajax/settings/settings_change_bio_ajax.php',
                type: 'POST',
                data: {
                    bio: bio,
                    user_logged_in: user_logged_in
                },
                error: function () {
                    alert('error try again');
                },
                success: function (data) {
                    // notification popup
                }
            })
            $(".toggel_conatiner_setting_page_bio").css('display', 'none');
            $(".change_bio").css('display', 'grid');
            simpleNotify.notify('Biography has been updated', 'good');

        })

        // update profile pic


        $('.submit_setting_value_profile_pic').click(function (e) {
            var user_logged_in = '<?php echo $user_name?>';
            var file_name = $('input[type=file]').val();

            var file_name = file_name.replace(/C:\\fakepath\\/, '')
            var filename_rand = '<?php echo $filename_rand ;?>'
            $.ajax({
                url: 'upload_profile_pic.php',
                type: 'POST',
                data: {
                    user_logged_in: user_logged_in,
                    file_name: file_name,
                    filename_rand: filename_rand,
                },
                error: function () {
                    alert('error try again');
                },
                success: function (data) {}
            })
            $(".toggel_conatiner_setting_page_profile_pic").css('display', 'none');
            $(".change_profile_pic").css('display', 'grid');

        })
        $('input[type=file]').change(function (event) {
            $(".setting_change_value_profile_pic_display_img_preview").fadeIn("fast").attr('src', URL
                .createObjectURL(event.target.files[0]));
        });
        // update user email

        function validateEmail(email) {
            var re =
                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
        $('.submit_setting_value_email').click(function () {
            var email = $('.setting_value_input_email').val();
            var repeat_email = $('.setting_value_input_repeat_email').val();
            var user_logged_in = '<?php echo $user_name?>';
            var is_email_used = false;
            // verifie if email is already used
            $.ajax({
                url: 'ajax/settings/verifie_email_class.php',
                type: 'POST',
                async: false,
                data: {
                    email: email,
                    user_logged_in: user_logged_in
                },
                error: function () {
                    alert('error try again');
                },
                success: function (data) {
                    $('.email_already_used').html(data);
                }
            })

            if ($('.email_already_used').text() == 'Email already used') {
                is_email_used = true;
            }
            if ((email == repeat_email) && (validateEmail(email)) && (is_email_used == false)) {
                $.ajax({
                    url: 'ajax/settings/settings_change_email_ajax.php',
                    type: 'POST',
                    data: {
                        email: email,
                        user_logged_in: user_logged_in
                    },
                    error: function () {
                        alert('error try again');
                    },
                    success: function (data) {
                        $('.setting_value_email').html(email)
                        // notification popup
                    }
                })
                $(".toggel_conatiner_setting_page_email").css('display', 'none');
                $(".change_email").css('display', 'grid');
                simpleNotify.notify('Email has been updated', 'good');
                $('.setting_value_input_email').css('border', '.2rem solid green')
                $('.setting_value_input_repeat_email').css('border', '.2rem solid green')
            } else {
                $('.setting_value_input_email').css('border', '.2rem solid red')
                $('.setting_value_input_repeat_email').css('border', '.2rem solid red')
                simpleNotify.notify('Invalid Email', 'danger');

                // notification
            }
        })


        // update user password

        $('.submit_setting_value_password').click(function () {
            var old_password = $('.setting_value_input_old_password').val();
            old_password = md5(old_password)
            var new_password = $('.setting_value_input_new_password').val();
            var repeat_password = $('.setting_value_input_repeat_password').val();
            var user_logged_in = '<?php echo $user_name?>';
            var user_password = '<?php echo($user_obj->get_user_password())?>';



            if ((old_password == user_password && new_password == repeat_password) && new_password.length > 5) {
                $.ajax({
                    url: 'ajax/settings/settings_change_password_ajax.php',
                    type: 'POST',
                    data: {
                        new_password: new_password,
                        user_logged_in: user_logged_in
                    },
                    error: function () {
                        alert('error try again');
                    },
                    success: function (data) {
                        // notification popup
                    }
                })
                $(".toggel_conatiner_setting_page_password").css('display', 'none');
                $(".change_password").css('display', 'grid');
                $('.setting_value_input_old_password').css('border', '.1rem solid #222')
                $('.setting_value_input_old_password').val('')
                $('.setting_value_input_new_password').css('border', '.1rem solid #222')
                $('.setting_value_input_new_password').val('')
                $('.setting_value_input_repeat_password').css('border', '.1rem solid #222')
                $('.setting_value_input_repeat_password').val('')
                location.reload();

            } else {
                $('.setting_value_input_old_password').css('border', '.2rem solid red');
                $('.setting_value_input_new_password').css('border', '.2rem solid red');
                $('.setting_value_input_repeat_password').css('border', '.2rem solid red')
                // notification
                simpleNotify.notify('invalid password', 'danger');

            }
        })


        // to prevent resubmition of post method when user reload page
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        $('.input-register2-tags').focus(function () {
            $('.scroling-div-step2-register').css('display', 'flex')
        })
        $('.input-register2-tags').focusout(function () {
            $('.scroling-div-step2-register').css('display', 'none')
        })
        $(".dropdown_step2 dt a").on('click', function () {
            $(".dropdown_step2 dd ul").slideToggle('fast');
        });

        function getSelectedValue(id) {
            return $("#" + id).find("dt a span.value").html();
        }
        var title;
        $('.mutliSelect input[type="checkbox"]').on('click', function () {

            title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
                title = $(this).val() + ",";

            if ($(this).is(':checked')) {
                var html = '<span title="' + title + '" " class="category_val">' + title + '</span>';
                $('.multiSel').append(html);
                $(".hida").hide();
            } else {
                $('span[title="' + title + '"]').remove();
                var ret = $(".hida");
                $('.dropdown_step2 dt a').show(ret);

            }
        });
        $('.submit_setting_value_category').click(function(){
            var tag_value = '';
            
            if($('input[name="check_box_category"]:checked'))
            {
                tag_value = tag_value +$('.category').attr('value')   
            }
            alert(tag_value)
        })
    </script>
</body>

</html>