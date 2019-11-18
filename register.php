<script src="3rd_party/notification/simpleNotify.min.js"></script>
<link rel="stylesheet" href="3rd_party/notification/simpleNotifyStyle.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<?php
// connection with db
$con = mysqli_connect('localhost','root','','riask');
if(mysqli_connect_errno()){
    echo 'connection failled';
}
?>



    <script>
        var error_array = new Array();

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
                    if((($(this).val().length<3))|| ($(this).val().length>25 )){
                        $('.firstName-popup').css('border','.2rem solid red');
                        error_array.push('First Name should be between 2 and 25 character');
                    }else{
                        $('.firstName-popup').css('border','.2rem solid green');
                        removeItem('First Name should be between 2 and 25 character');

                    }
                })

                $('.lastName-popup').keyup(function(){
                    if(($(this).val().length<3)||($(this).val.length)>25){
                        $('.lastName-popup').css('border','.2rem solid red');
                        error_array.push('Last Name should be between 2 and 25 character')

                    }else{
                        $('.lastName-popup').css('border','.2rem solid green');
                        removeItem('Last Name should be between 2 and 25 character')


                    }
                })

                $('.password-popup-one').keyup(function(){
                    if(($(this).val().length<6)||($(this).val.length)>30){
                        $('.password-popup-one').css('border','.2rem solid red');
                        error_array.push('password should be between 6 and 30 character')

                    }else{
                        $('.password-popup-one').css('border','.2rem solid green');
                        removeItem('password should be between 6 and 30 character')


                    }
                })

                 // see if password do not matche
                $('.repeat-password-popup').keyup(function(){

                if(document.querySelector('.password-popup-one').value ==document.querySelector('.repeat-password-popup').value){
                    document.querySelector('.repeat-password-popup').style.border = "0.2rem solid green";
                    removeItem('Repeated Password Incorrect')

                } else{
                // notification for password                
                    document.querySelector('.repeat-password-popup').style.border = "0.2rem solid red";
                    error_array.push('Repeated Password Incorrect')

                }
                })

            })
        
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
                        error_array.push('Email Already used')

                        }else{
                            if(validateEmail(email_val)){
                                $('.email-popup').css('border','.2rem solid green');
                                removeItem('Invalid Email')

                            }else{
                                $('.email-popup').css('border','.2rem solid red');
                                error_array.push('Invalid Email')

                                }
                                removeItem('Email Already used')


                        }
                    })
                })
            })
        
        
           

                $('#form-register').submit(function(e){
                    if(error_array.length > 0){
                        const distinct=(value,index,self)=>{return self.indexOf(value)===index;}
                        var dis=error_array.filter(distinct);
                            dis = dis.reverse();
                        // $("#button-popup").addClass("not-allowed");
                        dis.forEach(e => {
                            simpleNotify.notify(e,'danger');
                        });
                        e.preventDefault();
                        return false;
                    }else{
                        // $("#button-popup").removeAttr("disabled");
                        $('#button-popup').click(function(){
                            alert('hi');
                        })

                    }
                })     
                   
                
            </script>

<?php 
if (isset($_POST['reg_submit'])) {
    $first_name=strip_tags($_POST['reg_first_name']);
    $first_name=str_replace(' ','',$first_name);
    $first_name=ucfirst(strtolower($first_name));
    $_SESSION['reg_first_name'] = $first_name;

    $last_name=strip_tags($_POST['reg_last_name']);
    $last_name=str_replace(' ','',$last_name);
    $last_name=ucfirst(strtolower($last_name));
    $_SESSION['reg_last_name'] = $last_name;

    $email=strip_tags($_POST['reg_email']);
    $email=str_replace(' ','',$email);
    $_SESSION['reg_email'] = $email;

    $password=strip_tags($_POST['reg_password']);
    $password=md5($password);
    $_SESSION['reg_password'] = $password;

    $date=date("Y-m-d");
    $_SESSION['date'] = $date;

    header("Location: step2-register.php");
    ob_enf_fluch();
}


?>
                

