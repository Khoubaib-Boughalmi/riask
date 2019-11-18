<?php

define("header",true);
include('header.php');


?>


<body class="step_2_background">

    <div class="bg-modal" style="display:flex;	background-color: rgba(0, 0, 0,0);">
        <div class="modal-contents_step_2">

            <!-- <div class="left_side_registration_step_2">
                <span>Let's make the world a better place</span>
                <q>Your time is limited, so don't waste it living someone else's life</q>
            </div> -->
            <form action="" method="POST" style="padding:5rem">
                <label id="header-register2" for="">Let us know more about you</label>
                <br>
                <label id="paragraph-register2" for="">What do you want us to call you</label>
                <input type="text" class="popup input-register2 input-register2-user-name" name="input-register2-user-name" placeholder="User Name" value="<?php echo $_SESSION['userData']['email']?>"required>
                <br>
                <input type="text" class="popup input-register2 input-register2-password" name="input-register-password" placeholder="Password" required>
                <input type="text" class="popup input-register2 input-register2-repeat-password" name="input-register-repeat-password" placeholder="Repeat Password" required>
                <label id="paragraph-register2" for="">What are you interested in</label>
                <!-- <input type="tzxt" class="popup input-register2 input-register2-tags" name="input-register2-tags"
                    placeholder="Tags" required>
                <div class="scroling-div scroling-div-step2-register"
                    style=" display: flex;justify-content: center;margin-top:2rem;">
                    <div style="height:80px;width:90%;border:1px solid #ccc;overflow:auto;">
                        <p class="scroling-div-step2-register-body"></p>
                    </div>
                </div> -->
                <br>
                <div class="label" style="display:flex;">
                    <label id="conditions" for="">En appuyant sur Inscription, vous acceptez nos <a
                            href="#">Condition</a>, notre Politique d’utilisation des données et notre Politique
                        d’utilisation des <a href="#">cookies</a>. Vous recevrez peut-être des notifications par texto
                        de notre part et vous pouvez à tout moment vous désabonner.</label>

                </div>
                <br>
                <span id="button-popup" class="button-popup-register2">Create my account</span>
            </form>
        </div>
    </div>
    <div class="right-register2"></div>

    <!-- <script src="js/front.js"></script> -->
    <script>
        if (true) {
            simpleNotify.notify('<b>You are awesome   *--*</b>', 'attention');
        }
    </script>
    <script>
        var error_array = new Array();

        function removeItem(name) {
            for (var i = error_array.length - 1; i >= 0; i--) {
                if (error_array[i] === name) {
                    error_array.splice(i, 1);
                }
            }
        }

        $(document).ready(function (e) {
            $('.input-register2-user-name').blur(function () {
                var user_name_val = $(this).val();
                $.post("get_user_name.php", {
                    suggestion: user_name_val
                }, function (data) {
                    if (data != '0') {
                        $('.input-register2-user-name').css('border', '.2rem solid red');
                        simpleNotify.notify('Email already used', 'danger');
                        error_array.push('User name Already used')

                    } else {
                        simpleNotify.notify('User name availble', 'good');
                        $('.input-register2-user-name').css('border', '.2rem solid green');
                        removeItem('User name Already used')
                        sessionStorage.setItem('user_name_log_in', user_name_val)

                    }
                })
            })

            $('.input-register2-password').blur(function () {
                var password = $(this).val();
                if (password.length<6) {
                    simpleNotify.notify('password should be at least 6 characteres ', 'danger');
                    error_array.push('short password');
                    $(this).css('border', '.2rem solid red');

                }else{
                    $(this).css('border', '.2rem solid green');
                    removeItem('short password')


                }
                
            })

            $('.input-register2-repeat-password').blur(function () {
                var repeated_password = $(this).val();
             
                    if (repeated_password == $('.input-register2-password').val()) {
                    $(this).css('border', '.2rem solid green');
                    removeItem('passwords do not match');
                    }else{
                    simpleNotify.notify('passwords do not match ', 'danger');
                    error_array.push('passwords do not match');
                    $(this).css('border', '.2rem solid red');
                    }
                   
                
                
            })

            $('.input-register2-tags').keyup(function () {
                var tag_val = $('.input-register2-tags').val();

                $.post('get_tags.php', {
                    tag: tag_val
                }, function (data) {
                    $('.scroling-div-step2-register-body').html(data);
                });
            });

            $('.button-popup-register2').click(function (e) {
                if (($('.input-register2-user-name').val() == '') || ($('.input-register2-tags').val() == '')|| ($('.input-register2-password').val() == '')|| ($('.input-register2-repeat-password').val() == '')) {
                    simpleNotify.notify('input field is empty', 'danger');
                    error_array.push('input field is empty')


                } else {
                    removeItem('input field is empty')
                    if (error_array.length != 0) {
                        const distinct = (value, index, self) => {
                            return self.indexOf(value) === index;
                        }
                        var dis = error_array.filter(distinct);
                        dis = dis.reverse();
                        // $("#button-popup").addClass("not-allowed");
                        dis.forEach(e => {
                            simpleNotify.notify(e, 'danger');
                        });

                    } else {
                        // var tag_val = $('.input-register2-tags').val();
                        var user_name =$('.input-register2-user-name').val()
                        
                        var first_name = '<?php echo $_SESSION['userData']['first_name']; ?>'
                        var last_name = '<?php echo $_SESSION['userData']['last_name']; ?>'
                        var email = '<?php echo $_SESSION['userData']['email']; ?>'
                        var password=$('.input-register2-password').val();

                        $.ajax({
                        url: 'ajax/add_user_info_db_create_account.php',
                        type: 'POST',
                        data:{
                        user_name: user_name,
                        first_name:first_name,
                        last_name: last_name,
                        email:email,
                        password: password
                        },
                        
                        error: function(){
                            alert('error');
                        },
                        success:function (data) {
                            // window.location.replace("index.php");        
                            // alert('fffff')   
                            $('#header-register2').html(data)                 
                        }
                        }) 

                   }
                }
           })
        });
    </script>
</body>

</html>