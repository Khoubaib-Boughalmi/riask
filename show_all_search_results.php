<?php

define("header",true);
include('header.php');
?>
<link rel="stylesheet" type="text/css" href="css/reaction.css" />

<!-- jQuery for Reaction system -->
<script type="text/javascript" src="js/reaction.js"></script>
<?php
include('classes/notification.php');
include('classes/main_search_result_class.php');
if (isset($_SESSION['user_name_log_in'])) {
    $user_name=$_SESSION['user_name_log_in'];
    $query_log_in=mysqli_query($con,"SELECT * FROM users WHERE user_name ='$user_name'");
    $row=mysqli_fetch_array($query_log_in);
}else{
    header('location: index.php');
}
$notification_obj=new notification($con,$user_name);

if (isset($_GET['q'])) {
    $q_val=$_GET['q'];
}
$search_obj=new main_search_result($con,$q_val);
$num_notification=$notification_obj->num_notification($user_name);

?>
<script>
    $(document).ready(function () {
        var count_posts = 10;
        $('.show_more_button').click(function () {
            count_posts = count_posts + 10;
            $('.load_post').load("load_posts.php", {
                count_posts: count_posts
            })

        });
    })
</script>

<body style="background-color: #DAE0E6;overflow-x: hidden;">
    <section class="main-page-main">
        <!--start navigation bar -->
        <nav id="main-nav">
            <div class="user-main">
                <a class="user-name-menu" href="profile.php?user_profile=<?php echo $row['user_name']?>"><i class="fas fa-bars" style="font-size:1.8rem;"></i><span
                        class="user-name-menu-span"><?php echo $row['first_name'].' ';echo $row['last_name']?></span></a>
            </div>
            </div>
            </div>
            <div class="search-main">
                <i class=" fas fa-search" style="color:#222222;"></i>
                <input type="text" class="input-search input-search-main" placeholder="Search">
            </div>
            <div class="navigation-icons">
                <a href="#"><i class="fas fa-home"></i></a>
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
                <a href="#" class="fa-cog"><i class="fas fa-cog"></i></a>
                <a href="#"><i class="fas fa-pencil-alt"></i></a>
                <a href="classes/log_out.php" class="fa-sign-out-alt"><i class="fas fa-sign-out-alt"></i></a>
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
                    <div class="tags-friend-content" style="display flex;flex-direction:column;">
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
            <div class="slide-menu-header">
                <h3>Account info</h3>
                <a href="#">
                    <p class="slide-menu-header-close">+</p>
                </a>
            </div>
            <hr>
            <div class="slide-menu-profile-pic" style="display:flex;">
                <a href="<?php echo 'profile.php?user_profile='.$row['user_name']?>"><img src="<?php echo $row['profile_pic'] ?>" alt="" style="width:4.3rem;"></a>
                <a href="<?php echo 'profile.php?user_profile='.$row['user_name']?>">
                    <p><?php echo $row['first_name'].' ';echo $row['last_name']?></p>
                </a>
            </div>
            <div class="number-posts">
                <p><?php echo $row['followed_by'].' '.'Follower';?></p>
            </div>
            <hr>

            <div class="slide-menu-options">
            <div class="slide-menu-option">
                    <a href="profile.php?user_profile=<?php echo $row['user_name'] ?>">
                    <i class="fas fa-user" style="font-size:1.8rem;"></i>
                        <p>My Profile</p>
                    </a>
                </div>
                <div class="slide-menu-option">
                    <a href="marked_post_page.php?user_profile=<?php echo $row['user_name'] ?>">
                    <i class="far fa-bookmark" style="font-size:1.8rem;"></i>
                        <p>Marked post</p>
                    </a>
                </div>
             
                <div class="slide-menu-option">
                <a href="create-post.php">
                    <i class="fas fa-pencil-alt" style="font-size:1.8rem;"></i>
                        <p>Create A Post</p>
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
                    <a href="classes/log_out.php">
                        <p style="margin-left:0;">Log Out</p>
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
        document.querySelector('.user-name-menu').addEventListener("click", function () {
                document.querySelector('.slide-menu-wraper').style.display = "block";
            });

            document.querySelector('.slide-menu-header-close').addEventListener("click", function () {
                document.querySelector('.slide-menu-wraper').style.display = "none";
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