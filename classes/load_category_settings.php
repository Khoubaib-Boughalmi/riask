<?php

class category{
    private $con;
    private $user_name_logged_in;
    public function __construct($con,$user_name_logged_in){
        $this->con=$con;
        $this->user_name_logged_in=$user_name_logged_in;
    }
    public function load_category(){
        $user_name_logged_in = $this->user_name_logged_in;
        $query_category = mysqli_query($this->con,'SELECT * from category');
        $query_category_user = mysqli_query($this->con,"SELECT * from users where user_name='$user_name_logged_in'");
        $query_category_array = mysqli_fetch_array($query_category_user);
        while ($query_array=mysqli_fetch_array($query_category)) { 
            $category_list = $query_category_array['categories'];
            if (strstr($category_list,$query_array['category_val'])==false) {
                echo '<li>
                <input type="checkbox" value="'.$query_array['category_val'] .'" class="category" name="check_box_category">'.$query_array['category_val'] .'
            </li>
            <hr>';
            }else{
                echo '<li>
                <input type="checkbox" value="'.$query_array['category_val'] .'" class="category" checked name="check_box_category">'.$query_array['category_val'] .'
            </li>
            <hr>';
            }
        }
    }
}
?>