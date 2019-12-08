<?php
class notification{
    private $con;
	private $user_logged_in;
	private $query_notification;
    public function __construct($con,$user_logged_in){
        $this->con=$con;
		$this->user_logged_in=$user_logged_in;

    }


    public function num_notification($user_logged_in){
		$query_notification=mysqli_query($this->con,"SELECT count(*) as count FROM notifications WHERE user_to='$user_logged_in' and opened ='no' ORDER BY id DESC ");
        $num_notification=mysqli_fetch_array($query_notification);
        return $num_notification['count'];
    }


    public function insert_notification($post_id, $user_to, $type,$title,$pdp) {
		$user_logged_in = $this->user_logged_in;

		$date_time = date("Y-m-d H:i:s");

		$link = "show_comments.php?post_id=" . $post_id;
		if($type=='comment') {
			$message = $user_logged_in . " commented on your post";
			$insert_comment_query = mysqli_query($this->con, "INSERT INTO notifications VALUES('','$post_id', '$user_to', '$user_logged_in', '$message','$title', '$link', '$date_time', 'no', 'no','no','yes','$pdp')");
		}else if($type=='like') {
			$message = $user_logged_in . " reacted to your post";
			// to insert only one notification either liked or diliked so there not be doubled
			$delete_comment_query = mysqli_query($this->con, "DELETE FROM `notifications` WHERE post_id='$post_id' and user_from='$user_logged_in'");
			$insert_like_query = mysqli_query($this->con, "INSERT INTO notifications VALUES('','$post_id', '$user_to', '$user_logged_in', '$message','$title', '$link', '$date_time', 'no', 'no','yes','no','$pdp')");
		}
		

	}

	public function load_notification(){
		$user_logged_in=$this->user_logged_in;
		$query_notification=mysqli_query($this->con,"SELECT *,COUNT(*) as count FROM notifications WHERE user_to='$user_logged_in' group by post_id,is_like,is_comment order by datetime DESC");
		$query_notification_num=mysqli_num_rows($query_notification);
		$link_id=$query_notification_num['link'];
		if ($query_notification_num>0) {
				
			while ($row=mysqli_fetch_array($query_notification)) {
				$title=$row['notification_title'];
				$title = (string)$title;
				$title = str_replace(' ','-',$title);
				$user_to_profile_name=$row['user_from'];
				$user_profile_pic=$row['user_profile_pic'];
				

				// get post id from link in notification
				$count = (int)$row['count'] - 1;
						if ($row['opened'] == 'yes') {

							if ($count == 0) {	
								if ($row['is_comment'] == 'yes') {
									$notification_value="<div class='dropdown_notification_container dropdown_notification_container_type1_145'><a href='profile.php?user_profile=$user_to_profile_name' id='image_drop_down_profile_link'><img src='$user_profile_pic' style='width:3rem;height:3rem;border-radius:10rem;'></a><a href='".$row['link']."&opened_from_notification=true/$title' id='drop_down_link'>".$row['user_from']." Commented on your post <br><span class='hyphens'>".$row['notification_title']."</span></a></div>";
								}else{
									$notification_value="<div class='dropdown_notification_container dropdown_notification_container_type1_145'><a href='profile.php?user_profile=$user_to_profile_name' id='image_drop_down_profile_link'><img src='$user_profile_pic' style='width:3rem;height:3rem;border-radius:10rem;'></a><a href='".$row['link']."&opened_from_notification=true/$title' id='drop_down_link'>".$row['user_from']." Reacted to your post :  <br><span class='hyphens'>".$row['notification_title']."</span></a></div>";
								}
							}else{
								$notification_value="<div class='dropdown_notification_container dropdown_notification_container_type1_145'><a href='profile.php?user_profile=$user_to_profile_name' id='image_drop_down_profile_link'><img src='$user_profile_pic' style='width:3rem;height:3rem;border-radius:10rem;'></a><a href='".$row['link']."&opened_from_notification=true/$title' id='drop_down_link'>".$row['user_from']." and ".$count." other people reacted to your post :  <br><span class='hyphens'>".$row['notification_title']."</span></a></div>";
							}
						}else {
							if ($count == 0) {
								if ($row['is_comment'] == 'yes') {
								$notification_value="<div class='dropdown_notification_container dropdown_notification_container_type1_130' style='background-color:#e8f3ff;'><a href='profile.php?user_profile=$user_to_profile_name' id='image_drop_down_profile_link'><img src='$user_profile_pic' style='width:3rem;height:3rem;border-radius:10rem;'></a><a href='".$row['link']."&opened_from_notification=true/$title' id='drop_down_link'>".$row['user_from']." Commented on your post   <br><span class='hyphens'>".$row['notification_title']."</span></a></div>";
							}else{
								$notification_value="<div class='dropdown_notification_container dropdown_notification_container_type1_130' style='background-color:#e8f3ff;'><a href='profile.php?user_profile=$user_to_profile_name' id='image_drop_down_profile_link'><img src='$user_profile_pic' style='width:3rem;height:3rem;border-radius:10rem;'></a><a href='".$row['link']."&opened_from_notification=true/$title' id='drop_down_link'>".$row['user_from']." reacted to your post :  <br><span class='hyphens'>".$row['notification_title']."</span></a></div>";
								}
							}else{
								$notification_value="<div class='dropdown_notification_container dropdown_notification_container_type1_130' style='background-color:#e8f3ff;'><a href='profile.php?user_profile=$user_to_profile_name' id='image_drop_down_profile_link'><img src='$user_profile_pic' style='width:3rem;height:3rem;border-radius:10rem;'></a><a href='".$row['link']."&opened_from_notification=true/$title' id='drop_down_link'>".$row['user_from']." and ".$count." other people reacted to your post :  <br><span class='hyphens'>".$row['notification_title']."</span></a></div>";
							}
						}
					
					// else if($row['is_comment']=='yes') {
					// 	if ($row['opened'] == 'yes') {
					// 		$notification_value="<div class='dropdown_notification_container dropdown_notification_container_type2_145'><a href='profile.php?user_profile=$user_to_profile_name' id='image_drop_down_profile_link'><img src='$user_to_profile_pic' style='width:3rem;height:3rem;border-radius:10rem;'></a><a href='".$row['link']."&opened_from_notification=true/$title' id='drop_down_link'>".$row['user_from']." and ".$row['count']." other people commented to your post :   <br><span>".$row['notification_title']."</span></a></div>";
					// 	}else {
					// 		$notification_value="<div class='dropdown_notification_container dropdown_notification_container_type2_130' style='background-color:#e8f3ff;'><a href='profile.php?user_profile=$user_to_profile_name' id='image_drop_down_profile_link'><img src='$user_to_profile_pic' style='width:3rem;height:3rem;border-radius:10rem;'></a><a href='".$row['link']."&opened_from_notification=true/$title' id='drop_down_link'>".$row['user_from']." and ".$row['count']." other people commented to your post :   <br><span>".$row['notification_title']."</span></a></div>";
					// 	}
					// }



				
				echo $notification_value;
			}
		}else{
			$notification_value="
			<div class='dropdown_notification_container'><a href='#home'>You have no notifications yet</a></div>";
			echo $notification_value;
		}
	}

	// public function update_notification_viewed(){
	// 	$user_logged_in=$this->user_logged_in;
	// 	$update_view_query=mysqli_query($this->con,"UPDATE `notifications` SET `viewed`='yes' WHERE user_to='$user_logged_in'");
	// }

	// public function update_notification_opened($post_id,$type){
	// 	$user_logged_in=$this->user_logged_in;
	// 	if ($type=='like') {
	// 		$link='show_comments.php?post_id'.$post_id;
	// 		$update_view_query=mysqli_query($this->con,"UPDATE `notifications` SET `opened`='yes' WHERE link ='$link' and is_like='yes' and opened='no'");
	// 	}
	// }

}
?>