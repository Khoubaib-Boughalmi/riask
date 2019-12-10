<?php
    define("header",true);
    include('header.php');
    if ($_COOKIE['user_name_log_in']) {
        header('Location: main.php');
    }
?>

<body>

    <!-- main page -->
    <section class="main-page">
        <!-- start of left -->
        <div class="left">
            <div class="left-container">
                <div class="">
                    <h3 class="left-content-heading"> Education is the passport to the future, for tomorrow belongs to those who prepare for it today. <i>– Malcolm X</i></h3>
                </div>
            </div>


        </div>
        <!-- end of left -->

        <!-- start of right -->
        <div class="right">
            <div class="right-content">
                <form class="right-content-form" action="" method="POST">
                    <input type="text" class="user-email" name="user_email_log_in" placeholder="Email"
                        required>
                    <div class="user-password-div">
                        <input type="password" class="user-password" name="user_password_log_in" placeholder="Password"
                            required>
                        <input type="" name="user_name_log_in" style="display:none;">
                        <a href="#">Forgot Password</a>
                    </div>
                    <input class="submit" id="submit" type="submit" name="submit_log_in" value="Log in">
                </form>
            </div>
            <div class="middle-content">
                <i class="fa fa-brain"></i>
                <h1>Riask where everyone has the right to access information</h1>
                <h4>Join Riask</h4>
                <a href="#" class="btn sign-up">Log In</a>
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
            <div class="right_side_registration">

                <div class="create_account_email_header">
                    <span class="create_account_email_header_text">Feel free to submit your personal information</span>
                </div>

                <form action="" method="POST" id="form-register" autocomplete="off">
                    <input type="text" class="popup-input popup firstName-popup" name="reg_first_name"
                        placeholder="First Name" autocomplete="off" required>
                    <input type="text" class="popup-input popup lastName-popup" name="reg_last_name"
                        placeholder="Last Name" autocomplete="off" required>
                    <br>
                    <input type="email" class="popup-input popup email-popup" name="reg_email" placeholder="E-mail"
                        autocomplete="off" required value="">
                    <br>
                    <input type="password" class=" popup-input popup password-popup password-popup-one"
                        name="reg_password" placeholder="Password" autocomplete="off" required>
                    <input type="password" class="popup-input popup password-popup repeat-password-popup"
                        name="reg_repeat_password" placeholder="Repeat Password" autocomplete="off" required>
                    <br>
                    <span id="button-popup" onclick="load_errors()">Register</span>
                </form>


            </div>

        </div>
    </div>
    <div class="log_in_pop_up_container">
        <div class="log_in_pop_up">
            <div class="close_log_in">
                +
            </div>
            <div class="log_in_pop_up_body ">
                <div class="upper_log_in_pop_up">
                <span class="log_in_mobile_text">Log-in E-mail </span>
                <br>
                <input type="text" class="log_in_pop_up_mobile email_pop_up" style="margin-bottom: 3rem;" placeholder="Email">
                <br>
                <span class="log_in_mobile_text">Log-in Password </span>
                <br>
                <input type="password" class="log_in_pop_up_mobile password_pop_up" placeholder="Password">
                </div>
                <div class="lower_log_in_pop_up">
                    <a href="#" class="log_in_button_pop_up" id="button-popup">Log in</a>
                </div>
            </div>
        </div>
    </div>
    <script src="js/front.js"></script>
    <?php
include('log_in.php');
?>

    <script>
        var error_array = new Array();

        // create a remove function
        function removeItem(name) {
            for (var i = error_array.length - 1; i >= 0; i--) {
                if (error_array[i] === name) {
                    error_array.splice(i, 1);
                }
            }
        }
        $('.firstName-popup').keyup(function () {
            if ((($(this).val().length < 3)) || ($(this).val().length > 25)) {
                $('.firstName-popup').css('border', '.2rem solid red');
                error_array.push('First Name should be between 2 and 25 character');
            } else {
                $('.firstName-popup').css('border', '.2rem solid green');
                removeItem('First Name should be between 2 and 25 character');

            }
        })

        $('.lastName-popup').keyup(function () {
            if (($(this).val().length < 3) || ($(this).val.length) > 25) {
                $('.lastName-popup').css('border', '.2rem solid red');
                error_array.push('Last Name should be between 2 and 25 character')

            } else {
                $('.lastName-popup').css('border', '.2rem solid green');
                removeItem('Last Name should be between 2 and 25 character')


            }
        })

        $('.password-popup-one').keyup(function () {
            if (($(this).val().length < 6) || ($(this).val.length) > 30) {
                $('.password-popup-one').css('border', '.2rem solid red');
                error_array.push('password should be between 6 and 30 character')

            } else {
                $('.password-popup-one').css('border', '.2rem solid green');
                removeItem('password should be between 6 and 30 character')


            }
        })

        // see if password do not matche
        $('.repeat-password-popup').keyup(function () {

            if (document.querySelector('.password-popup-one').value == document.querySelector(
                    '.repeat-password-popup').value) {
                document.querySelector('.repeat-password-popup').style.border = "0.2rem solid green";
                removeItem('Repeated Password Incorrect')

            } else {
                // notification for password                
                document.querySelector('.repeat-password-popup').style.border = "0.2rem solid red";
                error_array.push('Repeated Password Incorrect')

            }
        })

        function validateEmail(email) {
            var re =
                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
        $(document).ready(function (e) {
            $('.email-popup').blur(function () {
                var email_val = $(this).val();
                $.post("get_emails.php", {
                    suggestion: email_val
                }, function (data) {
                    if (data != '0') {
                        $('.email-popup').css('border', '.2rem solid red');
                        simpleNotify.notify('Email already used', 'danger');
                        error_array.push('Email Already used')

                    } else {
                        if (validateEmail(email_val)) {
                            $('.email-popup').css('border', '.2rem solid green');
                            removeItem('Invalid Email')

                        } else {
                            $('.email-popup').css('border', '.2rem solid red');
                            error_array.push('Invalid Email')

                        }
                        removeItem('Email Already used')


                    }
                })
            })
        })




        $('#button-popup').click(function (e) {
            if (error_array.length > 0) {
                const distinct = (value, index, self) => {
                    return self.indexOf(value) === index;
                }
                var dis = error_array.filter(distinct);
                dis = dis.reverse();
                // $("#button-popup").addClass("not-allowed");
                dis.forEach(e => {
                    simpleNotify.notify(e, 'danger');
                });
            }
            if (($('.email-popup').val() === '') || ($('.repeat-password-popup').val() == '') || ($(
                    '.lastName-popup').val() == '') || ($('.firstName-popup').val() == '') || ($(
                    '.password-popup-one').val() == '')) {
                simpleNotify.notify('input field is empty', 'danger');

            } else {
                if (error_array.length == 0) {
                    // important do php just before inserting data in db 
                    first_name = $('.firstName-popup').val();
                    last_name = $('.lastName-popup').val();
                    email = $('.email-popup').val();
                    password = $('.repeat-password-popup').val();
                    sessionStorage.setItem('first_name', first_name);
                    sessionStorage.setItem('last_name', last_name);
                    sessionStorage.setItem('email', email);
                    sessionStorage.setItem('password', password);
                    window.location.replace("step2-register.php");

                }
            }
        })
        $('.log_in_button_pop_up').click(function () {
            var email_pop_up_val = $('.email_pop_up').val();
            var password_pop_up_val = $('.password_pop_up').val();
            $.ajax({
                url: 'ajax/log_in_pop_up.php',
                type: 'POST',
                data: {
                    email_pop_up_val:email_pop_up_val,
                    password_pop_up_val:password_pop_up_val
                },
                error: function () {
                    alert('error');
                },
                success: function (data) {
                    if (data == 1) {
                        window.location.replace("main.php");
                        // $('.email_pop_up').val(data)
                    }else{
                        simpleNotify.notify('Email or password are incorrect', 'danger'); 
                        $('.email_pop_up').css('border', '.2rem solid red');
                        $('.password_pop_up').css('border', '.2rem solid red');
                    }
                }
            })

        })

        $('.sign-up').click(function(){
            $('.log_in_pop_up_container').css('display','block');
        })
        $('.close_log_in').click(function(){
            $('.log_in_pop_up_container').css('display','none');
        })
    </script>
</body>

</html>