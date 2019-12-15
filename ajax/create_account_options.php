<link rel="manifest" href="../js/manifest.json"></link>

<div class="create_account_header">
    <span class="create_account_header_text"> Sotmy amet consectetur adipisicing elit </span>
</div>
<div class="create_account_log_in_options">
    <div class="create_account_facebook_container">
        <div class="create_account_facebook_div">
            <img src="images/facebook_icon1.png" alt="" style="width: 4.5rem;padding: .5rem;">
            <span class="create_account_facebook_text">Join Using Facebook</span>
        </div>
    </div>
    <br>
    <div class="create_account_email_container">
        <div class="create_account_email_div">
            <img src="images/email.png" alt="" style="width: 4.5rem;padding: .5rem;">
            <span class="create_account_email_text">Join Using email</span>
        </div>
    </div>
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