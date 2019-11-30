<?php

require '../db.php';

$user_name_logged_in=$_POST['user_name_logged_in'];
$category_val=$_POST['category_val'];

    $query_search=mysqli_query($con,"SELECT count(*) as count from posts where category='$category_val'");
    $query_search_array=mysqli_fetch_array($query_search);
    $num_post_category = $query_search_array['count'];

$int_part=intval((int)$num_post_category/10);
            if ($int_part!=$num_post_category/10) {
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
            var num_post_category = "<?php echo $num_post_category; ?>";
            var user_name_logged_in = "<?php echo $user_name_logged_in ?>";
            var pagination_formul_start=(parseInt(pagination_id)-1)*10


            $('.pagination_content').removeClass('active');
                $(this).addClass('active')
                window.scrollTo(0,0)
                $.ajax({
                    url: 'load_post_options/load_post_category.php',
                    type: 'POST',
                    data: {
                        user_name_logged_in: user_name_logged_in,
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