<link rel="manifest" href="/../js/manifest.json"></link>

<?php

require '../db.php';
if(mysqli_connect_errno()){
    echo 'connection failled';

}
// 7awel tal9a methode t3adi beha valeur (text) l9dim mta3 l UI liked w dislikes w ken liked zid we7k lel liked ken l3akes l3akes bech mato93edch t selecti f db meloul kol mara
$like_id=$_POST['like_id_val'];

$query_likes=mysqli_query($con,"SELECT count(*) as count FROM likes where post_id='$like_id' and is_like='yes'");
$query_dislikes=mysqli_query($con,"SELECT count(*) as count FROM likes where post_id='$like_id' and is_dislike='yes'");

$query_num_likes=mysqli_fetch_array($query_likes);
$query_num_dislikes=mysqli_fetch_array($query_dislikes);

// $query_num_likes=$query_num_likes+1;
echo" <div class='like-stat'> <!-- Like statistic container-->
<span class='like-emo'> <!-- like emotions container -->
<img src='images/green_flag.png' style='height: 1.8rem;'>
</span> 
<span class='like-details like-details_liked_".$like_id."'>".$query_num_likes['count']."</span>
</div>
<div class='like-stat' style='margin-left:2rem;'> <!-- Like statistic container-->
<span class='dislike-emo'> <!-- like emotions container -->
<img src='images/red_flag.png' style='height: 1.8rem;'>
</span>
<span class='like-details like-details_disliked_".$like_id."'>".$query_num_dislikes['count']."</span>
</div>";

?>

