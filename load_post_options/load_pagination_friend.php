<link rel="manifest" href="/../js/manifest.json"></link>

<?php

$num_followers_list=$_POST['num_followers_list'];
$user_name_logged_in=$_POST['user_name_logged_in'];
$followers_list=$_POST['followers_list'];
$user_profile_pic=$_POST['user_profile_pic'];

$int_part=intval((int)$num_followers_list/10);
            if ($int_part!=$num_followers_list/10) {
                for ($i=0; $i < $int_part+1; $i++) { 
                    $j=$i+1;
                    if ($i == 10) {
                        break;
                    }
                    echo "<span href='#' class='pagination_content' id='pagination_$j'>$j</span>";
                }
            }else{
                for ($i=0; $i < $int_part+1; $i++) { 
                    $j=$i+1;
                    if ($i == 10) {
                    break;
                }
                    echo "<span href='#' class='pagination_content' id='pagination_$j'>$j</span>";
                }
            }?>

<script>
        $('.pagination_content').click(function(){
            var pagination_id =$(this).attr('id');
            pagination_id = pagination_id.substr(11);
            var num_followers_list = "<?php echo $num_followers_list; ?>";
            var user_name_logged_in = "<?php echo $user_name_logged_in ?>";
            var user_profile_pic = "<?php echo $user_profile_pic ?>";
            var followers_list = "<?php echo $followers_list ?>";
            var pagination_formul_start=(parseInt(pagination_id)-1)*10


            $('.pagination_content').removeClass('active');
                $(this).addClass('active')
                window.scrollTo(0,0)
                $.ajax({
                    url: 'load_post_options/load_post_friend.php',
                    type: 'POST',
                    data: {
                        user_name_logged_in: user_name_logged_in,
                        followers_list: followers_list,
                        pagination_formul_start,pagination_formul_start,
                        user_profile_pic:user_profile_pic
                    },

                    error: function () {
                        alert('error');
                    },
                    success: function (data) {
                        $('.load_post').html(data);
                    }
                })    })
</script>