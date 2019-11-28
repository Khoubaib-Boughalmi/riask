<?php

class category_main{
    private $con;
    public function __construct($con){
        $this->con=$con;
    }
    public function load_category(){
        $query = mysqli_query($this->con,'SELECT * from category');
        while ($query_array=mysqli_fetch_array($query)) { 
            echo "<div class='load_category_search_div'>
            <div class='category_image_div_search_category'>
                <img src='".$query_array['category_img']."' alt='' srcset=''class='category_image_search_category'>
            </div>
            <div class='category_name_commen_categorys'>
                <a href='profile.php?user_profile=$'>
                <div class='category_name'><span>".$query_array['category_val']."</span></div>
                <div class='category_commen_categorys'><span>".$query_array['num_post']." Post in this category<span></div>
                </a>
            </div>
            <div class='follow_category_button_search_category follow_category_button_search_category_$'>Follow</div>
            <div class=''></div>
            </div>
        <hr>";
        }
    }
}
?>