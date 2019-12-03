<?php

class category_main{
    private $con;
    private $query;

    public function __construct($con){
        $this->con=$con;
        $this->query=mysqli_query($con,'SELECT * from category order by RAND()');
    }
    public function load_category(){
        $query=mysqli_query($this->con,'SELECT * from category order by RAND()');
        while ($query_array=mysqli_fetch_array($query)) { 
            echo "<div class='load_category_search_div load_category_search_div_".$query_array['category_val']."'>
            <div class='category_image_div_search_category'>
                <img src='".$query_array['category_img']."' alt='' srcset=''class='category_image_search_category'>
            </div>
            <div class='category_name_commen_categorys'>
                <div class='category_name'><span>".$query_array['category_val']."</span></div>
                <div class='category_commen_categorys'><span>".$query_array['num_post']." Post in this category<span></div>

            </div>
            <div class='follow_category_button_search_category follow_category_button_search_category_$'>Follow</div>

            <div class=''></div>
            </div>
        <hr>";
        }
    }

    public function load_category_create_post(){
        $query = $this->query;
        while ($query_array=mysqli_fetch_array($query)) { 
            echo "<option value='".$query_array['category_val']."'>".$query_array['category_val']."</option>";
        }
    }
    
    public function load_category_side(){
        $query_side = $this->query;
        $count = 0;
        while (($query_array_side=mysqli_fetch_array($query_side)) && ($count<4) ) { 
            echo "<div class='load_category_search_div load_category_search_div_".$query_array_side['category_val']."'>
            <div class='category_image_div_search_category'>
                <img src='".$query_array_side['category_img']."' alt='' srcset=''class='category_image_search_category'>
            </div>
            <div class='category_name_commen_categorys'>
                <div class='category_name'><span>".$query_array_side['category_val']."</span></div>

            </div>

            <div class=''></div>
            </div>
        <hr>";
        $count++;
        }
    }

}
?>