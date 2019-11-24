<?php

class category{
    private $con;
    public function __construct($con){
        $this->con=$con;
    }
    public function load_category(){
        $query = mysqli_query($this->con,'SELECT * from category');
        $query_array =mysqli_fetch_array($query);
        while ($query_array) { 
            echo '<li>
            <input type="checkbox" value="">'.$query_array['category_val'] .'
        </li>
        <hr>';
        }
    }
}
?>