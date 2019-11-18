<?php
if (isset($_POST['user_logged_in'])) {
    $user_name = $_POST['user_logged_in'];
}
?>
<!-- Create the editor container -->
<div class="description-create-post">
    <h3 class="h3-create-post">What languages, technologies, and/or frameworks is your question about?</h3>
    <h4 class="h4-create-post" style="margin-top:2rem;">Your description gives people the information they need to help
        you answer your question.</h4>

    <div id="trumbowyg-demo"></div>
    <h4 class="h4-create-post" style="margin-top:2rem;">Your description gives people the information they need to help
        you answer your question.</h4>
    
    <div class="next_privious_botton_flex">
        <span class="next_previous_button_create_post previous_botton_description">Previous</span>
        <span class="next_previous_button_create_post next_botton_description">Next</span>
    </div>

    <!-- Initialize Quill editor -->
    <script>
        $('#trumbowyg-demo').trumbowyg({
            btns: [
                ['undo', 'redo'], // Only supported in Blink browsers
                ['formatting'],
                ['strong', 'em'],
                ['superscript', 'subscript'],
                ['link'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['unorderedList', 'orderedList'],
                ['horizontalRule'],
                ['removeformat'],
                ['fullscreen']
            ]
        });


        $('.previous_botton_description').click(function () {
            var user_logged_in = '<?php echo $user_name; ?>';
            $.ajax({
                url: 'creat-post-files/tags-create-post.php',
                type: 'POST',
                data: {
                    user_logged_in: user_logged_in
                },
                error: function () {
                    alert('error');
                },
                success: function (data) {
                    $('.ajax-insert').html(data);

                }
            })

            // $.get('creat-post-files/tags-create-post.php',function(data){
            //     $('.ajax-insert').html(data);
            // })
            $('.botton2').removeClass('active_btn_tag');
            $('.botton1').addClass('active_btn_tag');
        })
        // $('.botton2').click(function(){
        //     var user_logged_in = '<?php echo $user_name; ?>';
        //     $.ajax({
        //     url: 'creat-post-files/description-create-post.php',
        //     type: 'POST',
        //     data:{
        //     user_logged_in:user_logged_in
        //     },
        //     error: function(){
        //         alert('error');
        //     },
        //     success:function (data) {
        //         $('.ajax-insert').html(data);

        //     }
        //     })

        //     $('svg').removeClass('active_btn_tag');
        //         $(this).addClass('active_btn_tag');
        // })
        $('.next_botton_description').click(function () {
            var user_logged_in = '<?php echo $user_name; ?>';
            var body_val = $('#trumbowyg-demo').text();
            var body_length = body_val.length
            if (body_length>10) {
                $.ajax({
                url: 'creat-post-files/review-create-post.php',
                type: 'POST',
                data: {
                    user_logged_in: user_logged_in
                },
                error: function () {
                    alert('error');
                },
                success: function (data) {
                    $('.ajax-insert').html(data);

                }
            })

            $('.botton2').removeClass('active_btn_tag');
            $('.botton3').addClass('active_btn_tag');

            $('.click_bitch').html(sessionStorage.getItem("tags") + '<br>' + sessionStorage.getItem("title"))

            var body = $('#trumbowyg-demo').html()
            body = body.replace(/&nbsp;/gi,'');
            sessionStorage.setItem("body", body);
            }else{
                simpleNotify.notify('Body should be at least 10 charcters', 'danger');

            }
            
        })
        // $('.next_botton_description').click(function () {
           
        //     // $('.text_palce').html(sessionStorage.getItem("body", body))
        // })
    </script>