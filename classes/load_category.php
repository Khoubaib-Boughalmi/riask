<?php

class category{
    private $con;
    public function __construct($con){
        $this->con=$con;
    }
    public function load_category(){
        $query = mysqli_query($this->con,'SELECT * from category');
        $query_array =mysqli_fetch_array($query);
        for ($i=0; $i <count($query_array)-1; $i++) { 
            echo 'hi '.'<br>';
        }
    }
}
?>