	
<?php
session_start();
session_regenerate_id();

require '../db.php';
if(mysqli_connect_errno()){
	echo 'connection failled';
}
$count=$_POST['count_post_option_friend'];
$user_name_logged_in=$_POST['user_name_logged_in'];
$friend_list=$_POST['followers_list'];

include_once('../like_dislike.php');
include_once('../classes/user.php');
$like_dislike_obj=new likes_dislikes($con,$user_name_logged_in);
$comp = 0;
$post="";
	// $query_load_post=mysqli_query($con,"SELECT * FROM posts ORDER BY id DESC" );
	$query_load_post=mysqli_query($con,"SELECT * from posts where MATCH(added_by) AGAINST('$friend_list') order by id DESC");
	$query_load_post_count=mysqli_query($con,"SELECT count(*) as count_db from posts where MATCH(added_by) AGAINST('$friend_list')");

	$query_num = mysqli_num_rows($query_load_post);	
	$query_load_post_count_array = mysqli_fetch_array($query_load_post_count);	
	if ($query_num>0) {
        if ($query_num>11) {
			echo "<script>$('.friend').css('display','block')</script>";

		}else{
			echo "<script>$('.friend').css({
				'display':'block',
				'opacity':'0'
				})</script>";
		}
		while($row=mysqli_fetch_array($query_load_post)){
			if (strstr($row['repored_by'],$user_name_logged_in)==false) {
				$user_obj=new user($con,$row['added_by']);

                // if (strstr($friend_list,$row['added_by'])) {
                    if ($comp<$count) {
					
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
								<a href='profile.php?user_profile=$user_name'><img src='".$user_obj->get_profile_pic()."'  class='images-user-post' ></a>
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
                                    <h4 class='post_title post_title_".$row['id']."'>".$row['title']."</h4>
                                    <span class='commen_css_post_span commen_css_post_span_".$row['id']."'>$body </span>
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
				$comp++;
				
			}
		}
		if ($comp == $query_load_post_count_array['count_db']) {
			echo "<script>$('.friend').hide()</script>";
		}
    }
	// } 
}   
?>
<script>
// $('.show_more_button').css('display','none')

            // like button clicked
			$(".reaction-like").click(function (event) {

var user_name_logged_in = '<?php echo $user_name_logged_in?>';
var full_like_id = $(this).attr('id');
var like_id = full_like_id.slice(4, full_like_id.len);
var liked_text_val = $('.bottom_post_like_'+like_id+' .like_btn_'+like_id).text();

$.ajax({
url: 'like_clicked.php',
type: 'POST',
data:{
like_id_val: like_id,
user_name_logged_in_val: user_name_logged_in,
liked_text_val:liked_text_val
},
async: false,
cache: false,
error: function(){
	alert('error');
},
success:function (data) {
	$('.bottom_post_like_' + like_id).html(data);
	
}
})

$.ajax({
url: 'ajax/like_clicked_update_ui_ajax.php',
type: 'POST',
data:{
like_id_val: like_id
},
async: false,
cache: false,
error: function(){
	alert('error');
},
success:function (data) {
	$('#likes_dislikes_display_number_' + like_id).html(data);
	
}
})
});

$(".reaction-love").click(function (event) {
var liked_text_val = $('.bottom_post_like_'+dislike_id+' .like_btn_'+dislike_id).text()
var user_name_logged_in = '<?php echo $user_name_logged_in?>';
var full_like_id = $(this).attr('id');
var dislike_id = full_like_id.slice(7, full_like_id.len);
$.ajax({
url: 'dislike_clicked.php',
type: 'POST',
data:{
like_id_val: dislike_id,
user_name_logged_in_val: user_name_logged_in,
liked_text_val:liked_text_val
},
async: false,
cache: false,
error: function(){
	alert('error');
},
success:function (data) {
	$('.bottom_post_like_' + dislike_id).html(data);
	
}
})

$.ajax({
url: 'ajax/like_clicked_update_ui_ajax.php',
type: 'POST',
data:{
like_id_val: dislike_id
},
async: false,
cache: false,
error: function(){
	alert('error');
},
success:function (data) {
	$('#likes_dislikes_display_number_' + dislike_id).html(data);
	
}
})
});

// mark post

$('.bottom_post_componment_mark_post').click(function () {
            var all_tags = '';
            var post_marked_id = $(this).attr('id');
            post_marked_id = post_marked_id.slice(33);
            var user_name_logged_in = '<?php echo $user_name_logged_in?>';
            var body = $('.commen_css_post_span_' + post_marked_id).text();
            var title = $('.post_title_' + post_marked_id).text();
            var tags = $('.span_tag_value_' + post_marked_id).each(function () {
                tags = $(this).text() + ',';
                all_tags = all_tags.concat(tags);
            })
            var mark_full_id = $(this).attr('id');
            var mark_text_value = $('#bottom_post_componment_mark_post_' + post_marked_id + ' .span-icon-name')
                .text();
            if (mark_text_value == 'Mark') {
                // mark the post
                $.post("ajax/mark_post.php", {
                    post_marked_id: post_marked_id,
                    user_name_logged_in: user_name_logged_in,
                    body: body,
                    title: title,
                    tags: all_tags
                }, function (data) {
                    $('#bottom_post_componment_mark_post_' + post_marked_id).html(data)
                })
            } else {
                // remove the mark

                $.ajax({
                    url: 'ajax/remove_marked_post_ajax.php',
                    type: 'POST',
                    data: {
                        post_id:post_marked_id,
                        user_name_logged_in: user_name_logged_in

                    },
                    error: function () {
                        alert('error');
                    },
                    success: function (data) {
                        $('#bottom_post_componment_mark_post_'+post_marked_id).html(data)
                    }
                })
            }
        })

// toggle between hiding and showing the dropdown content 

$('.ellipsis_img_post').click(function(){
    var ellipsis_id=$(this).attr('class');
    var ellipsis_id = ellipsis_id.slice(36);
    $(".dropdown-content_more_option_post_"+ellipsis_id).toggle("show");
})
// report a post
$('.report_post_div').click(function(){
    var report_id=$(this).attr('class');
    var report_id = report_id.slice(32);
    var user_name_logged_in = '<?php echo $user_name_logged_in?>';
    $.ajax({
        url: 'ajax/report_post_ajax.php',
        type: 'POST',
        data:{
        report_id: report_id,
        user_name_logged_in:user_name_logged_in
        },
        error: function(){
        alert('error');
        },
        success:function (data) {
        $('.post_' + report_id).hide('slow', function(){ $('.post_' + report_id).remove(); });
        }
    })
})
$('.delete_post_div').click(function(){
    var post_id=$(this).attr('class');
    var post_id = post_id.slice(32);
    var user_name_logged_in = '<?php echo $user_name_logged_in?>';
    $.ajax({
        url: 'ajax/delete_post_ajax.php',
        type: 'POST',
        data:{
        post_id: post_id
        },
        error: function(){
        alert('error');
        },
        success:function (data) {
        $('.post_' + post_id).hide('slow', function(){ $('.post_' + post_id).remove(); });
        }
    })
})
</script>


