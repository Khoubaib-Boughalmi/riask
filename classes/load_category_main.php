<?php

class category_main{
    private $con;
    public function __construct($con){
        $this->con=$con;
    }
    public function load_category(){
        $query = mysqli_query($this->con,'SELECT * from category');
        while ($query_array=mysqli_fetch_array($query)) { 
            echo "<div class='load_friend_search_div'>
            <div class='friend_image_div_search_friend'>
                <img src='".$query_array['category_img']."' alt='' srcset=''class='friend_image_search_friend'>
            </div>
            <div class='friend_name_commen_friends'>
                <a href='profile.php?user_profile=$'>
                <div class='friend_name'><span>Math</span></div>
                <div class='friend_commen_friends'><span>".$query_array['num_post']."<span></div>
                </a>
            </div>
            <div class='follow_friend_button_search_friend follow_friend_button_search_friend_$'>Follow</div>
            <div class=''></div>
            </div>
        <hr>";
        }
    }
}
?>