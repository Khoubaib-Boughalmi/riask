<?php

define("header",true);
include('header.php');
include('classes/load_category.php');
$category = new category($con);
?>
<style>

</style>


<body class="step_2_background">

    <div class="bg-modal" style="display:flex;	background-color: rgba(0, 0, 0,0);">
        <div class="modal-contents_step_2">

            <!-- <div class="left_side_registration_step_2">
                <span>Let's make the world a better place</span>
                <q>Your time is limited, so don't waste it living someone else's life</q>
            </div> -->
            <form action="" method="POST" style="padding:2rem 5rem">
                <label id="header-register2" for="">Let us know more about you</label>
                <br>
                <label id="paragraph-register2" for="">What do you want us to call you</label>
                <input type="text" class="popup input-register2 input-register2-user-name"
                    name="input-register2-user-name" placeholder="User Name" required>
                <br>
                <label id="paragraph-register2" for="">What are you interested in</label>
                <dl class="dropdown_step2">

                    <dt>
                        <a href="#" style="border: .1rem solid grey;">
                            <span class="hida">Select</span>
                            <p class="multiSel"></p>
                        </a>
                    </dt>

                    <dd>
                        <div class="mutliSelect">
                            <ul>
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

                <br>

            </form>
            <div class="label" style="flex-direction: column;height: 12rem;">
                <label id="conditions" for="">En appuyant sur Inscription, vous acceptez nos <a href="#">Condition</a>,
                    notre Politique d’utilisation des données et notre Politique
                    d’utilisation des <a href="#">cookies</a>. Vous recevrez peut-être des notifications par texto
                    de notre part et vous pouvez à tout moment vous désabonner.</label>

                <span id="button-popup" class="button-popup-register2">Create my account</span>
            </div>
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

            $('.input-register2-tags').keyup(function () {
                var tag_val = $('.input-register2-tags').val();

                $.post('get_tags.php', {
                    tag: tag_val
                }, function (data) {
                    $('.scroling-div-step2-register-body').html(data);
                });
            });

            $('.button-popup-register2').click(function (e) {
                if (($('.input-register2-user-name').val() == '') || ($('.input-register2-tags')
                        .val() == '')) {
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
                        var tag_val = $('.input-register2-tags').val();
                        var user_name = sessionStorage.getItem('user_name_log_in')
                        var first_name = sessionStorage.getItem('first_name')
                        var last_name = sessionStorage.getItem('last_name')
                        var password = sessionStorage.getItem('password')
                        var email = sessionStorage.getItem('email')
                        $.ajax({
                            url: 'ajax/add_user_info_db_create_account.php',
                            type: 'POST',
                            data: {
                                user_name: user_name,
                                first_name: first_name,
                                tag_val: tag_val,
                                last_name: last_name,
                                password: password,
                                email: email
                            },

                            error: function () {
                                alert('error');
                            },
                            success: function (data) {
                                window.location.replace("index.php");
                            }
                        })
                    }
                }
            })
            //    $('.input-register2-tags').keyup(function(){
            //         var len_tag = $('.input-register2-tags').val();
            //             len_tag =len_tag.length;
            //         if(len_tag>0){
            //             $('.scroling-div-step2-register').css('display','flex')
            //         }else{
            //             $('.scroling-div-step2-register').css('display','none')

            //         }
            //    })

            $('.input-register2-tags').focus(function () {
                $('.scroling-div-step2-register').css('display', 'flex')
            })
            $('.input-register2-tags').focusout(function () {
                $('.scroling-div-step2-register').css('display', 'none')
            })
            /*
            	Dropdown with Multiple checkbox select with jQuery - May 27, 2013
            	(c) 2013 @ElmahdiMahmoud
            	license: https://www.opensource.org/licenses/mit-license.php
            */

            $(".dropdown_step2 dt a").on('click', function () {
                $(".dropdown_step2 dd ul").slideToggle('fast');
            });

            $(".dropdown_step2 dd ul li a").on('click', function () {
                //   $(".dropdown_step2 dd ul").hide();
            });

            function getSelectedValue(id) {
                return $("#" + id).find("dt a span.value").html();
            }

            // $(document).bind('click', function(e) {
            //   var $clicked = $(e.target);
            //   if (!$clicked.parents().hasClass("dropdown_step2")) $(".dropdown_step2 dd ul").hide();
            // });

            $('.mutliSelect input[type="checkbox"]').on('click', function () {

                var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
                    title = $(this).val() + ",";

                if ($(this).is(':checked')) {
                    var html = '<span title="' + title + '">' + title + '</span>';
                    $('.multiSel').append(html);
                    $(".hida").hide();
                } else {
                    $('span[title="' + title + '"]').remove();
                    var ret = $(".hida");
                    $('.dropdown_step2 dt a').show(ret);

                }
            });
        });
    </script>
</body>

</html>