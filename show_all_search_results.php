<?php

define("header",true);
include('header.php');

?>

<?php
include('classes/notification.php');
include('classes/user.php');

if (isset($_SESSION['user_name_log_in'])) {
    $user_name=$_SESSION['user_name_log_in'];
    $query_log_in=mysqli_query($con,"SELECT * FROM users WHERE user_name ='$user_name'");
    $row=mysqli_fetch_array($query_log_in);
}else{
    header('location: index.php');
}
$user_obj=new user($con,$user_name);
$notification_obj=new notification($con,$user_name);

if (isset($_GET['q'])) {
    $q_val=$_GET['q'];
}
include('classes/main_search_result_class.php');
$search_obj=new main_search_result($con,$q_val);
$num_notification=$notification_obj->num_notification($user_name);

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
            <div class="empty-main-content1">

            </div>
            <div class="post">
                <form action="" method="POST">
                    <input type="hidden" name='hidden_id_val'>
                </form>
                <div class="post-container">
                    <div class="top-header-post" style="display: flex;justify-content: space-between;">
                        <h4>Search results</h4>
                        <i class="fas fa-poo" style="font-size:2.3rem;"></i>
                    </div>
                    
                    <div class="load_post">
                        <hr>
                        <div class="show_all_search_result_container">
                            <?php
                            $number_search_result=$search_obj->number_of_search_results();
                            echo "<span class='main_search_num_results'>$number_search_result results found</span>";

                            $search_obj->load_main_search_result();
                                ?>                               
                        </div>
                    </div>
                    <!-- !!!!!!!!!!!!!!!!!!!!! -->

                    <div class="pagination">
                        <span href="#" class="pagination_content active" id='pagination_1'>1</span>
                        <!-- <span href="#" class="pagination_content" id='pagination_2'>2</span>
                        <span href="#" class="pagination_content" id='pagination_3'>3</span>
                        <span href="#" class="pagination_content" id='pagination_4'>4</span>
                        <span href="#" class="pagination_content" id='pagination_5'>5</span>
                        <span href="#" class="pagination_content" id='pagination_6'>6</span> -->
                            <?php
                            $search_obj->pagination($number_search_result);
                            ?>
                    </div>
                </div>
            </div>
            <!-- **************** -->
            <div class="side">

                <div class="ads second-ads" style="margin-top:0;position:static">
                    <span> advertisment</span>
                </div>
                <div class="tags" style="font-size:3rem;">
                    <div class="header-side">
                        <h3 class="header-side-text">Tags that you may like</h3>
                    </div>
                    <div class="tags-friend-content" style="display: flex;flex-direction:column;">
                        <div class="tags_name"><img src="images/phpimg.png" alt=""><a href="#">PHP</a></div>
                        <hr>
                        <div class="tags_name"><img src="images/java.webp" alt=""><a href="#">Java</a></div>
                        <hr>
                        <div class="tags_name"><img src="images/cpp.png" alt=""><a href="#">Cpp</a></div>
                        <hr>
                    </div>
                    <div class="span-button"> <a href="#">Show more</a></div>
                </div>
                <div class="ads second-ads" style="position:static">
                    <span> advertisment</span>
                </div>
                <div class="footer" style="position:static">
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
        <div class="close_slide">
                +
            </div>
            <div class="slide-menu-header">
                <h3>Account info</h3>
                
            </div>
            <hr>
            <div class="slide-menu-profile-pic">
                <img src="<?php echo $user_obj->get_profile_pic()?>" alt="" style="width:4.3rem;">
                <a href="">
                    <p><?php echo $user_obj->get_first_last_name() ?></p>
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
                    <img src="images/icons/home.png" alt=""  style="height:2.1rem;">
                    <a
                        href="main.php">
                        <p>Home Page</p>
                    </a>
                </div>
                <div class="slide-menu-option">
                    <img src="images/icons/user.png" alt=""  style="height:2.1rem;">
                    <a
                        href="profile.php?user_profile=<?php echo $user_name?>">
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
                    href="marked_post_page.php?user_profile=<?php echo $user_name?>">
                    <p>Marked Post</p>
                    </a>
                </div>
                <hr>
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

        document.querySelector('.user-name-menu').addEventListener("click", function () {
                document.querySelector('.slide-menu-wraper').style.display = "block";
            });

           


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

            // paggination script
           
            $('.pagination_content').click(function(){
                var pagination_id =$(this).attr('id');
                pagination_id = pagination_id.substr(11);

                var input_search_val = '<?php echo $q_val?>';

                $('.pagination_content').removeClass('active');
                $(this).addClass('active')
                // var pagination_formul_start=(parseInt(pagination_id)-1)*10
                var pagination_formul_end=(parseInt(pagination_id)-1)*10
                window.scrollTo(0,0)
                $.post('ajax/pagination_main_search_ajax.php',{
                    // pagination_formul_start:pagination_formul_start,
                    pagination_formul_end:pagination_formul_end,
                    input_search_val:input_search_val
                },function(data){
                    $('.show_all_search_result_container').html(data)
                })
            })
       </script> 

</body>

</html>