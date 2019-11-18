<script src="3rd_party/notification/simpleNotify.min.js"></script>
<link rel="stylesheet" href="3rd_party/notification/simpleNotifyStyle.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<?php
// connection with db
$con = mysqli_connect('localhost','root','','riask');
if(mysqli_connect_errno()){
    echo 'connection failled';
}

// declaring variables
$first_name="";
$last_name="";
$email="";
$password="";
$repeat_password="";

if(isset($_POST['reg_submit'])){
    $first_name=strip_tags($_POST['reg_first_name']);
    $first_name=str_replace(' ','',$first_name);
    $first_name=ucfirst(strtolower($first_name));

    $last_name=strip_tags($_POST['reg_last_name']);
    $first_name=str_replace(' ','',$last_name);
    $first_name=ucfirst(strtolower($last_name));

    $email=strip_tags($_POST['reg_email']);
    $email=str_replace(' ','',$email);

    $password=strip_tags($_POST['reg_password']);

    $repeat_password=strip_tags($_POST['reg_repeat_password']);

    $date=date("Y-m-d");
    // change input name and last name border color
    // see if email is already used
    ?>
    <script>
          var error_array =[];
        // create a remove function
       function removeItem(name){
        for(var i = error_array.length - 1; i >= 0; i--) {
        if(error_array[i] === name) {
        error_array.splice(i, 1);
            }
        }
       }
        

            $(document).ready(function(e){
                $('.firstName-popup').keyup(function(){
                    if($(this).val().length<3){
                        $('.firstName-popup').css('border','.2rem solid red');
                        error_array.push('firstName')
                    }else{
                        $('.firstName-popup').css('border','.2rem solid green');
                        removeItem('firstName')

                    }
                })

                $('.lastName-popup').keyup(function(){
                    if($(this).val().length<3){
                        $('.lastName-popup').css('border','.2rem solid red');
                        error_array.push('lastName')

                    }else{
                        $('.lastName-popup').css('border','.2rem solid green');
                        removeItem('lastName')


                    }
                })

                $('.password-popup-one').keyup(function(){
                    if($(this).val().length<6){
                        $('.password-popup-one').css('border','.2rem solid red');
                        error_array.push('password-one')

                    }else{
                        $('.password-popup-one').css('border','.2rem solid green');
                        removeItem('password-one')


                    }
                })
            })
        </script>
        <script>
            function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
            }
            $(document).ready(function(e){
                $('.email-popup').blur(function(){
                    var email_val = $(this).val();
                    $.post("get_emails.php",{
                        suggestion: email_val   
                    },function(data){
                        if(data != '0'){
                        $('.email-popup').css('border','.2rem solid red');
                        simpleNotify.notify('Email already used','danger');
                        }else{
                            if(validateEmail(email_val)){
                                $('.email-popup').css('border','.2rem solid green');
                                removeItem('password')

                            }else{
                                $('.email-popup').css('border','.2rem solid red');
                                error_array.push('password')

                                }

                        }
                    })
                })
            })
        </script>
        <script>
        
        document.querySelector('.repeat-password-popup').addEventListener("focus", function(e) {
            // see if password do not matche
            $('.repeat-password-popup').keyup(function(){

                if(document.querySelector('.password-popup').value ==document.querySelector('.repeat-password-popup').value){
                    document.querySelector('.repeat-password-popup').style.border = "0.2rem solid green";
                    removeItem('repeat-password')

                } else{
                // notification for password                
                    document.querySelector('.repeat-password-popup').style.border = "0.2rem solid red";
                    error_array.push('repeat-password')

                }
            })
        });           
        </script>

        <!-- enable submit button -->
            <script>
                document.querySelector('#button-popup').addEventListener("click", function(e) {    
                    if(error_array.length > 0){
                        $("#button-popup").prop('disabled', true);
                        // $("#button-popup").addClass("intro");

                    }else{
                        $("#button-popup").prop('disabled', false);

                    }
                })
            </script>
             <?php
             }

?>













<?php 
     if(isset($_POST['reg_submit'])){
                            $query_inserting_users = mysqli_query($con,"INSERT INTO `users`(`id`, `first_name`, `last_name`, `user_name`, `email`, `password`, `number_posts`, `profile_pic`, `user_closed`, `folowers`) VALUES ('','9','9','9','9','9','9','9','9','9')");
                            if( $query_inserting_users == true){
                                echo 'hiii';
                            }else{
                                echo 'noooooooo';
                            };
                        }
                        ?>



<!-- ************ -->
<?php
$first_name= $_COOKIE['first_name_cookie'];
$last_name= $_COOKIE['last_name_cookie'];
$email= $_COOKIE['email_cookie'];
$password= $_COOKIE['password_cookie'];
$repeat_password= $_COOKIE['repeat_password_cookie'];

    $first_name=strip_tags($first_name);
    $first_name=str_replace(' ','',$first_name);
    $first_name=ucfirst(strtolower($first_name));

    $last_name=strip_tags($last_name);
    $last_name=str_replace(' ','',$last_name);
    $last_name=ucfirst(strtolower($last_name));

    $email=strip_tags($email);
    $email=str_replace(' ','',$email);

    $password=strip_tags($password);

    $repeat_password=strip_tags($repeat_password);

    $date=date("Y-m-d");
    // change input name and last name border color
    // see if email is already used 
        
    ?>

    <!-- ++++++++++++ -->

    <script>
$(".firstName-popup").keyup(function(){
    var first_name=$('.firstName-popup').val();
    document.cookie="first_name_cookie="+first_name;
})
$(".lastName-popup").keyup(function(){

    var last_name=$('.lastName-popup').val();
    document.cookie="last_name_cookie="+last_name;
})
$(".email-popup").keyup(function(){

    var email=$('.email-popup').val();
    document.cookie="email_cookie="+email;
})
$(".password-popup-one").keyup(function(){

    var password=$('.password-popup-one').val();
    document.cookie="password_cookie="+password;
})
$(".repeat-password-popup").keyup(function(){

    var repeat_password=$('.repeat-password-popup').val();
    document.cookie="repeat_password_cookie="+repeat_password;
})

</script>


<?php 
$first_name_cookie= $_SESSION['reg_first_name'];
$last_name_cookie= $_SESSION['reg_last_name'];
$email_cookie= $_SESSION['reg_email'];
$password_cookie= $_SESSION['reg_password'];

?>




<?php 
echo $_SESSION['reg_first_name'];
echo $_SESSION['reg_last_name'];
echo $_SESSION['reg_email'];
echo $_SESSION['reg_password'];
echo $_SESSION['input-register2-user-name'];

?>

<?php
$inserting_query=mysqli_query($con ,"INSERT INTO users ('id', 'first_name', 'last_name', 'user_name', 'email', 'password', 'number_posts', 'profile_pic', 'user_closed', 'folowers', 'tags_user') VALUES ('','$first_name_cookie','$last_name_cookie','$user_name_cookie','$email_cookie','$password_cookie','0','','no','0','$tags_val_cookie')");
?>



$('.icon_comment').click(function() {
        var comment_id = this.id;
        var res = comment_id.substr(5,comment_id.length);
        alert(res)



        <!-- +++++++++++++++++++++++ -->

        <?php
     
    echo "<section class='main-page-main'>
        <!--start navigation bar -->
        <nav id='main-nav'>
            <div class='user-main'>
                <a class='user-name-menu' href=''><i class='fas fa-bars' style='font-size:1.8rem;'></i><span class='user-name-menu-span'>Khoubaib Boughalmi</span></a>
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
        
        <div class='post post-create-post'>
            <div class='post-header-create-post'>
                <h2>Show Comments</h2>
                <hr>
                <div class='create-post-botton-btn'>
           
                </div>
            </div>
            <div class='post_show_comments_container' style='padding:3rem;'>
            <script></script>
                        $post='';
                        $query_load_comment=mysqli_query($con,'SELECT * FROM posts WHERE id='56' ');
                        if (mysqli_num_rows($query_load_comment)>0) {
                 
                            while($row=mysqli_fetch_array($query_load_comment)){
                                $user_name=".$row['added_by'].";
                                $body=".$row['body'].";
                                $date_time=".$row['date_added'].";
                                $likes=".$row['likes'].";
                                $id=".$row['id'].";
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
                
                                    $post= '<div class='post_'".$row['id']."''>
                                            <div class='top-post'>
                                            <div class='post-body'>
                                                <div class='post-body-user-image'>
                                                    <div class='color-post-body'></div>
                
                                                </div>
                                                <div class=' post-body-text'>
                
                                                    <div class='user-name-timer'>
                                                    <div class='image-name-post'>
                                                        <img src='images/elon.jpg'  class='images-user-post'>
                                                        <span class='user-name-post'>$user_name</span>
                                                        </div>
                                                        <span class='timer-post'>$time_message</span>
                                                    </div>
                                                    <h4>Async Programming with PHP</h4>
                                                    <span>$body </span>
                                                    <img src='images/tesla.webp'  style='width:100%; max-height:30rem;'>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='bottom-post'>
                                            <div class='icon1'>
                                                <i class='far fa-thumbs-up' style='font-size:1.6rem;'></i>
                
                                                <span style=' class='span-icon-name'>$likes Push Up</span>
                                            </div>
                                            <div class='icon1 icon_comment' id='comment_'.".$row['id']."''>
                                                <i class='far fa-comment-alt' style='font-size:1.6rem;'></i>
                                                <a href='' ><span style=' class='span-icon-name'>Comment</span></a>
                                            </div>
                                            <div class='icon1'>
                                                <i class='far fa-bookmark' style='font-size:1.6rem;'></i>
                
                                                <span style=' class='span-icon-name'>Mark</span>
                                            </div>
                                            </div>
                                            <hr>
                                        </div>';
                                
                                echo $post;            
                        }
                        }else{
                        echo 'no posts to show';
                    }
                    
                
                

                <hr>
                </div>
                <div class='show_answeares' style='padding:3rem;'>
                    <h2 id='reply-show-replies'>Reply</h2>
                    <!-- Create the editor container -->
                <div class='description-create-post'>
                <h3 class='h3-create-post'>Tell us more about your question</h3>
                <h4 class='h4-create-post' style='margin-top:2rem;'>Your description gives people the information they need to help you answer your question.</h4>

                <div id='editor'>
                <p>Hello World!</p>
                <p>Some initial <strong>bold</strong> text</p>
                <p><br></p>
                </div>
                </div>

                <h4 class='h4-create-post' style='margin-top:2rem;'>Your description gives people the information they need to help you answer your question.</h4>
                <input type='submit' class='submit-create-post-body' value='Reply'  style='margin-bottom:5rem;'>
                <!-- Initialize Quill editor -->
                <script>
                var quill = new Quill('#editor', {
                    theme: 'snow'
                });
                </script>
                    <h2>Answears</h2>

                    <div class='top-post'>
                <div class='post-body'>
                    <div class='post-body-user-image'style='background-color:#008000b8;'>
                        <div class='color-post-body'></div>

                    </div>
                    <div class=' post-body-text'>

                        <div class='user-name-timer'>
                        <div class='image-name-post'>
                            <img src='images/elon.jpg'  class='images-user-post'>
                            <span class='user-name-post'> echo $id_val_session</span>
                            </div>
                            <span class='timer-post'>$time_message</span>
                        </div>
                        <h4>Async Programming with PHP</h4>
                        <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo consequuntur possimus excepturi autem, eveniet sunt earum veniam iste laboriosam cum itaque deleniti et ratione reprehenderit! </span>
                    </div>
                </div>
            </div>
            <div class='bottom-post'>
                <div class='icon1'>
                    <i class='far fa-thumbs-up' style='font-size:1.6rem;'></i>

                    <span style='' class='span-icon-name'>likes Push Up</span>
                </div>
                <div class='icon1'>
                    <i class='far fa-comment-alt' style='font-size:1.6rem;'></i>

                    <a href='#reply-show-replies'><span style='' class='span-icon-name'>Comment</span></a>
                </div>
                <div class='icon1'>
                    <i class='far fa-bookmark' style='font-size:1.6rem;'></i>

                    <span style='' class='span-icon-name'>Mark</span>
                </div>
                </div>
                <hr>
               
                <div class='top-post'>
                <div class='post-body'>
                    <div class='post-body-user-image' style='background-color:#008000b8'>
                        <div class='color-post-body'></div>

                    </div>
                    <div class=' post-body-text'>

                        <div class='user-name-timer'>
                        <div class='image-name-post'>
                            <img src='images/elon.jpg'  class='images-user-post'>
                            <span class='user-name-post'>$user_name</span>
                            </div>
                            <span class='timer-post'>$time_message</span>
                        </div>
                        <h4>Async Programming with PHP</h4>
                        <span>Lorem ipsum laboriosam cum itaque deleniti et ratione reprehenderit! </span>
                    </div>
                </div>
            </div>
            <div class='bottom-post'>
                <div class='icon1'>
                    <i class='far fa-thumbs-up' style='font-size:1.6rem;'></i>

                    <span style='' class='span-icon-name'>likes Push Up</span>
                </div>
                <div class='icon1'>
                    <i class='far fa-comment-alt' style='font-size:1.6rem;'></i>

                    <a href='#reply-show-replies'><span style='' class='span-icon-name'>Comment</span></a>
                </div>
                <div class='icon1'>
                    <i class='far fa-bookmark' style='font-size:1.6rem;'></i>

                    <span style='' class='span-icon-name'>Mark</span>
                </div>
                </div>
                <hr>

                <div class='top-post'>
                <div class='post-body'>
                    <div class='post-body-user-image' style='background-color:#777777d1;'>
                        <div class='color-post-body'></div>

                    </div>
                    <div class=' post-body-text'>

                        <div class='user-name-timer'>
                        <div class='image-name-post'>
                            <img src='images/elon.jpg'  class='images-user-post'>
                            <span class='user-name-post'>$user_name</span>
                            </div>
                            <span class='timer-post'>$time_message</span>
                        </div>
                        <h4>Async Programming with PHP</h4>
                        <span>Lorem ipsum dolor sit Lorem ipsum dolor sit, amet consectetur adipisicing elit. Non quasi necessitatibus optio praesentium, fugiat voluptatibus corrupti, dignissimos magni suscipit provident tempore illo! Reprehenderit, at earum. Fugiat perferendis eos alias incidunt suscipit optio unde nostrum, possimus aut? Excepturi, vitae hic. Fugiat officia provident quaerat dignissimos ea sequi adipisci cum perferendis similique explicabo ipsum corrupti mollitia maxime soluta doloribus, non velit hic atque minus, delectus repellendus vel ipsam! Rem maiores dolore, cumque quia eius, nobis facilis quidem aut neque delectus at excepturi mollitia similique labore libero distinctio omnis! Alias nostrum, earum minus fugit accusantium porro eius iste nesciunt? Accusamus nulla asperiores animi, officiis ducimus error quibusdam, obcaecati, minima illum deleniti possimus voluptatum. Temporibus consequatur sapiente voluptatum ipsa repellat dolores nulla dolore eaque repellendus ut, odio dolorum praesentium maxime dolorem quibusdam consequuntur id a pariatur hic minus deleniti harum iste velit quam! Officiis ducimus similique atque velit ipsum facilis maiores totam deleniti recusandae? amet consectetur adipisicing elit. Explicabo consequuntur possimus excepturi autem, eveniet sunt earum veniam iste laboriosam cum itaque deleniti et ratione reprehenderit! </span>
                    </div>
                </div>
            </div>
            <div class='bottom-post'>
                <div class='icon1'>
                    <i class='far fa-thumbs-up' style='font-size:1.6rem;'></i>

                    <span style='' class='span-icon-name'>likes Push Up</span>
                </div>
                <div class='icon1'>
                    <i class='far fa-comment-alt' style='font-size:1.6rem;'></i>

                    <a href='#reply-show-replies'><span style='' class='span-icon-name'>Comment</span></a>
                </div>
                <div class='icon1'>
                    <i class='far fa-bookmark' style='font-size:1.6rem;'></i>

                    <span style='' class='span-icon-name'>Mark</span>
                </div>
                </div>
                <hr>

                <div class='top-post'>
                <div class='post-body'>
                    <div class='post-body-user-image' style='background-color:#777777d1;'>
                        <div class='color-post-body'></div>

                    </div>
                    <div class=' post-body-text'>

                        <div class='user-name-timer'>
                        <div class='image-name-post'>
                            <img src='images/elon.jpg'  class='images-user-post'>
                            <span class='user-name-post'>$user_name</span>
                            </div>
                            <span class='timer-post'>$time_message</span>
                        </div>
                        <h4>Async Programming with PHP</h4>
                        <span>atque minus, delectus repellendus vel ipsam! Rem maiores dolore, cumque quia eius, nobis facilis quidem aut neque delectus at excepturi mollitia similique labore libero distinctio omnis! Alias nostrum, earum minus fugit accusantium porro eius iste nesciunt? Accusamus nulla asperiores animi, officiis ducimus error quibusdam, obcaecati, minima illum deleniti possimus voluptatum. Temporibus consequatur sapiente voluptatum ipsa repellat dolores nulla dolore eaque repellendus ut, odio dolorum praesentium maxime dolorem quibusdam consequuntur id a pariatur hic minus deleniti harum iste velit quam! Officiis ducimus similique atque velit ipsum facilis maiores totam deleniti recusandae? amet consectetur adipisicing elit. Explicabo consequuntur possimus excepturi autem, eveniet sunt earum veniam iste laboriosam cum itaque deleniti et ratione reprehenderit! </span>
                    </div>
                </div>
            </div>
            <div class='bottom-post'>
                <div class='icon1'>
                    <i class='far fa-thumbs-up' style='font-size:1.6rem;'></i>

                    <span style='' class='span-icon-name'>likes Push Up</span>
                </div>
                <div class='icon1'>
                    <i class='far fa-comment-alt' style='font-size:1.6rem;'></i>

                    <a href='#reply-show-replies'><span style='' class='span-icon-name'>Comment</span></a>
                </div>
                <div class='icon1'>
                    <i class='far fa-bookmark' style='font-size:1.6rem;'></i>

                    <span style='' class='span-icon-name'>Mark</span>
                </div>
                </div>
                <hr>
              
                <div class='top-post'>
                <div class='post-body'>
                    <div class='post-body-user-image'>
                        <div class='color-post-body'></div>

                    </div>
                    <div class=' post-body-text'>

                        <div class='user-name-timer'>
                        <div class='image-name-post'>
                            <img src='images/elon.jpg'  class='images-user-post'>
                            <span class='user-name-post'>$user_name</span>
                            </div>
                            <span class='timer-post'>$time_message</span>
                        </div>
                        <h4>Async Programming with PHP</h4>
                        <span>Lorem ipsum dolor sit Lorem, ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga neque, quos commodi totam vero deserunt atque voluptatibus libero eligendi optio nobis! Nemo sunt quae veniam numquam voluptatibus adipisci aliquid quo! Ad dolorem sunt minima ipsum nobis ducimus dolor perferendis fugiat qui ratione. amet consectetur adipisicing elit. Explicabo consequuntur possimus excepturi autem, eveniet sunt earum veniam iste laboriosam cum itaque deleniti et ratione reprehenderit! </span>
                    </div>
                </div>
            </div>
            <div class='bottom-post'>
                <div class='icon1'>
                    <i class='far fa-thumbs-up' style='font-size:1.6rem;'></i>

                    <span style='' class='span-icon-name'>likes Push Up</span>
                </div>
                <div class='icon1'>
                    <i class='far fa-comment-alt' style='font-size:1.6rem;'></i>

                    <a href='#reply-show-replies'><span style='' class='span-icon-name'>Comment</span></a>
                </div>
                <div class='icon1'>
                    <i class='far fa-bookmark' style='font-size:1.6rem;'></i>

                    <span style='' class='span-icon-name'>Mark</span>
                </div>
                </div>
               
                <hr>
                
                </div>

        </div>
            <!-- **************** -->
            <div class='side'>
                <div class='tags' style='font-size:3rem;'>
                    <div class='header-side'>
                        <h3 class='header-side-text'>Tags that you may like</h3>
                    </div>
                    <div class='tags-friend-content' style='display flex;flex-direction:column;'>
                        <div class='><img src='images/phpimg.png' alt='><a href='#'>PHP</a></div>
                        <hr>
                        <div class='><img src='images/java.webp' alt='><a href='#'>Java</a></div>
                        <hr>
                        <div class='><img src='images/cpp.png' alt='><a href='#'>Cpp</a></div>
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
                        <div class='><img src='images/phpimg.png' alt='><a href='#'>PHP</a></div>
                        <hr>
                        <div class='><img src='images/java.webp' alt='><a href='#'>Java</a></div>
                        <hr>
                        <div class='><img src='images/cpp.png' alt='><a href='#'>Cpp</a></div>
                        <hr>
                        <div class='><img src='images/java.webp' alt='><a href='#'>Java</a></div>
                        <hr>
                        <div class='><img src='images/phpimg.png' alt='><a href='#'>PHP</a></div>
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
                            <div class='><a href='#'>Help</a></div>
                            <div class='><a href='#'>About</a></div>
                            <div class='><a href='#'>Terms</a></div>
                        </div>
                        <div class='top-footer2'>
                            <div class='><a href='#'>Join Our Team</a></div>
                            <div class='><a href='#'>Privacy Policy</a></div>
                            <div class='><a href='#'>&copy;2019 Riask</a></div>
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
                <a href='#'><p class='slide-menu-header-close'>+</p></a>
            </div>
            <hr>
            <div class='slide-menu-profile-pic'>
                <img src='images/bill.jpg' alt=' style='width:4.3rem;'>
                <a href='><p>Khoubaib boughalmi</p></a>
            </div>
            <div class='number-posts'>
                <p>269 Follower</p>
            </div>
            <hr>
    
            <div class='slide-menu-options'>
                <div class='slide-menu-option'>
                <i class='fas fa-user' style='font-size:1.8rem;'></i><a href='#'><p>User Profile</p></a>
                </div>
                <div class='slide-menu-option'>
                <i class='fas fa-home' style='font-size:1.8rem;'></i><a href='#'><p>Home</p></a>
                </div>
                <div class='slide-menu-option'>
                <i class='fas fa-pencil-alt' style='font-size:1.8rem;'></i><a href='#'><p>Create A Post</p></a>
                </div>
                <div class='slide-menu-option'>
                <i class='fas fa-cog' style='font-size:1.8rem;'></i><a href='#'><p>User Settings</p></a>
                </div>
                <hr>
                <div class='slide-menu-option'>
                <a href='#'><p style='margin-left:0;'>Settings And Privacy</p></a>
                </div>
                <div class='slide-menu-option'>
                <a href='#'><p style='margin-left:0;'>Help</p></a>
                </div>
                <div class='slide-menu-option'>
                <a href='#'><p style='margin-left:0;'>Log Out</p></a>
                </div>
            </div>
        </div>
    </div>
  <script>
document.querySelector('.user-name-menu').addEventListener('click', function() {
	document.querySelector('.slide-menu-wraper').style.display = 'block';
});

document.querySelector('.slide-menu-header-close').addEventListener('click', function() {
	document.querySelector('.slide-menu-wraper').style.display = 'none';
});

    $('.toggle').click(function(){
        $('#two').toggle();
    });

</script>
"

?>
















".$like_dislike_obj->display_likes($id)."



<?php
    if (isset($_POST['submit_setting_value_name'])) {
        $new_first_name=$_POST['setting_value_input_field_first_name'];
        $new_last_name=$_POST['setting_value_input_field_last_name'];
        $update_name=mysqli_query($con,"UPDATE `users` SET first_name='$new_first_name', last_name='$new_last_name' where user_name='$user_name'");
        echo '<script>location.reload();</script>';
    }
    if (isset($_POST['submit_setting_value_text-area'])) {
        $new_bio=$_POST['setting_value_textarea'];
        $update_bio=mysqli_query($con,"UPDATE `users` SET user_bio='$new_bio' where user_name='$user_name'");
        echo '<script>location.reload();</script>';

    }
?> 