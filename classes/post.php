<?php
class post{
    private $con;
    private $user_obj;
    public $user_name_loged_in;
    public $categories_list;
    public function __construct($con,$user_name,$categories_list){
        // include('user.php');
        $this->con=$con;
        // $this->user_obj=new user($con,$user_name);
        $this->user_name_loged_in=$user_name;
        $this->categories_list=$categories_list;
    }

    // public function submit_post($body){
    //     $body=strip_tags($body);
    //     $body=mysqli_real_escape_string($this->con,$body);
	// 	$check_empty = preg_replace('/\s+/', '', $body); //Deltes all spaces 
    //     $date_submited=date('Y-m-d H:i:s');
    //     if ($check_empty !='') {
    //         $user_name_val=$this->user_obj->get_user_name();
    //         // insert into db
    //         $insert_db_query=mysqli_query($this->con,"INSERT INTO `posts`(`id`, `body`, `added_by`, `date_added`, `deleted`, `user_closed`, `likes`) VALUES ('','$body','$user_name_val','$date_submited','no','no','0')");
    //         $return_id=mysqli_insert_id($this->con);
    //         // update number of postes posted by the user
    //         $num_post=$this->user_obj->number_of_posts();
    //         $num_post++;
    //         $update_query=mysqli_query($this->con,"UPDATE users SET number_posts='$num_post' WHERE user_name='$user_name_val'");
    //     }
    // }

    public function load_post(){
        // strat likes obj
        include_once('user.php');
        include_once('like_dislike.php');
        $like_dislike_obj=new likes_dislikes($this->con,$this->user_name_loged_in);
        // end likes obj
    $count=0;
        $post="";
        $num_posts = 0;
        $categories_list=$this->categories_list;
        $query_load_post=mysqli_query($this->con,"SELECT * from posts where MATCH(category) AGAINST('$categories_list')order by id DESC");
        if (mysqli_num_rows($query_load_post)>0) {
            
            while($row=mysqli_fetch_array($query_load_post)){
                if (strstr($row['repored_by'],$this->user_name_loged_in)==false) {                    
                    // if ((strstr($this->categories_list,$row['category']))&&($row['added_by'])) {
                        if ($num_posts<11) {
                            $user_obj=new user($this->con,$row['added_by']);
                            
                        
                $user_name=$row['added_by'];
                $body=$row['body'];
                $title=$row['title'];
                $date_time=$row['date_added'];
                $id=$row['id'];
                $date_time_now = date("Y-m-d H:i:s");
                
                $query_likes=mysqli_query($this->con,"SELECT * FROM likes where post_id='$id' and is_like='yes'");
                $query_dislikes=mysqli_query($this->con,"SELECT * FROM likes where post_id='$id' and is_dislike='yes'");
                
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
							$time_message = $interval->m . " month ". $days;
						}
						else {
							$time_message = $interval->m . " months ". $days;
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

                    echo "<div class='post_".$row['id']."'>
                            <div class='top-post'>
                            <div class='post-body'>
                            
                                <div class=' post-body-text'>

                                    <div class='user-name-timer'>
                                    <div class='image-name-post'>
                                        <a href='profile.php?user_profile=$user_name'><img src='".$user_obj->get_profile_pic()."'  class='images-user-post images-user-post_".$row['id']."' alt='' ></a>
                                            <div class='time_name_post'>
                                                <a href='profile.php?user_profile=$user_name'><span class='user-name-post'>$user_name</span></a>
                                                <span class='timer-post'>$time_message</span>
                                            </div>   
                                    </div>
                                    <div class='dropdown_post'>
                                        <img class='ellipsis_img_post ellipsis_img_post_".$row['id']."' src='images/ellipsis.png' alt=''>
                                        <div id='more_option_post_div more_option_post_div_".$row['id']."' class='dropdown-content_more_option_post dropdown-content_more_option_post_".$row['id']."'>";
                                        if ($row['added_by']==$this->user_name_loged_in) {
                                            echo "<div class='delete_post_div delete_post_div_".$row['id']."'><i class='far fa-times-circle' style='font-size: 1.3rem;'></i><span class='report_button_post'>delete</span></div>";
                                        }else{
                                            echo "<div class='report_post_div report_post_div_".$row['id']."'><i class='fas fa-ban' style='font-size: 1.3rem;'></i><span class='report_button_post'>Report</span></div>";
                                        }
                                        echo "</div>
                                        </div>
                                    </div>
                                    <h4 class='post_title post_title_".$row['id']."'>".$row['title']."</h4>
                                    <span class='commen_css_post_span commen_css_post_span_".$row['id']." hyphens'>$body </span>
                                    <div class='show_all_search_result_content_tags'>";
                                    $str = $row['post_tags'];
                                    $arr=explode(',',$str);
                                    $val=count($arr);
                                    $i=0;
                                    for($i=0;$i<$val-1;$i++){
                                    echo '<span class="span_tag_value span_tag_value_'.$row["id"].'">'.$arr[$i].'</span>';
                                    }  


                                           echo" </div>
                                </div>
                            </div>
                            </div>
                            <div class='likes_and_bottom_post".$id."'>
                            <div class='likes_dislikes_display_number' id='likes_dislikes_display_number_".$id."'>
                            <div class='like-stat'> <!-- Like statistic container-->
							<span class='like-emo'> <!-- like emotions container -->
                            <img src='images/green_flag.png' style='height: 1.8rem;' alt=''>
                            </span>
							<span class='like-details like-details_liked_".$id."'>".$query_num_likes."</span>
                            </div>
                            <div class='like-stat' style='margin-left:2rem;'> <!-- Like statistic container-->
							<span class='dislike-emo'> <!-- like emotions container -->
                            <img src='images/red_flag.png' style='height: 1.8rem;' alt=''>
							</span>
							<span class='like-details like-details_disliked_".$id."'>".$query_num_dislikes."</span>
                            </div>
                             </div>
                             ".$like_dislike_obj->display_likes($id,$title)."
                            </div>
                        </div>";
                        $num_posts++;
                }  
                         
            }    
        }
    // }
        }else{
        echo 'no posts to show';
    }
    
    
    
}

public function reduce_num_likes_post_table_db_by_one($text_value,$post_id){
    if ($text_value == 'Liked') {
        $query_num_likes_post=mysqli_query($this->con,"SELECT * from posts where id='$post_id'");
        $query_num_likes_post_array = mysqli_fetch_array($query_num_likes_post);
        $num_like = $query_num_likes_post_array['likes'];
        $num_like = (int)$num_like;
        $num_like=$num_like - 1;
        $update_num_likes_post=mysqli_query($this->con,"UPDATE posts set likes='$num_like' where id='$post_id'");


        # code...
    }elseif($text_value == 'Disliked'){
        $query_num_likes_post=mysqli_query($this->con,"SELECT * from posts where id='$post_id'");
        $query_num_likes_post_array = mysqli_fetch_array($query_num_likes_post);
        $num_like = $query_num_likes_post_array['dislikes'];
        $num_like = (int)$num_like;
        $num_like=$num_like - 1;
        $update_num_likes_post=mysqli_query($this->con,"UPDATE posts set dislikes='$num_like' where id='$post_id'");

    }

}


}
?>