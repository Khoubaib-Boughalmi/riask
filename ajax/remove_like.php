<?php

$con = mysqli_connect('localhost','root','','riask');
if(mysqli_connect_errno()){
    echo 'connection failled';

}

if (isset($_POST['like_id'])) {
    $like_id=$_POST['like_id'];
}
if (isset($_POST['user_name_logged_in'])) {
    $user_name_logged_in=$_POST['user_name_logged_in'];
}

    $delete_query = mysqli_query($con,"DELETE FROM `likes` WHERE post_id='$like_id' and user_name='$user_name_logged_in'");
    echo "<div class='riask-reaction'>
    <span class='like-btn'> 
    <span class='like-btn-emo like-btn-default like_".$like_id."'></span>
    <span class='like-btn-text like_btn_".$like_id."'>Like</span> 
            <ul class='reactions-box'> 
                    <button class='reaction reaction-like' data-reaction='Like' name='like' id='like".$like_id."'></button>
                    <button class='reaction reaction-love' data-reaction='dislike' name='dislike'  id='dislike".$like_id."'></button> 
                </form>    
            </ul>
        </span>
     </div>";



?>
<script>
    // like button clicked
    $(".reaction-like").click(function (event) {

        var user_name_logged_in = '<?php echo $user_name_logged_in?>';
        var full_like_id = $(this).attr('id');
        var like_id = full_like_id.slice(4, full_like_id.len);
        var liked_text_val = $('.bottom_post_like_'+like_id+' .like_btn_'+like_id).text()


        $.ajax({
            url: 'like_clicked.php',
            type: 'POST',
            data: {
                like_id_val: like_id,
                user_name_logged_in_val: user_name_logged_in,
                liked_text_val:liked_text_val
            },
            async: false,
            cache: false,
            error: function () {
                alert('error');
            },
            success: function (data) {
                $('.bottom_post_like_' + like_id).html(data);

            }
        })

        $.ajax({
            url: 'ajax/like_clicked_update_ui_ajax.php',
            type: 'POST',
            data: {
                like_id_val: like_id
            },
            async: false,
            cache: false,
            error: function () {
                alert('error');
            },
            success: function (data) {
                $('#likes_dislikes_display_number_' + like_id).html(data);

            }
        })
    });



    $(".reaction-love").click(function (event) {

        var user_name_logged_in = '<?php echo $user_name_logged_in?>';
        var full_like_id = $(this).attr('id');
        var dislike_id = full_like_id.slice(7, full_like_id.len);
        var liked_text_val = $('.bottom_post_like_'+dislike_id+' .like_btn_'+dislike_id).text()

        $.ajax({
            url: 'dislike_clicked.php',
            type: 'POST',
            data: {
                like_id_val: dislike_id,
                user_name_logged_in_val: user_name_logged_in,
                liked_text_val:liked_text_val
            },
            async: false,
            cache: false,
            error: function () {
                alert('error');
            },
            success: function (data) {
                $('.bottom_post_like_' + dislike_id).html(data);

            }
        })

        $.ajax({
            url: 'ajax/like_clicked_update_ui_ajax.php',
            type: 'POST',
            data: {
                like_id_val: dislike_id
            },
            async: false,
            cache: false,
            error: function () {
                alert('error');
            },
            success: function (data) {
                $('#likes_dislikes_display_number_' + dislike_id).html(data);

            }
        })
    });

    // // remove like 
    // $('.like-btn-text').click(function(){
    //             var like_id = $(this).attr('class');
    //             like_id = like_id.slice(23);
    //             var user_name_logged_in = '<?php echo $user_name_logged_in?>';
    //             var num_like_text_val = $(this).text()
    //             var like_val_class=$('.like_btn_'+like_id).text(); //DISLIKED, LIKED, LIKE
    //             // alert(like_val_class)
    //             $.ajax({
    //             url: 'ajax/remove_like.php',
    //             type: 'POST',
    //             data:{
    //             like_id: like_id,
    //             user_name_logged_in:user_name_logged_in,
    //             like_val_class:like_val_class
    //             },
    //             async: false,
    //             cache: false,
    //             error: function(){
    //                 alert('error');
    //             },
    //             success:function (data) {
    //                 alert(like_val_class)

    //                 $('.bottom_post_like_'+like_id).html(data);

    //                 if (like_val_class == 'Disliked'){

    //                     var liked_text_val = $('.like-details_disliked_'+like_id).text()
    //                     liked_text_val = parseInt(liked_text_val)-1;
    //                      $('.like-details_disliked_'+like_id).text(liked_text_val)

    //                 }
    //                  if (like_val_class == ' Liked') {
    //                     var liked_text_val = $('.like-details_liked_'+like_id).text()
    //                     liked_text_val = parseInt(liked_text_val)-1;
    //                     $('.like-details_liked_'+like_id).text(liked_text_val)
    //                 }
    //             }
    //             })  
    //         })

</script>