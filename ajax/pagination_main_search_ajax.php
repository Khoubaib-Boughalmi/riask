<link rel="manifest" href="/../js/manifest.json"></link>

<?php

require '../db.php';
if(mysqli_connect_errno()){
    echo 'connection failled';

}

$input_search_val=$_POST['input_search_val'];
// $pagination_formul_start=$_POST['pagination_formul_start'];
$pagination_formul_end=$_POST['pagination_formul_end'];

$query_search=mysqli_query($con,"SELECT * from posts where MATCH(title,body) AGAINST('$input_search_val')");
        $query_search_num=mysqli_num_rows($query_search);
        echo "<span class='main_search_num_results'>$query_search_num results found</span>";

$query_search=mysqli_query($con,"SELECT * from posts where MATCH(title,body) AGAINST('$input_search_val') limit $pagination_formul_end,10 ");
$date_time_now = date("Y-m-d H:i:s");
$query_search_num=mysqli_num_rows($query_search);
if ($query_search_num>0) {
    while($query_search_array=mysqli_fetch_array($query_search)){
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
        echo "
        <div class='show_all_search_result_content'>
        <div class='show_all_search_result_reactions'>
            <div class='show_all_search_result_reaction_like'>
            <img src='images/green_flag.png' style='height: 2.2rem;'>
            <span style='font-size:1.4rem; margin-left:.4rem;font-weight:bold'>".$query_search_array['likes']."</span>
            </div>
            <div class='show_all_search_result_reaction_dislike'>
            <img src='images/red_flag.png' style='height: 2.2rem;'>
                <span style='font-size:1.4rem; margin-left:.4rem;font-weight:bold'>".$query_search_array['dislikes']."</span>
            </div>
        </div>
        <div class='show_all_search_result_content_title_and_subtitle'>
            <a href='show_comments.php?post_id=".$query_search_array['id']."'>            
                <div class='show_all_search_result_content_title'>
                    <span>".$query_search_array['title']."</span>
                </div>
                <div class='show_all_search_result_content_subtitle'>
                    <span>".$query_search_array['body']."</span>
                </div>
                <div class='show_all_search_result_content_tags'>
                ";
                $str = $query_search_array['post_tags'];
                $arr=explode(',',$str);
                $val=count($arr);
                $i=0;
                for($i=0;$i<$val-1;$i++){
                echo '<span>'.$arr[$i].'</span>';
                }  
                echo"
                </div>
            </a>
        </div>
        <div class='show_all_search_result_content_date'>
        $time_message
        </div>
        
</div>";
        }
}



?>