<?php

$num_post_all=$_POST['num_post_all'];
$user_name_logged_in=$_POST['user_name_logged_in'];
$user_profile_pic=$_POST['user_profile_pic'];

$int_part=intval((int)$num_post_all/10);
            if ($int_part!=$num_post_all/10) {
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
            var num_post_all = "<?php echo $num_post_all; ?>";
            var user_name_logged_in = "<?php echo $user_name_logged_in ?>";
            var pagination_formul_start=(parseInt(pagination_id)-1)*10
            var user_profile_pic = '<?php echo $user_profile_pic?>';


            $('.pagination_content').removeClass('active');
                $(this).addClass('active')
                window.scrollTo(0,0)
                $.ajax({
                    url: 'load_post_options/load_post_all.php',
                    type: 'POST',
                    data: {
                        user_name_logged_in: user_name_logged_in,
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