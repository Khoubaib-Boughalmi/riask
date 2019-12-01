<?php
require 'db.php';
if(mysqli_connect_errno()){
    echo 'connection failled';
}

if(isset($_POST['title'])){
    
    $title= $_POST['title'];
    // $query_titles=mysqli_query($con,"SELECT * FROM titles WHERE title_name like '%$title%' order by number_post desc");
    $query_title=mysqli_query($con,"SELECT * FROM posts where MATCH(title) AGAINST('$title') order by likes");
    $date_time_now = date("Y-m-d H:i:s");

    $query_title_num=mysqli_num_rows($query_title);
    if(!empty($title)){
        if($query_title_num>0){
            echo "<script>$('.results_container_title').css('display','flex');</script>";
            while($title_name=mysqli_fetch_array($query_title)){

                // echo '<div class="tags_suggestion '.$tag_name['id'].'">';
                // echo '<span class="tag_name"> ' .$tag_name['title']. '</span>';
                // // echo '<span class="tag_number_post"> ' .$tag_name['number_post']. ' post on this category</span>';
                // echo '</div>';
                // ********************************
                $date_time=$title_name['date_added'];
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
                                    $time_message = $interval->m . " month".' ago';
                                }
                                else {
                                    $time_message = $interval->m . " months".' ago';
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
                echo "<div class='main_search_result_content' style='padding: .5rem;border: 0.1rem solid #929292;margin: 0.2rem 0rem;'>
                <div class='main_search_result_reactions' style=''>
                    <div class='main_search_result_like'>
                    <img src='images/green_flag.png' style='height: 1.8rem;' alt=''>
                    <span style='font-size:1.4rem; margin-left:.4rem;font-weight:bold'>".$title_name['likes']."</span>
                    </div>
                    <div class='main_search_result_like'>
                    <img src='images/red_flag.png' style='height: 1.8rem;' alt=''>
                    <span style='font-size:1.6rem; margin-left:.4rem;font-weight:bold'>".$title_name['dislikes']."</span>
                    </div>
                </div>
                <a href='show_comments.php?post_id=".$title_name['id']."' style='padding: .8rem 0rem;'>
                <div class='main_search_result_title'>
                    <span style='font-size:1.3rem;font-weight:bold;color:black'>".$title_name['title']."</span>
                    </div>
                    </a>
                <div class='search_result_date'>
                    <span style='font-size: 1.1rem;font-weight: bold;'>$time_message</span>
                </div>
            </div>";
            }
        }
    }
}
?>
<script>

$('.tags_suggestion').click(function(){
    $('.create-post-tags-input').focus()
    var tag_name = $(this).attr('class');
    var tag_name = tag_name.slice(16);
    // var string_val = $('.create-post-tags-input').val();
            // if (string_val.includes(tag_name)==false) {
                // string_val = tag_name+','+string_val
                if (tag_name !='another') {
                var final_result="<span class='tags_value tags_value_"+tag_name+"'>"+tag_name+"</span>"
                }else{
                tag_name=$('.create-post-tags-input').val()
                if (tag_name.length>0) {
                    var final_result="<span class='tags_value tags_value_"+tag_name+"'>"+tag_name+"</span>"
                    }
                }
    $('.create-post-title-input').val('')
    $('.results_container_title').css('display','none');

})
$('.delete_title').click(function(){
    $('.top_tag').css('padding','1.85rem 0rem');
    $('.results_container_title').css('display','none');


})


// $('.botton1').click(function(){
//                 $.get('creat-post-files/tags-create-post.php',function(data){
//                     $('.ajax-insert').html(data);
//                 })
//                     $('svg').removeClass('active_btn_tag');
//                     $(this).addClass('active_btn_tag');
//             })
//             $('.botton2').click(function(){
//                 $.get('creat-post-files/description-create-post.php',function(data){
//                     $('.ajax-insert').html(data);
//                 })
//                 $('svg').removeClass('active_btn_tag');
//                     $(this).addClass('active_btn_tag');
//             })
//             $('.botton3').click(function(){
//                 $.get('creat-post-files/review-create-post.php',function(data){
//                     $('.ajax-insert').html(data);
//                 })
//                 $('svg').removeClass('active_btn_tag');
//                     $(this).addClass('active_btn_tag');
//             })
</script>