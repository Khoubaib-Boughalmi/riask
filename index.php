<?php
    define("header",true);
    include('header.php');
?>
<body>

    <!-- main page -->
    <section class="main-page">
        <!-- start of left -->
        <div class="left">
            <div class="left-container">
                <div class="">
                    <i class="fas fa-search"></i>
                    <h3 class="left-content-heading "> Find your intrests</h3>
                </div>
                <div class="">
                    <i class="fas fa-user-friends"></i>
                    <h3 class="left-content-heading"> Explore more</h3>
                </div>
                <div class="">
                    <i class="fas fa-comment"></i>
                    <h3 class="left-content-heading"> Join us</h3>
                </div>
            </div>


        </div>
        <!-- end of left -->

        <!-- start of right -->
        <div class="right">
            <div class="right-content">
                <form class="right-content-form" action="" method="POST">
                    <input type="text" class="user-email" name="user_email_log_in" placeholder="Phone, Email, Username"
                        required>
                    <div class="user-password-div">
                        <input type="password" class="user-password" name="user_password_log_in" placeholder="Password"
                            required>
                        <input type="" name="user_name_log_in" style="display:none;">
                        <a href="#">Forgot Password</a>
                    </div>
                    <input class="submit" id="submit" type="submit" name="submit_log_in" value="log-in">
                </form>
            </div>
            <div class="middle-content">
                <i class="fa fa-brain"></i>
                <h1>Exlore what's hapenning</h1>
                <h4>Join Riask</h4>
                <a href="#" class="btn sign-up">log In</a>
                <a href="#" class="btn log-in" id="log-in">Register</a>
            </div>
            <!-- Footer -->
            <div class="main-page-footer">

                <div class="main-page-footer-div"><a href="#">Help</a></div>
                <div class="main-page-footer-div"><a href="#">About</a> </div>
                <div class="main-page-footer-div"><a href="#">Terms</a> </div>
                <div class="main-page-footer-div"><a href="#">Privacy Policy</a> </div>
                <div class="main-page-footer-div"><a href="#">Join Our Team</a> </div>
                <div class="main-page-footer-div"><a href="#">&copy;2019 Riask</a></div>


                </footer>
                <!-- end of footer -->
            </div>
            <!-- end of right -->

    </section>
    </div>
    <!-- end of main page -->

    <!-- start of register popup -->
    <div class="bg-modal">
        <div class="modal-contents">
            <div class="close">+</div>

            <div class="left_side_registration">
                <img src="images/chip.png" width="60%" alt="">
            </div>

            <div class="right_side_registration">

                <!-- <form action="" method="POST" id="form-register">
                    <input type="text" class="popup-input popup firstName-popup" name="reg_first_name"
                        placeholder="First Name" autocomplete="off" required>
                    <input type="text" class="popup-input popup lastName-popup" name="reg_last_name"
                        placeholder="last Name" autocomplete="off" required>
                    <br>
                    <input type="email" class="popup-input popup email-popup" name="reg_email" placeholder="E-Mail"
                        autocomplete="off" required>
                    <br>
                    <input type="password" class=" popup-input popup password-popup password-popup-one"
                        name="reg_password" placeholder="Password" autocomplete="off" required>
                    <input type="password" class="popup-input popup password-popup repeat-password-popup"
                        name="reg_repeat_password" placeholder="Repeat Password" autocomplete="off" required>
                    <br>
                    <input type="submit" class="" id="button-popup" value="Register" name="reg_submit"
                        onclick="load_errors()">
                </form> -->
                <div class="create_account_header">
                    <span class="create_account_header_text"> Sotmy amet consectetur adipisicing elit </span>
                </div>
                 <div class="create_account_log_in_options">
                <!--    <div class="create_account_facebook_container">
                        <div class="create_account_facebook_div" onclick="window.location = ''">
                            <img src="images/facebook_icon1.png" alt="" style="width: 4.5rem;padding: .5rem;">
                            <span class="create_account_facebook_text">Join Using Facebook</span>
                        </div>
                    </div> -->
                    <br>
                    <div class="create_account_email_container">
                        <div class="create_account_email_div">
                            <img src="images/email.png" alt="" style="width: 4.5rem;padding: .5rem;">
                            <span class="create_account_email_text">Join Using email</span>
                        </div>
                    </div>
                </div>
                <div class="create_account_footer">
                    Lorem ipsum dolor sit .
                </div>
            </div>

        </div>
    </div>
    <script src="js/front.js"></script>
    <?php
include('log_in.php');
?>

    <script>
        $('.create_account_email_container').click(function () {
            $.ajax({
                url: 'ajax/create_account_email.php',
                type: 'POST',
                data: {

                },
                error: function () {
                    alert('error');
                },
                success: function (data) {
                    $('.right_side_registration').html(data);
                }
            })
        })
    </script>
</body>

</html>