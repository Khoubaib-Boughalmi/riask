<link rel="manifest" href="/../js/manifest.json"></link>

<?php

require '../db.php';
if(mysqli_connect_errno()){
    echo 'connection failled';

}

if (isset($_POST['input_search_val'])) {
    $input_search_val=$_POST['input_search_val'];
}


$query_search=mysqli_query($con,"SELECT * from posts where MATCH(title,body) AGAINST('$input_search_val') LIMIT 5");
// i need the second query to get id and select likes using post id
// $query_search_second=mysqli_query($con,"SELECT * from posts where MATCH(title,body) AGAINST('$input_search_val') LIMIT 5");

// $id_array = array_fill(0, 5, 0);
// $i=0;
// while($fetch_search_array_id = mysqli_fetch_array($query_search_second)){
// 	$replacement = array($i => $fetch_search_array_id['id']);
// 	$id_array = array_replace($id_array, $replacement);
// 	$i++;
// }

// $query_likes_posts=mysqli_query($con,"SELECT *,count(*) as count FROM `likes` WHERE (post_id='$id_array[0]' or post_id='$id_array[1]' or post_id='$id_array[2]' or post_id='$id_array[3]' or post_id='$id_array[4]') GROUP by post_id,is_like order by post_id asc");

// $T=array(
// 	array(0,0,0),
// 	array(0,0,0),
// 	array(0,0,0),
// 	array(0,0,0),
// 	array(0,0,0),
// );

// $i = 0; $j =0; $x = 0;
// $previous_id=0;
// while($query_likes_posts_array = mysqli_fetch_array($query_likes_posts)){
// 	$current_id =(int)$query_likes_posts_array['post_id']; 
// 	$T[$i][0]=(int)$query_likes_posts_array['post_id'];
	
// 	if ($query_likes_posts_array['is_like']=='yes') {
// 		$T[$i][$i+1]=(int)$query_likes_posts_array['count'];
// 	}else{
// 		$T[$i][$i+2]=(int)$query_likes_posts_array['count'];
// 	}
// 	if (($current_id !== $T[$i][0])) {
// 		$i++;
// 	}
// }
// echo mysqli_num_rows($query_likes_posts).'<br>';
// echo $T[0][0];
// echo $i;
// echo $x;


$date_time_now = date("Y-m-d H:i:s");
if (mysqli_num_rows($query_search)>0) {

echo "<div class='main_search_result_header'>
                <span>Search Result</span>
            </div>";
    while($query_search_array=mysqli_fetch_array($query_search)){

		$title = $query_search_array['title'];
		$title = (string)$title;
        $title = str_replace(' ','-',$title);
        $date_time=$query_search_array['date_added'];
        $start_date = new DateTime($date_time); //Time of post
					$end_date = new DateTime($date_time_now); //Current time
					$interval = $start_date->diff($end_date); //Difference between dates 
					if($interval->y >= 1) {
						if($interval == 1)
							$time_message = $interval->y . " year ago"; //1 year ago
						else 
							$time_message = $interval->y . " years ago"; //1+ year ago
					}
					else if ($interval-> m >= 1) {
						if($interval->d == 0) {
							$days = " ago";
						}
						else if($interval->d == 1) {
							$days = $interval->d . " day ago";
						}
						else {
							$days = $interval->d . " days ago";
						}


						if($interval->m == 1) {
							$time_message = $interval->m . " month ".'ago';
						}
						else {
							$time_message = $interval->m . " months ".'ago';
						}

					}
					else if($interval->d >= 1) {
						if($interval->d == 1) {
							$time_message = "Yesterday";
						}
						else {
							$time_message = $interval->d . " days ago";
						}
					}
					else if($interval->h >= 1) {
						if($interval->h == 1) {
							$time_message = $interval->h . " hour ago";
						}
						else {
							$time_message = $interval->h . " hours ago";
						}
					}
					else if($interval->i >= 1) {
						if($interval->i == 1) {
							$time_message = $interval->i . " minute ago";
						}
						else {
							$time_message = $interval->i . " minutes ago";
						}
					}
					else {
						if($interval->s < 30) {
							$time_message = "Just now";
						}
						else {
							$time_message = $interval->s . " seconds ago";
						}
					}
			// while($query_likes_posts_array = mysqli_fetch_array($query_likes_posts)){

			
					// if ($query_search_array['id']==$query_likes_posts_array['id']) {
					// 	# code...
					// }
		echo "
		
        <div class='main_search_result_content'>
        <div class='main_search_result_reactions' style=''>
            <div class='main_search_result_like'>
			<img src='images/green_flag.png' style='height: 2rem;'>
			<span style='font-size:1.4rem; margin-left:.4rem;font-weight:bold'>".$query_search_array['likes']."</span>
            </div>
            <div class='main_search_result_like'>
			<img src='images/red_flag.png' style='height: 2rem;'>
			<span style='font-size:1.6rem; margin-left:.4rem;font-weight:bold'>".$query_search_array['dislikes']."</span>
            </div>
        </div>
        <a href='show_comments.php?post_id=".$query_search_array['id']."/$title' style='padding: .8rem 0rem;'>
        <div class='main_search_result_title'>
            <span style='font-size:1.3rem;font-weight:bold;color:black'>".$query_search_array['title']."</span>
            </div>
            </a>
        <div class='search_result_date'>
            <span>$time_message</span>
        </div>
    </div>
	</div>";
	}
	echo "<div class='main_search_result_content' style='background-color:#f1f1f1f1;margin-top:1rem;'>
	<div class='main_search_result_empty' style=''>
 
	</div>
	<a href='show_all_search_results.php?q=$input_search_val'>

	<div class='main_search_result_title main_search_result_title_active'>
		<span style='font-size:1.2rem;font-weight:bold;color:#3C89C4'>See all results for <b style='font-size:1.3rem;'>' ".$input_search_val." ' </b></span>
	</div>
	</a>
</div>";

// }
}else{
	echo "
	<div class='main_search_result_header'>
	<span>Search results</span>
</div>

<div class='main_search_result_content_all'>
	
	<div><img src='images/no_result_found.jpg' style='width:25rem;height:26rem;margin-left: 19rem;transform: rotate(180deg);'alt=''></div>

</div>

<div class='main_search_result_content' style='background-color:#f1f1f1f1;margin-top:1rem;'>
<div class='main_search_result_empty' style=''>

</div>

<div class='main_search_result_title' style='padding: .5rem;'>
		<span style='font-size:1.2rem;font-weight:bold;color:#3C89C4;display: block;'>No result found</span>
	</div>
</div>";
}
// echo "<div class='main_search_result_content'>
//                 <div class='main_search_result_reactions' style='>
//                     <div class='main_search_result_like'>
//                         <i class='fas fa-flag' style='font-size:1.8rem ;color:#0080008c;'></i>
//                         <span style='font-size:1.4rem; margin-left:.4rem;font-weight:bold'>0</span>
//                     </div>
//                     <div class='main_search_result_like'>
//                         <i class='fas fa-flag' style='font-size:1.8rem;color:#ff000094'></i>
//                         <span style='font-size:1.6rem; margin-left:.4rem;font-weight:bold'>32</span>
//                     </div>
//                 </div>
//                 <div class='main_search_result_title'>
//                     <span style='font-size:1.3rem;font-weight:bold;'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, earum.sit amet consectetur adipisicing elit</span>
//                 </div>
//                 <div class='search_result_date'>
//                     <span>1 April 2019</span>
//                 </div>
//             </div>
//             </div>"

// $query_user_logged_in=mysqli_query($con,"SELECT * from users where user_name='$user_name_logged_in'");

?>