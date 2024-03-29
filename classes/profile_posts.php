
<?php
class profile_posts{
	private $con;
	private $user_name_logged_in;
	private $user_profile;
	private $user_profile_pic;
	public function __construct($con,$user_name_logged_in,$user_profile,$user_profile_pic){
		$this->con = $con;
		$this->user_name_logged_in = $user_name_logged_in;
		$this->user_profile = $user_profile;
		$this->$user_profile_pic = $user_profile_pic;
	}
	public function load_profile_posts($con,$user_profile,$user_name_logged_in,$user_profile_pic){
		include_once('like_dislike.php');

		$like_dislike_obj=new likes_dislikes($con,$user_profile);
	
$post="";
$query_load_post=mysqli_query($con,"SELECT * FROM posts WHERE added_by ='$user_profile'ORDER BY id DESC" );	
if (mysqli_num_rows($query_load_post)>0) {
	while($row=mysqli_fetch_array($query_load_post)){
		if (strstr($row['repored_by'],$user_name_logged_in)==false) {
				
			
		$user_name=$row['added_by'];
		$body=$row['body'];
		$date_time=$row['date_added'];
		$likes=$row['likes'];
		$title=$row['title'];
		$id=$row['id'];
		$date_time_now = date("Y-m-d H:i:s");
		
		$query_likes=mysqli_query($con,"SELECT * FROM likes where post_id='$id' and is_like='yes'");
		$query_dislikes=mysqli_query($con,"SELECT * FROM likes where post_id='$id' and is_dislike='yes'");
		
		$query_num_likes=mysqli_num_rows($query_likes);
		$query_num_dislikes=mysqli_num_rows($query_dislikes);
		

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
					$time_message = $interval->m . " month". $days;
				}
				else {
					$time_message = $interval->m . " months". $days;
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

				$post= "<div class='post_".$row['id']."'>
				<div class='top-post'>
				<div class='post-body'>
					<div class='post_empty'>

					</div>
					<div class=' post-body-text'>

						<div class='user-name-timer'>
						<div class='image-name-post'>
							<a href='profile.php?user_profile=$user_name'><img src='$user_profile_pic'  class='images-user-post' ></a>
								<div class='time_name_post'>
									<a href='profile.php?user_profile=$user_name'><span class='user-name-post'>$user_name</span></a>
									<span class='timer-post'>$time_message</span>
								</div>   
						</div>
						<div class='dropdown_post'>
									<img class='ellipsis_img_post ellipsis_img_post_".$row['id']."' src='images/ellipsis.png'>
									<div id='more_option_post_div more_option_post_div_".$row['id']."' class='dropdown-content_more_option_post dropdown-content_more_option_post_".$row['id']."'>";
									if ($row['added_by']==$user_name_logged_in) {
										$post.="<div class='delete_post_div delete_post_div_".$row['id']."'><i class='far fa-times-circle' style='font-size: 1.3rem;'></i><span class='report_button_post'>delete</span></div>";
									}else{
										$post.="<div class='report_post_div report_post_div_".$row['id']."'><i class='fas fa-ban' style='font-size: 1.3rem;'></i><span class='report_button_post'>Report</span></div>";
									}
									$post.="</div>
									</div>
								</div>
								<h4 class='post_title post_title_".$row['id']." hyphens'>".$row['title']."</h4>
								<span class='commen_css_post_span commen_css_post_span_".$row['id']."  hyphens'>$body </span>
								<div class='show_all_search_result_content_tags'>";
								$str = $row['post_tags'];
								$arr=explode(',',$str);
								$val=count($arr);
								$i=0;
								for($i=0;$i<$val-1;$i++){
								$post.='<span class="span_tag_value span_tag_value_'.$row["id"].'">'.$arr[$i].'</span>';
								}  


							   $post.=" </div>
					</div>
				</div>
				</div>
				<div class='likes_and_bottom_post".$id."'>
				<div class='likes_dislikes_display_number' id='likes_dislikes_display_number_".$id."'>
				<div class='like-stat'> <!-- Like statistic container-->
				<span class='like-emo'> <!-- like emotions container -->
				<img src='images/green_flag.png' style='height: 1.8rem;' alt=''>
				</span>
				<span class='like-details'>".$query_num_likes."</span>
				</div>
				<div class='like-stat' style='margin-left:2rem;'> <!-- Like statistic container-->
				<span class='dislike-emo'> <!-- like emotions container -->
				<img src='images/red_flag.png' style='height: 1.8rem;' alt=''>
				</span>
				<span class='like-details'>".$query_num_dislikes."</span>
				</div>
				 </div>
				".$like_dislike_obj->display_likes($id,$title)."
				</div>
			</div>";
			
			echo $post;
			
	}
	
} 
}   

	
	}
}

?>
<script>
	
</script>


