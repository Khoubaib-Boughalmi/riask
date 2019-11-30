<?php
    class main_pagination{

        private $con;

        public function __construct($con){
            $this->con=$con;
        }
    
    public function number_of_results_related($categories_list){
        $query_search=mysqli_query($this->con,"SELECT * from posts where MATCH(category) AGAINST('$categories_list')");
        $query_search_num=mysqli_num_rows($query_search);
        return $query_search_num;
    }

    public function pagination($number_search_result){
        $int_part=intval((int)$number_search_result/10);
            if ($int_part!=$number_search_result/10) {
                for ($i=0; $i < $int_part; $i++) { 
                    $j=$i+2;
                    if ($i == 10) {
                        break;
                    }
                    echo "<span href='#' class='pagination_content' id='pagination_$j'>$j</span>";
                }
            }else{
                for ($i=0; $i < $int_part; $i++) { 
                    $j=$i+2;
                    if ($i == 10) {
                    break;
                }
                    echo "<span href='#' class='pagination_content' id='pagination_$j'>$j</span>";
                }
            }
        }
    
}
?>