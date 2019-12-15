<link rel="manifest" href="../js/manifest.json"></link>

<?php

$num_post_related_list=$_POST['num_post_related_list'];
$user_name_logged_in=$_POST['user_name_logged_in'];
$categories_list=$_POST['categories_list'];

$int_part=intval((int)$num_post_related_list/10);
            if ($int_part!=$num_post_related_list/10) {
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
            var num_post_related_list = "<?php echo $num_post_related_list; ?>";
            var user_name_logged_in = "<?php echo $user_name_logged_in ?>";
            var categories_list = "<?php echo $categories_list ?>";
            var pagination_formul_start=(parseInt(pagination_id)-1)*10


            $('.pagination_content').removeClass('active');
                $(this).addClass('active')
                window.scrollTo(0,0)
                $.ajax({
                    url: 'load_post_options/load_post_related.php',
                    type: 'POST',
                    data: {
                        user_name_logged_in: user_name_logged_in,
                        categories_list: categories_list,
                        pagination_formul_start,pagination_formul_start
                    },

                    error: function () {
                        alert('error');
                    },
                    success: function (data) {
                        $('.load_post').html(data);
                    }
                })    })
</script>